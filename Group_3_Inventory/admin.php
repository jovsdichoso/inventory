<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Martian+Mono:wght@300;400;500;700&family=Montserrat:wght@200;300;400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@200;300;400;500;600;700;800;900&family=Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
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
                <p class="bold"><?php echo $_SESSION['user_name']?><br><h5><?php echo $_SESSION['user_role']?></h5></p>
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
                        <button type="submit" name="non_perishable">Non-Perishable</button>
                        <button href="admin.php">All</button>
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
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody class="display">
                            <?php
                                $file = fopen('items.csv', 'r');
                                $sequentialNumber = 1; // Initialize sequential numbering
                                
                                if ($file) {
                                    while (($data = fgetcsv($file, 1000, ',')) !== false) {
                                        // Add condition to check if "Perishable" button is clicked
                                        if (isset($_POST['perishable'])) {
                                            // Check if the item is perishable
                                            if ($data[1] == 'Perishable') {
                                                displayItem($sequentialNumber, $data);
                                                $sequentialNumber++; // Increment numbering for perishable items
                                            }
                                        } elseif (isset($_POST['non_perishable'])) {
                                            // Check if the item is non-perishable
                                            if ($data[1] == 'Non-Perishable') {
                                                displayItem($sequentialNumber, $data);
                                                $sequentialNumber++; // Increment numbering for non-perishable items
                                            }
                                        } else {
                                            // Display all items if no button is clicked
                                            displayItem($sequentialNumber, $data);
                                            $sequentialNumber++; // Increment numbering for all items
                                        }
                                    }
                                }

                                fclose($file);

                                // Function to display item data in a table row
                                function displayItem($number, $data) {
                                        echo '  <tr>
                                                    <td>'. $number .'</td>
                                                    <td>'. $data[0] .'</td>
                                                    <td>'. $data[2] .'</td>
                                                    <td>'. $data[3] .'</td>
                                                    <td>'. $data[1] .'</td>
                                                </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>