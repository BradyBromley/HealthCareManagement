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
        $endTime = strtotime('+25 minutes', strtotime($startTime));
        $endTime = date('Y-m-d H:i', $endTime);
            
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

    public function getAvailableTimes($date) {
        $output = '';

        $current = strtotime($date . '00:00');
        $end = strtotime($date . '23:59');
        
        // Find all appointments booked on the currently selected day
        $sql = '
        SELECT * FROM Appointments
        WHERE startTime BETWEEN
        "' . $date . ' 00:00:00" AND "' . $date . ' 23:59:59"';

        $stmt = $this->mysqli->prepare($sql);
        $unavailableTimes = [];
        
        if ($stmt->execute()) {
            $appointments = $stmt->get_result();
            while ($appointmentRow = $appointments->fetch_row()) {
                array_push($unavailableTimes, strtotime($appointmentRow[3]));
            }
        }
        $stmt->close();

        // A time is available if no appointments have been booked for that time
        while ($current <= $end) {
            if (!in_array($current, $unavailableTimes)) {
                $time = date('H:i', $current);
                $selected = ($time == '00:00') ? ' selected' : '';
        
                $output .= '<option value='. $time . $selected . '>' . date('h:i A', $current) .'</option>';
            }
            // Appointments can be booked in 30 minute increments
            $current = strtotime('+30 minutes', $current);
            
        }
    
        return $output;
    }
}