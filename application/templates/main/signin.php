<?php
/**
 * @var Signin $signin
 */

use application\model\forms\Signin;?>

<form class="form-signin" autocomplete="off" method="post">

    <?php if ($signin->hasErrors()): ?>
        <div class="alert alert-danger mx-4 mt-3" role="alert">
            <?= $signin->getErrorsList() ?>
        </div>
    <?php endif; ?>

    <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
    <input type="login" name="login" class="first form-control <?= $signin->getValidClass('login') ?>" placeholder="Логин" required autofocus autocomplete="off">
    <input type="password" name="pass" class="last form-control <?= $signin->getValidClass('pass') ?>" placeholder="Пароль" required >

    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
</form>
