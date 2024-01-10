const TOGGLING_POPUP_ELEMENTS = $('#delete_account_button, .popup > .popup-close-button, #popup_cancel_button'),
      CONFIRMATION_POPUP = $('#popup_confirm_account_deleting'),
      CONFIRM_BUTTON = $('#popup_confirm_button'),
      FORM = $('#password_form'),
      PASSWORD_INPUT = $('input[name="password_verification"]');

TOGGLING_POPUP_ELEMENTS.on('click', () => {
    $("body").toggleClass("body-overflow-clip");
    CONFIRMATION_POPUP.toggleClass("popup-hidden");
});

FORM.on('submit', (e) => {
    e.preventDefault();

    $.post('/profile/delete-account/confirm', {password: PASSWORD_INPUT.val()})
        .done(data => {
            $("li.input-error").html(data);
        });
});