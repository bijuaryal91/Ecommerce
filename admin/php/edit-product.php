<?php
$host = 'localhost';
$dbname = 'rk_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['id'];
    $pname = trim($_POST['pname']);
    $short = trim($_POST['short']);
    $long = trim($_POST['long']);
    $category = trim($_POST['category']);
    $price = trim($_POST['price']);
    $material = trim($_POST['material']);
    $weight = trim($_POST['weight']);
    $stock = trim($_POST['stock']);

    // Validate if any required field is empty
    if (empty($pname) || empty($short) || empty($long) || empty($category) || empty($price) || empty($material) || empty($weight) || empty($stock)) {
        echo "Error: All fields are required.";
        exit;
    }

    // Validate price (should be a non-negative number)
    if (!is_numeric($price) || $price < 0) {
        echo "Error: Price must be a non-negative number.";
        exit;
    }

    try {
        $sql = "UPDATE products SET name = :pname, short_description = :short, long_description = :long, category_id = :category, price = :price, material = :material, weight = :weight, stock_quantity = :stock WHERE product_id = :id";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(':pname', $pname);
        $stmt->bindParam(':short', $short);
        $stmt->bindParam(':long', $long);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':material', $material);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':id', $id);
    
        $success = $stmt->execute();
    
        if ($success) {
            echo "success";
        } else {
            echo "Update failed!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
}
