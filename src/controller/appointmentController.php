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
        // Physicians are only available at certain times of the day
        $sql = '
        SELECT startTime, endTime
        FROM Availability
        WHERE physicianID = ?';

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $physicianID);
        if (($stmt->execute()) && ($result = $stmt->get_result()) && ($result->num_rows)) {
            $row = $result->fetch_row();
            $availability = [
                'startTime' => $row[0],
                'endTime' => $row[1]
            ];
            return $availability;
        }
        $stmt->close();
        return null;
    }

    public function setAvailability($physicianID) {
        // Set the availability for a particular physician
        $startTime = trim($_POST['startTime']);
        $endTime = trim($_POST['endTime']);
        $availability = $this->getAvailability($physicianID);

        if ($availability) {
            // Update Availability
            $sql = 'UPDATE Availability SET startTime = ?, endTime = ? WHERE physicianID = ?';
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param('ssi', $startTime, $endTime, $physicianID);
        } else {
            // Insert Availability
            $sql = 'INSERT INTO Availability (physicianID, startTime, endTime) VALUES (?, ?, ?)';
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param('iss', $physicianID, $startTime, $endTime);
        }

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function deleteAvailability($physicianID) {
        $sql = 'DELETE FROM Availability WHERE physicianID = ?';

        $stmt = $this->mysqli->prepare($sql);
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
        $availability = $this->getAvailability($physicianID);
        $startTime = $date . ' ' . $availability['startTime'];
        $endTime = $date . ' ' . $availability['endTime'];

        $current = strtotime($startTime);
        $end = strtotime($endTime);

        // Find all appointments booked for the selected day and physician
        $sql = '
        SELECT * FROM Appointments
        WHERE physicianID = ? AND
        startTime BETWEEN ? AND ?';

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('iss', $physicianID, $startTime, $endTime);
        
        $unavailableTimes = [];
        if (($stmt->execute()) && ($result = $stmt->get_result()) && ($result->num_rows)) {
            while ($row = $result->fetch_row()) {
                array_push($unavailableTimes, strtotime($row[3]));
            }
        }
        $stmt->close();

        // A time is available if no appointments have been booked for that time
        while ($current < $end) {
            if (!in_array($current, $unavailableTimes)) {
                $time = date('H:i', $current);
                $selected = ($time == $availability['startTime']) ? ' selected' : '';
        
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

    public function listAppointments($physicianID) {
        // Get the raw appointment data from the database
        $sql = '
        SELECT patientID, firstName, lastName, startTime, endTime, reason
        FROM Appointments, Users
        WHERE Appointments.patientID = Users.ID AND isActive = 1';
        if ($physicianID != 'all') {
            $sql .= ' AND physicianID = "' . $physicianID . '"';
        }
        $sql .= ' ORDER BY startTime';

        $stmt = $this->mysqli->prepare($sql);
        if (($stmt->execute()) && ($result = $stmt->get_result()) && ($result->num_rows)) {
            
            // Format the data for the view
            $appointments = [];
            while ($row = $result->fetch_row()) {
                $appointment = [
                    'patientID' => $row[0],
                    'firstName' => $row[1],
                    'lastName' => $row[2],
                    'startTime' => date('M j Y,  g:i A', strtotime($row[3])),
                    'startTimeTableKey' => date('YmdHi', strtotime($row[3])),
                    'endTime' => date('M j Y,  g:i A', strtotime($row[4])),
                    'endTimeTableKey' => date('YmdHi', strtotime($row[4])),
                    'reason' => $row[5]
                ];
                array_push($appointments, $appointment);
            }
            return $appointments;
        }
        $stmt->close();
        return null;
    }

    public function bookAppointment() {
        $physicianID = trim($_POST['physician']);
        $date = trim($_POST['appointmentDate']);
        $time = trim($_POST['appointmentTime']);
        $reason = trim($_POST['reason']);
        
        $startTime = $date . ' ' . $time;
        $endTime = strtotime('+25 minutes', strtotime($startTime));
        $endTime = date('Y-m-d H:i', $endTime);
            
        // Insert Appointment into database
        $sql = 'INSERT INTO Appointments (patientID, physicianID, startTime, endTime, reason) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('iisss', $_SESSION['id'], $physicianID, $startTime, $endTime, $reason);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

}