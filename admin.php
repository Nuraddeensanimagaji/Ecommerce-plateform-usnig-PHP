<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Set session timeout duration (e.g., 15 minutes)
$timeout_duration = 900;

// Check if the session has expired
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout_duration) {
    // Session has expired, destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Update the login time to extend the session
$_SESSION['login_time'] = time();

// Database connection
$servername = "localhost";
$username = "root";
$password = "@Kangire1084";
$dbname = "bicycle";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to add a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = basename($_FILES["image"]["name"]); // Get the file name

                $sql = "INSERT INTO products (name, description, price, category, image, stock) VALUES ('$name', '$description', '$price', '$category', '$image', '$stock')";

                if ($conn->query($sql) === TRUE) {
                    echo "New product added successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded or there was an error uploading the file.";
    }
}

// Handle form submission to update a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    $sql = "UPDATE products SET name='$name', description='$description', price='$price', category='$category', stock='$stock' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission to delete a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Cycle-Connect</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <h1>Cycle-Connect Admin Panel</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>

    <!-- Add Product Form -->
    <section class="add-product">
        <h2>Add New Product</h2>
        <form method="POST" action="admin.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price (₦):</label>
            <input type="number" id="price" name="price" required>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <button type="submit">Add Product</button>
        </form>
    </section>

    <!-- Products List -->
    <section class="products">
        <h2>Manage Products</h2>
        <div class="product-grid">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">';
                    echo '<img src="images/' . $row["image"] . '" alt="' . $row["name"] . '">';
                    echo '<h3>' . $row["name"] . '</h3>';
                    echo '<p>' . $row["description"] . '</p>';
                    echo '<p>Category: ' . $row["category"] . '</p>';
                    echo '<p>Price: ₦' . $row["price"] . '</p>';
                    echo '<p>Stock: ' . $row["stock"] . '</p>';
                    echo '<form method="POST" action="admin.php">';
                    echo '<input type="hidden" name="action" value="update">';
                    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                    echo '<input type="text" name="name" value="' . $row["name"] . '" required>';
                    echo '<textarea name="description" required>' . $row["description"] . '</textarea>';
                    echo '<input type="number" name="price" value="' . $row["price"] . '" required>';
                    echo '<input type="text" name="category" value="' . $row["category"] . '" required>';
                    echo '<input type="number" name="stock" value="' . $row["stock"] . '" required>';
                    echo '<button type="submit">Update</button>';
                    echo '</form>';
                    echo '<form method="POST" action="admin.php">';
                    echo '<input type="hidden" name="action" value="delete">';
                    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                    echo '<button type="submit">Delete</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo "No products available.";
            }
            $conn->close();
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Cycle-Connect. All rights reserved.</p>
    </footer>
</body>
</html>