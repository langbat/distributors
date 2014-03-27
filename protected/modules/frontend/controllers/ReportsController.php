<?php

class ReportsController extends Controller {

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
        $this->redirect("/reports/list");
    }

    public function actionAdd()
    {
        $this->render('add', array());
    }

    public function actionList()
    {
        $this->render('list', array());
    }

    public function actionEdit($id)
    {
        if ($id){

        }
    }

    public function actionView()
    {
        $this->render('view', array());
    }

    public function actionDelete($id)
    {
        if ($id){

        }
        $this->redirect('/reports/list');
    }

    public function actionAjax(){
        $request = Yii::app()->request->getPost('request', false);
        if ($request){

        }
    }

    public function actionContactlog($id)
    {
        if ($id){
            if (isset($_POST)){

            }else{
                $this->render('/reports/contactlog');
            }
        }else{
            $this->redirect('/distributors/');
        }
    }

}