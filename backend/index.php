<?php
$data = json_decode(file_get_contents("php://input")); 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;


$app->get('/person', 'getPersons');
$app->post('/person', 'addPerson');
$app->post('/person/update/:id', 'updatePerson');
$app->post('/person/delete/:id', 'deletePerson');
$app->run();

//Select All
function getPersons() {
    try {
        $db = getConnection();
        $stmt = $db->query('select * from person');
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Save Data
function addPerson() {
	
    global $app;
	$data = json_decode(file_get_contents("php://input")); 

    $sql = "insert into person values(?,?,?,?)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $data->id);
        $stmt->bindParam(2, $data->name);
        $stmt->bindParam(3, $data->address);
        $stmt->bindParam(4, $data->hobbies);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Edit Data
function updatePerson($id) {
	$data = json_decode(file_get_contents("php://input")); 
	$sql = "update person set name=?,address=?,hobbies=? where id = ?";
	
	try{
		echo 'dentro echo';
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $data->name);
        $stmt->bindParam(2, $data->address);
        $stmt->bindParam(3, $data->hobbies);
        $stmt->bindParam(4, $data->id);
        $stmt->execute();
	}catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Delete Data
function deletePerson($id) {

	$data = json_decode(file_get_contents("php://input"));
	$sql = "delete from person where id = :id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('id',$data->id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Connection Database
function getConnection() {
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "sabmas01";
    $dbname = "bookstore";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
