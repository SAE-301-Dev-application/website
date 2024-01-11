const POPUP = $("#search_scene_popup"),
      POPUP_CLOSE_BUTTON =$(".popup > .popup-close-button");

POPUP_CLOSE_BUTTON.on("click", () => {  console.log("click")
    POPUP.addClass("popup-hidden");
    $("body").removeClass("body-overflow-clip");
});