var text = $("#movie-new");

text.keydown(function(event){
    if(event.keyCode == 13){
        event.preventDefault();
        var title = $(this).val();
        getTag(title);
    }
});

$("#add-tag").on("click", function() {
    var title = text.val();
    getTag(title);
});

function getTag(title) {
    $.ajax({
        url: "/site/add",
        type: "POST",
        data: {"title": title},
        success: function (data) {
            text.val('');
            if(!data) return false;
            if($.isNumeric(data)){
                $("#tag" + data).attr("checked","checked");
            }else{
                $("#movie-tags").append(data);
            }
        },
        error: function () {
            alert('Error!');
        }
    });
}

$(".delete-button").on("click", function (e) {
    e.preventDefault();
    var path = $(this).attr('href');
    $('#delete-link').attr('href', path);
    $('#delete').modal();
});






