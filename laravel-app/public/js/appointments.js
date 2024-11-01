var change_status_modal = document.getElementById('change_status_modal');
change_status_modal.addEventListener('show.bs.modal', function (event) {
    // Get the appointment ID
    var id = event.relatedTarget.getAttribute('data-bs-id');

    // Get the appointment status
    var status = event.relatedTarget.getAttribute('data-status');
    document.getElementById('status').value = status;

    // Set the button to change the appointment status
    var change_status_button = change_status_modal.querySelector('#change_status_button');
    change_status_button.href = '/appointments/' + id + '/changeStatus/' + status;
});

var cancel_appointment_modal = document.getElementById('cancel_appointment_modal');
cancel_appointment_modal.addEventListener('show.bs.modal', function (event) {
    // Get the appointment ID
    var id = event.relatedTarget.getAttribute('data-bs-id');
    // Set the button to cancel the appointment
    var modal_body_input = cancel_appointment_modal.querySelector('#cancel_appointment_form');
    modal_body_input.action = '/appointments/' + id;
});

// Change the status
$(document).on('change', '#status', function(){
    // Get the current href of the button and trim off everything after the last /
    var href = $('#change_status_button').attr('href');
    href = href.substr(0, href.lastIndexOf('/'));

    var status = $('#status').val();

    $('#change_status_button').attr('href', href + '/' + status)
});
