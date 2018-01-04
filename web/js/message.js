$( document ).ready(function() {

    if($('#appbundle_task_date').attr("id") != undefined) {
        $("#appbundle_task_is_date").click(function () {
            $("#appbundle_task_date").toggle();
        });
        $.datetimepicker.setLocale('fr');
        $('#appbundle_task_date').datetimepicker({
            timepicker: false,
            format: 'd-m-Y'
        });
    }
    if($('#appbundle_task_is_time').attr("id") != undefined) {
        $("#appbundle_task_is_time").click(function () {
            $("#appbundle_task_time").toggle();
        });
        $('#appbundle_task_time').datetimepicker({
            datepicker: false,
            format: 'H:i'
        });
    }
    if($('#appbundle_message_fosUser').attr("id") != undefined) {
        $('#appbundle_message_fosUser').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true
        });
    }
    if ($("table").attr("class") == "table-hover") {
        $("table").DataTable();
    }

    //SI SHOW
    if ($("table").attr("class") == undefined) {
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

