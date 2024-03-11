$(document).ready(function(){
    // Invoke a change on page load so the start/end times get correctly shown/hidden
    $('#role').change();
});

// The start and end time dropdowns should only show if the physician role is selected
$('#role').on('change', function(){
    var role = $('#role').find('option:selected').text();
    var physicianID = $('#userID').attr('value');

    $.ajax({
        type: 'POST',
        url: 'editProfilePhysicianHelper.php',
        data: {
            physicianID: physicianID
        },
        cache: false,
        success: function(data) {
            if (role == 'physician') {
                $('#availableTimes').html(data);
            } else {
                $('#availableTimes').html('');
            }
        }
    });
});

// The end time dropdown should only show times after the start time
$('#startTime').on('change', function(){
    var startTime = $('#startTime').val();
    var endTime =  $('#endTime').val();

    $.ajax({
        type: 'POST',
        url: 'editProfileAvailableTimesHelper.php',
        data: {
            startTime,
            endTime
        },
        cache: false,
        success: function(data) {
            $('#endTimeHTML').html(data);
        }
    });
});