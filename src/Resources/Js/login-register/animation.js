/**
 * The animation of the slogan.
 * 
 * @param {string} page
 */
function sloganAnimation(page) {

    const SLOGAN = $(`#${page}_main > .left-side > .side-contents > p.slogan`);
    const TIMELINE = gsap.timeline({paused: false});

    TIMELINE
      .from(SLOGAN, {
          duration: 1,
          delay: 1,

          opacity: 0,
          y: 50,

          ease: Power2.easeOut,
      })
      .play();
}