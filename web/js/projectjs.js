$( document ).ready(function() {

    // SI EDIT
    if ($("#appbundle_project_date").attr("id") != undefined){
        $("#appbundle_project_is_date").click(function () {
            $("#appbundle_project_date").toggle();
        });
        $.datetimepicker.setLocale('fr');
        $('#appbundle_project_date').datetimepicker({
            timepicker:false,
            format:'d-m-Y'
        });
    }

    if ($("#appbundle_project_is_time").attr("id") != undefined) {
        $("#appbundle_project_is_time").click(function () {
            $("#appbundle_project_time").toggle();
        });
        $('#appbundle_project_time').datetimepicker({
            datepicker:false,
            format:'H:i'
        });
    }

    if ($("#appbundle_project_fosUser").attr("id") != undefined) {

        $('#appbundle_project_fosUser').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true
        });
    }
    //FIN SI EDIT


    //SI INDEX
    if ($("table").attr("class") == "table-hover") {
        $("table").DataTable();
    }
    //FIN SI INDEX
    //SI SHOW
    if ($("table").attr("class") == undefined) {
        $("button#show-task-in-project").click(function () {
            $(".task-in-project").toggle();
        });
        $("button#show-user-in-project").click(function () {
            $(".user-in-project").toggle();
        });
    }
    //FIN SI SHOW

    // $("form").addClass("form-horizontal");
    // $("label").parent("div").addClass("form-group");
    // $("label").addClass("col-sm-2 control-label");



});



