<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';





//$client = new MongoDB\Client("mongodb://localhost:27017");

$collection = (new MongoDB\Client)->test->users;

$insertOneResult = $collection->insertOne([
    'username' => 'admin',
    'email' => 'admin@example.com',
    'name' => 'Admin User',
]);

printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

var_dump($insertOneResult->getInsertedId());
die;





echo '<pre>';
print_r(get_declared_classes());
die;

// Manager Class
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

// Query Class
//$query = new MongoDB\Driver\Query(array('age' => 30));
$query = new MongoDB\Driver\Query([]);

// Output of the executeQuery will be object of MongoDB\Driver\Cursor class
//$cursor = $manager->executeQuery('testDb.testColl', $query);
$cursor = $manager->executeQuery('blogpost.movie', $query);

// Convert cursor to Array and print result
print_r($cursor->toArray());



echo '<pre>';
print_r(get_declared_classes());


/*
$class_methods = get_class_methods(new MongoClient());

foreach ($class_methods as $method_name) {
    echo "$method_name\n";
}
*/
