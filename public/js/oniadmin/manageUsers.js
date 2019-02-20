$( document ).ready(function() {
    // Initial Ajax Setup
    $.ajaxSetup({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $( "#searchButton" ).click(function() {
        var searchData = $('#searchData').val();
        var searchBy = $('#searchBy').find(":selected").attr('id');
        searchForUser(searchBy,searchData);
    });
});

function searchForUser(searchBy,searchData){
    console.log(searchBy + ": " + searchData);
    $.ajax({
        url: "/oniadmin/searchUser",
        data: {
            searchBy: searchBy,
            searchData: searchData
        }
    }).done(function(data){
        console.log(data)
    });
}

function updateField(property){
    const recordId        = $(property).closest("tr").prop("id");
    const container     = $(property).closest("td").prop("id");
    const containerId   = "#"+container;
    let textToUpdate    = $(property).html();

    const editId = "edit-"+container;
    $(containerId).empty();
    $(containerId).append("<textarea id='"+editId+"' data-original-text='"+textToUpdate+"'>"+textToUpdate+"</textarea><button onclick='saveField(this)'>save</button>");
    $("#"+editId).focus();
}

function saveField(property){
    const recordId = $(property).closest("tr").prop("id");
    const container =  $(property).closest("td").prop("id");
    const containerId = "#"+container;
    const editId = "edit-"+container;
    const newText =  $(property).prev().val();

    if($("#"+editId).attr('data-original-text') !== newText){
        console.log("[Spectre] Updated Text: " + newText);

        // Add Save Logic

        $.ajax({
            url: "/oniadmin/updateUser",
            data: {
                updateUserId: recordId,
                updateField: container,
                updateData: newText
            }
        }).done(function(data){
            console.log(data)
        });

        $(containerId).empty();
        $(containerId).append("<span onclick='updateField(this)'>"+newText+"</span>");
    } else {
        console.log("[Spectre] Text Unchanged");
        $(containerId).empty();
        $(containerId).append("<span onclick='updateField(this)'>"+newText+"</span>");
    }
}
