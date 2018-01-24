$( document ).ready(function() {

    // SI EDIT
    if ($("#page").val() == "edit" || $("#page").val() == "new"){
        $("#appbundle_project_is_date").click(function () {
            $("#appbundle_project_date").toggle();
        });
        $.datetimepicker.setLocale('fr');
        $('#appbundle_project_date').datetimepicker({
            timepicker:false,
            format:'d-m-Y'
        });


        if ($("#appbundle_project_is_time").attr("id") != undefined) {
            $("#appbundle_project_is_time").click(function () {
                $("#appbundle_project_time").toggle();
            });
            $('#appbundle_project_time').datetimepicker({
                datepicker:false,
                format:'H:i'
            });
        }

        if ($("#appbundle_project_user").attr("id") != undefined) {

            $('#appbundle_project_user').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true
            });
        }
    }
    //FIN SI EDIT


    //SI INDEX
    if ($("#page").val() == "index") {
        $("table").DataTable();
    }
    //FIN SI INDEX
    //SI SHOW
    if ($("#page").val() == "show") {
        $("button#show-task-in-project").click(function () {
            $(".task-in-project").slideToggle();
        });
        $("button#show-user-in-project").click(function () {
            $(".user-in-project").slideToggle();
        });
    }
    //FIN SI SHOW

    // $("form").addClass("form-horizontal");
    // $("label").parent("div").addClass("form-group");
    // $("label").addClass("col-sm-2 control-label");



});



