<?php

class UserManagement
{
    public function loginUser($username, $password)
    {
        session_start();
        $file = fopen('accounts.csv', 'r');

        // Check if the user exists and the password is correct
        while (($row = fgetcsv($file)) !== FALSE) {
            if ($row[1] == $username && $row[2] == $password) {
                $this->setSessionData($row[0], $row[3]);
                $this->redirectBasedOnRole($row[3]);
            }
        }

        // If no matching user is found
        echo "
            <h1 style= 'color: red;'>Invalid username or password!</h1>
            <a href='index.php'><button>BACK</button>";
        fclose($file);
    }

    public function addAccount($fullname, $username, $password)
    {
        $file = fopen('accounts.csv', 'a');

        // Check if the username already exists
        if ($this->usernameExists($username)) {
            echo "Username already exists!";
        } else {
            $newAccount = array($fullname, $username, $password, 'Staff');
            fputcsv($file, $newAccount);

            echo "Account added successfully!
            <a href='admin.php'><button>BACK</button>";
        }

        fclose($file);
    }

    public function addItem($name, $category, $quantity, $expiry_date, $description)
    {
        // Check if the item name already exists
        if ($this->itemExists($name)) {
            echo "Item with the same name already exists!";
            exit();
        }

        $file = fopen('items.csv', 'a');
        $newItem = array($name, $category, $quantity, $expiry_date, $description);
        fputcsv($file, $newItem);

        $this->redirectBasedOnUserRole();

        fclose($file);
    }

    public function updateItem($name, $category, $quantity, $expiry, $description)
    {
        $items = $this->readItemsCSV();
        $updated = false;

        foreach ($items as &$data) {
            if ($data[0] == $name) {
                $newItem = [$name, $category, $quantity, $expiry, $description];
                if ($data != $newItem) {
                    $data = $newItem;
                    $updated = true;
                }
            }
        }

        if ($updated) {
            $this->writeItemsCSV($items);

            header('Location: update_item.php');
        } else {

            echo "No changes made to the item";
        }


    }

    public function updateExpiration($name, $category, $quantity, $expiry, $description)
    {
        $file = fopen('items.csv', 'r');
        $items = [];
        $updated = false;

        while (($data = fgetcsv($file, 1000, ',')) !== false) {
            if ($data[0] == $name) {
                $newItem = [$name, $category, $quantity, $expiry, $description];
                if ($data != $newItem) {
                    // Only update if there are changes
                    $items[] = $newItem;
                    $updated = true;
                } else {
                    // No changes, keep the original data
                    $items[] = $data;
                }
            } else {
                $items[] = $data;
            }
        }

        fclose($file);

        if ($updated) {
            $file = fopen('items.csv', 'w');

            foreach ($items as $item) {
                fputcsv($file, $item);
            }

            fclose($file);
        }
        $this->redirectBasedOnUserRole('item_expiration.php');
    }


    public function removeItem($name)
    {
        $items = $this->readItemsCSV();
        $items = array_filter($items, function ($data) use ($name) {
            return $data[0] != $name;
        });

        $this->writeItemsCSV($items);

        header('Location: update_item.php');
    }

    private function setSessionData($userName, $userRole)
    {
        $_SESSION['user_name'] = $userName;
        $_SESSION['user_role'] = $userRole;
    }

    private function redirectBasedOnRole($role = null)
    {
        session_start();
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
            header('Location: admin.php');
        } elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Staff') {
            header('Location: staff.php');
        } else {
            header('Location: some_default_page.php');
        }
    }

    private function redirectBasedOnUserRole($defaultRedirect = null)
    {
        session_start();
        if (isset($_SESSION['user_role'])) {
            header('Location: ' . $_SESSION['user_role'] . '.php');
        } elseif ($defaultRedirect) {
            header('Location: ' . $defaultRedirect);
        } else {
            header('Location: some_default_page.php');
        }
    }

    private function usernameExists($username)
    {
        $checkFile = fopen('accounts.csv', 'r');
        while (($row = fgetcsv($checkFile)) !== FALSE) {
            if ($row[1] == $username) {
                fclose($checkFile);
                return true;
            }
        }
        fclose($checkFile);
        return false;
    }

    private function itemExists($itemName)
    {
        $file = fopen('items.csv', 'r');
        while (($row = fgetcsv($file)) !== FALSE) {
            if ($row[0] == $itemName) {
                fclose($file);
                return true;
            }
        }
        fclose($file);
        return false;
    }

    private function readItemsCSV()
    {
        $file = fopen('items.csv', 'r');
        $items = [];

        while (($data = fgetcsv($file, 1000, ',')) !== false) {
            $items[] = $data;
        }

        fclose($file);
        return $items;
    }

    private function writeItemsCSV($items)
    {
        $file = fopen('items.csv', 'w');

        foreach ($items as $item) {
            fputcsv($file, $item);
        }

        fclose($file);
    }
}

$userManagement = new UserManagement();

if (isset($_POST['login'])) {
    $userManagement->loginUser($_POST['username'], $_POST['password']);
} elseif (isset($_POST['add_account'])) {
    $userManagement->addAccount($_POST['fullname'], $_POST['username'], $_POST['password']);
} elseif (isset($_POST['add_item'])) {
    $userManagement->addItem($_POST['name'], $_POST['category'], $_POST['quantity'], $_POST['expiry_date'], $_POST['description']);
} elseif (isset($_POST['update_item'])) {
    $userManagement->updateItem($_POST['name'], $_POST['category'], $_POST['quantity'], $_POST['expiry'], $_POST['description']);
} elseif (isset($_POST['update_expiration'])) {
    $userManagement->updateExpiration($_POST['name'], $_POST['category'], $_POST['quantity'], $_POST['expiry'], $_POST['description']);
} elseif (isset($_POST['remove_item'])) {
    $userManagement->removeItem($_POST['name']);
}

?>