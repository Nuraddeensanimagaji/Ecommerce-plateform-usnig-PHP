<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Cycle-Connect</title>
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
                <li><a href="product.php">products</a></li>
                <li><a href="sell.php">Sell products</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Contact Form Section -->
    <section class="contact">
        <h2>Contact Us</h2>
        <form method="POST" action="contact_db.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>
    </section>

    <!-- Footer Section -->
     <pre>

     </pre>
    <footer>
        <p>&copy; 2025 Cycle-Connect. All rights reserved.</p>
    </footer>
</body>
</html>