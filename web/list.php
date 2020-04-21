<?php
/**
 * @var View $view
 * @var Task[] $taskList
 * @var TaskRepository $taskRepo
 * @var Sorting $sorting
 * @var Pagination $pagination
 * @var int $count
 * @var UrlManager $urlManager
 * @var bool $isAuth
 * @var string $message
 */

use application\model\repository\TaskRepository;
use application\model\dto\Task;
use components\Pagination;
use components\Sorting;
use components\UrlManager;
use components\View;

?>

<?php if ($message): ?>
    <div class="alert alert-primary" role="alert">
        <?= $message ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="row d-flex justify-content-center container">
    <div class="col-md-8">
        <div class="card-hover-shadow-2x mb-3 card">
            <div class="card-header-tab card-header">
                <?php $view->renderPart('taskList/parts/sorting.php', [
                    'sorting' => $sorting,
                    'urlManager' => $urlManager,
                    'enable' => $count > 1,
                ]); ?>

            </div>
            <div class="ps-content">

                <?php if ($count): ?>
                    <ul class=" list-group list-group-flush">

                        <?php foreach ($taskList as $task): ?>
                            <?php $view->renderPart('taskList/task.php', [
                                'task' => $task,
                                'taskRepo' => $taskRepo,
                                'isAuth' => $isAuth,
                            ]); ?>
                        <?php endforeach; ?>

                    </ul>
                <?php else: ?>
                    <div class="row">
                        <div class="col m-3">
                            Создайте первую задачу
                        </div>
                    </div>
                <?php endif; ?>


            </div>
            <div class="d-block text-right card-footer">
                <?php if ($pagination->getTotalPages() > 1): ?>
                    <?php $view->renderPart('taskList/parts/pagination.php', [
                        'pagination' => $pagination,
                        'urlManager' => $urlManager,
                    ]); ?>
                <?php endif; ?>

                <a class="btn btn-sm btn-primary" href="/task/edit">Добавить задачу</a></div>
        </div>
    </div>
</div>
