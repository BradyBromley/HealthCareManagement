<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Availability;
use Illuminate\Http\Request;
use App\Common\Helpers;

class AvailabilityController extends Controller
{
    /**
     * Return a select list for the user's start time availability
     * 
     * @param  string  $start_time
     * @return string
     */
    private function startTimeSelectList($start_time): string
    {
        $availabilities = Availability::all();

        // Create the start_time select list
        $start_options = '';
        foreach ($availabilities as $key => $availability)
        {
            if ($availability->time == $start_time)
            {
                $start_options .= "<option value='" . $availability->id . "' selected>" . Helpers::localTime($availability->time)->format('h:i A') . "</option>";
            } else
            {
                $start_options .= "<option value='" . $availability->id . "'>" . Helpers::localTime($availability->time)->format('h:i A') . "</option>";
            } 
        }
        
        $start_time_select_list = "
        <label for='start_time'>Start Time</label>
        <select class='form-select' id='start_time' name='start_time'>
            " . $start_options . "
        </select>
        ";

        return $start_time_select_list;
    }

    /**
     * Return a select list for the user's end time availability
     *
     * @param  string  $start_time
     * @param  string  $end_time
     * @return string
     */
    private function endTimeSelectList($start_time, $end_time) : string
    {
        $availabilities = Availability::all();

        // Create the end_time select list
        $end_options = '';
        $next_day_availability = [];
        foreach ($availabilities as $key => $availability)
        {
            if ($availability->time > $start_time)
            {
                if ($availability->time == $end_time)
                {
                    $end_options .= "<option value='" . $availability->id . "' selected>" . Helpers::localTime($availability->time)->format('h:i A') . "</option>";
                } else
                {
                    $end_options .= "<option value='" . $availability->id . "'>" . Helpers::localTime($availability->time)->format('h:i A') . "</option>";
                }
            } else if ($availability->time < $start_time)
            {
                array_push($next_day_availability, $availability);
            }
        }

        // This accounts for the availability starting on one day and ending on another
        foreach ($next_day_availability as $key => $availability)
        {
            if ($availability->time == $end_time)
            {
                $end_options .= "<option value='" . $availability->id . "' selected>" . Helpers::localTime($availability->time)->format('h:i A') . "</option>";
            } else
            {
                $end_options .= "<option value='" . $availability->id . "'>" . Helpers::localTime($availability->time)->format('h:i A') . "</option>";
            }
        }

        $end_time_select_list = "
        <label for='end_time'>End Time</label>
        <select class='form-select' id='end_time' name='end_time'>
            " . $end_options . "
        </select>
        ";

        return $end_time_select_list;
    }


    /**
     * Update the availability for the user in real time
     *
     * @param  int  $id
     */
    public function updateAvailability($id)
    {
        $user = User::find($id);
        $start_time = $user->startTime();
        $end_time = $user->endTime();

        $result = [];

        $result['start_time_select_list'] = $this->startTimeSelectList($start_time);
        $result['end_time_select_list'] = $this->endTimeSelectList($start_time, $end_time);

        echo json_encode($result);
    }

    /**
     * Update the end time select list for the user in real time
     *
     * @param  int  $id
     */
    public function updateEndTime($id)
    {
        $user = User::find($id);

        // The end time dropdown should only show times after the start time
        $start_time = Availability::find($_POST['start_time'])->time;
        $end_time = Availability::find($_POST['end_time'])->time;

        $result = [];

        $result['end_time_select_list'] = $this->endTimeSelectList($start_time, $end_time);

        echo json_encode($result);
    }
}
