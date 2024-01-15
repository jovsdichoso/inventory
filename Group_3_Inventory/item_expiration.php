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
    <title>Item Expiration</title>
    <style>
        input[type="submit"] {
            width: 150px;
            height: 40px;
            border: none;
            border-radius: 10px;
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
    // Start the session to access session variables
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
                <div class="title">
                    <h4>Category</h4>
                    <form method="post">
                        <button type="submit" name="perishable">Perishable</button>
                    </form>
                </div>
                <div class="table">
                    <table class="display1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Expiration Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        $file = fopen('items.csv', 'r');
                        $sequentialNumber = 1; // Initialize sequential numbering
                        
                        if ($file) {
                            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                                if ($data[1] == 'Perishable') {
                                    displayItem($sequentialNumber, $data);
                                    $sequentialNumber++;
                                }
                            }
                        }
                        function displayItem($number, $data)
                        {
                            echo '<table>
                    <tr>
                        <td>' . $number . '</td>
                        <td>' . $data[0] . '</td>
                        <td>' . $data[2] . '</td>
                        <td>' . $data[3] . '</td>
                        <td>
                            <form action="expiration.php" method="post">
                                <input type="hidden" name="name" value="' . $data[0] . '">
                                <input type="hidden" name="category" value="' . $data[1] . '">
                                <input type="hidden" name="quantity" value="' . $data[2] . '">
                                <input type="hidden" name="expiry" value="' . $data[3] . '">
                                <input type="hidden" name="description" value="' . $data[4] . '">
                                <input type="submit" name="manage_expiry" value="Set Expiration">
                            </form>
                        </td>
                    </tr>
                </table>';
                        }
                        ?>