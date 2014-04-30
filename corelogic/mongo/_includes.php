<?php

// MongoDB
$connection = new MongoClient(global_mongodb_database);

try{
  echo "Connecting to database";
$db = $connection->heroku_app24497420;   //playgroundreservation is the name of the database
}catch(MongoException $e)
{
  echo "ConnectFailed";
}

include_once('playground_functions_mongo.php');
include_once('userfunctions_mongo.php');
include_once('utilityFunctions.php');

?>
