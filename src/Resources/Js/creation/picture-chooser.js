const CHOOSE_PICTURE_BUTTON = $("button#choose_picture");

const PICTURE_INPUT = $("input#picture_input");

const IMG_PREVIEW = $("img#preview-img");

CHOOSE_PICTURE_BUTTON.on("click", e => {
    e.preventDefault();
    
    PICTURE_INPUT.trigger("click");
    
    PICTURE_INPUT.on("change", e => {
        let url = URL.createObjectURL(e.target.files[0]);
        
        IMG_PREVIEW.attr("src", url);
        
        console.log(url);
        console.log(e);
    });
});