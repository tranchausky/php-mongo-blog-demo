<?php

require_once __DIR__ . '/vendor/autoload.php';

include 'config.php';
include 'layout.php';
include 'db.php';

use Blog\DB,
	Blog\Layout;

// Constructor to the db
$db = new DB\DB($config);

// Constructor to layout view
$layout = new Layout\Layout();