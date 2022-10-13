<?php 
  class Product {
    // DB stuff
    private $conn;
    private $table = 'products';

    // Product Properties
    public $id;
    public $name;
    public $price;
    public $description;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get products
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table ;
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single product
    public function read_single() {
          // Create query
          $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->name = $row['name'];
          $this->price = $row['price'];
          $this->description = $row['description'];
    }

    // Create product
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . " SET name = :name, price = :price, description = :description";

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->price = htmlspecialchars(strip_tags($this->price));
          $this->description = htmlspecialchars(strip_tags($this->description));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':price', $this->price);
          $stmt->bindParam(':description', $this->description);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update product
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET 
        name = :name, 
        price = :price, 
        description = :description WHERE id = :id ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind data
        $stmt->bindParam(':id', $this->id,\PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete product
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }