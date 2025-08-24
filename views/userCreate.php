<?php
/** @var $params UserModel
 */

use app\core\Application;
use app\models\UserModel;

?>


<div class="card">
    <div class="card-body">
        <form action="/userPost" method="post">
            <div class="mb-3">
                <?php Application::$app->form->renderInput($params, 'name', 'Name', 'text', 'Please enter name'); ?>
            </div>
            <div class="mb-3">
                <?php Application::$app->form->renderInput($params, 'phone_number', 'Phone number', 'text', 'Please enter phone number'); ?>
            </div>
            <div class="mb-3">
                <?php Application::$app->form->renderInput($params, 'email', 'Email', 'email', 'Please enter email'); ?>
            </div>
            <div class="mb-3">
                <?php Application::$app->form->renderInput($params, 'password', 'Password', 'password', 'Please enter password'); ?>
            </div>
            <div class="mb-3">
                <?php Application::$app->form->renderInput($params, 'active', 'Active', 'checkbox', ''); ?>
            </div>

            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </form>
    </div>
</div>