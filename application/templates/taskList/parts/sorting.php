<?php
/**
 * @var Sorting $sorting
 * @var bool $enable
 * @var UrlManager $urlManager
 */

use components\Sorting;
use components\UrlManager;

?>

<ul class="nav nav-sorting ">

    <li class="nav-item <?= (!$enable ? 'disabled' : '') ?>">
        <a class="nav-link disabled" href="#">Сортировать:</a>
    </li>

    <?php foreach ($sorting->getSortingTypes() as $sortingType => $title): ?>
        <li class="nav-item  <?= $sorting->isCurrentSorting($sortingType) ? 'active' : '' ?>">

            <?php if ($sorting->isCurrentSorting($sortingType)): ?>
                <a class="nav-link <?= (!$enable ? 'disabled' : '') ?>"
                   href="<?= $urlManager->getUrl([
                       'sort' => $sortingType,
                       'direct' => $sorting->getNextDirection(),
                   ]) ?>">
                    <i class="fa fa-sort-amount-<?= $sorting->getCurrenDirection() ?>"></i>
                    <?= $title ?>
                </a>
            <?php else: ?>
                <a class="nav-link <?= (!$enable ? 'disabled' : '') ?>"
                   href="<?= $urlManager->getUrl([
                       'sort' => $sortingType,
                       'direct' => Sorting::SORT_DIRECTION_ASC,
                   ]) ?>">
                    <i class="fa fa-sort-amount-asc"></i>
                    <?= $title ?>
                </a>
            <?php endif; ?>

        </li>
    <?php endforeach; ?>

</ul>
