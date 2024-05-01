<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Error handling for database operations
try {
    // Fetch profile and count cart items
    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->bindValue(1, $user_id, PDO::PARAM_INT);
    $select_profile->execute();
    $result = $select_profile->fetchAll(PDO::FETCH_ASSOC);

    // Count cart items
    $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $count_cart_items->bindValue(1, $user_id, PDO::PARAM_INT);
    $count_cart_items->execute();
    $total_cart_items = $count_cart_items->rowCount();
} catch (PDOException $e) {
    // Handle error (e.g., log or display an error message)
    echo "Error: " . $e->getMessage();
}
?>

<?php

// Add messages to the array
$message[] = '';

// Display messages
if (isset($message)) {
    // Check if $message is not empty before attempting to iterate over it
    if (!empty($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="message">
                <span>'.$msg.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
}
?>


<header class="header">
    <section class="flex">
        <a href="index.php" class="logo">TAR UMT</a>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="menu.php">Menu</a>
            <a href="orders.php">Orders</a>
            <a href="contact.php">Contact</a>
        </nav>
        <div class="icons" style="display: inline;">
            <a href="search.php"><i class="fas fa-search"><img src="project images/search.png" style="width:16px;"></i></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"><img src="project images/shopping-cart.png" style="width:16px;"></i><span>(<?= $total_cart_items ?>)</span></a>
            <div id="user-btn" class="fas fa-user"style="display: inline-block;"><img src="project images/user.png" style="width:16px;"></div>
            <div id="menu-btn" class="fas fa-bars"><img src="project images/menu.png" style="width:16px;"></div>
        </div>
        <div class="profile">
            <?php if (count($result) > 0) : ?>
                <?php $fetch_profile = $result[0]; ?>
                <p class="name"><?= $fetch_profile['name'] ?></p>
                <div class="flex">
                    <a href="profile.php" class="btn">Profile</a>
                    <a href="components/user_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn">Logout</a>
                </div>
            <?php else : ?>
                <p class="name">Please login first!</p>
                <a href="login.php" class="btn">Login</a>
            <?php endif; ?>
        </div>
    </section>
</header>
