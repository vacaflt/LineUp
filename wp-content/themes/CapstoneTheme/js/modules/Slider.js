//Slider.js by Thais Vacaflores
import $ from 'jquery';

class Slider {
  constructor() {
    this.els = $(".slider");
    this.initSlider();
  }

  initSlider() {
    this.els.slick({
      autoplay: true,
      arrows: false,
      dots: true
    });
  }
}

export default Slider;