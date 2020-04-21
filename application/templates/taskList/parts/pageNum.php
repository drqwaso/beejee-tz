<?php

use components\Pagination;
use components\UrlManager;

/**
 * @var int $pageNum
 * @var Pagination $pagination
 * @var UrlManager $urlManager
 */
?>

<?php if ($pagination->isCurrentPage($pageNum)): ?>
    <li class="page-item active">
        <span class="page-link">
            <?= $pageNum ?>
            <span class="sr-only">(current)</span>
        </span>
    </li>
<?php else: ?>
    <li class="page-item">
        <a class="page-link" href="<?= $urlManager->getUrl(['page' => $pageNum]) ?>"><?= $pageNum ?></a>
    </li>
<?php endif; ?>
