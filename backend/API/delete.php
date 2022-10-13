<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once './../config/db.php';
  include_once './../models/product.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate product object
  $product = new Product($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  //$my_id = $_GET['id'];

  // Set ID to update
  //$product->id = $my_id;//$data->id
  $product->id = $data->id;
  
  // Delete product
  if($product->delete()) {
    echo json_encode(
      array('message' => 'product Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'product Not Deleted')
    );
  }