var changeStatusModal = document.getElementById('changeStatusModal');
changeStatusModal.addEventListener('show.bs.modal', function (event) {
    // Get the appointment ID
    var id = event.relatedTarget.getAttribute('data-bs-id');

    // Get the appointment status
    var status = document.getElementById('status').value;

    // Set the button to change the appointment status
    var changeStatusButton = changeStatusModal.querySelector('#changeStatusButton');
    changeStatusButton.href = '/src/view/helper/changeAppointmentStatusHelper.php?id=' + id + '&status=' + status;
});

var cancelAppointmentModal = document.getElementById('cancelAppointmentModal');
cancelAppointmentModal.addEventListener('show.bs.modal', function (event) {
    // Get the appointment ID
    var id = event.relatedTarget.getAttribute('data-bs-id');
    // Set the button to cancel the appointment
    var cancelAppointmentButton = cancelAppointmentModal.querySelector('#cancelAppointmentButton');
    cancelAppointmentButton.href = '/src/view/helper/cancelAppointmentHelper.php?id=' + id;
});


// Change the status
$(document).on('change', '#status', function(){
    // Get the current href of the button and trim off everything after the & (including the &)
    var href = $('#changeStatusButton').attr('href').split('&')[0];

    var status = $('#status').val();

    $('#changeStatusButton').attr('href', href + '&status=' + status)
});
