$(".edit-item").click(function(){
    $.ajax({
        url: "/brands/info/"+$(this).attr("data-id"),
        type: "GET",
        success: function(data){
            data = JSON.parse(data);
            $("[name=new_name]").val(data["name"]);
            $("[name=edit_id]").val(data["id"]);
        },
        error: function(){
            console.error("Nepodařilo se získat data pro editaci položky.");
        }
    });
});
$(".delete-item").click(function(){
    $.ajax({
        url: "/brands/info/"+$(this).attr("data-id"),
        type: "GET",
        success: function(data){
            data = JSON.parse(data);
            $("strong.name").html(data["name"]);
            $("[name=delete_id]").val(data["id"]);
        },
        error: function(){
            console.error("Nepodařilo se získat data pro smazání položky.");
        }
    })
});
