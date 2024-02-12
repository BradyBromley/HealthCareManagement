<!DOCTYPE html>
<html>
    <div id='navigation'>    
        <h1>Health Care Management</h1>
        <ul class='navbar'>
            <li class='navbarLink'><a href='/index.php'>Home</a></li>
            <?php if ($userController->access('patients')) { ?>
                <li class='navbarLink'><a href='/src/view/patients.php'>Patients</a></li>
            <?php } if ($userController->access('admin')) {?>
                <li class='navbarLink'><a href='/src/view/admin/users.php'>Users</a></li>
                <li class='navbarLink'><a href='/src/view/admin/admin.php'>Admin</a></li>
            <?php } ?>
                <li class='navbarLink'><a href='/src/view/profile.php'>Profile</a></li>
            <li class='navbarLink'><a href='/src/view/auth/logout.php'>Logout</a></li>
            </form>
        </ul>
    </div>
</html>