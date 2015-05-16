<section class="panel">
	<header class="panel-heading"><?= $t('New category'); ?></header>

	<div class="panel-body">
	<?= $this->form->create($category, array('url'=>array('Categories::add'), 'type'=>'file', 'class'=>''));?>


		<?=$this->form->hidden('parent_id', array('value' => $rootCat->_id)); ?>
		<?=$this->form->field('title', array(
			'label' => $t('Category title'),
			'placeholder' => $t('eg. pages'),
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

	<div class="view-footer">
		<div class="actions">
			<?=$this->form->submit($t('Save'), array(
				'class' => 'btn btn-primary'
			)); ?>
			
		</div>
	</div>		
	<?=$this->form->end(); ?>

</div>
</section>




</div>