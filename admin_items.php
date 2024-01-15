<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Martian+Mono:wght@300;400;500;700&family=Montserrat:wght@200;300;400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@200;300;400;500;600;700;800;900&family=Sriracha&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="add.css">
    <title>Add Item</title>
</head>

<body>
    <?php
    session_start();
    ?>

    <div class="container">
        <div class="sidebar">
            <div class="top">

                <div class="logo">
                    <span>INVENTORY</span>
                    <hr>
                </div>
            </div>
            <div class="user">
                <p class="bold">
                    <?php echo $_SESSION['user_name'] ?><br>
                <h5>
                    <?php echo $_SESSION['user_role'] ?>
                </h5>
                </p>
            </div>
            <div class="nav-items">
                <ul>
                    <li>
                        <a href="admin.php">
                            <i class="bx bx-grid-alt"></i>
                            <span class="nav-item">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_items.php">
                            <i class="bx bx-plus-circle"></i>
                            <span class="nav-item">Add Items</span>
                        </a>
                    </li>
                    <li>
                        <a href="update_item.php">
                            <i class="bx bx-plus-circle"></i>
                            <span class="nav-item">Update Item</span>
                        </a>
                    </li>
                    <li>
                        <a href="item_expiration.php">
                            <i class="bx bx-plus-circle"></i>
                            <span class="nav-item">Item Expiration</span>
                        </a>
                    </li>
                    <?php
                    if ($_SESSION['user_role'] == 'Admin') {
                        ?>
                        <li>
                            <a href="add_account.php">
                                <i class="bx bx-user-plus"></i>
                                <span class="nav-item">Add Account</span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="logout">
                        <a href="index.php">
                            <i class="bx bx-log-out"></i>
                            <span class="nav-item">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="right">
            <div class="items">
                <h2>Add Items</h2>
                <div class="add">
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'): ?>
                    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Staff'): ?>
                    <?php else: ?>
                        <?php endif; ?>
                       
                        <form action="function.php" method="post">
                            <label for="name">Name:</label>
                            <input type="text" name="name" required>
                            <br>
                            <label for="category">Category:</label>
                            <select name="category" required>
                                <option value="Perishable">Perishable</option>
                                <option value="Non-Perishable">Non-Perishable</option>
                            </select>
                            <br>
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" required>
                            <br>
                            <label for="expiry_date">Expiry Date:</label>
                            <input type="date" name="expiry_date" required>
                            <br>
                            <label for="description">Description:</label>
                            <textarea name="description" required></textarea>
                            <br>
                            <input type="submit" name="add_item" value="Add Item">
                        </form>
                </div>
            </div>
        </div>
</body>

</html>