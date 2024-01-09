const NAVIGATION_LINKS = $(".left-side > .menu-container > a"),
      SECTIONS = [
          "my_profile", "my_festivals",
          "my_spectacles", "settings",
      ];

SECTIONS.forEach(section => {
    $(".left-side > .menu-container > a[href='#" + section + "']")
        .on("click", () => {
            toSection(section);
        });
});

function toSection(sectionId) {
    const CURRENT_LINK = $(".left-side > .menu-container > a[href='#" + sectionId + "']");

    focusedSection = sectionId;

    NAVIGATION_LINKS
        .removeClass("active-link");

    CURRENT_LINK
        .addClass("active-link");
}