<?php

namespace application\model\repository;

use application\model\dto\Task;
use components\db\AbstractDao;
use components\Sorting;

class TaskRepository extends AbstractDao
{
    public const PERPAGE = 3;

    public const SORTING_NAME = 'username';
    public const SORTING_EMAIL = 'email';
    public const SORTING_STATUS = 'status';

    private $availableSorting = [
        self::SORTING_NAME,
        self::SORTING_EMAIL,
        self::SORTING_STATUS,
    ];

    private $availableSortDirections = [
        Sorting::SORT_DIRECTION_ASC,
        Sorting::SORT_DIRECTION_DESC,
    ];

    /**
     * @return int
     */
    public function getTasksCount()
    {
        $stmt = $this->query('select count(t.id) from tasks t');

        return (int) $stmt->fetchColumn();
    }

    /**
     * @param string|null $sorting
     * @param string|null $sortDirection
     * @param int|null $limit
     * @param int $offset
     * @return array
     */
    public function getTaskList(
        string $sorting = null,
        string $sortDirection = null,
        int $limit = null,
        int $offset = 0
    ) {
        $sql = "select * from tasks";

        if ($sorting && in_array($sorting, $this->availableSorting)) {
            $sql .= " order by $sorting";

            if ($sortDirection && in_array($sortDirection, $this->availableSortDirections)) {
                $sql .= " $sortDirection";
            }
        }

        if ($limit) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }

        $stmt = $this->query($sql);

        return $this->hidrateCollection($stmt->fetchAll());
    }

    /**
     * @param array $data
     * @return Task
     */
    public function hidrateObject(array $data)
    {
        $task = new Task();

        return $task->setId($data['id'])
            ->setUsername($data['username'])
            ->setEmail($data['email'])
            ->setText($data['text'])
            ->setStatus($data['status'])
            ->setUpdated($data['updated']);
    }

    /**
     * @param string $status
     * @return string
     */
    public function getStatusClass(string $status): string
    {
        $statusClasses = [
            Task::STATUS_NEW => 'badge-warning',
            Task::STATUS_DONE => 'badge-success',
            Task::STATUS_PROGRESS => 'badge-primary',
        ];

        return $statusClasses[$status] ?? 'badge-secondary';
    }

    /**
     * @param string $status
     * @return string
     */
    public function getStatusName(string $status): string
    {
        $statuslist = $this->getStatusList();

        return $statuslist[$status] ?? 'неизвестно';
    }

    /**
     * @return array
     */
    public function getStatusList(): array
    {
        return [
            Task::STATUS_NEW => 'Новая',
            Task::STATUS_PROGRESS => 'Прогресс',
            Task::STATUS_DONE => 'Выполнена',
        ];
    }

    /**
     * @return array
     */
    public function getSortingTypes(): array
    {
        return [
            TaskRepository::SORTING_NAME => 'По имени',
            TaskRepository::SORTING_EMAIL => 'По email',
            TaskRepository::SORTING_STATUS => 'По статусу',
        ];
    }

    /**
     * @param int $id
     * @return Task|null
     */
    public function findTask(int $id): ?Task
    {
        $stmt = $this->query('select * from tasks t WHERE t.id = :id', [
            'id' => $id,
        ]);

        $data = $stmt->fetch();

        return $data ? $this->hidrateObject($data): null;
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function save(Task $task)
    {
        $data = [
            'username' => $task->getUsername(),
            'email' => $task->getEmail(),
            'text' => $task->getText(),
            'status' => $task->getStatus(),
            'updated' => $task->getUpdated(),
        ];

        $params = [];
        $values = [];
        foreach ($data as $item => $val) {
            if ($val) {
                $params[] = "$item = :$item";
                $values[$item] = htmlspecialchars($val);
            }
        }

        $id = $task->getId();

        if ($id) {
            $values['id'] = $task->getId();
            $sql = sprintf(
                "update tasks set %s where id = :id",
                implode(', ', $params)
            );
        } else {
            $sql = sprintf(
                "insert tasks set %s",
                implode(', ', $params)
            );
        }

        return $this->exec($sql, $values);
    }
}
