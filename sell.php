<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Bicycle - Cycle-Connect</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <h1>Cycle-Connect</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Buy Bicycles</a></li>
                <li><a href="sell.php">Sell Bicycle</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Sell Bicycle Form -->
    <section class="sell-form">
        <h2>Sell Your Bicycle</h2>
        <form action="add_bicycle.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="bicycleName">Bicycle Name:</label>
                <input type="text" id="bicycleName" name="bicycleName" required>
            </div>
            <div class="form-group">
                <label for="bicycleDescription">Description:</label>
                <textarea id="bicycleDescription" name="bicycleDescription" required></textarea>
            </div>
            <div class="form-group">
                <label for="bicyclePrice">Price (₦):</label>
                <input type="number" id="bicyclePrice" name="bicyclePrice" required>
            </div>
            <div class="form-group">
                <label for="bicycleCategory">Category:</label>
                <input type="text" id="bicycleCategory" name="bicycleCategory" required>
            </div>
            <div class="form-group">
                <label for="bicycleImage">Image:</label>
                <input type="file" id="bicycleImage" name="bicycleImage" required>
            </div>
            <div class="form-group">
                <label for="bicycleStock">Stock:</label>
                <input type="number" id="bicycleStock" name="bicycleStock" required>
            </div>
            <button type="submit">Sell Bicycle</button>
        </form>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 Cycle-Connect. All rights reserved.</p>
    </footer>
</body>
</html>