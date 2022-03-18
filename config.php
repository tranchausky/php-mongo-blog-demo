<?php
//define('URL', 'http://duythien.dev/sitepoint/blog-mongodb');
define('URL', 'http://172.19.71.5/php-mongodb-master');
define('UserAuth', 'chau');
define('PasswordAuth', '123456789');

$config = array(
	'username' => 'chau',
	'password' => '123456789',
	'dbname'   => 'blogpost',
	//'cn' 	   => sprintf('mongodb://%s:%d/%s', $hosts, $port,$database),
	//'connection_string'=> sprintf('mongodb://%s:%d/%s','127.0.0.1','27017','blogpost')
	'connection_string'=> "mongodb://localhost:27017"
);
