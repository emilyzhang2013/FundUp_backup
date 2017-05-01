<?php
/**
 * Created by PhpStorm.
 * User: louis
 * Date: 4/29/17
 * Time: 8:54 PM
 */
session_start();
require_once ('include/dbconfig.php');
$pdo = db_connect();
$stmt = $pdo -> prepare("SELECT cover FROM Project WHERE pid = :pid");
$stmt -> execute([':pid' => $_GET['pid']]) or die("Cannot get image(s) for the project");
$result = $stmt -> fetch();
header("Content-type: image/JPEG",true);
header("Content-type: image/PNG",true);
echo $result['cover'];
