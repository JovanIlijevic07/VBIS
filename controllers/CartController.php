<?php

namespace app\controllers;

use app\core\Application;
use app\core\Constant;
use app\core\Controller;
use app\models\OrderItemModel;
use app\models\OrderModel;

class CartController extends Controller
{
    public function cart()
    {
        return $this->view("cart", "main", null);
    }

    public function noItemsInCart()
    {
        return $this->view("noItemsInCart", "main", null);
    }

    public function cartPost()
    {
        $orderModel = new OrderModel();
        $request = $this->request->all();
        $cart = $request["cart"];
        $cartItems = $cart["items"];
        $orderModel->mapData($request);
        $orderModel->created_on = date("Y-m-d h:i:s");
        $loggedInUser = Application::$app->session->get(Constant::$auth_session);

        if ($loggedInUser) {
            $orderModel->created_by = $loggedInUser->{"email"};
            $orderModel->create();

            $orderModel->mapData($orderModel->getLastRecord(""));

            foreach ($cartItems as $item) {
                $orderItemModel = new OrderItemModel();
                $orderItemModel->mapData($item);
                $orderItemModel->order_id =   $orderModel->id;
                $orderItemModel->created_on = date("Y-m-d h:i:s");
                $orderItemModel->created_by = $loggedInUser->{"email"};
                $orderItemModel->create();
            }
        }
    }

    public function authorizeRoles(): array
    {
        return [Constant::$korisnik_role];
    }
}