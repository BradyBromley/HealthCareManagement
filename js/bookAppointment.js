$(document).ready(function(){
    // Invoke a change on page load so the availability gets correctly shown
    $('#appointmentDate').change();
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
var appointmentDate = document.getElementById('appointmentDate');
var today = new Date();
var tomorrow = new Date(today.setDate(today.getDate() + 1));
var tomorrowYMD = htmlDate(tomorrow);
var nextYear = htmlDate(new Date(new Date().setFullYear(new Date().getFullYear() + 1)));

appointmentDate.valueAsDate = tomorrow;
appointmentDate.setAttribute('min', tomorrowYMD);
appointmentDate.setAttribute('max', nextYear);

// The available appointment times depend on the physician and date chosen
$('#appointmentDate, #physician').on('change', function(){
    var date = $('#appointmentDate').val();
    var physicianID = $('#physician').val();

    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: 'helper/bookAppointmentHelper.php',
        data: {
            date: date,
            physicianID: physicianID
        },
        cache: false,
        success: function(data) {
            var json = $.parseJSON(data);
            var appointmentTimeHTML = json.appointmentTimeHTML;
            $('#appointmentTimeHTML').html(appointmentTimeHTML);
            if (appointmentTimeHTML) {
                $('#submitHTML').html('<button id="submit" type="submit" class="btn btn-success">Submit</button>');
            } else {
                $('#submitHTML').html('<div class="banner alert alert-warning">There are no appointments available for this day.</div>');
                
            }
        }
    });
});