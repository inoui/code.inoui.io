Inoui.define('Inoui.Admin', Inoui.extend({
    init:function() {

    },
    ready:function() {

      var that = this;

      $('select').customSelect();

      $('.fa-bars').click(function () {
          if ($('#sidebar > ul').is(":visible") === true) {
              $('#main-content').css({
                  'margin-left': '0px'
              });
              $('#sidebar').css({
                  'margin-left': '-210px'
              });
              $('#sidebar > ul').hide();
              $("#container").addClass("sidebar-closed");
          } else {
              $('#main-content').css({
                  'margin-left': '210px'
              });
              $('#sidebar > ul').show();
              $('#sidebar').css({
                  'margin-left': '0'
              });
              $("#container").removeClass("sidebar-closed");
          }
      });
      $('.default-date-picker').datepicker({
          format: 'dd-mm-yyyy'
      });
      
      // $("[data-toggle='switch']").wrap('<div class="switch" />').parent().bootstrapSwitch();
      $("[data-toggle='switch']").bootstrapSwitch();
      $('.wysiwyg').redactor({
          minHeight:'250',
          imageUpload: conf.baseUrl+'/media/upload',
          buttons: ['html', '|', 'formatting', '|', 'bold', 'boldred', 'italic', '|', 'unorderedlist', '|', 'image', 'table', 'link', '|']
      });

      $('.ui-sortable, .sortable').sortable2({
        
      }).bind('sortupdate', function(e) {

          var arr = [];
          var cls = $(this).data('class');
          $(this).children().each(function(){
              arr.push($(this).data('id'));
          });
          that._service('Media::reorder', {order:arr, cls:cls});
      });

      // $('.uploader_div').each(function() {
        
      //   var o = {
      //     fk_type:$(this).data('type'),
      //     fk_id:$(this).data('id')
      //   }
        
      //   $(this).ajaxupload({
      //       url:conf.baseUrl+'/media/attach/id/'+$('#AttachId').val(),
      //       chunkSize:0,
      //       autoStart:true,
      //       removeOnSuccess:true,
      //       data:o,
      //       onInit: function(AU){
      //       		AU.uploadFiles.hide();//Hide upload button
      //       		AU.removeFiles.hide();//hide remove button
      //       },
      //       success:function(o) {
      //         this.AU.settings.data.dataType = 'html';
      //         that._service('Media::getFiles', this.AU.settings.data, that.onFiles);
      //       }
      //     });
        
      // })

      $('.tooltips').tooltip();

      $('#modal-media').on('hidden', function () {
        $(this).removeData('modal');
      });
      var currentAction = $('.part').data('init');
      if (currentAction) {
        this[currentAction]();
      }

      Dropzone.autoDiscover = false;


      $('.dropzone').each(function() {
        $this = $(this);
        var myDropzone = new Dropzone($this[0], $this.data());
        myDropzone.on("sending", function(file, xhr, formData) {
          formData.append('fk_type', $(this.element).data('fk_type'));
          formData.append('fk_id', $(this.element).data('fk_id'));
        });
        myDropzone.on("complete", function(file) {

          this.removeFile(file);
          if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            var o = {
              fk_type:$(this.element).data('fk_type'),
              fk_id:$(this.element).data('fk_id'),
              dataType:'html'
            }
            
            that._service('Media::getFiles', o, that.onFiles);
          }
        });
        
        
      })

      // 
      // Dropzone.options.myAwesomeDropzone = {
      //   paramName: "file", // The name that will be used to transfer the file
      // };
      // 
    },
    
    setUpMedium:function() {

      this.editor = new MediumEditor('.editable');
      $('.editable.mimages').mediumInsert({
          editor: this.editor,
          addons: { // (object) Addons configuration
              images: { // (object) Image addon configuration
                  label: '<span class="fa fa-camera"></span>', // (string) A label for an image addon
                  uploadScript:'/media/upload/',
                  // deleteScript: 'delete.php', // (string) A relative path to a delete script
              }
          }
      });


      // $('.editable.mimages').mediumImages({
      //   uploadScript:'/media/upload/'
      // });
      $('.nav.nav-tabs li:eq(0)').addClass('active')
      $('.tab-pane:eq(0)').addClass('active')      
      
      
    },
    
    savePage:function() {
      var that = this;
      var allContents = this.editor.serialize();
      var i = 0;

      $.each(allContents, function( index, element ) {
        var field = $('.editable:eq('+(i++)+')').data('field');
        var value = element.value;
        $('<input>').attr({
            type: 'hidden',
            id: "Pages"+that.capitaliseFirstLetter(field),
            name: field,
            value:value
        }).appendTo('#frmPages');

      });
      $("#frmPages").submit();

    },
    
    showOrder:function(evt) {
      var href = $(evt.currentTarget).data("href");
      $('#orderReceipt').load(href);
      $(evt.currentTarget).closest('.row').togglecol('show');
    },
    addCategory:function(evt) {
      var $select = $(evt.currentTarget);

      if ($select.val() == $select.find('option:last-child').val()) {
        $("#ProductsNewCategory").removeClass('hide');
        $("#ProductsNewCategory").prop('disabled', false);
      } else {
        $("#ProductsNewCategory").addClass('hide');
        $("#ProductsNewCategory").prop('disabled', true);
      }
    },
    
    deleteMedia:function(evt) {
      var $target = $(evt.currentTarget);
      var url = $target.attr('href');
      var data = this._service(url);
      $(evt.currentTarget).closest('li').remove();
    },
    
    onFiles:function(data) {
      if (Inoui.Admin.Media != undefined) {
        return Inoui.Admin.Media.onFiles(data)
      }
      $("#file_receipt").html(data);
      var that = this;
      $('.ui-sortable').sortable2({
          
      }).bind('sortupdate', function(e) {
          var arr = [];
          $(this).find('li').each(function(){
              arr.push($(this).data('id'));
          });
          that._service('Media::reorder', {order:arr});
      });

    },
    onFilesReorder:function() {
      return false;
    },
    addVariant:function() {
      var variant = $('.variant:last').clone();
      var key = $('.variant').size();

      variant.find('input[type="text"]').each(function(){
        this.name = this.name.replace(/\[(\d+)\]/,function(str,p1){
          return '[' + key + ']'
        });
        this.value = '';
      });
      $('.variant:last').after(variant);
    },
    deleteVariant:function(evt) {

      $(evt.currentTarget).closest('.variant').remove();

      var key = 0;

      $('.variant').each(function() {
        $(this).find('input[type="text"]').each(function(){
          this.name = this.name.replace(/\[(\d+)\]/,function(str,p1){
            return '[' + key + ']'
          });
        });
        key++;
      })



    },

    onChannelSelect:function(){

      var channelId = $('#ProductsChannelId').val();
      var productId = $('#productFrm').data('id');
      this._service(['ecomm', 'Products::getChannelForm'], {channelId:channelId, productId:productId, dataType:'html'}, this.onChannelChanged);
      this._service(['ecomm', 'Products::getChannelVariants'], {channelId:channelId, productId:productId, dataType:'html'}, this.onVariantsChanged);
    },

    onChannelChanged:function(data) {
      $("#channelForm").html(data);
      $('#channelForm .wysiwyg').redactor({
          minHeight:'250',
          imageUpload: conf.baseUrl+'/media/upload',
          buttons: ['html', '|', 'formatting', '|', 'bold', 'boldred', 'italic', '|', 'unorderedlist', '|', 'image', 'table', 'link', '|']
      });

    },

    onVariantsChanged:function(data) {
      $("#inventoryForm").html(data);
    },


    changeOrderStatus:function(evt) {
      var $select = $(evt.currentTarget);
      $('.infoStatus, .tracking').addClass('hidden');
      $('#OrdersSendmail').prop('checked', false);
      $('.infoStatus').addClass('hidden');
      if($select.val() == 'shipped' || $select.val() == 'cancelled' || $select.val() == 'ready') {
        $('.infoStatus').removeClass('hidden');
        if($select.val() == 'shipped') $('.tracking').removeClass('hidden');
      }
    },

    changeProductStatus:function(evt) {
      var $select = $(evt.currentTarget);
      var key = $select.data('key');
      var status = $select.val();
      this._service(['ecomm', 'Products::setfield'], {key:key, value:status});
    },


    capitaliseFirstLetter:function(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
}));
