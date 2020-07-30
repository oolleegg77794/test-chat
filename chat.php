<?php  

$db = new mysqli("localhost", "root", "", "chat");
if($db->connect_error){
	die("Connection failed: " . $db->connect_error);
}


$result = array();
$message = isset($_POST['message']) ? $_POST['message'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;

if (!empty($message) && !empty($name)) {
	$sql = "INSERT INTO chats (message, name) VALUES ('$message', '$name')";
	$result['send_status'] = $db->query($sql);
}

//print messages
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$item = $db -> query("SELECT * FROM chats WHERE id > '$start'"); 
while ($row = mysqli_fetch_assoc($item)){
	$result['items'][] = $row;
}

$db->close();
 
header( 'Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo json_encode($result);

/*
$errors = "";
$link = mysqli_connect('localhost', 'root', '','chat') 
    or die("Ошибка " . mysqli_error($link));
$message = isset($_POST['message']) ? $_POST['message'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;
mysqli_query($link ,"INSERT INTO chats (message, name) VALUES ('$message', '$name')");
*/
?>