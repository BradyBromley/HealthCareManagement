<?php
require_once 'validationController.php';

class AppointmentController extends ValidationController {
    // Properties
    public $mysqli;


    // Constructor
    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    
    // Private Methods

    // Public Methods
    public function bookAppointment() {
        $physicianID = trim($_POST['physician']);
        $date = trim($_POST['appointmentDate']);
        $time = trim($_POST['appointmentTime']);
        $reason = trim($_POST['reason']);
        
        $startTime = $date . ' ' . $time;
        $endTime = $date . ' ' . $time;
            
        // Insert Appointment
        $sql = 'INSERT INTO Appointments (patientID, physicianID, startTime, endTime, reason) VALUES (?, ?, ?, ?, ?)';
        $appointmentStmt = $this->mysqli->prepare($sql);
        $appointmentStmt->bind_param('iisss', $_SESSION['id'], $physicianID, $startTime, $endTime, $reason);

        if ($appointmentStmt->execute()) {
            $appointmentStmt->close();
            return true;
        }
        $appointmentStmt->close();
        return false;
    }
}