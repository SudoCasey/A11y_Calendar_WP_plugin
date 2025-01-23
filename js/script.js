(function($) {
    $(document).ready(function() {
        // Use event delegation to handle clicks on dynamically added links
        $(document).on('click', '.a11y-calendar .prev-month, .a11y-calendar .next-month', function(e) {
            e.preventDefault();

            let month = parseInt($(this).data('month'));
            let year = parseInt($(this).data('year'));

            // Wrap months correctly (December to January and vice versa)
            if (month < 1) {
                month = 12;
                year -= 1;
            } else if (month > 12) {
                month = 1;
                year += 1;
            }

            // AJAX request to fetch and update the calendar
            $.ajax({
                url: a11yCalendarAjax.ajax_url,
                method: 'POST',
                data: {
                    action: 'a11y_calendar_update',
                    month: month,
                    year: year,
                },
                success: function(response) {
                    if (response.success) {
                        $('.a11y-calendar').replaceWith(response.data);
                    }
                }
            });
        });
    });
})(jQuery);