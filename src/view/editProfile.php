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
    // Redirect if the user only has access to their own profile and they are trying to edit someone elses
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
    $result = $userController->editUser($_REQUEST['id']);
}

$roleController = new RoleController($mysqli);
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='/css/style.css'>

        <meta charset='utf-8'>
        <title>Edit Profile</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/view/header.php') ?>

        <!-- Edit Profile -->
        <div class='content'>
        <h2>Edit Profile</h2>
        <?php
        $user = $userController->getUser($_REQUEST['id']);
        if ($user) {
            $userRow = $user->fetch_row();
            ?>

            <form id='editProfileForm' class='needs-validation' action='<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>' method='post'>
                <div class='form-group formInput'>
                    <label for='firstName'>First Name</label>
                    <input id='firstName' name='firstName' type='text' class='form-control <?php echo (!empty($userController->firstNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['firstName'] : $userRow[3]; ?>' placeholder='Enter first name'>
                    <div class="invalid-feedback"><?php echo $userController->firstNameError; ?></div>
                </div>
                
                <div class='form-group formInput'>
                    <label for='lastName'>Last Name</label>
                    <input id='lastName' name='lastName' type='text' class='form-control <?php echo (!empty($userController->lastNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['lastName'] : $userRow[4]; ?>' placeholder='Enter last name'>
                    <div class="invalid-feedback"><?php echo $userController->lastNameError; ?></div>
                </div>

                <div class='form-group formInput'>
                    <label for='address'>Address</label>
                    <input id='address' name='address' type='text' class='form-control <?php echo (!empty($userController->lastNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['address'] : $userRow[5]; ?>' placeholder='Enter address'>
                </div>

                <div class='form-group formInput'>
                    <label for='city'>City</label>
                    <input id='city' name='city' type='text' class='form-control <?php echo (!empty($userController->lastNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['city'] : $userRow[6]; ?>' placeholder='Enter city'>
                </div>

                <?php
                // Allow the role to be changed if the logged in user is an admin
                if ($userController->access('admin')) {
                    // Role List
                    $roles = $roleController->listRoles();
                    if ($roles) {
                ?>
                        <div class='form-group formInput'>
                            <label for='role'>Role</label>
                            <select class='form-select' id='role' name='role'>
                            <?php
                            while ($roleRow = $roles->fetch_row()) {
                                if ($userRow[7] == $roleRow[0]) {
                            ?>
                                    <option value='<?php echo $roleRow[0]; ?>' selected><?php echo $roleRow[1]; ?></option>
                                <?php } else { ?>
                                    <option value='<?php echo $roleRow[0]; ?>'><?php echo $roleRow[1]; ?></option>
                            <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                <?php
                    } else {
                ?>
                        <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
                <?php
                    }
                } else {
                    // Don't let the role be editable if the logged in user isn't an admin
                    $role = $roleController->getRole($userRow[7]);
                    if ($role) {
                        $roleRow = $role->fetch_row();
                ?>
                    <div class='form-group formInput'>
                        <label for='role'>Role</label>
                        <select class='form-select' id='role' name='role'>
                            <option value='<?php echo $roleRow[0]; ?>' selected><?php echo $roleRow[1]; ?></option>
                        </select>
                    </div>
                <?php
                    } else {
                ?>
                        <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
                <?php
                    }
                }
                ?>

                <button id='submit' type='submit' class='btn btn-success'>Submit</button>
            </form>

            <?php if ($result) { ?>
                <div class="banner alert alert-success">Updated Successfully!</div>
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