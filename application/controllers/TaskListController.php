<?php

namespace application\controllers;

use application\Container;
use application\model\dto\Task;
use application\model\forms\TaskForm;
use application\model\repository\TaskRepository;
use components\Auth;
use components\exceptions\NotFoundException;
use components\UrlManager;
use components\Pagination;
use components\Request;
use components\Sorting;
use components\View;

class TaskListController
{
    private const SHOW_PAGES = 12;

    /** @var Container */
    private $container;

    /** @var Request */
    private $request;

    /** @var bool */
    private $isAuth;

    /** @var View */
    private $view;

    /** @var TaskRepository */
    private $taskRepository;

    /**
     * TaskListController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $auth = $container->get(Auth::class);
        $this->view = $container->get(View::class);
        $this->isAuth = (bool) $auth->getUser();
        $this->request = $container->get(Request::class);
        $this->taskRepository = $this->container->get(TaskRepository::class);
    }

    /**
     * @param int|null $page
     * @param string|null $sort
     * @param string|null $direct
     */
    public function actionList(int $page = null, string $sort = null, string $direct = null)
    {
        $countTasks = $this->taskRepository->getTasksCount();

        $sorting = new Sorting(
            $this->taskRepository->getSortingTypes(),
            $this->getSorting($sort),
            $this->getSortDirection($direct)
        );

        $pagination = new Pagination(
            $countTasks,
            TaskRepository::PERPAGE,
            self::SHOW_PAGES,
            $page
        );
        
        $taskList = $this->taskRepository->getTaskList(
            $sorting->getCurrenSorting(),
            $sorting->getCurrenDirection(),
            $pagination->getLimit(),
            $pagination->getOffset()
        );

        $urlManager = new UrlManager(
            $this->request->getRequestUri(),
            array_replace($this->request->paramsGet(), [
                'page' => $page,
                'sort' => $sort,
                'direct' => $direct,
            ])
        );

        $this->view->render('taskList/list.php', [
            'taskList' => $taskList,
            'taskRepo' => $this->taskRepository,
            'sorting' => $sorting,
            'pagination' => $pagination,
            'urlManager' => $urlManager,
            'message' => $this->request->hasMessage() ? $this->request->flushMessage() : null,
            'count' => $countTasks,
            'isAuth' => $this->isAuth
        ]);
    }

    /**
     * @param int|null $id
     * @throws NotFoundException
     */
    public function actionEdit($id = null)
    {
        if ($id && !$this->isAuth) {
            $this->request->redirect('/signin');
        }

        $task = $id ? $this->loadTask($id) : new Task();

        $taskForm = new TaskForm($this->taskRepository, $task);

        if ($this->request->isPost()) {
            $taskForm->setFields($_POST);

            try {
                if ($taskForm->validate() && $taskForm->save()) {
                    $message = $id ? 'Изменения сохранены' : 'Создана новая задача';
                    $backurl = $this->request->flushBackUrl();
                    if ($backurl) {
                        $this->request->redirect($backurl, $message);
                    }
                    $this->request->redirect('/task/list', $message);
                }
            } catch (\Throwable $e) {
                $error = 'Ошибка при сохранении задачи';
            }

        } else {
            $this->request->saveBackUrl();
        }

        $this->view->render('taskList/form.php', [
            'form' => $taskForm,
            'taskRepository' => $this->taskRepository,
            'backurl' => $this->request->getBackUrl(),
            'error' => $error ?? null,
            'id' => $id,
        ]);
    }

    /**
     * @param int $id
     * @throws NotFoundException
     */
    public function actionDone($id)
    {
        if ($id && !$this->isAuth) {
            $this->request->redirect('/signin');
        }
        $this->request->saveBackUrl();

        $taskForm = new TaskForm($this->taskRepository, $this->loadTask($id));
        $taskForm->setFields(['status' => Task::STATUS_DONE]);

        try {
            if ($taskForm->validate()) {
                $taskForm->save();
                $message = 'Задача выполнена';
            }
        } catch (\Throwable $e) {
            $message = 'Ошибка при сохранении задачи';
        }

        $backurl = $this->request->flushBackUrl();
        if ($backurl) {
            $this->request->redirect($backurl, $message ?? null);
        }

        $this->request->redirect('/task/list', $message ?? null);
    }

    /**
     * @param string|null $sortingType
     * @return string|null
     */
    private function getSorting(string $sortingType = null): ?string
    {
        if ($sortingType) {
            $_SESSION['task.sorting.type'] = $sortingType;
        }

        return $_SESSION['task.sorting.type'] ?? null;
    }

    private function getSortDirection($direction = null): ?string
    {
        if ($direction) {
            $_SESSION['task.sorting.direction'] = $direction;
        }

        return $_SESSION['task.sorting.direction'] ?? null;
    }

    private function loadTask($id): Task
    {
        $task = $this->taskRepository->findTask($id);
        if (!$task) {
            throw new NotFoundException('Задача не найдена');
        }

        return $task;
    }
}
