<?php

// MongoDB
$connection = new MongoClient(global_mongodb_database);
$db = $connection->playgroundreservation;   //playgroundreservation is the name of the database

include_once('playground_functions_mongo.php');
include_once('userfunctions_mongo.php');
include_once('utilityFunctions.php');

?>