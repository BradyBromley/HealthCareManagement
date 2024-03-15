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
    public function getAvailability($physicianID) {
        $startTime = '';
        $endTime = '';

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
        
        // Return the start and end times if they exist
        if ($startTime && $endTime) {
            return [$startTime, $endTime];
        } else {
            return null;
        }
    }

    public function setAvailability($physicianID) {
        // Set the availability for a particular physician
        $startTime = trim($_POST['startTime']);
        $endTime = trim($_POST['endTime']);

        $physicianHours = $this->getAvailability($physicianID);

        if ($physicianHours) {
            // Update Availability
            $sql = 'UPDATE Availability SET startTime = ?, endTime = ? WHERE physicianID = ?';
            $availabilityStmt = $this->mysqli->prepare($sql);
            $availabilityStmt->bind_param('ssi', $startTime, $endTime, $physicianID);
        } else {
            // Insert Availability
            $sql = 'INSERT INTO Availability (physicianID, startTime, endTime) VALUES (?, ?, ?)';
            $availabilityStmt = $this->mysqli->prepare($sql);
            $availabilityStmt->bind_param('iss', $physicianID, $startTime, $endTime);
        }

        if ($availabilityStmt->execute()) {
            $availabilityStmt->close();
            return true;
        }
        $availabilityStmt->close();
        return false;
    }

    public function deleteAvailability($physicianID) {
        $sql = 'DELETE FROM Availability WHERE physicianID = ?';
        $stmt = $this->mysqli->prepare($sql);
        echo $physicianID;
        $stmt->bind_param('i', $physicianID);
            if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function getAvailableTimes($date, $physicianID) {
        $output = '';

        // Get the default start and end time for a particular physician
        $physicianHours = $this->getAvailability($physicianID);
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
        while ($current < $end) {
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

    public function getTimeList($earliestTime = '00:00:00', $latestTime = '24:00:00', $selectedTime = '00:00:00') {
        // Return a select list of times in 30 minute increments
        $output = '';

        $current = strtotime($earliestTime);
        $end = strtotime($latestTime);

        while ($current < $end) {
            $time = date('H:i:s', $current);
            // Set the default time displayed based on the provided value
            $selected = ($time == $selectedTime) ? ' selected' : '';
    
            $output .= '<option value="'. $time . '" ' . $selected . '>' . date('h:i A', $current) .'</option>';
            $current = strtotime('+30 minutes', $current);
        }
    
        return $output;
    }

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

    public function listAppointments($physicianID) {
        $sql = '
        SELECT patientID, firstName, lastName, startTime, endTime, reason
        FROM Appointments, Users
        WHERE Appointments.patientID = Users.ID AND isActive = 1';
        if ($physicianID != 'all') {
            $sql .= ' AND physicianID = "' . $physicianID . '"';
        }

        $stmt = $this->mysqli->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->get_result();
        }
        $stmt->close();
        return null;
    }
}