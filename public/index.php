<?php

require_once __DIR__ . "/../vendor/autoload.php";

use app\controllers\AuthController;
use app\controllers\CarController;
use app\controllers\CartController;
use app\controllers\HomeController;
use app\controllers\ProductController;
use app\controllers\ReportController;
use app\controllers\UserController;
use app\core\Application;
use app\core\Constant;

$app = new Application();

$app->router->get("/", [HomeController::class, 'home']);
$app->router->get("/home", [HomeController::class, 'home']);
$app->router->get("/about", [HomeController::class, 'about']);
$app->router->get("/contact", [HomeController::class, 'contact']);
$app->router->get("/userList", [UserController::class, 'list']);
$app->router->get("/userOne", [UserController::class, 'one']);
$app->router->get("/userCreate", [UserController::class, 'create']);
$app->router->get("/registration", [AuthController::class, 'registration']);
$app->router->get("/login", [AuthController::class, 'login']);
$app->router->get("/accessDenied", [AuthController::class, 'accessDenied']);
$app->router->get("/logout", [AuthController::class, 'logout']);
$app->router->get("/carList", [CarController::class, 'carList']);
$app->router->get("/cart", [CartController::class, 'cart']);
$app->router->get("/carListApi", [CarController::class, 'carListApi']);
$app->router->get("/noItemsInCart", [CartController::class, 'noItemsInCart']);
$app->router->get("/reportTotalPricePerMonth", [ReportController::class, 'totalPricePerMonth']);
$app->router->get("/reportTotalPricePerBrand", [ReportController::class, 'totalPricePerBrand']);
$app->router->post("/userPost", [UserController::class, 'createPost']);
$app->router->post("/cartPost", [CartController::class, 'cartPost']);
$app->router->post("/registrationPost", [AuthController::class, 'registrationPost']);
$app->router->post("/loginPost", [AuthController::class, 'loginPost']);

$app->router->put("/update", "update.php");
$app->router->delete("/delete", "delete.php");

$app->run();