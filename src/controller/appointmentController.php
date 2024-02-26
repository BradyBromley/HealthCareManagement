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

    public function getTimes($default = '00:00') {
        $output = '';

        //$current = strtotime(date('H:00'));
        $current = strtotime('00:00');
        $end = strtotime('23:59');
        
        $sql = '
        SELECT * FROM Appointments';
        $stmt = $this->mysqli->prepare($sql);
        $unavailableTimes = [];
        
        if ($stmt->execute()) {
            $appointments = $stmt->get_result();
            while ($appointmentRow = $appointments->fetch_row()) {
                array_push($unavailableTimes, strtotime($appointmentRow[3]));
            }
        }
        $stmt->close();

        // I need to 'call' getTimes every time the calendar date is changed
        // CURRENT TIMESTAMPS ARE FOR TODAY, NEED TO GET THE DATE FROM THE SELECT LIST TO MAKE IT MORE ACCURATE
        while ($current <= $end) {
            if (!in_array($current, $unavailableTimes)) {
                $time = date('H:i', $current);
                $selected = ($time == $default) ? ' selected' : '';
        
                $output .= '<option value='. $time . $selected . '>' . date('h:i A', $current) .'</option>';
            }
            $current = strtotime('+30 minutes', $current);
            
        }
    
        return $output;
    }
}