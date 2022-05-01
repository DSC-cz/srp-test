$(".delete-item").click(function(){
    $.ajax({
        url: "/users/info/"+$(this).attr("data-id"),
        type: "GET",
        success: function(data){
            data = JSON.parse(data);
            $("#delete .name").html(data["username"]);
            $("[name=remove_id]").val(data["id"]);
        },
        error: function(){
            alert("Napodařilo se získat data uživatele");
        }
    })
});

$(".reset-item").click(function(){
    $.ajax({
        url: "/users/info/"+$(this).attr("data-id"),
        type: "GET",
        success: function(data){
            data = JSON.parse(data);
            $("#reset .name").html(data["username"]);
            $("[name=reset_id]").val(data["id"]);
        },
        error: function(){
            alert("Napodařilo se získat data uživatele");
        }
    })
});