//Major.js by Thais Vacaflores

import $ from 'jquery';

class Major {
  constructor() {
    this.events();
  }

  events() {
    $(".major-box").on("click", this.ourClickDispatcher.bind(this));
  }

  // methods
  ourClickDispatcher(e) {
    var currentMajorBox = $(e.target).closest(".major-box");
    this.changeMajor(currentMajorBox);
  }

  changeMajor(currentMajorBox) {

    var newMajor = currentMajorBox.data('major')
    
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', capstoneData.nonce);
      },
      url: capstoneData.root_url + '/wp-json/v1/manageMajor',
      type: 'POST',
      data: {'major': newMajor},
      success: (response) => {

        $(".major-box").each(function() {
            $(this).attr('data-selected', '');
        });

        currentMajorBox.attr('data-selected', 'yes');

        console.log(response);
      },
      error: (response) => {
        console.log(response);
      }
    });
  }
}

export default Major;