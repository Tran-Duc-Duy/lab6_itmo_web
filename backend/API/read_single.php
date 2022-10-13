<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once './../config/db.php';
  include_once './../models/product.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate product object
  $product = new Product($db);

  // Get ID
  $product->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get product
  $product->read_single();

  // Create array
  $product_arr = array(
    'id' => $product->id,
    'name' => $product->name,
    'price' => $product->price,
    'description' => $product->description
  );

  // Make JSON
  print_r(json_encode($product_arr));