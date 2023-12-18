<?php
class AuthController {
    // Properties
    public $mysqli;

    public $email;
    public $password;
    public $firstName;
    public $lastName;

    public $emailError;
    public $passwordError;
    public $confirmPasswordError;
    public $firstNameError;
    public $lastNameError;

    // Constructor
    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }


    // Private Methods
    private function validateEmail() {
        if (empty(trim($_POST['email']))) {
            $this->emailError = 'Please enter an email.';
        } else if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
            $this->emailError = 'Invalid email format.';
        } else {
            $this->email = trim($_POST['email']);
        }
    }

    private function validatePassword() {
        if (empty(trim($_POST['password']))) {
            $this->passwordError = 'Please enter a password.';
        } else if (strlen(trim($_POST['password'])) < 8) {
            $this->passwordError = 'Password must have at least 8 characters.';
        } else {
            $this->password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        }
    }

    private function validateName() {
        // Validate first name
        if (empty(trim($_POST['firstName']))) {
            $this->firstNameError = 'Please enter a first name.';
        } else {
            $this->firstName = trim($_POST['firstName']);
        }

        // Validate last name
        if (empty(trim($_POST['lastName']))) {
            $this->lastNameError = 'Please enter a last name.';
        } else {
            $this->lastName = trim($_POST['lastName']);
        }
    }

    private function emailInUse() {
        // Return ID and password if the email is in use
        $sql = 'SELECT ID, passwordHash FROM Users WHERE email = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('s', $this->email);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result) {
                return $result->fetch_row();
            }
        }
        $stmt->close();
        return null;
    }


    // Public Methods
    public function register() {
        // Validate all inputs in the form
        $this->validateEmail();
        $this->validatePassword();
        if ($this->emailInUse()) {
            $this->emailError = 'This email is already in use.';
        }
        if (!password_verify(trim($_POST['confirmPassword']), $this->password)) {
            $this->confirmPasswordError = 'This password does not match.';
        }
        $this->validateName();

        // Insert into database
        if (empty($this->emailError) && empty($this->passwordError)
        && empty($this->confirmPasswordError) && empty($this->firstNameError)
        && empty($this->lastNameError)) {
            
            // Insert User
            $sql = 'INSERT INTO Users (email, passwordHash, firstName, lastName) VALUES (?, ?, ?, ?)';
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param('ssss', $this->email, $this->password, $this->firstName, $this->lastName);
            if ($stmt->execute()) {
                header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/login.php');
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }
            $stmt->close();
        }
    }

    
    public function login() {
        // Validate all inputs in the form
        $this->validateEmail();
        $this->validatePassword();
        if ($row = $this->emailInUse()) {
            if (password_verify(trim($_POST['password']), $row[1])) {
                // If the user exists, then login and store the ID
                $_SESSION['loggedIn'] = true;
                $_SESSION['id'] = $row[0];
                header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
            } else {
                $this->passwordError = 'This password does not match.';
            }
        }
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/login.php');
    }

    public function access($role) {
        // Check if the current user has the required permissions
        $sql = 'SELECT Roles.ID FROM Roles, UsersToRoles WHERE UsersToRoles.userID = ? AND Roles.ID = UsersToRoles.roleID AND roleName = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('is', $_SESSION['id'], $role);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result && $result->fetch_row()) {
                return true;
            } else {
                return false;
            }
        }
        $stmt->close();
    }

}
?>