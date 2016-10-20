<?php
class IndexController{
    public function indexAction(){
        $fc = FrontController::getInstance();
        //Get Params
        $params = $fc->getParams();
        $model = new IndexModel();//model init
        if(empty($params[0])){
            $data['posts'] = $model->getAllPosts(1);
            $data['categories'] = $model->getAllCategories();
            $result = $fc->render('../views/indexView.php', $data);
        }
        else{
            $data['posts'] = $model->getAllPosts($params[0]);
            $result = $fc->ajaxRender('../views/indexView.php', $data);
        }
        $fc->setBody($result);
    }

    public function addAction(){
        $fc = FrontController::getInstance();
        $model = new IndexModel();//model init
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data = [
                'id_cat' => abs((int)$_POST['category']),
                'topic' => strip_tags(trim($_POST['topic'])),
                'body' => strip_tags(trim($_POST['text'])),
                'author_id' => $_SESSION['id_u'],
                'email' => strip_tags(trim($_POST['email'])),
                'phone' => strip_tags(trim($_POST['telephone'])),
                'city' => strip_tags(trim($_POST['city'])),
                'country' => strip_tags(trim($_POST['country'])),
                'price' => abs((int)$_POST['price']),
                'add_time' => time()
            ];
            foreach ($data as $item){
                if(empty($item)){
                    header("Location: /index/add");
                    exit();
                }
            }
            $model->insertPost($data);
            if(!empty($_FILES['photo']['name'])){
                $model->addUserPhoto($_FILES['photo']['name'], $model->getLastPostId(), $_FILES['photo']['tmp_name']);
            }
            $url = "/index/index";
            header("Location: $url");
            exit();
        }
        //Get Params
        $data['categories'] = $model->getAllCategories();
        $result = $fc->render('../views/add_advert.php', $data);
        $fc->setBody($result);
    }

    public function moreAction(){
        $fc = FrontController::getInstance();
        $indexModel = new IndexModel();//model init
        $userModel = new UserModel();
        $indexModel->increaseViews($fc->getParams()[0]);
        $data['post'] = $indexModel->getExtendedPostInfo($fc->getParams()[0]);
        $data['categories'] = $indexModel->getAllCategories();
        $data['user'] = $userModel->getOneUserById($data['post']['author_id']);
        $result = $fc->render('../views/moreView.php', $data);
        $fc->setBody($result);
    }
    
    public function searchAction(){
        $fc = FrontController::getInstance();
        $params = $fc->getParams();
        $phrase = "%".trim(strip_tags($_REQUEST['searchRequest']))."%";
        $model = new IndexModel();
        if(empty($params[0])){
            $data['posts'] = $model->searchPostsByKeywords($phrase, 1);
        }
        else {
            $data['posts'] = $model->searchPostsByKeywords($phrase, $params[0]);
        }
        $result = $fc->ajaxRender('../views/searchView.php', $data);
        $fc->setBody($result);
    }

    public function categoryAction(){
        $fc = FrontController::getInstance();
        //Get Params
        $params = $fc->getParams();
        $model = new IndexModel();//model init
        if(empty($params[1])){
            $data['posts'] = $model->getPostsByCategoryId($params[0], 1);
            $data['categories'] = $model->getAllCategories();
            $result = $fc->render('../views/categoryView.php', $data);
        } else{
            $data['posts'] = $model->getPostsByCategoryId($params[0], $params[1]);
            $result = $fc->ajaxRender('../views/categoryView.php', $data);
        }
        $fc->setBody($result);
    }
    
    public function deleteAction(){
        $fc = FrontController::getInstance();
        $model = new IndexModel();//model init
        $model->deletePost($_POST['id_ad']);
        $data['posts'] = $model->getAllPosts($_POST['id_page']);
        $result = $fc->ajaxRender('../views/indexView.php', $data);
        $fc->setBody($result);
    }
    
    public function editAction(){
        $fc = FrontController::getInstance();
        $params = $fc->getParams();
        $indexModel = new IndexModel();
        if($_SESSION['id_u'] == $indexModel->getExtendedPostInfo($params[0])['author_id'] || $_SESSION['is_admin'] == true){
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $data = [
                    'id_ad' => $params[0],
                    'id_cat' => abs((int)$_POST['category']),
                    'topic' => strip_tags(trim($_POST['topic'])),
                    'body' => strip_tags(trim($_POST['text'])),
                    'email' => strip_tags(trim($_POST['email'])),
                    'phone' => strip_tags(trim($_POST['telephone'])),
                    'city' => strip_tags(trim($_POST['city'])),
                    'country' => strip_tags(trim($_POST['country'])),
                    'price' => abs((int)$_POST['price']),
                    'add_time' => time()
                ];
                foreach ($data as $item){
                    if(empty($item)){
                        header("Location: /index/edit");
                        exit();
                    }
                }
                $indexModel->editPost($data);
                $url = "/index/more/".$params[0];
                header("Location: $url");
                exit();
            }
            $data['post'] = $indexModel->getExtendedPostInfo($params[0]);
            $data['categories'] = $indexModel->getAllCategories();
            $result = $fc->render('../views/editAdvertView.php', $data);
            $fc->setBody($result);
        } else {
            header("Location: /index/more/".$params[0]);
        }
    }
}