<?php
use inoui_cms\models\Contents;
use inoui_cms\models\ContentTypes;
?>

<div class="view-container">
	<div class="view-header well">
		<h3><?= $t('New page'); ?></h3>
	</div>

	<?= $this->form->create($content, array('url'=>array('Contents::add'), 'type'=>'file', 'class'=>''));?>
	<div class="view-body">

		<?=$this->form->field('title', array(
			'label' => $t('Category title'),
			'placeholder' => $t('eg. about'),
			'class' => 'form-control'
		)); ?>

		<?=$this->form->field('channel_id', array(
			'label' => $t('Page type'),
			'type' =>'select',
			'list' => ContentTypes::select(),
			'class' => 'form-control'
		)); ?>
		

		<?=$this->form->field('slub', array(
			'label' => $t('Slug'),
			'placeholder' => $t('eg. about-us'),
			'class' => 'form-control'
		)); ?>



		<?=$this->form->field('name.fr', array(
			'label' => $t('French'),
			'class' => 'form-control'
		)); ?>

		<?=$this->form->field('name.en', array(
			'label' => $t('English'),
			'class' => 'form-control'
		)); ?>

	</div>
	<div class="view-footer">
		<div class="actions">
			<?=$this->form->submit($t('Save'), array(
				'class' => 'btn btn-primary'
			)); ?>
			
		</div>
	</div>		
	<?=$this->form->end(); ?>






</div>