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
    private function getTimes($startTime = '00:00:00', $endTime = '00:00:00') {
        // Return an array of times in 30 minute increments
        $times = [];
        $current = strtotime($startTime);
        $end = strtotime($endTime);

        // This accounts for the availability starting on one day and ending on another
        if ($current >= $end) {
            $end = strtotime('+24 hours', $end);
        }
        
        // Execute once before checking the condition to account for starting and ending 24hours apart
        do {
            array_push($times, date('H:i:s', $current));
            $current = strtotime('+30 minutes', $current);
        } while ($current != $end);

        return $times;
    }


    // Public Methods
    public function getAvailability($physicianID) {
        // Physicians are only available at certain times of the day
        $sql = '
        SELECT availableTime
        FROM Availability
        WHERE physicianID = ?';

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $physicianID);
        if (($stmt->execute()) && ($result = $stmt->get_result()) && ($result->num_rows)) {
            // Format the data for the view
            $availability = [];
            while ($row = $result->fetch_row()) {
                array_push($availability, $row[0]);
            }
            return $availability;
        }
        $stmt->close();
        return null;
    }

    public function setAvailability($physicianID) {
        // Set the availability for a particular physician
        $startTime = trim($_POST['startTime']);
        $endTime = trim($_POST['endTime']);

        if ($this->getAvailability($physicianID)) {
            // On update, delete the old entries and insert new ones
            $this->deleteAvailability($physicianID);
        }

        // Insert Availability
        $sql = 'INSERT INTO Availability (physicianID, availableTime) VALUES (?, ?)';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('is', $physicianID, $time);

        $times = $this->getTimes($startTime, $endTime);
        foreach ($times as $time) {
            if (!$stmt->execute()) {
                $stmt->close();
                return false;
            }
        }

        $stmt->close();
        return true;
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
        $startTime = $date . ' ' . $availability[0];
        // End time is 30 minutes after the last available time
        $latestTime = strtotime($availability[array_key_last($availability)]);
        $endTime = $date . ' ' . date('H:i:s', strtotime('+30 minutes', $latestTime));

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
        foreach ($availability as $time) {
            $timestamp = strtotime($date . ' ' . $time);
            if (!in_array($timestamp, $unavailableTimes)) {
                $selected = ($time == $availability[0]) ? ' selected' : '';
                $output .= '<option value='. $time . $selected . '>' . date('h:i A', $timestamp) .'</option>';
            }
        }
        return $output;
    }

    public function getTimeList($startTime = '00:00:00', $selectedTime = '00:00:00') {
        // Return a select list of times in 30 minute increments
        $output = '';

        $times = $this->getTimes($startTime, $startTime);
        foreach ($times as $time) {
            $selected = ($time == $selectedTime) ? ' selected' : '';
            $output .= '<option value='. $time . ' ' . $selected . '>' . date('h:i A', strtotime($time)) .'</option>';
        }
        return $output;
    }

    public function listAppointments($ID, $roleName) {
        // Get the raw appointment data from the database
        $sql = '
        SELECT Appointments.ID, patientID, physicianID, Patient.firstName, Patient.lastName,
        Physician.firstName, Physician.lastName, startTime, endTime, reason, status
        FROM Appointments, Users Patient, Users Physician
        WHERE Appointments.patientID = Patient.ID AND Appointments.physicianID = Physician.ID
        AND Patient.isActive = 1 AND Physician.isActive = 1';
        
        if ($roleName == 'patient') {
            $sql .= ' AND patientID = "' . $ID . '"';
        } else if ($roleName == 'physician') {
            $sql .= ' AND physicianID = "' . $ID . '"'; 
        }
        $sql .= ' ORDER BY startTime';

        $stmt = $this->mysqli->prepare($sql);
        if (($stmt->execute()) && ($result = $stmt->get_result()) && ($result->num_rows)) {
            
            // Format the data for the view
            $appointments = [];
            while ($row = $result->fetch_row()) {
                $appointment = [
                    'ID' => $row[0],
                    'patientID' => $row[1],
                    'physicianID' => $row[2],
                    'patientFirstName' => $row[3],
                    'patientLastName' => $row[4],
                    'physicianFirstName' => $row[5],
                    'physicianLastName' => $row[6],
                    'startTime' => date('M j Y,  g:i A', strtotime($row[7])),
                    'startTimeTableKey' => date('YmdHi', strtotime($row[7])),
                    'endTime' => date('M j Y,  g:i A', strtotime($row[8])),
                    'endTimeTableKey' => date('YmdHi', strtotime($row[8])),
                    'reason' => $row[9],
                    'status' => $row[10]
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

    public function changeStatus($id, $status) {
        // Change the status of an appointment
        $sql = 'UPDATE Appointments SET status = ? WHERE ID = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('si', $status, $id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function cancelAppointment($id) {
        // Cancel an appointment
        $sql = 'DELETE FROM Appointments WHERE ID = ?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
}