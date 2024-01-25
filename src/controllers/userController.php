<?php
require_once 'validationController.php';

class UserController extends ValidationController {
    // Properties
    public $mysqli;


    // Constructor
    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    
    // Private Methods

    // Public Methods
    public function listUsers() {
        $sql = '
        SELECT Users.ID, firstName, lastName, email, roleName
        FROM Users, Roles
        WHERE Users.roleID = Roles.ID';
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->get_result();
        }
        $stmt->close();
        return null;
    }

    public function getUser($id) {
        $sql = 'SELECT * FROM Users WHERE ID = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return $stmt->get_result();
        }
        $stmt->close();
        return null;
    }

    public function editUser($id) {
        // Validate all inputs in the form
        $firstName = $this->validateFirstName($_POST['firstName']);
        $lastName = $this->validateLastName($_POST['lastName']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $role = trim($_POST['role']);

        if (empty($this->firstNameError) && empty($this->lastNameError)) {
            // Update User
            $sql = 'UPDATE Users SET firstName = ?, lastName = ?, address = ?, city = ?, roleID = ? WHERE id = ?';
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param('ssssss', $firstName, $lastName, $address, $city, $role, $id);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            return false;
        }
    }

    public function access($role) {
        // Check if the current user has the required permissions
        $sql = 'SELECT Roles.ID FROM Roles, Users WHERE Users.ID = ? AND Users.RoleID = Roles.ID AND Roles.roleName = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('is', $_SESSION['id'], $role);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            if ($result && $result->fetch_row()) {
                return true;
            } else {
                return false;
            }
        } else {
            $stmt->close();
        }
    }
}