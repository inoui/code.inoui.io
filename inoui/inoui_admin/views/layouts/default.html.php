<?php 
use lithium\core\Environment;
use lithium\security\Auth;
$user  = Auth::check('user');
$admin = $user['role'] == 'admin' ? true:false;

?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <?= $this->html->charset();?>

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <!-- Mobile viewport optimized: h5bp.com/viewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

	<title>Admin > <?= $this->title(); ?></title>

	<?= $this->html->style(array(

		'/inoui/js/bower_components/medium-editor/dist/css/medium-editor.min.css',
		'/inoui/js/bower_components/medium-editor/dist/css/themes/default.css',
		'/inoui/js/bower_components/medium-editor-insert-plugin/dist/css/medium-editor-insert-plugin.min.css',
		
		'/inoui/js/bower_components/dropzone/dist/dropzone',
		'/inoui/js/bower_components/dropzone/dist/basic',


		'/inoui_admin/css/bootstrap.min', 
		'/inoui_admin/css/bootstrap-reset', 
		'/inoui_admin/css/gallery', 

		'/inoui_admin/css/bootstrap-switch.min', 
		'/inoui_admin/css/font-awesome', 
		'/inoui_admin/js/vendor/redactor/redactor', 
		'/inoui_admin/css/style'
	), array('inline' => false)); ?>
	<?= $this->styles(); ?>
	<?= $this->html->link('Icon', null, array('type' => 'icon')); ?>

</head>

<body>
	
	<section id="container" >

		<?= $this->_render('element','header'); ?>

		<?= $this->_render('element', 'sidebar'); ?>			

	    <!-- Wrap all page content here -->
	    <section id="main-content">
	        <section class="wrapper">
				<?= $this->_render('element','breadcrumb'); ?>	
				<?=$this->flashMessage->show(); ?>
				<?= $this->content(); ?>
			</section>
		</section>
	    <?= $this->_render('element','footer'); ?>
	    <?= $this->_render('element','bottom'); ?>
	</section>
</body>
</html>
