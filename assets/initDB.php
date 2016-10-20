<?php
include_once "settings.php";
include_once $_SERVER['DOCUMENT_ROOT']."/protected/library/PDOConnection.php";

//Connect
try{
    $link = PDOConnection::getInstance()->getConnection();
}catch (PDOException $e){
    echo $e->getCode().": ".$e->getMessage();
    exit();
}

//Category
$sql = "CREATE TABLE IF NOT EXISTS Category
(id_cat INT(11) NOT NULL AUTO_INCREMENT,
 title VARCHAR(50) NOT NULL,
 PRIMARY KEY (id_cat))";
try{
    $link->exec($sql);
    print_r($link->errorInfo());
}catch (PDOException $e){
    echo $e->getCode().": ".$e->getMessage();
    exit();
}

//User
$sql = "CREATE TABLE IF NOT EXISTS User
(id_u INT(11) NOT NULL AUTO_INCREMENT,
 name VARCHAR(75) NOT NULL,
 surname VARCHAR(75) NOT NULL,
 login VARCHAR(100) NOT NULL,
 password VARCHAR(100) NOT NULL,
 email VARCHAR(50) NOT NULL,
 path_to_photo VARCHAR(200),
 register_date INT(14) NOT NULL,
 is_admin INT(4) NOT NULL,
 PRIMARY KEY (id_u),
 UNIQUE (login))";
try{
    $link->exec($sql);
    print_r($link->errorInfo());
}catch (PDOException $e){
    echo $e->getCode().": ".$e->getMessage();
    exit();
}

//Advert
$sql = "CREATE TABLE IF NOT EXISTS Advert
(id_ad INT(11) NOT NULL AUTO_INCREMENT,
 topic VARCHAR(150) NOT NULL,
 body TEXT NOT NULL,
 add_time INT(20) NOT NULL,
 views INT(11) DEFAULT 1,
 author_id INT(11) NOT NULL,
 price DECIMAL(10, 2) NOT NULL,
 phone VARCHAR(20) NOT NULL,
 city VARCHAR(50) NOT NULL,
 country VARCHAR(50) NOT NULL,
 id_cat INT(11) NOT NULL,
 PRIMARY KEY (id_ad),
 FOREIGN KEY(author_id) REFERENCES User(id_u)
 ON DELETE CASCADE
 ON UPDATE CASCADE,
 FOREIGN KEY(id_cat) REFERENCES Category(id_cat)
 ON DELETE CASCADE
 ON UPDATE CASCADE)";
try{
    $link->exec($sql);
    print_r($link->errorInfo());
}catch (PDOException $e){
    echo $e->getCode().": ".$e->getMessage();
    exit();
}

//Picture
$sql = "CREATE TABLE IF NOT EXISTS Picture
(id_p INT(11) NOT NULL AUTO_INCREMENT,
 reference VARCHAR(150) NOT NULL,
 advert_id INT(11) NOT NULL,
 PRIMARY KEY (id_p),
 FOREIGN KEY(advert_id) REFERENCES Advert(id_ad)
 ON DELETE CASCADE
 ON UPDATE CASCADE)";
try{
    $link->exec($sql);
    print_r($link->errorInfo());
}catch (PDOException $e){
    echo $e->getCode().": ".$e->getMessage();
    exit();
}

echo "Completed";