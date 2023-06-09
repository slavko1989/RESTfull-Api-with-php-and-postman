<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once('../core/initialize.php');

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

$post->post_id = $data->post_id;
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->cat_id = $data->cat_id;

if($post->update()){

	echo json_encode(
		array('message','post updated'));
}else{
	echo json_encode(array('message','post not updated'));
}