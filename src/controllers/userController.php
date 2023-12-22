<?php
class UserController {
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
        FROM Users, UsersToRoles, Roles
        WHERE Users.ID = userID AND Roles.ID = roleID';
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->get_result();
            
        }
        $stmt->close();
        return null;
    }
}