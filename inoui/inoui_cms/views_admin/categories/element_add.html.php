<section class="panel">
	<header class="panel-heading"><?= $t('New category'); ?></header>

	<div class="panel-body">
		<?= $this->form->create($category, array('url'=>array('Categories::add'), 'type'=>'file', 'class'=>''));?>


			<?=$this->form->hidden('parent_id', array('value'=>$rootCat->_id)); ?>



			<?=$this->form->field('title', array(
				'label' => $t('Category title'),
				'placeholder' => $t('eg. T-shirt'),
				'class' => 'form-control'
			)); ?>



			<?=$this->form->field('description', array(
				'label' => $t('Description'),
				'class' => 'form-control',
				'type' => 'textarea'
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
