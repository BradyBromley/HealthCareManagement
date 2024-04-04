<?php
require_once '../config.php';
require_once '../controller/userController.php';
require_once '../controller/roleController.php';

// Redirect if user is not logged in
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/view/auth/login.php');
}

// Redirect if user does not have access to the user listing or patient listing
$userController = new UserController($mysqli);
if (!$userController->access('userListing') && !$userController->access('patientListing')) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

$roleController = new RoleController($mysqli);
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
        <link rel='stylesheet' href='/css/style.css'>

        <!-- Import for modals -->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

        <!-- Import js -->
        <script src='https://www.kryogenix.org/code/browser/sorttable/sorttable.js'></script>

        <meta charset='utf-8'>
        <title>Users</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/view/header.php') ?>

        <!-- Users -->
        <div class='content'>
            <?php if ($userController->access('userListing')) { ?>
                <h2>Users</h2>
            <?php } else { ?>
                <h2>Patients</h2>
            <?php } ?>
            <?php
            
            if (($user = $userController->getUser($_SESSION['id'])) &&
                ($role = $roleController->getRole($user['roleID']))) {

                // Only list patients if user is not admin
                if ($userController->access('userListing')) {
                    $users = $userController->listUsers('admin');
                } else {
                    $users = $userController->listUsers('patient');
                }

                if ($users) {
            ?>
                    <table class='table table-striped table-bordered sortable userTable'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                            <?php if ($userController->access('userListing')) { ?>
                                <th>Role</th>
                            <?php } ?>
                                <th class='sorttable_nosort'>View</th>
                            <?php if ($userController->access('userListing')) { ?>
                                <th class='sorttable_nosort'>Deactivate</th>
                            <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td><?php echo $user['ID']?></td>
                                <td><?php echo $user['firstName']?></td>
                                <td><?php echo $user['lastName']?></td>
                                <td><?php echo $user['email']?></td>
                            <?php if ($userController->access('userListing')) { ?>
                                <td><?php echo $user['roleName']?></td>
                            <?php } ?>
                                <td><a type='button' class='btn btn-secondary' href='/src/view/profile.php?id=<?php echo $user['ID']; ?>'><i class='fa-solid fa-newspaper'></i></a></td>
                            <?php if ($userController->access('userListing')) { ?>
                                <td><a type='button' class='btn btn-danger' data-bs-toggle='modal' href='#deactivateUserModal' data-bs-id='<?php echo $user['ID']; ?>'><i class='fa-solid fa-ban'></i></a></td>
                            <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
                <?php } ?>

            <?php } else { ?>
                <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
            <?php } ?>

            <!-- Deactivate User Modal -->
            <div class='modal fade' id='deactivateUserModal' tabindex='-1' aria-labelledby='deactivateUserModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='deactivateUserModalLabel'>Deactivate User</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            Are you sure you want to deactivate this user?
                        </div>
                        <div class='modal-footer'>
                            <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</a>
                            <a type='button' class='deactivateUserButton btn btn-danger'>Deactivate User</a>
                        </div>
                    </div>
                </div>
            </div>
            <script src='/js/users.js'></script>

        </div>
    </body>
</html>

<?php
$mysqli->close();
?>