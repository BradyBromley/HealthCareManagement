<?php
require_once '../config.php';
require_once '../controller/userController.php';
require_once '../controller/roleController.php';

// Redirect if user is not logged in
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/view/auth/login.php');
}

// Redirect if user does not have access to this page
$userController = new UserController($mysqli);
$roleController = new RoleController($mysqli);
if (($_REQUEST['id']) && ($_SESSION['id'] != $_REQUEST['id'])) {
    // Redirect if the user only has access to their own profile and they are trying to view someone elses
    if (!$userController->access('profile')) {
        header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
    }

    // Redirect non-admins who try to look at non patient profiles
    $user = $userController->getUser($_REQUEST['id']);
    if ($user) {
        $userRow = $user->fetch_row();
        $role = $roleController->getRole($userRow[7]);
        if ($role) {
            $roleRow = $role->fetch_row();
            if (($roleRow[1] != 'patient') && (!$userController->access('admin'))) {
                header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
            }
        }
    }
}

// Edit User
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_REQUEST['id']) {
        $result = $userController->editUser($_REQUEST['id']);
    } else {
        $result = $userController->editUser($_SESSION['id']);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='/css/style.css'>

        <!-- Import jquery -->
        <script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>
        
        <meta charset='utf-8'>
        <title>Profile</title>
        
        <?php if ($_REQUEST['id']) { ?>
            <div id='userID' value='<?php echo $_REQUEST["id"]?>'></div>
        <?php } else { ?>
            <div id='userID' value='<?php echo $_SESSION["id"]?>'></div>
        <?php } ?>
        
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/view/header.php') ?>

        <!-- Profile -->
        <div class='content'>
        <h2>Profile</h2>
        <?php
        if ($_REQUEST['id']) {
            $user = $userController->getUser($_REQUEST['id']);
        } else {
            $user = $userController->getUser($_SESSION['id']);
        }
        if ($user) {
            $userRow = $user->fetch_row();
            $role = $roleController->getRole($userRow[7]);
            if ($role) {
                $roleRow = $role->fetch_row();
        ?>
                    <div class='accountField'>
                        <span class='accountFieldLabel'>First Name</span>
                        <span class='accountFieldValue'><?php echo $userRow[3]; ?></span>
                    </div>
                    
                    <div class='accountField'>
                        <span class='accountFieldLabel'>Last Name</span>
                        <span class='accountFieldValue'><?php echo $userRow[4]; ?></span>
                    </div>

                    <div class='accountField'>
                        <span class='accountFieldLabel'>Address</span>
                        <span class='accountFieldValue'><?php echo $userRow[5]; ?></span>
                    </div>

                    <div class='accountField'>
                        <span class='accountFieldLabel'>City</span>
                        <span class='accountFieldValue'><?php echo $userRow[6]; ?></span>
                    </div>

                    <div class='accountField'>
                        <span class='accountFieldLabel'>Role</span>
                        <span id='role' class='accountFieldValue'><?php echo $roleRow[1]; ?></span>
                    </div>

                    <div id='availabilityHTML'></div>

                    <?php if ($_REQUEST['id']) { ?>
                        <a class='btn btn-secondary' href='/src/view/editProfile.php?id=<?php echo $_REQUEST['id'] ?>'>Edit</a>
                    <?php } else { ?>
                        <a class='btn btn-secondary' href='/src/view/editProfile.php?id=<?php echo $_SESSION['id'] ?>'>Edit</a>
                    <?php }?>

            <?php } else { ?>
                <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
        <?php
            }
        } else {
        ?>
            <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
        <?php } ?>

        <script src='/js/profile.js'></script>
        </div>
    </body>
</html>

<?php
$mysqli->close();
?>