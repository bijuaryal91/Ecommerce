<?php
include_once("connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
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

    // Initialize variables for file paths
    $mainImgPath = '';
    $smallImages = [];

    // Handle Main Image Upload
    if (isset($_FILES['mimg']) && $_FILES['mimg']['error'] === UPLOAD_ERR_OK) {
        $mainImgTmp = $_FILES['mimg']['tmp_name'];
        $timestamp = time(); // Current timestamp
        $mainImgName = pathinfo($_FILES['mimg']['name'], PATHINFO_FILENAME); // Get filename without extension
        $mainImgExtension = pathinfo($_FILES['mimg']['name'], PATHINFO_EXTENSION); // Get file extension
        $mainImgName = $mainImgName . '_' . $timestamp . '.' . $mainImgExtension; // Name as originalname_1630470743.jpg
        $mainImgPath = '../uploads/' . $mainImgName;
    
        // Move uploaded file to the target directory
        if (!move_uploaded_file($mainImgTmp, $mainImgPath)) {
            echo "Error uploading main image.";
            exit;
        }
    }
    

    // Handle Other Images Upload
    if (isset($_FILES['oimg']) && is_array($_FILES['oimg']['name'])) {
        foreach ($_FILES['oimg']['name'] as $key => $name) {
            if ($_FILES['oimg']['error'][$key] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['oimg']['tmp_name'][$key];
                $timestamp = time(); // Current timestamp
                $fileExtension = pathinfo($name, PATHINFO_EXTENSION);
                $fileName = ($key + 1) . '_' . $timestamp . '.' . $fileExtension; // Name as 1_1630470743.jpg, 2_1630470743.jpg, etc.
                $path = '../uploads/'.$fileName;
    
                // Move uploaded file to the target directory
                if (move_uploaded_file($tmpName, $path)) {
                    $smallImages[] = $fileName; // Add the filename to the array
                } else {
                    echo "Error uploading file: $name.";
                    exit;
                }
            }
        }
    }
    

    // Convert array of image filenames to a comma-separated string
    $smallImagesString = implode(',', $smallImages);

    // Insert data into the database
    $query = "INSERT INTO products (name, short_description, long_description, category_id, price, material, weight, stock_quantity, main_image_url, small_images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'ssssssssss', $pname, $short, $long, $category, $price, $material, $weight, $stock, $mainImgName, $smallImagesString);

        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            echo "success";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }


    // Close the database connection
    mysqli_close($conn);
}
