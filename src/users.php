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
if (!$userController->access('admin')) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>      
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel='stylesheet' href='/css/style.css'>

        <meta charset='utf-8'>
        <title>Users</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/header.php') ?>

        <!-- Users -->
        <div class='content'>
            <h2>Users</h2>
            <?php
            $result = $userController->listUsers();
            if ($result) {
            ?>
                <table class='table table-striped table-bordered userTable'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $numCols = 5;
                    while ($row = $result->fetch_row()) {
                    ?>
                        <tr>
                        <?php for ($i = 0; $i < $numCols; $i++) { ?>
                            <td><?php echo $row[$i]?></td>
                        <?php } ?>
                            <td><a type='button' class='btn btn-secondary' href='/src/editUser.php?id=<?php echo $row[0]; ?>'><i class='fa-solid fa-pen-to-square'></i></a></td>
                            <td><a type='button' class='btn btn-danger' data-bs-toggle='modal' href='#deleteUserModal' data-bs-id='<?php echo $row[0]; ?>'><i class='fa-solid fa-trash'></i></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
            <?php } ?>

            <!-- Delete User Modal -->
            <div class='modal fade' id='deleteUserModal' tabindex='-1' aria-labelledby='deleteUserModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='deleteUserModalLabel'>Delete User</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            Are you sure you want to delete this user?
                        </div>
                        <div class='modal-footer'>
                            <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</a>
                            <a type='button' class='deleteUserButton btn btn-danger'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <script src="/js/users.js"></script>

        </div>
    </body>
</html>

<?php
$mysqli->close();
?>