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
    public function listUsers($roleName) {
        $sql = '
        SELECT users.id, email, first_name, last_name, address, city, role_id, role_name
        FROM users, roles
        WHERE users.role_id = roles.id AND is_active = 1';
        if ($roleName != 'admin') {
            $sql .= ' AND roles.role_name = "' . $roleName . '"';
        }

        $stmt = $this->mysqli->prepare($sql);
        if (($stmt->execute()) && ($result = $stmt->get_result()) && ($result->num_rows)) {
            // Format the data for the view
            $users = [];
            while ($row = $result->fetch_row()) {
                $user = [
                    'ID' => $row[0],
                    'email' => $row[1],
                    'firstName' => $row[2],
                    'lastName' => $row[3],
                    'address' => $row[4],
                    'city' => $row[5],
                    'roleID' => $row[6],
                    'roleName' => $row[7]
                ];
                array_push($users, $user);
            }
            return $users;
        }
        $stmt->close();
        return null;
    }

    public function getUser($id) {
        $sql = '
        SELECT users.id, email, first_name, last_name, address, city, role_id
        FROM users
        WHERE id = ?';

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        if (($stmt->execute()) && ($result = $stmt->get_result()) && ($result->num_rows)) {
            $row = $result->fetch_row();
            $user = [
                'ID' => $row[0],
                'email' => $row[1],
                'firstName' => $row[2],
                'lastName' => $row[3],
                'address' => $row[4],
                'city' => $row[5],
                'roleID' => $row[6]
            ];
            return $user;
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
            $sql = 'UPDATE users SET first_name = ?, last_name = ?, address = ?, city = ?, role_id = ? WHERE id = ?';
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param('ssssii', $firstName, $lastName, $address, $city, $role, $id);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            $stmt->close();
            return false;
        }
    }

    public function deactivateUser($id) {
        $sql = 'UPDATE users SET password = "", is_active = 0 WHERE id = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function access($permission) {
        // Check if the current user has the required permission
        $sql = 'SELECT users.id
            FROM users, roles_to_permissions, permissions
            WHERE
                users.id = ? AND users.role_id = roles_to_permissions.role_id AND
                roles_to_permissions.permission_id = permissions.id AND 
                permissions.permission_name = ?';
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