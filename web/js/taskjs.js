$( document ).ready(function() {
    if ($("#page").val() == "edit" || $("#page").val() == "new") {
        if ($('#appbundle_task_date').attr("id") != undefined) {
            $("#appbundle_task_is_date").click(function () {
                $("#appbundle_task_date").toggle();
            });
            $.datetimepicker.setLocale('fr');
            $('#appbundle_task_date').datetimepicker({
                timepicker: false,
                format: 'd-m-Y'
            });
        }
        if ($('#appbundle_task_is_time').attr("id") != undefined) {
            $("#appbundle_task_is_time").click(function () {
                $("#appbundle_task_time").toggle();
            });
            $('#appbundle_task_time').datetimepicker({
                datepicker: false,
                format: 'H:i'
            });
        }
        if ($('#appbundle_task_user').attr("id") != undefined) {

            $('#appbundle_task_user').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true
            });
        }
    }
    if ($("#page").val() == "index") {
        if ($("table").attr("class") == "table-hover") {
            $("table").DataTable();
        }
    }

    //SI SHOW
    if ($("#page").val() == "show") {
        $("button#show-task-in-task").click(function () {
            $(".task-in-task").slideToggle();
        });
        $("button#show-user-in-task").click(function () {
            $(".user-in-task").slideToggle();
        });
        $("button#show-project-in-task").slideToggle(function () {
            $(".project-in-task").toggle();
        });
    }
    //FIN SI SHOW

});

