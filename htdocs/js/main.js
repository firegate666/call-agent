$(function () {
    $('.datepicker').datetimepicker({
        locale: 'de'
    });

    $('table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
    });

    /** 0 before call, 1 while call, 2 call ended */
    var callState = 0;

    $("body").on("click", "#manage-call", function() {
        var $button = $(this);

        if (callState === 0) {
            $button.removeClass('btn-primary');
            $button.addClass('btn-warning');
            $button.text('Anruf beenden');

            $("#start-date").data("DateTimePicker").date(new Date());

            callState = 1;
        } else if (callState === 1) {
            $button.removeClass('btn-warning');
            $button.addClass('btn-success');
            $button.text('Anruf ist beendet');

            $("#end-date").data("DateTimePicker").date(new Date());

            $("#submit-call").prop("disabled", false);
            callState = 2;
        }
    });
});
