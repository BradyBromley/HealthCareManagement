$(document).ready(function(){
    // Invoke a change on page load so the availability gets correctly shown
    $('#appointment_date').change();
});

function htmlDate(date) {
    var dd = date.getDate();
    var mm = date.getMonth() + 1;
    var yyyy = date.getFullYear();

    dd = (dd < 10) ? '0' + dd : dd;
    mm = (mm < 10) ? '0' + mm : mm;

    return yyyy + '-' + mm + '-' + dd;
}

// Appointments can be booked anytime from the following day, to a year from now
var appointment_date = document.getElementById('appointment_date');
var today = new Date();
var tomorrow = new Date(today.setDate(today.getDate() + 1));
var tomorrow_ymd = htmlDate(tomorrow);
var next_year = htmlDate(new Date(new Date().setFullYear(new Date().getFullYear() + 1)));

appointment_date.valueAsDate = tomorrow;
appointment_date.setAttribute('min', tomorrow_ymd);
appointment_date.setAttribute('max', next_year);

// The available appointment times depend on the physician and date chosen
$('#appointment_date, #physician_id').on('change', function(){
    var physician_id = $('#physician_id').val();
    var date = $('#appointment_date').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').attr('value')
        }
    });
    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: '/appointments/updateAppointmentAvailability',
        data: {
            physician_id,
            date,
        },
        cache: false,
        success: function(data) {
            var json = $.parseJSON(data);
            var appointment_options = json.appointment_options;
            

            // Only allow an appointment to be booked if there is an available time
            console.log(appointment_options);
            if (appointment_options) {
                $('#submit_button').html('<button id="submit" type="submit" class="btn btn-success">Submit</button>');
                $('#appointment_availability_details').show();
            } else {
                $('#submit_button').html('<div class="banner alert alert-warning">There are no appointments available for this day.</div>');
                $('#appointment_availability_details').hide();
            }

            $('#appointment_options').html(appointment_options);
        }
    });
});