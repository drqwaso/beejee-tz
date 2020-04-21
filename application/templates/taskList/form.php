<?php
/**
 * @var TaskForm $form
 * @var int $id
 * @var TaskRepository $taskRepository
 * @var string $backurl
 * @var string $error
 */

use application\model\forms\TaskForm;
use application\model\repository\TaskRepository; ?>


<?php if ($form->hasErrors()): ?>
    <div class="alert alert-danger mx-4 mt-3" role="alert">
        <?= $form->getErrorsList() ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger mx-4 mt-3" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>

<form class="needs-validation p-4" autocomplete="off" method="post" action="/task/edit?id=<?= $id ?>" enctype=”multipart/form-data” enctype=”multipart/form-data”>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="status">Статус</label>
            <select class="form-control <?= $form->getValidClass('status') ?>" id="status" name="status">
                <?php foreach ($taskRepository->getStatusList() as $status => $title): ?>
                    <option value="<?= $status ?>"
                        <?= ($form->getStatus() === $status ? 'selected' : '') ?>><?= $title ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="username">Имя</label>
            <input type="text" class="form-control <?= $form->getValidClass('username') ?>"
                   id="username" name="username" value="<?= htmlspecialchars_decode($form->getUsername()) ?>" required="">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control <?= $form->getValidClass('email') ?>"
                   id="email" name="email"  value="<?= htmlspecialchars_decode($form->getEmail()) ?>" required="">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="text">Описание</label>
            <textarea class="form-control <?= $form->getValidClass('text') ?>" id="text" name="text" rows="4" required=""><?= htmlspecialchars_decode($form->getText()) ?></textarea>
        </div>
    </div>

    <button class="btn btn-primary" type="submit">Сохранить задачу</button>

    <?php if ($id): ?>
        <a class="btn" href="<?= ($backurl ?? '/task/list') ?>">Отмена</a>
    <?php endif; ?>

</form>
