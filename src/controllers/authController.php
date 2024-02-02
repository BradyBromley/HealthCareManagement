<?php
require_once 'validationController.php';

class AuthController extends ValidationController {
    // Properties
    public $mysqli;


    // Constructor
    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    

    // Private Methods
    private function getUserFromEmail($email) {
        // Return ID and password if the email exists
        $sql = 'SELECT ID, passwordHash, isActive FROM Users WHERE email = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            if ($result) {
                return $result->fetch_row();
            }
        }
        return null;
    }

    private function getRoleID($role) {
        // Return ID if the role exists
        $sql = 'SELECT ID FROM Roles WHERE roleName = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('s', $role);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            if ($result) {
                return $result->fetch_row()[0];
            }
        }
        return null;
    }


    // Public Methods
    public function register() {
        // Validate all inputs in the form
        $email = $this->validateEmail($_POST['email']);
        $passwordHash = $this->validatePassword($_POST['password']);
        if (($row = $this->getUserFromEmail($email)) && ($row[2] == 1)) {
            $this->emailError = 'This email is already in use.';
        }
        if (!password_verify(trim($_POST['confirmPassword']), $passwordHash)) {
            $this->confirmPasswordError = 'This password does not match.';
        }
        $firstName = $this->validateFirstName($_POST['firstName']);
        $lastName = $this->validateLastName($_POST['lastName']);

        // Insert into database
        if (empty($this->emailError) && empty($this->passwordError)
        && empty($this->confirmPasswordError) && empty($this->firstNameError)
        && empty($this->lastNameError)) {
            
            if ($row) {
                // Reactivate User
                $sql = 'UPDATE Users SET passwordHash = ?, firstName = ?, lastName = ?, address = "", city = "", roleID = ?, isActive = 1 WHERE id = ?';
                $usersStmt = $this->mysqli->prepare($sql);
                $usersStmt->bind_param('sssss', $passwordHash, $firstName, $lastName, $this->getRoleID('guest'), $row[0]);
            } else {
                // Insert User
                $sql = 'INSERT INTO Users (email, passwordHash, firstName, lastName, roleID) VALUES (?, ?, ?, ?, ?)';
                $usersStmt = $this->mysqli->prepare($sql);
                $usersStmt->bind_param('sssss', $email, $passwordHash, $firstName, $lastName, $this->getRoleID('guest'));
            }
            
            if ($usersStmt->execute()) {
                $usersStmt->close();
                return true;
            }
            $usersStmt->close();
            return false;

            
        }
    }
    
    public function login() {
        // Validate all inputs in the form
        $email = $this->validateEmail($_POST['email']);
        $this->validatePassword($_POST['password']);
        if (($row = $this->getUserFromEmail($email)) && ($row[2] == 1)) {
            if (password_verify(trim($_POST['password']), $row[1])) {

                // If the user exists, then login and store the ID
                $_SESSION['loggedIn'] = true;
                $_SESSION['id'] = $row[0];
                header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
            } else {
                $this->passwordError = 'This password does not match.';
            }
        } else {
            $this->emailError = 'This email does not exist.';
        }
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/login.php');
    }
}
?>