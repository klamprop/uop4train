$( document ).ready(
    $(".update_course_status").on('click',function(){
        var section_id=$(this).attr("data-sectionid");
        var user_id=$(this).attr("data-user_id");
        var course_id=$(this).attr("data-course_id");
        var dataStr = {"section_id":section_id,"user_id":user_id,"course_id":course_id};
        $.ajax({
            type: "POST",
            url: "functions/update_course_status.php",
            data: dataStr,
            dataType: "json",
            success: function(msg){},
            error:function(err){}
            
        });
    })
)
