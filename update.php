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
    <title>Update Items</title>
    <style>
        .items {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            width: 600px;
            margin-top: 5px;

        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 7px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #007bff;
        }

        input[type="submit"] {
            text-align: center;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
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

                <?php
                echo '  <form action="function.php" method="post">
                    <label>Item Name</label>
                    <input type="text" name="name" placeholder="Item Name" value="' . $_POST['name'] . '" readonly><br>
                    <label>Category</label>
                    <input type="text" name="category" placeholder="Category" value="' . $_POST['category'] . '" readonly>
                    <label>Quantity</label>
                    <input type="text" name="quantity" placeholder="Quantity" value="' . $_POST['quantity'] . '"><br>
                    <label>Expiration Date</label>
                    <input type="date" name="expiry" placeholder="Expiration Date" value="' . $_POST['expiry'] . '"><br>
                    <label>Description</label>
                    <input type="text" name="description" placeholder="Description" value="' . $_POST['description'] . '">
                    <input type="submit" name="update_item" value="Update">
                </form>';
                ?>
            </div>
        </div>
</body>

</html>