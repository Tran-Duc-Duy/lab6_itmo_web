<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
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

  // Set ID to update
  $product->id = $data->id;

  $product->name = $data->name;
  $product->price = $data->price;
  $product->description = $data->description;

  // Update product
  if($product->update()) {
    echo json_encode(
      array('message' => 'Product Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Product Not Updated')
    );
  }