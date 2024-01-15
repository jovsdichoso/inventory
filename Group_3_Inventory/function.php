<?php

class UserManagement
{
    public function loginUser($username, $password) #function para sa pag login ng user based sa tiginput which is ang username and password
    {
        session_start(); #ibabase nya sa tig input na username tapos kukuhaon nya ang linya sadto
        $file = fopen('accounts.csv', 'r'); #open file accounts.csv para iread 'r'

        while (($row = fgetcsv($file)) !== FALSE) { 
            #sa kada linya daw sa csv na accounts.csv igeget nya ang kada linya which is ang ngaran san kada linya is $row
            if ($row[1] == $username && $row[2] == $password) { 
                #if daw ang index[1] or username sa csv == sa tig input na $username 
                #and(dapat both true) index[2] which is ang pass == sa tig input na $password
                $this->setSessionData($row[0], $row[3]); 
                #call ang setsessiondata which is ang function na ini para ini sa pagkuha sa ngaran para idisplay sa dashboard
                $this->redirectBasedOnRole($row[3]); #tapos icacall nya man ang redirect based sa role or index[3] sa accounts.csv
            }
        }
        echo "
            <h1 style= 'color: red;'>Invalid username or password!</h1>
            <a href='index.php'><button>BACK</button>"; #kapag walang nagmatch sa accounts.csv magsasabi ng invalid username or password
        fclose($file); #tapos iclose ang file para di na magulit
    }

    private function setSessionData($userName, $userRole)
    {
        $_SESSION['user_name'] = $userName; #session para kunin ang username
        $_SESSION['user_role'] = $userRole; #session para kunin ang user role
    }

    private function redirectBasedOnRole($role = null) 
    #null kasi kapag wala pa syang role di sya mageerorr bale if may role papalitan nya lang ang null into admin man o staff
    {
        session_start();
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') { #if ang role daw is = to 'Admin'
            header('Location: admin.php'); #maproceed sya sa admin dashborad or admin.php
        } elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Staff') { #if ang role daw is = to 'Staff'
            header('Location: staff.php'); #maproceed sya sa staff dashborad or staff.php
        } else { #else if wara pa ki role
            header('Location: some_default_page.php');  #wara lang mangyayare or diri ma error
        }
    }

    public function addAccount($fullname, $username, $password) 
    #function para sa pag add ng user based sa tiginput which is ang fullname,username and password
    {
        $file = fopen('accounts.csv', 'a'); #open na muna ng file which is ang accounts.csv then append para sa pag add 'a'

        if ($this->usernameExists($username)) { 
            #if ang function na usernameExist or function sa pag check kung nagexist ang username sa accounts.csv
            echo "Username already exists!"; #magsasabi sya ng username already exist
        } else { #kapag hindi naman nag exist sa accounts.csv ang username
            $newAccount = array($fullname, $username, $password, 'Staff'); #nag declare na mmuna ng variable na $newaccount 
            #which is ang laman is array na may format na fullname,username,password and default na 'Staff' role
            fputcsv($file, $newAccount); #tapos ilalagay nya ang array or $newaccount sa file na accounts.csv

            echo "Account added successfully!
            <a href='admin.php'><button>BACK</button>"; #then once na write na sa csv magsasabi ng account added succesfully
        }

        fclose($file); #close ang file para diri na magulit
    }

    private function usernameExists($username) #function para sa pag check kung existing na ang usernamme
    {
        $checkFile = fopen('accounts.csv', 'r'); #read na muna ng accounts.csv 'r'
        while (($row = fgetcsv($checkFile)) !== FALSE) { 
            #sa kada linya daw sa csv na accounts.csv igeget nya ang kada linya which is ang ngaran san kada linya is $row
            if ($row[1] == $username) { #if ang row[1] or username sa csv is == sa tig input or $username
                fclose($checkFile); #close ang file
                return true; #tapos ma return sya as true
            }
        }
        fclose($checkFile);
        return false; #else if nagfalse ang condition or wara dae nag exist ang username sa accounts.csv mareturn sya as false
    }

    public function addItem($name, $category, $quantity, $expiry_date, $description) 
    #function para sa pag add ng item based sa tiginput which is ang name ng product or $name,category,quantity,expiry,description
    {
        if ($this->itemExists($name)) { 
            #if ang function na itemexist or ang function para mag check kung existing na ang name sa items.csv or nagtrue
            echo "Item with the same name already exists!"; #magpriprint or display sya or magsasabi sya ng item already exist
            exit(); #exit nya
        }

        $file = fopen('items.csv', 'a'); 
        #else kapag hindi true ang itemexist or kapag false, magoopen na muna sya ng file which is items.csv tapos 'a' or append
        $newItem = array($name, $category, $quantity, $expiry_date, $description); #nag declare na mmuna ng variable na $newItem 
        #which is ang laman is array na may format na name,category,quantity,expiry,description
        fputcsv($file, $newItem); #tapos ipuput nya sa file or items.csv ang array na $newItem

        $this->redirectBasedOnUserRole(); #once na nakaag na sa items.csv file ma redirect na siya or mabalik sa dashboard based sa role

        fclose($file); #close ang file
    }

    private function redirectBasedOnUserRole($defaultRedirect = null) 
     #null kasi kapag wala pa syang role di sya mageerorr bale if may role papalitan nya lang ang null into admin man o staff
    {
        session_start();
        if (isset($_SESSION['user_role'])) {  #if ang role is admin or staff
            header('Location: ' . $_SESSION['user_role'] . '.php'); 
            #maredirect sya depende sa role so if admin ang nakalagay sa isset mapupunta sya sa admin.php
            #if naman staff mapupunta sya sa staff.php
        } elseif ($defaultRedirect) { 
            header('Location: ' . $defaultRedirect);
        } else { #kapag walang role
            header('Location: some_default_page.php'); #mapupunta sya sa defaul na page or hindi lang sya mag eerorr
        }
    }

    public function updateItem($name, $category, $quantity, $expiry, $description) 
    #function para sa pag update ng item based sa tiginput which is ang name ng product or $name,category,quantity,expiry,description
    {
        $items = $this->readItemsCSV(); #nagassign na muna sya ng variable na $items para sa condition
        #tapos ang laman ng $items is function sa pag read ng kada items sa csv
        $updated = false; #nag assign den ng variable $updated para ma track kung na update

        foreach ($items as &$data) { #sa kada data or linya sa items array
            if ($data[0] == $name) { #if ang index[0] or name ng products sa kada linya is equal sa ininput na name
                $newItem = [$name, $category, $quantity, $expiry, $description]; 
                #kukunin nya lahat ng nakalagay sa mga input na naka format ng name,category,quantity,exipiry and description 
                #which is ang pangalan ng format is $newItem
                if ($data != $newItem) { #if ang $newItem hindi existing or not equal sa kada linya or $data
                    $data = $newItem; #bale iaassign nya ang $newItem as $data
                    $updated = true; #tapos mapapalitan ang false into true
                }
            }
        }

        if ($updated) { #if naman true daw ang $updated
            $this->writeItemsCSV($items); #icall nya ang function sa pag write ng items sa items.csv

            header('Location: update_item.php'); #tapos once na nawrite na sa csv babalik sya sa page ng update item or update_item.php
        } else { #else kapag walang binago sa pagupdate ng item
            echo "No changes made to the item"; #magsasabi sya or display ng no chanes made to the item
        }


    }

    private function writeItemsCSV($items) #function para sa pagwrite ng laman ng items
    {
        $file = fopen('items.csv', 'w'); #open na mmuna ng file na naka write mode 'w'

        foreach ($items as $item) { #sa kada items daw or value sa laog ng $items array
            fputcsv($file, $item); #ipuput nya sa $file na items.csv ang kada laman ng $items array or kada linya ng array which is $item
        }

        fclose($file); #close ang file
    }

    private function readItemsCSV() #function sa pag read ng kada items sa csv
    {
        $file = fopen('items.csv', 'r'); #open na muna ng items.csv para sa pag read 'r'
        $items = []; #assign na muna sya ng empty array para dito ilalagay ang mga data or kada linya sa csv

        while (($data = fgetcsv($file, 1000, ',')) !== false) { 
            #sa kada linya daw sa csv na items.csv igeget nya ang kada linya which is ang ngaran san kada linya is $data
            $items[] = $data; #ilalagay nya ang kada linya or $data sa array na $items
        }

        fclose($file); #close ang file
        return $items; #tapos mag return ng laman or may laman pa den ang $items array once na cinall
    }

    public function updateExpiration($name, $category, $quantity, $expiry, $description)
    #function para sa pag update ng expiration based sa tiginput which is ang name ng product or $name,category,quantity,expiry,description
    {
        $file = fopen('items.csv', 'r'); #read items.csv naka readmode read nga sabi nga read oh diba ohhhh yeaaahh
        $items = []; #declare na muna ng empty array $items ohh yeahh
        $updated = false; #para ma keep nya ang track kung nagupdate ohhh yahhhmete

        while (($data = fgetcsv($file, 1000, ',')) !== false) { #basta same lang to sa pag update ng pinakauna na update
            #kapagod na mag explain parang may bayad wala naman ohhh yaaa
            if ($data[0] == $name) {
                $newItem = [$name, $category, $quantity, $expiry, $description];
                if ($data != $newItem) {
                    $items[] = $newItem;
                    $updated = true;
                } else {
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


    public function removeItem($name) #function para itanggal ang item
    {
        $items = $this->readItemsCSV(); #magreread na anay siya san csv which is ang items.csv
        $items = array_filter($items, function ($data) use ($name) { #nag gamit ki array_filter para diri iupod ang tig input na data san user sa $item array
            return $data[0] != $name; #kukuhaon anng mga diri equal na item sa tig input
        });

        $this->writeItemsCSV($items); #then iwriwrite niya sa items.csv aang $items array

        header('Location: update_item.php'); #then once na write na ang updated mabalik sya sa update item page or update_item.php ohh yeeeeeeeeee
    }

    private function itemExists($itemName) #function para icheck kung existing na ang item
        {
            $file = fopen('items.csv', 'r'); #open na anay san file na items.csv na naka read mode
            while (($row = fgetcsv($file)) !== FALSE) { #sa kada linyaa sa file na items.csv ang tawag san kada linya is $row
                if ($row[0] == $itemName) { #if ang kada index[0] sa kada $row or linya is == $itemmname or sa tig input na ngaran san user
                    fclose($file); #iclose nya ang file
                    return true; #then mareturn true kapag nahanap ang item
                }
            }
            fclose($file); #close ang file
            return false; #kung hindi nag true or hindi na hanap ang item magrereturn sya as false ohhhh sheeet paking shet
        }

    }


$userManagement = new UserManagement(); #instance user managera

if (isset($_POST['login'])) { #once na pinindot or click or tap ang button na login
    $userManagement->loginUser($_POST['username'], $_POST['password']); 
    #icacall nya ang function sa pag login ng account and ang mga ininput ng user

} elseif (isset($_POST['add_account'])) { #once na pinindot or click or tap ang button na add account
    $userManagement->addAccount($_POST['fullname'], $_POST['username'], $_POST['password']);
    #icacall nya ang function sa pag add ng account and ang mga ininput ng user

} elseif (isset($_POST['add_item'])) { #once na pinindot or click or tap ang button na add item
    $userManagement->addItem($_POST['name'], $_POST['category'], $_POST['quantity'], $_POST['expiry_date'], $_POST['description']);
    #icacall nya ang function sa pag add ng item and ang mga ininput ng user

} elseif (isset($_POST['update_item'])) { #once na pinindot or click or tap ang button na update item
    $userManagement->updateItem($_POST['name'], $_POST['category'], $_POST['quantity'], $_POST['expiry'], $_POST['description']);
    #icacall nya ang function sa pag update ng item and ang mga ininput ng user

} elseif (isset($_POST['update_expiration'])) { #once na pinindot or click or tap ang button na update expiry
    $userManagement->updateExpiration($_POST['name'], $_POST['category'], $_POST['quantity'], $_POST['expiry'], $_POST['description']);
    #icacall nya ang function sa pag update san expiry ng item and ang mga ininput ng user

} elseif (isset($_POST['remove_item'])) { #once na pinindot or click or tap ang button na remove item
    $userManagement->removeItem($_POST['name']); 
    #icacall nya ang function sa pag remove ng item and ang mga ininput ng user
}

?>