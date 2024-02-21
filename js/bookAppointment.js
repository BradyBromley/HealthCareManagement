function htmlDate(date) {
    var dd = date.getDate();
    var mm = date.getMonth() + 1;
    var yyyy = date.getFullYear();

    dd = (dd < 10) ? '0' + dd : dd;
    mm = (mm < 10) ? '0' + mm : mm;

    return yyyy + '-' + mm + '-' + dd;
}

var appointmentDate = document.getElementById('appointmentDate');
var today = htmlDate(new Date());
var nextYear = htmlDate(new Date(new Date().setFullYear(new Date().getFullYear() + 1)));

appointmentDate.valueAsDate = new Date();
appointmentDate.setAttribute('min', today);
appointmentDate.setAttribute('max', nextYear);