<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require   "../../predis-2.x/autoload.php";
require __DIR__ . '/../vendor/autoload.php';
use \Firebase\JWT\JWT;




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    


    if (empty($_POST["email"]) || empty($_POST["password"])) {
        echo "The fields should not be empty";
        exit();
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email";
        exit();
    }

    try {
        $dsn = "mysql:host=localhost;dbname=guvi_task";
        $dbusername = "root";
        $dbpassword = "";

        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
        $check_query = "SELECT * FROM users WHERE email = :email";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->bindParam(":email", $email);
        $check_stmt->execute();
        $existing_user = $check_stmt->fetch();

        if (!$existing_user) {
            echo "User does not exist. Register to continue.";
            exit();
        }

        if ($password === $existing_user['pwd']) {
            $key = "eruwehuehu";
            $payload = array(
                "user_id" => $existing_user['id'],
              "username" => $existing_user['username'],
              "email"=> $existing_user['email'],
              "password"=> $existing_user['pwd']
             );
            $algorithm = 'HS256';
            $jwt = JWT::encode($payload, $key, $algorithm);

            $res=array("status"=> "Success","jwt"=>$jwt);
            echo json_encode($res);
            exit();
        } else {
            echo "Invalid credentials";
            exit();
        }

    } catch(PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    echo "Error";
    exit();
}
