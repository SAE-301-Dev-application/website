const BODY = $('body');

const UNSUBSCRIBE_BUTTON = $('#unsubscribe-button');

const CONFIRMATION_POPUP = $('#profile_main > #confirmation-popup');

let popupVisible = false;

UNSUBSCRIBE_BUTTON.on('click', () => {
    confirmationPopup();
});

/**
 * Makes the unsubscribe confirmation pop-up visible.
 */
function confirmationPopup() {
    if (!popupVisible) {
        BODY.addClass('hide-overflow');

    } else {
        BODY.removeClass('hide-overflow');
    }
}

/**
 * Redirects the user to the unsubscribe page.
 */
function unsubscribe() {
    header("Location: /unsubscribe");
}