$(document).ready(function(){
    // Invoke a change on page load so the start/end times get correctly shown/hidden
    $('#role').change();
});

// The start and end time dropdowns should only show if the physician role is selected
$(document).on('change', '#role', function(){
    var role = $('#role').find('option:selected').text();
    var physicianID = $('#userID').attr('value');
    
    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: 'helper/editProfilePhysicianHelper.php',
        data: {
            physicianID: physicianID
        },
        cache: false,
        success: function(data) {
            var json = $.parseJSON(data);
            var startTimeHTML = json.startTimeHTML;
            var endTimeHTML = json.endTimeHTML;

            if (role == 'physician') {
                $('#startTimeHTML').html(startTimeHTML);
                $('#endTimeHTML').html(endTimeHTML);

                $('#startTimeHTML').show();
                $('#endTimeHTML').show();
            } else {
                $('#startTimeHTML').html('');
                $('#endTimeHTML').html('');

                $('#startTimeHTML').hide();
                $('#endTimeHTML').hide();
            }
        }
    });
});

// The end time dropdown should only show times after the start time
$(document).on('change', '#startTime', function(){
    var startTime = $('#startTime').val();
    var endTime =  $('#endTime').val();

    $.ajax({
        type: 'POST',
        url: 'helper/editProfileAvailableTimesHelper.php',
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