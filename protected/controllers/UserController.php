<?php
class UserController{
    public function registerAction(){
        $fc = FrontController::getInstance();
        $indexModel = new IndexModel();//model init
        $userModel = new UserModel();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data = [
                'name' => strip_tags(trim($_POST['name'])),
                'surname' => strip_tags(trim($_POST['surname'])),
                'login' => md5(md5(strip_tags(trim($_POST['login'])))),
                'password' => md5(md5(strip_tags(trim($_POST['password'])))),
                'email' => strip_tags(trim($_POST['email'])),
                'register_date' => time()
            ];
            foreach ($data as $key => $item){
                if(empty($item)){
                    $_SESSION['error_msg'] = "Заполните поле $key!";
                    header("Location: /user/register");
                    exit();
                }
            }
            if($userModel->isRegistered($data['login'])){
                $_SESSION['error_msg'] = "Извините, но пользователь с таким логином уже зарегистрирован";
                header("Location: /index/index");
                exit();
            }
            $data['is_admin'] = 0;
            if(!empty($_FILES['avatar']['name'])){
                $data['path_to_photo'] = $userModel->addAvatar($_FILES['avatar']['name'], $userModel->getLastUserId() + 1, $_FILES['avatar']['tmp_name']);
            }
            $userModel->addUser($data);
            $_SESSION['id_u'] = $userModel->getLastUserId();
            $_SESSION['is_admin'] = $userModel->getOneUserById($_SESSION['id_u'])['is_admin'];
            $url = "/index/index";
            header("Location: $url");
            exit();
        }
        $data['categories'] = $indexModel->getAllCategories();
        $result = $fc->render('../views/registerView.php', $data);
        $fc->setBody($result);
    }

    public function loginAction(){
        $userModel = new UserModel();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data = [
                'login' => md5(md5(strip_tags(trim($_POST['login'])))),
                'password' => md5(md5(strip_tags(trim($_POST['password'])))),
            ];
            $user = $userModel->searchUser($data);
            if(!empty($user)){
                $_SESSION['id_u'] = $user[0];
                $_SESSION['is_admin'] = $user[1];
            } else {
                $_SESSION['error_msg'] = "Неверный логин или пароль!";
            }
            $url = "/index/index";
            header("Location: $url");
            exit();
        }
    }

    public function aboutAction(){
        $fc = FrontController::getInstance();
        $userModel = new UserModel();
        $indexModel = new IndexModel();
        $params = $fc->getParams();
        if($_SESSION['id_u'] == $params[0]){
            $data['user'] = $userModel->getOneUserById($params[0]);
            $data['categories'] = $indexModel->getAllCategories();
            $data['posts'] = $userModel->getUserPosts($params[0]);
            $result = $fc->render('../views/aboutUserView.php', $data);
            $fc->setBody($result);
        } else {
            header("Location: /index/index");
        }
    }

    public function editAction(){
        $fc = FrontController::getInstance();
        $userModel = new UserModel();
        $indexModel = new IndexModel();
        $params = $fc->getParams();
        if($_SESSION['id_u'] == $params[0]){
            $data['user'] = $userModel->getOneUserById($params[0]);
            $data['categories'] = $indexModel->getAllCategories();
            $data['posts'] = $userModel->getUserPosts($params[0]);
            $result = $fc->render('../views/editUserView.php', $data);
            $fc->setBody($result);
        } else {
            header("Location: /index/index");
        }
    }
}