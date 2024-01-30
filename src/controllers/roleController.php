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
        $sql = '
        SELECT * FROM Roles';
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->get_result();
        }
        $stmt->close();
        return null;
    }

    public function getRole($id) {
        $sql = 'SELECT * FROM Roles WHERE ID = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return $stmt->get_result();
        }
        $stmt->close();
        return null;
    }
}