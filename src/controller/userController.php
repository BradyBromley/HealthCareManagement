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
        WHERE Users.roleID = Roles.ID AND isActive = 1';
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->get_result();
        }
        $stmt->close();
        return null;
    }

    public function listPatients() {
        $sql = '
        SELECT Users.ID, firstName, lastName, email, roleName
        FROM Users, Roles
        WHERE Users.roleID = Roles.ID AND Roles.roleName = "patient" AND isActive = 1';
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
            $stmt->close();
            return false;
        }
    }

    public function deactivateUser($id) {
        $sql = 'UPDATE Users SET passwordHash = "", isActive = 0 WHERE id = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('s', $id);
            if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function access($permission) {
        // Check if the current user has the required permission
        $sql = 'SELECT Users.ID
            FROM Users, RolesToPermissions, Permissions
            WHERE
                Users.ID = ? AND Users.RoleID = RolesToPermissions.roleID AND
                RolesToPermissions.permissionID = Permissions.ID AND 
                Permissions.permissionName = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('is', $_SESSION['id'], $permission);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            if ($result && $result->fetch_row()) {
                return true;
            } else {
                return false;
            }
        }
        $stmt->close();
        return false;
    }
}