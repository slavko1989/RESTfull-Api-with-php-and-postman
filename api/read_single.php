<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$post = new Post($db);

$post->post_id = isset($_GET['post_id']) ? $_GET['post_id'] : die();
$post->read_single();

		$post_arr = array(
		'post_id'=> $post->post_id,
		'title'=> $post->title,
		'body'=> $post->body,
		'author'=> $post->author,
		'cat_id'=> $post->cat_id,
		'cat_name'=> $post->cat_name
		);


print_r(json_encode($post_arr));


?>