

// Wrap every letter in a span
var textWrapper = document.querySelector('.home-8-title');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

  anime.timeline({loop: true})
    .add({
      targets: '.home-8-title .letter',
      translateY: [100,0],
      translateZ: 0,
      opacity: [0,1],
      easing: "easeOutExpo",
      duration: 1400,
      delay: function(el, i) {
        return 300 + 30 * i;
      }
    }).add({
      targets: '.home-8-title .letter',
      translateY: [0,-100],
      opacity: [1,0],
      easing: "easeInExpo",
      duration: 1200,
      delay: function(el, i) {
        return 100 + 30 * i;
      }
    });
