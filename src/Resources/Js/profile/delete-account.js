const TOGGLING_POPUP_ELEMENTS = $('#delete_account_button, .popup > .popup-close-button, #popup_cancel_button'),
      CONFIRMATION_POPUP = $('#popup_confirm_account_deleting');

TOGGLING_POPUP_ELEMENTS.on('click', () => {
    $("body").toggleClass("body-overflow-clip");
    CONFIRMATION_POPUP.toggleClass("popup-hidden");
});

CONFIRMATION_POPUP.on('click', () => {
    header('Location: /profile/delete-account');
});