$(document).ready(function(){
    // Invoke a change on page load so the start/end times get correctly shown/hidden
    $('#role_id').change();
});

// The start and end time dropdowns should only show if the physician role is selected
$(document).on('change', '#role_id', function(){
    var role = $('#role_id').find('option:selected').text();
    var user_id = $('#user_id').attr('value');

    $.ajax({
        type: 'GET',
        datatype: 'json',
        url: '/users/' + user_id + '/updateAvailability',
        cache: false,
        success: function(data) {
            var json = $.parseJSON(data);
            var start_time_select_list = json.start_time_select_list;
            var end_time_select_list = json.end_time_select_list;

            if (role == 'physician') {
                $('#start_time_select_list').html(start_time_select_list);
                $('#end_time_select_list').html(end_time_select_list);

                $('#start_time_select_list').show();
                $('#end_time_select_list').show();
            } else {
                $('#start_time_select_list').html('');
                $('#end_time_select_list').html('');

                $('#start_time_select_list').hide();
                $('#end_time_select_list').hide();
            }
        }
    });
});

// The end time dropdown should only show times after the start time
$(document).on('change', '#start_time_select_list', function(){
    var user_id = $('#user_id').attr('value');
    var start_time = $('#start_time').val();
    var end_time =  $('#end_time').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').attr('value')
        }
    });

    // Post start and end times so that they don't get reset when dropdowns change
    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: '/users/' + user_id + '/updateEndTime',
        data: {
            start_time,
            end_time,
        },
        cache: false,
        success: function(data) {
            var json = $.parseJSON(data);
            var end_time_select_list = json.end_time_select_list;
            $('#end_time_select_list').html(end_time_select_list);
        }
    });
});