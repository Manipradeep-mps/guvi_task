<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");



if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        echo "The fields should not be empty";
        exit();
    }
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!preg_match("/^[a-zA-Z\-]+$/", $name)) {
        echo "Invalid name";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email";
        exit();
    }

    
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long";
        exit();
    }

    try {
        $dsn = "mysql:host=localhost;dbname=guvi_task";
        $dbusername = "root";
        $dbpassword = "";

        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $query = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            pwd VARCHAR(255) NOT NULL
        )";
        $statement = $pdo->prepare($query);
        $statement->execute();

 
        $check_query = "SELECT * FROM users WHERE email = :email";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->bindParam(":email", $email);
        $check_stmt->execute();
        $existing_user = $check_stmt->fetch();

        if ($existing_user) {
            echo "User already exists";
            exit();
        }
        
    
        $insertquery = "INSERT INTO users (username,email,pwd) VALUES (:username,:email,:pwd)";
        $stmt = $pdo->prepare($insertquery);
        $stmt->bindParam(":username", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":pwd", $password);
        $stmt->execute();

    
        $pdo = null;

        
        echo "Success";
        exit();
    } catch(PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else{
     
     echo "Error";
     exit();
}
