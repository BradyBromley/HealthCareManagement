$(document).ready(function(){
    // Show the availability of the user if they are a physician
    var role = $('#role').text();
    if (role == 'physician') {
        var physicianID = $('#userID').attr('value');

        $.ajax({
            type: 'POST',
            datatype: 'json',
            url: 'helper/profileHelper.php',
            data: {
                physicianID: physicianID
            },
            cache: false,
            success: function(data) {
                var json = $.parseJSON(data);
                var availabilityHTML = json.availabilityHTML;
                $('#availabilityHTML').html(availabilityHTML);
            }
        });
    }
});