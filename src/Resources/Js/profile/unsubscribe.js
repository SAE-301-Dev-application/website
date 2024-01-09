const TOGGLING_POPUP_ELEMENTS = $('#unsubscribe_button, .popup > .popup-close-button'),
      CONFIRMATION_POPUP = $('#popup_confirm_account_deleting');

TOGGLING_POPUP_ELEMENTS.on('click', () => {
    $("body").toggleClass("body-overflow-clip");
    CONFIRMATION_POPUP.toggleClass("popup-hidden");
});