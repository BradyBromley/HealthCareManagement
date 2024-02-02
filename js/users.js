var deactivateUserModal = document.getElementById('deactivateUserModal');
deactivateUserModal.addEventListener('show.bs.modal', function (event) {
    // Get the user's ID
    var id = event.relatedTarget.getAttribute('data-bs-id');
    // Set the deactivate button to deactivate that particular user
    var modalBodyInput = deactivateUserModal.querySelector('.deactivateUserButton');
    modalBodyInput.href = '/src/deactivateUser.php?id=' + id;
});
