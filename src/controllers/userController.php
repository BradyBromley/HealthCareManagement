<?php
require_once 'validationController.php';

class UserController extends ValidationController {
    // Properties
    public $mysqli;

    // Private Methods

    // Public Methods
    public function listUsers() {
        $sql = '
        SELECT Users.ID, firstName, lastName, email, roleName
        FROM Users, UsersToRoles, Roles
        WHERE Users.ID = userID AND Roles.ID = roleID';
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

        if (empty($this->firstNameError) && empty($this->lastNameError)) {
            // Update User
            $sql = 'UPDATE Users SET firstName = ?, lastName = ? WHERE id = ?';
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param('sss', $firstName, $lastName, $id);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            return false;
        }
    }
}