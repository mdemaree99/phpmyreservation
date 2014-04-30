<?php

// MongoDB
$connection = new MongoClient(global_mongodb_database);
$db = $connection->heroku_app24497420;   //playgroundreservation is the name of the database

include_once('playground_functions_mongo.php');
include_once('userfunctions_mongo.php');
include_once('utilityFunctions.php');

?>
