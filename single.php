<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'app.php';


// Fetch all the posts
$post = $db->getById($_GET['id'],'posts');
if ($post == FALSE) {	
	header('Location: index.php');
	
} else {
	
	$layout->view('single', array(
		'article' => $post
	));
}
