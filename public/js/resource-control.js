
$(document).on("click",".delete_res_btn", function(){

    let $alert= confirm("Are you sure, you want to "+$(this).html()+"?")

    if($alert){
        console.log("yasd", $(this).data("id"))
        $("form#"+$(this).data("id")).submit()
    }
})