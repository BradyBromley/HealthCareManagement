function htmlDate(date) {
    var dd = date.getDate();
    var mm = date.getMonth() + 1;
    var yyyy = date.getFullYear();

    dd = (dd < 10) ? '0' + dd : dd;
    mm = (mm < 10) ? '0' + mm : mm;

    return yyyy + '-' + mm + '-' + dd;
}

var appointmentDate = document.getElementById('appointmentDate');
var today = new Date();
var tomorrow = new Date(today.setDate(today.getDate() + 1));
var tomorrowYMD = htmlDate(tomorrow);
var nextYear = htmlDate(new Date(new Date().setFullYear(new Date().getFullYear() + 1)));

appointmentDate.valueAsDate = tomorrow;
appointmentDate.setAttribute('min', tomorrowYMD);
appointmentDate.setAttribute('max', nextYear);

$('#appointmentDate, #physician').on('change', function(){
    var date = $('#appointmentDate').val();
    var physicianID = $('#physician').val();

    $.ajax({
        type: 'POST',
        url: 'bookAppointmentHelper.php',
        data: {
            date: date,
            physicianID: physicianID
        },
        cache: false,
        success: function(data) {
            $('#appointmentTimeHTML').html(data);
        }
    });
});