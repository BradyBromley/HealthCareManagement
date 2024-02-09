<?php
require_once 'config.php';
require_once 'controllers/userController.php';
require_once 'controllers/roleController.php';

// Redirect if user is not logged in
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/login.php');
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

        <meta charset='utf-8'>
        <title>Profile</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/header.php') ?>

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
                        <span class='accountFieldValue'><?php echo $roleRow[1]; ?></span>
                    </div>

                    <?php if ($_REQUEST['id']) { ?>
                        <a class='btn btn-secondary' href='/src/editProfile.php?id=<?php echo $_REQUEST['id'] ?>'>Edit</a>
                    <?php } else { ?>
                        <a class='btn btn-secondary' href='/src/editProfile.php?id=<?php echo $_SESSION['id'] ?>'>Edit</a>
                    <?php }?>

            <?php } else { ?>
                <div class="banner alert alert-danger">Oops! Something went wrong. Please try again later.</div>
        <?php
            }
        } else {
        ?>
            <div class="banner alert alert-danger">Oops! Something went wrong. Please try again later.</div>
        <?php } ?>
        </div>
    </body>
</html>

<?php
$mysqli->close();
?>