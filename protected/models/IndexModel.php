<?php
include $_SERVER['DOCUMENT_ROOT']."/assets/settings.php";

class IndexModel{
    public function insertPost(array $data){
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "INSERT INTO Advert(topic, body, add_time, author_id,
                price, phone, city, country, id_cat) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($sql);
            $stmt->execute([$data['topic'], $data['body'], $data['add_time'],
                $data['author_id'], $data['price'], $data['phone'],
                $data['city'], $data['country'], $data['id_cat']]);
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
        } catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }

    public function getAllPosts($page){
        $result = [];
        $limit = LIMIT;
        $offset = ($page - 1) * $limit;
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT a.id_ad, a.topic, a.body, a.add_time, a.views, 
                    a.price, a.phone, a.city, a.country, a.author_id, u.name, u.surname, c.title, p.reference
                    FROM Advert a
                    INNER JOIN User u INNER JOIN Category c INNER JOIN Picture p
                    ON a.author_id = u.id_u AND a.id_cat = c.id_cat AND p.advert_id = a.id_ad
                    ORDER BY add_time DESC
                    LIMIT ? OFFSET ?";
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $limit, PDO::PARAM_INT);
            $stmt->bindParam(2, $offset, PDO::PARAM_INT);
            $stmt->execute();
            if(!empty($stmt->errorInfo()[1])){
                var_dump($page);
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

    public function getPostsByCategoryId($category, $page = 0){
        $result = [];
        $limit = LIMIT;
        $offset = ($page - 1) * $limit;
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT a.id_ad, a.topic, a.body, a.add_time, a.views, 
                    a.price, a.phone, a.city, a.country, a.author_id, a.id_cat, u.name, u.surname, c.title, p.reference
                    FROM Advert a
                    INNER JOIN User u INNER JOIN Category c INNER JOIN Picture p
                    ON a.author_id = u.id_u AND a.id_cat = c.id_cat AND p.advert_id = a.id_ad
                    WHERE a.id_cat = ?
                    ORDER BY add_time DESC ";
            if($page != 0){
                $sql .= "LIMIT ? OFFSET ?";
            }
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $category, PDO::PARAM_INT);
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

    public function getExtendedPostInfo($index){
        $result = [];
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT a.id_ad, a.topic, a.body, a.add_time, a.views, 
                    a.price, a.phone, a.city, a.country, a.author_id, u.name, u.surname, u.email, c.title, c.id_cat, p.reference
                    FROM Advert a
                    INNER JOIN User u INNER JOIN Category c INNER JOIN Picture p
                    ON a.author_id = u.id_u AND a.id_cat = c.id_cat AND p.advert_id = a.id_ad
                    WHERE id_ad = ?";
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $index, PDO::PARAM_INT);
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

    public function getAllCategories(){
        $result = [];
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT id_cat, title FROM Category
                    ORDER BY title ASC";
            $stmt = $link->prepare($sql);
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

    public function increaseViews($post_id){
        try {
            $views = $this->getExtendedPostInfo($post_id)['views'] + 1;
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "UPDATE Advert SET views = ? WHERE id_ad = ?";
            $stmt = $link->prepare($sql);
            $stmt->execute([$views, $post_id]);
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
        } catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }

    public function searchPostsByKeywords($phrase, $page = 0){
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
                    WHERE a.topic LIKE ?
                    ORDER BY add_time DESC ";
            if($page != 0){
                $sql .= "LIMIT ? OFFSET ?";
            }
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $phrase, PDO::PARAM_STR);
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
    
    public function countPostPages(){
        $result = 0;
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT COUNT(*) FROM Advert";
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
            if($result % LIMIT != 0){
                return (int)($result / LIMIT) + 1;
            } else{
                return $result / LIMIT;
            }
        }
    }
    
    public function getLastPostId(){
        $result = 0;
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "SELECT id_ad FROM Advert
                    ORDER BY id_ad DESC
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

    public function createDir($title){
        $dir = $_SERVER['DOCUMENT_ROOT'].'/photos/'.$title;
        if(!file_exists($dir)){
            mkdir($dir, 0666);
        }
        return $dir;
    }

    public function addUserPhoto($file_name, $dir_title, $tmpfilename){
        $directory = $this->createDir($dir_title);
        $timestamp = time();
        $path_to_photo = "";
        if(!empty($file_name)){
            $save_path = $directory.'/'.$timestamp.'_'.$file_name;
            move_uploaded_file($tmpfilename, $save_path);
            $path_to_photo = "/photos/".basename($directory)."/$timestamp"."_"."$file_name";
        }
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "INSERT INTO Picture(reference, advert_id) VALUES(?, ?)";
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $path_to_photo, PDO::PARAM_STR);
            $stmt->bindParam(2, $dir_title, PDO::PARAM_INT);
            $stmt->execute();
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
        } catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }
    
    public function deletePost($id){
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "DELETE FROM Advert WHERE id_ad = ?";
            $stmt = $link->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
        } catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }

    public function editPost($data){
        try {
            $link = PDOConnection::getInstance()->getConnection();
            $sql = "UPDATE Advert
                    SET topic = ?, body = ?, add_time = ?, price = ?,
                        phone = ?, city = ?, country = ?, id_cat = ?
                    WHERE id_ad = ?";
            $stmt = $link->prepare($sql);
            $stmt->execute([$data['topic'], $data['body'], $data['add_time'], $data['price'],
                            $data['phone'], $data['city'], $data['country'], $data['id_cat'], $data['id_ad']]);
            if(!empty($stmt->errorInfo()[1])){
                print_r($stmt->errorInfo());
                exit();
            }
        } catch (PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }
}