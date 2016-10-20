<?php
include $_SERVER['DOCUMENT_ROOT']."/assets/settings.php";

class UserModel{
    public function addUser(array $user_data){
        try{
            $connection = PDOConnection::getInstance()->getConnection();
            $sql = "INSERT INTO User(name, surname, login, password, email, path_to_photo, register_date, is_admin)
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->execute(array($user_data['name'], $user_data['surname'], $user_data['login'], $user_data['password'],
                $user_data['email'], $user_data['path_to_photo'], $user_data['register_date'], $user_data['is_admin']));
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }

    public function createDirectory($title){
        $dir = $_SERVER['DOCUMENT_ROOT'].'/photos/avatars/'.$title;
        if(!file_exists($dir)){
            mkdir($dir, 0666);
        }
        return $dir;
    }

    public function addAvatar($file_name, $dir_title, $tmp_name){
        $directory = $this->createDirectory($dir_title);
        $path_to_photo = "";
        if(!empty($file_name)){
            $save_path = $directory.'/'.$file_name;
            move_uploaded_file($tmp_name, $save_path);
            $path_to_photo = "/photos/avatars/".basename($directory)."/".$file_name;
        }
        return $path_to_photo;
    }

    public function getLastUserId(){
        $result = 0;
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT id_u FROM User
                    ORDER BY id_u DESC
                    LIMIT 1";
            $stmt = $link->prepare($sql);
            $stmt->execute();
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
            $result = $stmt->fetch()[0];
        } catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        } finally {
            return $result;
        }
    }
    
    public function searchUser(array $data){
        $result = [];
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT id_u, is_admin FROM User
                    WHERE login = ? AND password = ?";
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $data['login'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['password'], PDO::PARAM_STR);
            $stmt->execute();
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
            $result = $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            return $result;
        }
    }

    public function getOneUserById($id_u){
        $result = [];
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT id_u, name, surname, login, password, email, path_to_photo, register_date, is_admin
                    FROM User
                    WHERE id_u = ?";
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $id_u, PDO::PARAM_INT);
            $stmt->execute();
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        }
        finally{
            return $result;
        }
    }
    
    public function isRegistered($login){
        $result = false;
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT id_u FROM User WHERE login = ?";
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $login, PDO::PARAM_STR);
            $stmt->execute();
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($user)){
                $result = true;
            }
        } catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        }
        finally{
            return $result;
        }
    }

    public function getUserPosts($id_u, $page = 0){
        $result = [];
        $limit = LIMIT;
        $offset = ($page - 1) * LIMIT;
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT a.id_ad, a.topic, a.body, a.add_time, a.views, 
                    a.price, a.phone, a.city, a.country, a.author_id, u.name, u.surname, c.title, p.reference
                    FROM Advert a
                    INNER JOIN User u INNER JOIN Category c INNER JOIN Picture p
                    ON a.author_id = u.id_u AND a.id_cat = c.id_cat AND p.advert_id = a.id_ad
                    WHERE a.author_id = ?
                    ORDER BY add_time DESC ";
            if($page != 0){
                $sql .= "LIMIT ? OFFSET ?";
            }
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $id_u, PDO::PARAM_INT);
            if($page != 0){
                $stmt->bindParam(2, $limit, PDO::PARAM_INT);
                $stmt->bindParam(3, $offset, PDO::PARAM_INT);
            }
            $stmt->execute();
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
            $result = $stmt->fetchAll();
        } catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        }
        finally{
            return $result;
        }
    }
}