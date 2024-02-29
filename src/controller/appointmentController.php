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
    private function physicianHours($physicianID) {
        $startTime = '00:00:00';
        $endTime = '23:59:59';

        // Physicians are only available at certain times of the day
        $sql = '
        SELECT * FROM Availability
        WHERE physicianID = ' . $physicianID;

        $availabilityStmt = $this->mysqli->prepare($sql);
        
        if ($availabilityStmt->execute()) {
            $availability = $availabilityStmt->get_result();
            $availabilityRow = $availability->fetch_row();
            $startTime = $availabilityRow[2];
            $endTime = $availabilityRow[3];
        }
        $availabilityStmt->close();
        
        return [$startTime, $endTime];
    }

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

    public function getAvailableTimes($date, $physicianID) {
        $output = '';

        // Set the default start and end time for each physician
        $physicianHours = $this->physicianHours($physicianID);
        $current = strtotime($date . $physicianHours[0]);
        $end = strtotime($date . $physicianHours[1]);


        // Find all appointments booked for the selected day and physician
        $sql = '
        SELECT * FROM Appointments
        WHERE physicianID = ' . $physicianID . ' AND
        startTime BETWEEN "' . $date . ' ' . $physicianHours[0] . '" AND "' . $date . ' ' . $physicianHours[1] . '"';

        $appointmentStmt = $this->mysqli->prepare($sql);
        $unavailableTimes = [];
        
        if ($appointmentStmt->execute()) {
            $appointments = $appointmentStmt->get_result();
            while ($appointmentRow = $appointments->fetch_row()) {
                array_push($unavailableTimes, strtotime($appointmentRow[3]));
            }
        }
        $appointmentStmt->close();

        // A time is available if no appointments have been booked for that time
        while ($current <= $end) {
            if (!in_array($current, $unavailableTimes)) {
                $time = date('H:i', $current);
                $selected = ($time == $physicianHours[0]) ? ' selected' : '';
        
                $output .= '<option value='. $time . $selected . '>' . date('h:i A', $current) .'</option>';
            }
            // Appointments can be booked in 30 minute increments
            $current = strtotime('+30 minutes', $current);
            
        }
    
        return $output;
    }
}