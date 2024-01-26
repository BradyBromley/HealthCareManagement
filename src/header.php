<!DOCTYPE html>
<html>
    <div id='navigation'>    
        <h1>Health Care Management</h1>
        <ul class='navbar'>
            <li class='navbarLink'><a href='/index.php'>Home</a></li>
            <?php if ($userController->access('admin')) { ?>
                <li class='navbarLink'><a href='/src/admin.php'>Admin</a></li>
                <li class='navbarLink'><a href='/src/users.php'>Users</a></li>
            <?php } ?>
            <li class='navbarLink'><a href='/src/account.php'>Account</a></li>
            <li class='navbarLink'><a href='/src/logout.php'>Logout</a></li>
            </form>
        </ul>
    </div>
</html>