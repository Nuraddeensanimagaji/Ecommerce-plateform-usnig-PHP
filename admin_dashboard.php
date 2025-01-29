<?php
session_start();
require 'config.php'; // Include the database connection file

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle delete requests
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $type = $_POST['type'];
    $id = $conn->real_escape_string($_POST['id']);

    if ($type == 'order') {
        // Delete related order items first
        $sql = "DELETE FROM order_items WHERE order_id='$id'";
        if ($conn->query($sql) === TRUE) {
            // Now delete the order
            $sql = "DELETE FROM orders WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Order deleted successfully!</p>";
            } else {
                echo "<p>Error deleting order: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Error deleting order items: " . $conn->error . "</p>";
        }
    } elseif ($type == 'user') {
        $sql = "DELETE FROM users WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>User deleted successfully!</p>";
        } else {
            echo "<p>Error deleting user: " . $conn->error . "</p>";
        }
    } elseif ($type == 'product') {
        $sql = "DELETE FROM products WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Product deleted successfully!</p>";
        } else {
            echo "<p>Error deleting product: " . $conn->error . "</p>";
        }
    }
}

// Fetch orders
$sql = "SELECT * FROM orders";
$orders = $conn->query($sql);

// Fetch users
$sql = "SELECT * FROM user";
$users = $conn->query($sql);

// Fetch products
$sql = "SELECT * FROM products";
$products = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cycle-Connect</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style/admin.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Cycle-Connect</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Logout</a>
                        <a class="nav-link" href="admin.php">admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">

        <h2 class="mb-4">Admin Dashboard</h2>

        <h3>Orders</h3>
        <table class="table table-striped">
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['total_amount']; ?></td>
                    <td><?php echo isset($order['status']) ? $order['status'] : 'Pending'; ?></td>
                    <td>
                        <form method="POST" action="admin_dashboard.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="type" value="order">
                            <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h3>Users</h3>
        <table class="table table-striped">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php while ($user = $users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <form method="POST" action="admin_dashboard.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="type" value="user">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h3>Products</h3>
        <table class="table table-striped">
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php while ($product = $products->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['category']; ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width: 50px; height: auto;"></td>
                    <td>
                        <form method="POST" action="admin_dashboard.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="type" value="product">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>