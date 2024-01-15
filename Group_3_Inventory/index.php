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
    <title>Inventory System</title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            width: auto;
            height: auto;
            background: #E4E4E4;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .contain {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 350px;
            height: 280px;
            background-color: #3C3C63;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 4px 4px 11.8px 13px rgba(0, 0, 0, 0.25);
        }

        .box {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box h1 {
            text-align: center;
            color: white;
            font-weight: 600;
        }

        .box input[type="text"],
        .box input[type="password"] {
            text-align: center;
            width: 250px;
            height: 40px;
            border-radius: 10px;
            border: none;
            margin: 10px;
        }

        .button {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box input[type="submit"] {
            width: 100px;
            height: 40px;
            margin: 10px;
            margin-bottom: 30px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s ease-in-out;
            /* Added transition property */
        }

        .box input[type="submit"]:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="contain">
            <div class="box">
                <form action="function.php" method="post">
                    <h1>INVENTORY</h1>
                    <input type="text" name="username" placeholder="Username" required>
                    <br>
                    <input type="password" name="password" placeholder="Password" required>
                    <br>
                    <div class="button">
                        <input type="submit" name="login" value="Login">
                    </div>

                    <?php
                    session_start();
                    // Check if there are any error messages
                    if (isset($_SESSION['error'])) {
                        echo '<div style="color: red; margin-bottom: 10px;">' . $_SESSION['error'] . '</div>';
                        // Clear the error message after displaying it
                        unset($_SESSION['error']);
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>