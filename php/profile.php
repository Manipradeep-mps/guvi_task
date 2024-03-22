<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require __DIR__ . '/../vendor/autoload.php';
use \Firebase\JWT\JWT;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jwt = $_POST["jwt"];
    $secretKey = ["eruwehuehu"]; 

    try {
        $headers = new stdClass();

        $decoded = JWT::decode($jwt, $secretKey, $headers);

        $decodedJson = json_encode($decoded);
        $userData = getUserDataFromDatabase($userId);
          echo $decodedJson;
          exit();
    } catch (Exception $e) {
        
        echo "Error: " . $e->getMessage();
    }
}

function getUserDataFromDatabase($id){
    function getUserDataFromDatabase($id) {
        try {
            $dsn = "mysql:host=localhost;dbname=guvi_task";
            $dbusername = "root";
            $dbpassword = "";
    
        
            $pdo = new PDO($dsn, $dbusername, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            
            $query = "SELECT * FROM users WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
    
        
            $userData = $statement->fetch(PDO::FETCH_ASSOC);
    
        
            $pdo = null;
    
            return $userData; 
        } catch(PDOException $e) {
            
            return null; 
        }
    }
    


}
