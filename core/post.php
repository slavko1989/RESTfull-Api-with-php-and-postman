<?php

class Post{

	private $conn;
	private $table = "posts";


	public $post_id;
	public $cat_id;
	public $cat_name;
	public $title;
	public $body;
	public $author;
	public $create_at;

	public function __construct($db){
		$this->conn =$db;
	}

	public function read(){
		$query = 'select 
		c.cat_name as cat_name,
		p.post_id,
		p.cat_id,
		p.title,
		p.body,
		p.author,
		p.create_at
		from 
		'.$this->table .' p
		left join
		categories c on p.cat_id = c.cat_id
		order by p.create_at DESC';

		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function read_single(){
		$query = 'select 
		c.cat_name as cat_name,
		p.post_id,
		p.cat_id,
		p.title,
		p.body,
		p.author,
		p.create_at
		from 
		'.$this->table .' p
		left join
		categories c on p.cat_id = c.cat_id

		where p.post_id = ? limit 1';

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1,$this->post_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->title = $row['title'];
		$this->body = $row['body'];
		$this->author = $row['author'];
		$this->cat_id = $row['cat_id'];
		$this->cat_name = $row['cat_name'];
		
	}

	public function create(){

		$query ='insert into posts(title,body,author,cat_id)values(:title,:body,:author,:cat_id)';
		$stmt= $this->conn->prepare($query);


	/*$this->title = htmlspecialchars(strip_tags($this->title));
	$this->body = htmlspecialchars(strip_tags($this->body));
	$this->author = htmlspecialchars(strip_tags($this->author));
	$this->cat_id = htmlspecialchars(strip_tags($this->cat_id));*/

	$stmt->bindParam(':title',$this->title);
	$stmt->bindParam(':body',$this->body);
	$stmt->bindParam(':author',$this->author);
	$stmt->bindParam(':cat_id',$this->cat_id);

	if($stmt->execute()){
		return true;
	}

	printf("Error %s. \n", $stmt->error);
	return false;
	}

	public function update(){

		$query ='update  posts  set title = :title,body = :body,author = :author, cat_id = :cat_id where post_id = :post_id';
		$stmt= $this->conn->prepare($query);


	/*$this->title = htmlspecialchars(strip_tags($this->title));
	$this->body = htmlspecialchars(strip_tags($this->body));
	$this->author = htmlspecialchars(strip_tags($this->author));
	$this->cat_id = htmlspecialchars(strip_tags($this->cat_id));*/

	$stmt->bindParam(':title',$this->title);
	$stmt->bindParam(':body',$this->body);
	$stmt->bindParam(':author',$this->author);
	$stmt->bindParam(':cat_id',$this->cat_id);
	$stmt->bindParam(':post_id',$this->post_id);

	if($stmt->execute()){
		return true;
	}

	printf("Error %s. \n", $stmt->error);
	return false;

	}

	public function delete(){

		$query = 'delete from posts where post_id = :post_id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':post_id',$this->post_id);

		if($stmt->execute()){
		return true;
	}

	printf("Error %s. \n", $stmt->error);
	return false;

	}


}

?>