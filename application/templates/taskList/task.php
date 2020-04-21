<?php
/**
 * @var Task $task
 * @var TaskRepository $taskRepo
 * @var bool $isAuth
 */

use application\model\repository\TaskRepository;
use application\model\dto\Task; ?>

<li class="list-group-item">
    <div class="p-0">
        <div class="widget-content-wrapper">

            <?php if ($isAuth): ?>
            <div class="buttons-block mr-3">
                <?php if ($task->getStatus() !== Task::STATUS_DONE): ?>
                    <a class="border-0 btn-transition btn btn-outline-success" href="/task/done?id=<?= $task->getId() ?>">
                        <i class="fa fa-check"></i>
                    </a>
                <?php endif; ?>

                    <a class="border-0 btn-transition btn btn-outline-primary" href="/task/edit?id=<?= $task->getId() ?>">
                        <i class="fa fa-pencil"></i>
                    </a>
            </div>
            <?php endif; ?>

            <div class="message-box">
                <div class="message-title mb-2"><i><?= $task->getUsername() ?>
                    (<a href="mailto:<?= $task->getEmail() ?> "><?= $task->getEmail() ?> </a>)</i>
                    <span class="badge <?= $taskRepo->getStatusClass($task->getStatus()) ?> ml-2">
                        <?= $taskRepo->getStatusName($task->getStatus()) ?>
                    </span>

                    <?php if ($task->getUpdated()): ?>
                        <span class="badge badge-dark ml-2">
                            Отредактировано администратором
                        </span>
                    <?php endif; ?>
                </div>
                <div class="">
                    <?= $task->getText() ?>
                </div>
            </div>

        </div>
    </div>
</li>
