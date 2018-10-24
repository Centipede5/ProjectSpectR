$( document ).ready(function() {
    $('#user_info_display_name').keypress(function (e) {
        const regex = new RegExp("^[a-zA-Z0-9]+$");
        const str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

        if (regex.test(str)) { return true; }
        e.preventDefault();

        return false;
    });

    updateCountdown();
    $('#user_info_bio').change(updateCountdown).keyup(updateCountdown);

    $('#user_info_youtube').bind('keypress keyup blur', function() {
        $('#user_info_youtube_input').html($(this).val());
    });
    $('#user_info_twitter').bind('keypress keyup blur', function() {
        $('#user_info_twitter_input').html($(this).val());
    });
    $('#user_info_facebook').bind('keypress keyup blur', function() {
        $('#user_info_facebook_input').html($(this).val());
    });
});

function updateCountdown() {
    const currentLength    = $('#user_info_bio').val().length;
    const remaining        = 255 - currentLength;
    const percentRemaining = Math.round((currentLength / 255) * 100);

    $('#countdown').text(remaining + ' characters remaining.');
    if(percentRemaining >= 95){
        $('#bio-progress-bar').removeClass('progress-bar-success progress-bar-warning').addClass('progress-bar-danger').css('width',percentRemaining+'%');
    } else if(percentRemaining > 75 && percentRemaining < 95){
        $('#bio-progress-bar').removeClass('progress-bar-success progress-bar-danger').addClass('progress-bar-warning').css('width',percentRemaining+'%');
    } else {
        $('#bio-progress-bar').removeClass('progress-bar-warning progress-bar-danger').addClass('progress-bar-success').css('width',percentRemaining+'%');
    }
}

function openSocialLink(link){
    if(link === 'youtube'){
        url="https://www.youtube.com/" + $('#user_info_youtube').val();
        window.open(url,'_blank');
    } else if(link === 'twitter'){
        url="https://www.twitter.com/" + $('#user_info_twitter').val();
        window.open(url,'_blank');
    } else if(link === 'facebook'){
        url="https://www.facebook.com/" + $('#user_info_facebook').val();
        window.open(url,'_blank');
    } else if(link === 'website'){
        url=$('#user_info_website').val();
        window.open(url,'_blank');
    }
}