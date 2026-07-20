// Newsletter subscribe (footer, site-wide). MAS-26.
// ajax.js yalnızca yorum sayfalarında yüklendiği için handler buraya alındı; bu dosya
// her sayfada yüklenir. URL form action'dan okunur → kök ve alt klasör sayfalarında çalışır.

$(document).ready(function () {
    $('#newsletter_form').submit(function (e) {
        e.preventDefault();

        var $form = $(this);
        var email = $form.find('input[name="email"]').val();
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailPattern.test(email)) {
            $('#message_success').hide();
            $('#message_failed').text('Please enter a valid email address.').show();
            setTimeout(function () { $('#message_failed').fadeOut(); }, 3000);
            return;
        }

        $.ajax({
            type: 'POST',
            url: $form.attr('action') || './functions/mailer/newsletter.php',
            data: $form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#message_failed').hide();
                    $('#message_success').show();
                    $form[0].reset();
                } else {
                    $('#message_success').hide();
                    $('#message_failed').text(response.message).show();
                }
                setTimeout(function () {
                    $('#message_success').fadeOut();
                    $('#message_failed').fadeOut();
                }, 3000);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                $('#message_success').hide();
                $('#message_failed').text('There was an error. Please try again.').show();
                setTimeout(function () { $('#message_failed').fadeOut(); }, 3000);
            }
        });
    });
});
