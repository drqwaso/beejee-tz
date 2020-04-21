<?php

namespace application\model\forms;

use application\model\repository\TaskRepository;
use application\model\dto\Task;
use components\interfaces\ValidableInterface;
use components\Validation;
use components\ValidationTrait;

class TaskForm implements ValidableInterface
{
    use ValidationTrait;

    /** @var Task */
    private $task;

    /** @var TaskRepository */
    private $taskRepository;

    /** @var Task */
    private $oldTask;

    public function __construct(TaskRepository $taskRepository, Task $task)
    {
        $this->taskRepository = $taskRepository;
        $this->task = $task;

        if ($task->getId()) {
            $this->oldTask = clone $task;
        }
    }

    private function isUpdated(): int
    {
        return $this->oldTask
            ? $this->oldTask->getText() !== $this->task->getText()
            : false;
    }
    
    public function setFields($fields)
    {
        if (isset($fields['username'])) {
            $this->task->setUsername($fields['username'] ?? null);
        }
        if (isset($fields['email'])) {
            $this->task->setEmail($fields['email'] ?? null);
        }
        if (isset($fields['status'])) {
            $this->task->setStatus($fields['status'] ?? null);
        }
        if (isset($fields['text'])) {
            $this->task->setText($fields['text'] ?? null);
        }

        $this->task->setUpdated($this->isUpdated());
    }

    public function validate(): bool
    {
        $validation = new Validation($this);
        $validation->required('username', $this->task->getUsername())
            ->required('email', $this->task->getEmail())
            ->required('text', $this->task->getText())
            ->lenght('text', $this->task->getText(), null, 255)
            ->lenght('email', $this->task->getEmail(), null, 180)
            ->lenght('username', $this->task->getUsername(), null, 100)
            ->email('email', $this->task->getEmail());

        if (!array_key_exists($this->task->getStatus(), $this->taskRepository->getStatusList())) {
            $this->addError('status', 'Не верное значение поля "Статус"');
        }

        if ($this->hasErrors()) {
            return false;
        }

        return true;
    }

    public function save()
    {
        return $this->taskRepository->save($this->task);
    }

    public function getUsername(): ?string
    {
        return $this->task->getUsername();
    }

    public function getEmail(): ?string
    {
        return $this->task->getEmail();
    }

    public function getText(): ?string
    {
        return $this->task->getText();
    }

    public function getUpdated(): ?int
    {
        return $this->task->getUpdated();
    }

    public function getStatus(): ?string
    {
        return $this->task->getStatus();
    }
}
