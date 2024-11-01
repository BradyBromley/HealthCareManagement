var deactivate_user_modal = document.getElementById('deactivateUserModal');
deactivate_user_modal.addEventListener('show.bs.modal', function (event) {
    // Get the user's ID
    var id = event.relatedTarget.getAttribute('data-bs-id');
    // Set the deactivate form to deactivate that particular user
    var modal_body_input = deactivate_user_modal.querySelector('#deactivateUserForm');
    modal_body_input.action = '/users/' + id;
});
