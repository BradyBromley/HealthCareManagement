<!DOCTYPE html>
<html>
    <div id='navigation'>    
        <h1 class='websiteHeader'>Health Care Management</h1>
        <ul class='navbar'>
            <li class='navbarLink'><a href='/index.php'>Home</a></li>
            <?php if ($userController->access('bookAppointment')) {?>
                <li class='navbarLink'><a href='/src/view/bookAppointment.php'>Book Appointment</a></li>
            <?php } if ($userController->access('appointmentListing')) { ?>
                <li class='navbarLink'><a href='/src/view/appointmentListing.php'>Appointments</a></li>
            <?php } if ($userController->access('patientListing')) { ?>
                <li class='navbarLink'><a href='/src/view/userListing.php'>Patients</a></li>
            <?php } if ($userController->access('userListing')) {?>
                <li class='navbarLink'><a href='/src/view/userListing.php'>Users</a></li>
            <?php } if ($userController->access('admin')) {?>
                <li class='navbarLink'><a href='/src/view/admin/admin.php'>Admin</a></li>
            <?php } ?>
                <li class='navbarLink'><a href='/src/view/profile.php'>Profile</a></li>
            <li class='navbarLink'><a href='/src/view/auth/logout.php'>Logout</a></li>
            </form>
        </ul>
    </div>
</html>