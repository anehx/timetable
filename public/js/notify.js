jQuery(function() {
  "use strict";

  $.fn.notify = function(params) {
    var defaults = {
        'timeout' : 10000,
        'clickable' : true,
        'opacity': 1,
        'opacityHover': 0.7
    }
    var options = $.extend({}, defaults, params || {});

    if (options.clickable) {
      this.on('click', function(){$(this).slideUp()})
    }
    this.on('mouseover', function(){
      $(this).css({
        'opacity':options.opacityHover,
        'cursor':'pointer'
      })
    })
    this.on('mouseleave', function(){
      $(this).css({
        'opacity':options.opacity,
        'cursor':'default'
      })
    })

    setTimeout(function(){
      $(this).fadeOut('fast')
    }.bind(this), options.timeout)
  }
});