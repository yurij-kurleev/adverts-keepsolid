<?php
class AjaxController{
    public function indexAction(){
        $fc = FrontController::getInstance();
        $model = new IndexModel();//model init
        $result = $model->countPostPages();
        $fc->setBody($result);
    }

    public function searchAction(){
        $fc = FrontController::getInstance();
        $model = new IndexModel();//model init
        $phrase = "%".$_REQUEST['searchRequest']."%";
        $result = count($model->searchPostsByKeywords($phrase));
        if($result % LIMIT != 0){
            $pages =  (int)($result / LIMIT) + 1;
        } else{
            $pages = $result / LIMIT;
        }
        $fc->setBody($pages);
    }

    public function categoryAction(){
        $fc = FrontController::getInstance();
        $model = new IndexModel();//model init
        $params = $fc->getParams();
        $result = count($model->getPostsByCategoryId($params[0]));
        if($result % LIMIT != 0){
            $pages =  (int)($result / LIMIT) + 1;
        } else{
            $pages = $result / LIMIT;
        }
        $fc->setBody($pages);
    }
/*
    public function aboutAction(){
        $fc = FrontController::getInstance();
        $model = new UserModel();//model init
        $result = count($model->getUserPosts($_SESSION['id_u']));
        if($result % LIMIT != 0){
            $pages =  (int)($result / LIMIT) + 1;
        } else{
            $pages = $result / LIMIT;
        }
        $fc->setBody($pages);
    }
*/
}