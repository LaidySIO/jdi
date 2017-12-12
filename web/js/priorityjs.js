$( document ).ready(function() {
    if($('#colorSelector').attr("id") != undefined) {
        $('#colorSelector').ColorPicker({
            color: $("#appbundle_priority_color").val(),
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorSelector div').css('backgroundColor', '#' + hex);
                $("#appbundle_priority_color").val('#' + hex);
            }
        });
    }

    $("table").dataTable();
});

