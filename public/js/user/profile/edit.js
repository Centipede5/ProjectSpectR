$( document ).ready(function() {
    $('#user_info_display_name').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

        if (regex.test(str)) { return true; }
        e.preventDefault();

        return false;
    });
});