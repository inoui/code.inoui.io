<?php 
use lithium\core\Environment;
 ?>



<div id="modal-confirm" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?= $t("Confirm action"); ?></h4>
      </div>
      <div class="modal-body">
		<p><?= $t('Do you really want to delete this entry ?'); ?>	</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= $t('Cancel'); ?>	</button>

		<?=$this->html->link($t('confirm'), '#', array('class'=>'btn btn-danger')); ?>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<?=$this->html->script(array(
    '/inoui_admin/js/vendor/jquery-1.10.2.min',
    '/inoui_admin/js/vendor/jquery-migrate-1.2.1.min',
    '/inoui_admin/js/vendor/bootstrap',
    '/inoui_admin/js/vendor/bootstrap-datepicker',
    '/inoui_admin/js/bootstrap-inoui',
    '/inoui_admin/js/vendor/redactor/redactor',
    '/inoui_admin/js/vendor/ajaxupload',	
    // '/inoui_admin/js/vendor/dropzone/dropzone.min.js',
    '/inoui_admin/js/vendor/bootstrap-switch.min',
    '/inoui/js/vendor/jquery.form.min.js',
    // '/inoui_admin/js/vendor/jquery.sortable',
    // '/inoui_admin/js/vendor/html.sortable.min.0.1.0',
    '/inoui_admin/js/vendor/jquery.customSelect.min',

    '/inoui/js/bower_components/dropzone/dist/dropzone',

    '/inoui/js/bower_components/medium-editor/dist/js/medium-editor',
    '/inoui/js/bower_components/handlebars/handlebars.runtime.min',
    '/inoui/js/bower_components/jquery-sortable/source/js/jquery-sortable-min',
    '/inoui/js/bower_components/blueimp-file-upload/js/vendor/jquery.ui.widget',
    '/inoui/js/bower_components/blueimp-file-upload/js/jquery.iframe-transport',
    '/inoui/js/bower_components/blueimp-file-upload/js/jquery.fileupload',
    '/inoui/js/bower_components/medium-editor-insert-plugin/dist/js/medium-editor-insert-plugin.min',

    '/inoui/js/bower_components/html.sortable/src/html.sortable',

    '/inoui/js/Inoui.js',
    '/inoui_admin/js/Inoui.Admin.js',
    )); ?>
    
<?=$this->scripts(); ?>
<!-- end scripts -->

<?php $locale = Environment::get('locale'); ?>
<script>
  var conf = {
      baseUrl: '<?=$this->url("/admin/", array('absolute'=>true));?>',
      locale:'<?=$locale; ?>'
  }
</script>
