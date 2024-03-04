$(document).ready(function(){
    // Invoke a change on page load so the start/end times get correctly shown/hidden
    $("#role").change();
});

$('#role').on('load change', function(){
    var role = $('#role').find('option:selected').text();

    if (role == 'physician') {
        $('#availableTimes').show();
    } else {
        $('#availableTimes').hide();
    }
});

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