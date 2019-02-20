$( document ).ready(function() {
    // Initial Ajax Setup
    $.ajaxSetup({
        url: "/oniadmin/ajaxController",
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $( "#game-list" ).change(updateGamesList);

    $( "#skip-game" ).click(function() {
        var gameId = $('#game-list').find(":selected").attr('id');
        var gameValue = $('#game-list').find(":selected").val();
        matchGame(gameValue,'Not Found');

        $("#game-list option[id='"+gameId+"']").remove();
        $('#game-list option:eq(1)').prop('selected', true);

        updateGamesList();
    });
});

function updateGamesList(){
    $.ajax({
        data: {
            game: $('#game-list').find(":selected").text()
        }
    }).done(function(data){
        $(".game-response").empty();
        for(var i = 0; i < data.length; i++) {
            var obj = data[i];
            $(".game-response").append(
                "<div class='col-2 themed-grid-col'><div style='text-decoration: none;color: gray;cursor: pointer;padding-bottom: 60px;'> <h6 onclick='matchGame(null,\""+obj.psn_id+"\")'>"+obj.name+"<br />("+obj.release_date+")</h6> <img src='"+obj.thumbnail_url_base+"' width='100%' /><a href='"+obj.psn_store_url+"' target='_blank'>PSN Link</a> </div></div>"
            );
        }
    });
}

function matchGame(gameId,psnId){
    if(gameId==null){
        gameId = $('#game-list').find(":selected").val();
        $("#game-list option[value='"+gameId+"']").remove();
        $('#game-list option:eq(1)').prop('selected', true);
        updateGamesList();
    }

    $.ajax({
        data: {
            idgb_id: gameId,
            psn_id: psnId
        }
    }).done(function(data){
        console.log(data + " | UPDATE game_id_sync || " + "IGDB_ID: " + gameId + " PSN_ID: " + psnId)
    });
}
