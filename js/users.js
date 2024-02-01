var deleteUserModal = document.getElementById('deleteUserModal');
deleteUserModal.addEventListener('show.bs.modal', function (event) {
    // Get the user's ID
    var id = event.relatedTarget.getAttribute('data-bs-id');
    // Set the delete button to delete that particular user
    var modalBodyInput = deleteUserModal.querySelector('.deleteUserButton');
    modalBodyInput.href = '/src/editUser.php?id=' + id;
});
