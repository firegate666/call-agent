$(function () {
    var timer,
        callState = 0; // 0 before call, 1 while call, 2 call ended

    $('.datepicker').datetimepicker({
        locale: 'de',
        calendarWeeks: true,
        showTodayButton: true,
        showClear: true,
        format: "L LTS"
    });

    $('table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
    });

    $("body").on("click", "#manage-call", function() {
        var $button = $(this);

        if (callState === 0) {
            $button.removeClass('btn-primary');
            $button.addClass('btn-warning');
            $button.find('span.message').text('Anruf beenden');
            $button.find('span.spinning').removeClass('hidden');

            $("#start-date").data("DateTimePicker").date(new Date());
            $("#end-date").data("DateTimePicker").date(new Date());

            timer = setInterval(function() {
                $("#end-date").data("DateTimePicker").date(new Date());
            }, 1000);

            callState = 1;
        } else if (callState === 1) {
            clearInterval(timer);
            $button.removeClass('btn-warning');
            $button.addClass('btn-success');
            $button.find('span.message').text('Anruf ist beendet');
            $button.find('span.spinning').addClass('hidden');

            $("#end-date").data("DateTimePicker").date(new Date());
            $("#submit-call").prop("disabled", false);

            callState = 2;
        }
    });
});
