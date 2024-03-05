$(document).ready(function(){
    // Invoke a change on page load so the start/end times get correctly shown/hidden
    $("#role").change();
});

// The start and end time dropdowns should only show if the physician role is selected
$('#role').on('change', function(){
    var role = $('#role').find('option:selected').text();

    if (role == 'physician') {
        $('#availableTimes').show();
    } else {
        $('#availableTimes').hide();
    }
});

// The end time dropdown should only show times after the start time
$('#startTime').on('change', function(){
    var startTime = $('#startTime').val();

    $.ajax({
        type: 'POST',
        url: 'editProfileHelper.php',
        data: {
            startTime
        },
        cache: false,
        success: function(data) {
            $('#endTimeHTML').html(data);
        }
    });
});