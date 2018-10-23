$( document ).ready(function() {
    $('#user_info_display_name').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

        if (regex.test(str)) { return true; }
        e.preventDefault();

        return false;
    });

    updateCountdown();
    $('#user_info_bio').change(updateCountdown).keyup(updateCountdown);
});

function updateCountdown() {
    var currentLength    = $('#user_info_bio').val().length;
    var remaining        = 255 - currentLength;
    var percentRemaining = Math.round((currentLength / 255) * 100);

    $('#countdown').text(remaining + ' characters remaining.');
    if(percentRemaining >= 95){
        $('#bio-progress-bar').removeClass('progress-bar-success progress-bar-warning').addClass('progress-bar-danger').css('width',percentRemaining+'%');
    } else if(percentRemaining > 75 && percentRemaining < 95){
        $('#bio-progress-bar').removeClass('progress-bar-success progress-bar-danger').addClass('progress-bar-warning').css('width',percentRemaining+'%');
    } else {
        $('#bio-progress-bar').removeClass('progress-bar-warning progress-bar-danger').addClass('progress-bar-success').css('width',percentRemaining+'%');
    }
}