<?php
require_once 'validationController.php';

class RoleController extends ValidationController {
    // Properties
    public $mysqli;


    // Constructor
    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    
    // Private Methods

    // Public Methods
    public function listRoles() {
        $sql = 'SELECT * FROM Roles';
        
        $stmt = $this->mysqli->prepare($sql);
        if (($stmt->execute()) && ($result = $stmt->get_result()) && ($result->num_rows)) {
            // Format the data for the view
            $roles = [];
            while ($row = $result->fetch_row()) {
                $role = [
                    'ID' => $row[0],
                    'roleName' => $row[1]
                ];
                array_push($roles, $role);
            }
            return $roles;
        }
        $stmt->close();
        return null;
    }

    public function getRole($id) {
        $sql = 'SELECT * FROM Roles WHERE ID = ?';
        
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        if (($stmt->execute()) && ($result = $stmt->get_result()) && ($result->num_rows)) {
            $row = $result->fetch_row();
            $role = [
                'ID' => $row[0],
                'roleName' => $row[1]
            ];
            return $role;
        }
        $stmt->close();
        return null;
    }
}