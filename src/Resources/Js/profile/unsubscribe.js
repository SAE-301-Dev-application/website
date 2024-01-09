const TOGGLING_POPUP_ELEMENTS = $('#unsubscribe_button, .popup > .popup-close-button'),
      CONFIRMATION_POPUP = $('#popup_confirm_account_deleting');

console.log("importé");

TOGGLING_POPUP_ELEMENTS.on('click', () => {
    console.log("cliqué", CONFIRMATION_POPUP);
    CONFIRMATION_POPUP.toggleClass("popup-hidden");
});