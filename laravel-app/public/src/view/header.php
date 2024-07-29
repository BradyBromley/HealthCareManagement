<!DOCTYPE html>
<html>
    <div id='navigation'>    
        <h1 class='websiteHeader'>Health Care Management</h1>
        <div class='navbar'>
            <!-- Navbar links -->
            <ul class='navbarLeft'>
                <li class='navbarLink'><a href='/index.php'>Home</a></li>
            <?php if ($userController->access('bookAppointment')) {?>
                <li class='navbarLink'><a href='/src/view/bookAppointment.php'>Book Appointment</a></li>
            <?php } if ($userController->access('appointmentListing')) { ?>
                <li class='navbarLink'><a href='/src/view/appointmentListing.php'>Appointments</a></li>
            <?php } if ($userController->access('patientListing')) { ?>
                <li class='navbarLink'><a href='/src/view/userListing.php'>Patients</a></li>
            <?php } if ($userController->access('userListing')) {?>
                <li class='navbarLink'><a href='/src/view/userListing.php'>Users</a></li>
            <?php } ?>
            </ul>

            <!-- User dropdown -->
            <ul class='navbarRight'>
                <li class='navbarLink dropdown'>
                    <button class='dropdownButton'>
                    <?php if ($user = $userController->getUser($_SESSION['id'])) { ?>
                        <?php echo $user['firstName'] . ' ' . $user['lastName'] ?>
                    <?php } ?>
                        <i class='fa fa-caret-down'></i>
                    </button>
                    <div class='dropdownContent'>
                        <a href='/src/view/profile.php'>Profile</a>
                        <a href='/src/view/auth/logout.php'>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</html>