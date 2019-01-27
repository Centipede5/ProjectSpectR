$( document ).ready(function() {
    // Initial Ajax Setup
    $.ajaxSetup({
        url: "/oniadmins/gameGetSync",
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $( "#game-list" ).change(function(){
        $.ajax({
            data: {
                game: $('#game-list').find(":selected").text()
            }
        }).done(function(data){
            $(".game-response").empty();
            for(var i = 0; i < data.length; i++) {
                var obj = data[i];
                $(".game-response").append(
                    "<div class='col-2 themed-grid-col'><div style='text-decoration: none;color: gray;cursor: pointer;padding-bottom: 60px;'> <h6>"+obj.name+"<br />("+obj.release_date+")</h6> <img src='"+obj.thumbnail_url_base+"' width='100%' /> </div></div>"
                );
                console.log(obj.id);
            }
        });
    });

});
