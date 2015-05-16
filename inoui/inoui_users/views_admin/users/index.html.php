<?php
	$this->set(array('topActions'=>array(
		'new' => array(
	        'title' => $t('New user'),
	        'url' => array('Users::add', 'library'=>'inoui_users', 'admin'=>true),
	        'options' => array('class'=>'btn btn-success')
	    )
	)));
	$this->title($t('Users'));
?>
<div class="row">
	<div class="col-md-4 col-lg-6">
		<?= $this->_render('element', 'list'); ?>
	</div>
	<div class="col-md-8  col-lg-6">
		<?php 
			if(isset($user)) {
				if ($user->exists()) {
					echo $this->_render('element', 'edit');
				} else {
					echo $this->_render('element', 'add');
				}
			}
		?>
	</div>
</div>
