$( document ).ready(function() {

    if ($("#appbundle_project_date").attr("id") != undefined){
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

    $("table").DataTable();
});

