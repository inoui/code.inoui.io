/* ========================================================
 * inoui-bootstrap.js v0.1
 * http://twitter.github.com/bootstrap/javascript.html#tabs
 * ======================================================= */

!function ($) {

  "use strict"; // jshint ;_;


 /* TAB CLASS DEFINITION
  * ==================== */

  var ToggleCol = function (element) {
    this.$element = $(element);
    this.$cols = $(element).find("div[class^='col-'],div[class*=' col-']");
    this.$cols.each( function() {
      if (!$(this).attr('data-on')) $(this).data('on', $(this).attr('class'));
      if (!$(this).attr('data-off')) $(this).data('off', $(this).attr('class'));
    });
  }

  ToggleCol.prototype = {
    
    constructor: ToggleCol
    
  , show: function () {

      this.$element.addClass('in');
      this.$cols.each( function() {
        $(this).attr('class', $(this).data('on'));
      });
    }
  , hide: function () {
      this.$element.removeClass('in');
      this.$cols.each( function() {
        $(this).attr('class', $(this).data('off'));
      });
      
    }
  , toggle: function () {
      this[this.$element.hasClass('in') ? 'hide' : 'show']()
    }
  }


 /* TAB PLUGIN DEFINITION
  * ===================== */

  $.fn.togglecol = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('togglecol')
      if (!data) $this.data('togglecol', (data = new ToggleCol(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.togglecol.Constructor = ToggleCol
  $.fn.togglecol.defaults = {  }


 /* TAB DATA-API
  * ============ */

  $(document).on('click.togglecol.data-api', '[data-toggle="col"]', function (e) {
    e.preventDefault()
    $(e.currentTarget).closest('.row').togglecol('toggle');
  })

}(window.jQuery);