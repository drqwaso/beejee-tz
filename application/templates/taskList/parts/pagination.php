<?php

/**
 * @var View $view
 * @var Pagination $pagination
 * @var UrlManager $urlManager
 */

use components\Pagination;
use components\UrlManager;
use components\View;

?>

<nav aria-label="...">
    <ul class="pagination pagination-sm">
        <?php if ($pagination->hasPrevPage()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $urlManager->getUrl(['page' => $pagination->getPrevPage()]) ?>">Назад</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Назад</span>
            </li>
        <?php endif; ?>


        <?php foreach ($pagination->getLeftPages() as $page): ?>
            <?php $view->renderPart('taskList/parts/pageNum.php', [
                    'pageNum' => $page,
                    'pagination' => $pagination,
                    'urlManager' => $urlManager,
            ]); ?>
        <?php endforeach; ?>


        <?php if ($pagination->hasMiddlePages()): ?>
            <li class="page-item disabled">
                <span class="page-link">...</span>
            </li>

            <?php foreach ($pagination->getMiddlePages() as $page): ?>
                <?php $view->renderPart('taskList/parts/pageNum.php', [
                    'pageNum' => $page,
                    'pagination' => $pagination,
                    'urlManager' => $urlManager,
                ]); ?>
            <?php endforeach; ?>

        <?php endif; ?>


        <?php if ($pagination->hasRightPages()): ?>
            <li class="page-item disabled">
                <span class="page-link">...</span>
            </li>

            <?php foreach ($pagination->getRightPages() as $page): ?>
                <?php $view->renderPart('taskList/parts/pageNum.php', [
                    'pageNum' => $page,
                    'pagination' => $pagination,
                    'urlManager' => $urlManager,
                ]); ?>
            <?php endforeach; ?>

        <?php endif; ?>


        <?php if ($pagination->hasNextPage()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $urlManager->getUrl(['page' => $pagination->getNextPage()]) ?>">Вперед</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Вперед</span>
            </li>
        <?php endif; ?>
    </ul>
</nav>
