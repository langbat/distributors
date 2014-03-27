<?php

class RoutesController extends Controller {

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
        $this->redirect("/routes/list");
    }

    public function actionMap()
    {
        $id = Yii::app()->request->getParam('id', false);
        $result = array();
        if ($id){
            $route = Routes::model()->findByPk($id);
            $distributors = Rd::model()->findAllByAttributes(array('route_id' => $route->id));
            $return = array();
            foreach($distributors as $d){
                $distributor = Distributors::model()->findByPk($d->distributor_id);
                $return[] = $distributor;
            }
            $result = array(array('route' => $route, 'distributors' => $return));
            $count = 1;
        }
        $this->render('map', array('result' => $result, 'count' => $count));
    }

    public function actionGlobal()
    {
        $result = array();
        $routes = Routes::model()->findAll();
        foreach ($routes as $route){
            $array['route'] = $route;
            $distributors = Rd::model()->findAllByAttributes(array('route_id' => $route->id));
            $return = array();
            foreach($distributors as $d){
                $distributor = Distributors::model()->findByPk($d->distributor_id);
                $return[] = $distributor;
            }
            $array['distributors'] = $return;
            $result[] = $array;
        }
        $count = count($result);
        $this->render('map', array('result' => $result, 'count' => $count));
    }

    public function actionAdd()
    {
        $states = States::model()->findAll();
        $companies = Companies::model()->findAll();
        $this->render('add', array('states' => $states, 'companies' => $companies));
    }

    public function actionList()
    {
        $routes = Routes::model()->findAll();
        $result = array(
            1 => array('name' => "QLD Routes", 'routes' => array()),
            2 => array('name' => "NSW/ACT Routes", 'routes' => array()),
            3 => array('name' => "VIC/TAS Routes", 'routes' => array()),
            4 => array('name' => "SA Routes", 'routes' => array()),
            5 => array('name' => "WA Routes", 'routes' => array()),
            6 => array('name' => "NT Routes", 'routes' => array())
        );
        foreach ($routes as $route){
            $new = $route;
            switch ($route->state_id){
                case 1:
                    $result[1]['routes'][] = $new;
                    break;
                case 2:
                    $result[2]['routes'][] = $new;
                    break;
                case 3:
                    $result[3]['routes'][] = $new;
                    break;
                case 4:
                    $result[2]['routes'][] = $new;
                    break;
                case 5:
                    $result[3]['routes'][] = $new;
                    break;
                case 6:
                    $result[4]['routes'][] = $new;
                    break;
                case 7:
                    $result[5]['routes'][] = $new;
                    break;
                case 8:
                    $result[6]['routes'][] = $new;
                    break;
            }
        }

        $this->render('list', array('results' => $result));
    }

    public function actionEdit($id)
    {
        if ($id){

        }else{
            $this->redirect('/routes/list');
        }
    }

    public function actionActive($id)
    {
        if ($id){

        }else{
            $this->redirect('/routes/list');
        }
    }

    public function actionStart($id)
    {
        if ($id){
            $session = RoutesSession::model()->findByAttributes(array('status' => 1));
            if (count($session) > 0){
                $this->redirect('/routes/list');
            }else{
                $routes_session = new RoutesSession();
                $routes_session->user_id = Yii::app()->user->id;
                $routes_session->route_id = $id;
                $routes_session->status = 1;
                $routes_session->start_date = date("Y-m-d");
                $routes_session->save();
                $this->redirect('/routes/active/'.$routes_session->id);
            }
        }
    }

    public function actionComplete($id)
    {
        if ($id){

        }else{
            $this->redirect('/routes/list');
        }
    }

    public function actionAjax()
    {
        $state_id = Yii::app()->request->getPost('state_id', false);
        $company_id = Yii::app()->request->getPost('company_id', false);
        $suppliers = Suppliers::model()->getSuppliers();
        $groups = Groups::model()->getGroups();
        $regions = Regions::model()->getRegions();

        $criterias = array();
        $criterias['state_id'] = (int)$state_id;
        $criterias['company_id'] = (int)$company_id;
        $distributors = Distributors::model()->findAllByAttributes($criterias);
        $this->render('distributors_list', array(
                'distributors' => $distributors,
                'suppliers' => $suppliers,
                'groups' => $groups,
                'regions' => $regions
            )
        );
    }

    public function actionCreate()
    {
        $title = Yii::app()->request->getPost('title', false);
        $state_id = Yii::app()->request->getPost('state_id', false);
        $days = Yii::app()->request->getPost('days', false);
        $duration = Yii::app()->request->getPost('duration', false);
        $company_id = Yii::app()->request->getPost('company_id', false);
        $distributors = Yii::app()->request->getPost('distributors', false);
        $route = new Routes();
        $route->title = $title;
        $route->state_id = $state_id;
        $route->days = $days;
        $route->duration = $duration;
        $route->user_id = Yii::app()->user->id;
        $route->save();
        $id = $route->id;
        foreach ($distributors as $day => $d){
            foreach ($d as $value){
                $rd = new Rd();
                $rd->route_id = $id;
                $rd->distributor_id = $value;
                $rd->day = $day;
                $rd->save();
            }
        }
        return true;
    }

    public function actionView()
    {
        $this->render('view', array());
    }

    public function actionDelete($id)
    {
        if ($id){

        }else{
            $this->redirect('/routes/list');
        }
    }

}