var cancelAppointmentModal = document.getElementById('cancelAppointmentModal');
cancelAppointmentModal.addEventListener('show.bs.modal', function (event) {
    // Get the appointment ID
    var id = event.relatedTarget.getAttribute('data-bs-id');
    // Set the cancel button to cancel that particular appointment
    var modalBodyInput = cancelAppointmentModal.querySelector('.cancelAppointmentButton');
    modalBodyInput.href = '/src/view/cancelAppointment.php?id=' + id;
});
