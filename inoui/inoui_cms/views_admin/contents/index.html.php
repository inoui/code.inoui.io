<?php
	$this->set(array('topActions'=>array(

		'new' => array(
	        'title' => $t('Add page'),
	        'url' => array('Contents::add', 'library'=>'inoui_admin', 'admin'=>true),
	        'options' => array('class'=>'btn btn-success')
	    )

	)));
	$this->title($t('Your pages'));
?>


<div class="contentBg">
	<div class="row">
		<div class="col-xs-6">
			<?= $this->_render('element', 'contents-list', array(), array('controller' => 'contents', 'library'=>'inoui_admin')); ?>
		</div>
		<div class="col-xs-6">
			<?php 
				if(isset($content)) {
					if ($content->exists()) {
						echo $this->_render('element', 'form-edit', array(), array('controller' => 'contents', 'library'=>'inoui_admin'));
					} else {
						echo $this->_render('element', 'form-add', array(), array('controller' => 'contents', 'library'=>'inoui_admin'));
					}
				}
			?>
			
		</div>
	</div>

</div>