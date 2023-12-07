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
            
            // Check if the email has already been used
            $sql = 'SELECT ID FROM Users WHERE Email = ?';
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param('s', trim($_POST['email']));
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $this->emailError = 'This email is already in use.';
                } else {
                    $this->email = trim($_POST['email']);
                }
            }
            $stmt->close();
        }
    }

    private function validatePassword() {
        if (empty(trim($_POST['password']))) {
            $this->passwordError = 'Please enter a password.';
        } else if (strlen(trim($_POST['password'])) < 8) {
            $this->passwordError = 'Password must have at least 8 characters.';
        } else {
            $this->password = trim($_POST['password']);
        }
    }

    private function validateConfirmPassword() {
        if (empty(trim($_POST['confirmPassword']))) {
            $this->confirmPasswordError = 'Please confirm password.';
        } else if ($this->password != trim($_POST['confirmPassword'])) {
            $this->confirmPasswordError = 'Password does not match';
        }
    }

    private function validateName() {
        // Validate first name
        if (empty(trim($_POST['firstName']))) {
            $this->firstNameError = 'Please enter a first name';
        } else {
            $this->firstName = trim($_POST['firstName']);
        }

        // Validate last name
        if (empty(trim($_POST['lastName']))) {
            $this->lastNameError = 'Please enter a last name';
        } else {
            $this->lastName = trim($_POST['lastName']);
        }
    }


    // Public Methods
    public function register() {
        $this->validateEmail();
        $this->validatePassword();
        $this->validateConfirmPassword();
        $this->validateName();

        // Insert into database
        if (empty($this->emailError) && empty($this->passwordError) && empty($this->confirmPasswordError)) {
            
            $sql = 'INSERT INTO Users (Email, PasswordHash, Salt, FirstName, LastName) VALUES (?, ?, ?, ?, ?)';
            $stmt = $this->mysqli->prepare($sql);
            
            $salt = 'Salt Test';
            $stmt->bind_param('sssss', $this->email, $this->password, $salt, $this->firstName, $this->lastName);
            if ($stmt->execute()) {
                header('location: login.php');
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }

            $stmt->close();
        }
    }

    /*
    public function login() {
        
    }*/

}
?>