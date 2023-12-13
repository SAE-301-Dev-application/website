const SLOGAN = $("#app > .left-side > .content > p.slogan");

function sloganAnimation() {
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