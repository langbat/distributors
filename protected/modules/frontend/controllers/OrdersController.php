<?php

class OrdersController extends Controller {

    public function init()
    {
        if (Yii::app()->user->isGuest){
            $this->redirect('/users/signin');
        }
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = false;
        }
        parent::init();
    }


    public function actionIndex()
    {
        $this->redirect("/orders/list");
    }

    public function actionAdd($id)
    {
        $templates = Templates::model()->findAll();
        if ($id){
            $products = Yii::app()->request->getPost('products', false);
            $data = Yii::app()->request->getPost('data', false);
            $promo = Yii::app()->request->getPost('promo', false);
            $pickups = Yii::app()->request->getPost('pickup', false);
            if ($products){
                //var_dump($_POST); die();
                $order = new Orders();
                $order->user_id = Yii::app()->user->id;
                $order->template_id = $data['template_id'];
                $order->distributor_id = $data['store_id'];
                $order->date = date('Y-m-d H:i:s');
                $order->total = (float)$data['final'];
                $order->save();

                $promo_result = array();
                foreach ($promo as $p => $value){
                    $promo_result[(int)$p] = $value;
                }

                $pickups_result = array();
                foreach ($pickups as $pu => $value){
                    $pickups_result[(int)$pu] = $value;
                }

                foreach ($products as $id => $quantity){
                    $orderQ = new OrdersQuantity();
                    $orderQ->order_id = $order->id;
                    $orderQ->product_id = $id;
                    $orderQ->promo = $promo_result[$id];
                    $orderQ->pickup = $pickups_result[$id];
                    $orderQ->quantity = (int)$quantity;
                    $orderQ->save();
                }
                $this->redirect('/orders/view/'.$order->id);
            }else{
                $distributor = Distributors::model()->findByPk($id);
                $this->render('add', array('templates' => $templates, 'distributor' => $distributor));
            }
        }else{
            $this->redirect('/orders/list');
        }
    }

    public function actionList()
    {
        $users = User::model()->sortById();
        $orders = Orders::model()->findAll();
        $this->render('list', array('orders' => $orders, 'users' => $users));
    }

    public function actionEdit($id)
    {
        if ($id){
            $order = Orders::model()->findByPk($id);
            $distributor = Distributors::model()->findByPk($order->distributor_id); 
            $orderQ = OrdersQuantity::model()->findAllByAttributes(array('order_id' => $id));
            $this->render('edit', array('order' => $order, 'orderQ' => $orderQ, 'distributor' => $distributor));
        }else{
            $this->redirect('/orders/list');
        }
    }

    public function actionSubmit($id)
    {
        if ($id){
            $order = Orders::model()->findByPk($id);
            if ($order->status == 0){
                // Sending Emails with XLS files

            }else{

            }
            $this->render('edit', array('order' => $order));
        }else{
            $this->redirect('/orders/list');
        }
    }

    public function actionView($id)
    {
        if ($id){
            $order = Orders::model()->findByPk($id);
            $distributor = Distributors::model()->findByPk($order->distributor_id); 
            $orderQ = OrdersQuantity::model()->findAllByAttributes(array('order_id' => $id));
            $this->render('view', array('order' => $order, 'orderQ' => $orderQ, 'distributor' => $distributor));
        }else{
            $this->redirect('/orders/list');
        }
    }

    public function actionDelete($id)
    {
        if ($id){

        }
        $this->redirect('/orders/list');
    }

    public function actionAjax(){
        $template_id = Yii::app()->request->getPost('template_id', false);
        if ($template_id){
            $template = Templates::model()->findByPk($template_id);
            $products = TemplatesProducts::model()->findAllByAttributes(array('template_id' => $template_id));
            $this->render('ajax', array('products' => $products, 'template' => $template));
        }
    }

}