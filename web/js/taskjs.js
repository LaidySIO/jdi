$( document ).ready(function() {

    if($('#appbundle_task_date').attr("id") != undefined) {
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
    if($('#appbundle_task_fosUser').attr("id") != undefined) {
        $('#appbundle_task_fosUser').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true
        });
    }
    $("table").DataTable();

});

