const POPUP = $("#search_contributor_popup"),
      POPUP_CLOSE_BUTTON = $(".popup > .popup-close-button");

POPUP_CLOSE_BUTTON.on("click", () => {
    POPUP.addClass("popup-hidden");
    $("body").removeClass("body-overflow-clip");
});