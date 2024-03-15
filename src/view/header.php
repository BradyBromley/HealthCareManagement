<!DOCTYPE html>
<html>
    <div id='navigation'>    
        <h1 class='websiteHeader'>Health Care Management</h1>
        <ul class='navbar'>
            <li class='navbarLink'><a href='/index.php'>Home</a></li>
            <?php if ($userController->access('bookAppointment')) {?>
                <li class='navbarLink'><a href='/src/view/bookAppointment.php'>Book Appointment</a></li>
            <?php } if ($userController->access('upcomingAppointments')) { ?>
                <li class='navbarLink'><a href='/src/view/upcomingAppointments.php'>Upcoming Appointments</a></li>
            <?php } if ($userController->access('patients')) { ?>
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