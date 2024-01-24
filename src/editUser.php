<?php
require_once 'config.php';
require_once 'controllers/userController.php';

// Redirect if user is not logged in
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/login.php');
}

// Redirect if user is not an admin
$userController = new UserController($mysqli);
if (!$userController->access('admin') && $_SESSION['id'] != $_REQUEST['id']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

// Edit User
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $userController->editUser($_REQUEST['id']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='/css/style.css'>

        <meta charset='utf-8'>
        <title>Admin Page</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/header.php') ?>

        <!-- Edit User -->
        <?php
        $user = $userController->getUser($_REQUEST['id']);
        if ($user) {
            $row = $user->fetch_row();
            echo $row[0] . ' ' . $row[1] . ' ' . $row[3] . ' ' . $row[4];
            ?>

            <form id='editUserForm' class='needs-validation' action='<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>' method='post'>
                <div class='form-group formInput'>
                    <label for='firstName'>First Name</label>
                    <input id='firstName' name='firstName' type='text' class='form-control <?php echo (!empty($userController->firstNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['firstName'] : $row[3]; ?>' placeholder='Enter first name'>
                    <div class="invalid-feedback"><?php echo $userController->firstNameError; ?></div>
                </div>
                
                <div class='form-group formInput'>
                    <label for='lastName'>Last Name</label>
                    <input id='lastName' name='lastName' type='text' class='form-control <?php echo (!empty($userController->lastNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['lastName'] : $row[4]; ?>' placeholder='Enter last name'>
                    <div class="invalid-feedback"><?php echo $userController->lastNameError; ?></div>
                </div>

                <div class='form-group formInput'>
                    <label for='address'>Address</label>
                    <input id='address' name='address' type='text' class='form-control <?php echo (!empty($userController->lastNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['address'] : $row[5]; ?>' placeholder='Enter address'>
                </div>

                <div class='form-group formInput'>
                    <label for='city'>City</label>
                    <input id='city' name='city' type='text' class='form-control <?php echo (!empty($userController->lastNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['city'] : $row[6]; ?>' placeholder='Enter city'>
                </div>

                <button id='submit' type='submit' class='btn btn-primary'>Submit</button>
            </form>

            <?php
            if ($result) {
            ?>
                <div class="alert alert-success">Updated Successfully!</div>
            <?php
            }
        } else {
        ?>
            <div class="alert alert-danger">Oops! Something went wrong. Please try again later.</div>
        <?php
        }
        ?>
    </body>
</html>

<?php
$mysqli->close();
?>