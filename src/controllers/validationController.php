<?php
class ValidationController {
    // Properties
    public $emailError;
    public $passwordError;
    public $confirmPasswordError;
    public $firstNameError;
    public $lastNameError;

    // Public Methods
    public function validateEmail($email) {
        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $this->emailError = 'Invalid email format.';
            return null;
        } else {
            return trim($email);
        }
    }

    public function validatePassword($password) {
        if (strlen(trim($password)) < 8) {
            $this->passwordError = 'Password must have at least 8 characters.';
            return null;
        } else {
            return password_hash(trim($password), PASSWORD_DEFAULT);
        }
    }

    public function validateFirstName($firstName) {
        // Validate first name
        if (empty(trim($_POST['firstName']))) {
            $this->firstNameError = 'Please enter a first name.';
            return null;
        } else {
            return trim($firstName);
        }
    }

    public function validateLastName($lastName) {
        // Validate last name
        if (empty(trim($lastName))) {
            $this->lastNameError = 'Please enter a last name.';
            return null;
        } else {
            return trim($lastName);
        }
    }
}
?>