<?php
/**
 * Created by PhpStorm.
 * User: louis
 * Date: 4/26/17
 * Time: 4:27 PM
 */
require_once("include/helpfulFunctions.php");

function db_connect() {
    $servername = "localhost:3306";
    $username = "root";
    $password = "920930";
    try {
        $conn = new PDO("mysql:host=$servername; dbname=FundUp", $username, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        warningMessage("Connection failed, catched an PDOException." . $e->getMessage());
    }
    if (!$conn) {
        return false;
    }
    return $conn;
}

?>