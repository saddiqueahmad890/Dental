$(document).ready(function() {
    "use strict";
    $(document).on('change', '#doctor_id, #appointment_date', function() {
        let userId = $('#doctor_id').val();
        let appointmentDate = $('#appointment_date').val();
        let siteUrl = $('meta[name="site-url"]').attr('content');
        let url = siteUrl + '/patient-appointments/get-schedule/doctorwise';
        let submitButton = $('input[type="submit"]');

        if (userId && appointmentDate) {
            $.get(url, { userId, appointmentDate }, function(response) {
                displayFlashMessage(response.message);
                console.log(response.message);

                // Hide submit button if doctor is not available
                if (response.status === 0) {
                    submitButton.hide();
                } else {
                    submitButton.show();
                }
            });
        } else {
            submitButton.show();
        }
    });

    function displayFlashMessage(message) {
        console.log("Displaying message:", message);  // Log the message
        $('.custom-flash-message').remove();

        let flashMessage = $('<div class="custom-flash-message"></div>').html(message).hide();
        $('body').prepend(flashMessage);
        flashMessage.fadeIn('slow');

        setTimeout(function() {
            flashMessage.fadeOut('slow', function() {
                $(this).remove();
            });
        }, 3000);
    }
});
