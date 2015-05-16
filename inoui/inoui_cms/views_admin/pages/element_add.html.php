<div class="view-container">
	<div class="view-header well">
		<h3><?= $t('New page'); ?></h3>
	</div>

	<?= $this->form->create($page, array('url'=>array('Pages::add'), 'type'=>'file', 'class'=>''));?>
	<div class="view-body">
		<?=$this->form->field('title', array(
			'label' => $t('Page title'),
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