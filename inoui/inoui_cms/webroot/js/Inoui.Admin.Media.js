Inoui.define('Inoui.Admin.Media', Inoui.extend({
    shifted:false,
    init:function () {
    },
    ready:function() {
      $("img.lazy").lazyload({
          effect : "fadeIn"
      });
      var that = this;

      $( "#NewFkType" ).on('keyup', $.proxy(this.setNewCategory, this));


      // $('body').on('click', '.grid li', $.proxy(this.onFigureClick, this))
    },
    
    setNewCategory:function(evt) { 
      $('.dropzone').data('fk_type', $( "#NewFkType" ).val());
    },

    editMedia:function(evt) { 
      
      if (evt.shiftKey) return this.editMultipleMedia(evt);
      $('li.selected').removeClass("selected");
      
      this.$lastSelected = $(evt.currentTarget).closest('li');
      this.$lastSelected.toggleClass("selected");

      var url = $(evt.currentTarget).attr('href');
      var that = this;

      $('#right-col').load(url, function() {
        $(evt.currentTarget).closest('.row').togglecol('show');
        that.setAffix();
      });
      
    },
    onFiles:function() {
      window.location.reload();
    },
    editMultipleMedia:function(evt) { 
      $li = $(evt.currentTarget).closest('li');
      if ($li == this.$lastSelected) return;
      if (this.$lastSelected.index() < $li.index()+1) {
        $('.grid li').slice(this.$lastSelected.index(), $li.index()+1).addClass('selected');        
      } else {
        $('.grid li').slice($li.index(), this.$lastSelected.index()-1).addClass('selected');
      }

      var that = this;
      $('#right-col').load(conf.baseUrl+'/cms/media/edit', function() {
        $(evt.currentTarget).closest('.row').togglecol('show');
        that.setAffix();
      })
      
//      if ($li.hasClass('selected')) return $li.removeClass('selected');
    },
    
    deleteMedia:function(evt) {
      var $target = $(evt.currentTarget);
      var url = $target.attr('href');
      var data = this._service(url);
      $('[data-id="'+$target.data('idd')+'"]').remove();
      $('#media-list').togglecol('hide');
    },

    deleteMultipleMedia:function (evt) {
      var ids = '';
      var url = $(evt.currentTarget).attr('href');      
      $('.grid li.selected').each(function() {
        ids += $(this).data('id') + ',';
        $('[data-id="'+$(this).data('id')+'"]').remove();
      });
      url += '/id/'+ids;
      this._service(url);
    },
    
    setAffix:function () {
      $('[data-spy="affix"]').each(function () {
        var $spy = $(this)
          , data = $spy.data()

        data.offset = data.offset || {}

        data.offsetBottom && (data.offset.bottom = data.offsetBottom)
        data.offsetTop && (data.offset.top = data.offsetTop)

        $spy.affix(data)
      });
    },
    showupload:function(){
      $("#media-uploader").toggle();
      $("#media-uploader").removeClass('hidden');
    },
    
    closeEditMedia:function() {
      $('#right-col')
        .addClass('hidden');

      $('#center-col')
        .removeClass('col-md-8')
        .addClass('col-md-12')
    },
    imageSaved:function() {

    },
    changeCat:function(evt) {      
      if ($(evt.currentTarget).val() == 0) {
        $("#NewFkType").removeClass('hidden');
      } else {
        $("#NewFkType").addClass('hidden');
      }
      $('.dropzone').data('fk_type', $("#FkType option:selected").val());
    }
}));
