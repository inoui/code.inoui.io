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
		'/inoui_admin/css/bootstrap.min', 
		'/inoui_admin/css/bootstrap-reset', 
		'/inoui_admin/css/font-awesome', 
		'/inoui_admin/css/style'
	), array('inline' => true)); ?>

	<?= $this->html->link('Icon', null, array('type' => 'icon')); ?>

</head>

<body>

			<?= $this->content(); ?>

</body>
</html>
