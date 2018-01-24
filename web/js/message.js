$( document ).ready(function() {

    if($('#page').val() == "new") {
        $('#appbundle_message_user').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true
        });
    }
    if ($("#page").val() == "index") {
        $("table").DataTable();
    }

    //SI SHOW
    if ($("table").hasClass("borderless")) {
        $("button#show-task-in-task").click(function () {
            $(".task-in-task").toggle();
        });
        $("button#show-user-in-task").click(function () {
            $(".user-in-task").toggle();
        });
        $("button#show-project-in-task").click(function () {
            $(".project-in-task").toggle();
        });
    }
    //FIN SI SHOW

});

