<!DOCTYPE html>
<html>
    <div id='navigation'>    
        <h1>Health Care Management</h1>
        <ul class='navbar'>
            <li class='navbarLink'><a href='/index.php'>Home</a></li>
            <?php if ($userController->access('patients')) { ?>
                <li class='navbarLink'><a href='/src/patients.php'>Patients</a></li>
            <?php } if ($userController->access('admin')) {?>
                <li class='navbarLink'><a href='/src/users.php'>Users</a></li>
                <li class='navbarLink'><a href='/src/admin.php'>Admin</a></li>
            <?php } ?>
                <li class='navbarLink'><a href='/src/profile.php'>Profile</a></li>
            <li class='navbarLink'><a href='/src/logout.php'>Logout</a></li>
            </form>
        </ul>
    </div>
</html>