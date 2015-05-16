<section class="panel">
	<header class="panel-heading"><?= $channel->title; ?></header>

	<div class="panel-body">

		<?= $this->form->create($channel, array('url'=>array('Channels::edit','id'=>$channel->_id), 'type'=>'file', 'class'=>''));?>
		<div class="view-body">
			<?=$this->form->field('title', array(
				'label' => $t('Channel title'),
				'placeholder' => $t('eg. pages'),
				'class' => 'form-control'
			)); ?>



			<?=$this->form->field('schema', array(
				'label' => $t('Schema'),
				'class' => 'form-control',
				'type' => 'textarea',
				'style'  => 'height:450px'
			)); ?>



			<?=$this->form->field('slug', array(
				'label' => $t('Slug'),
				'class' => 'form-control'
			)); ?>


		</div>
		<div class="view-footer">
			<div class="actions">
				<?=$this->form->submit($t('Save'), array(
					'class' => 'btn btn-primary'
				)); ?>
				<?=$this->html->link($t('Delete'), array('Channels::delete', 'id'=>$channel->_id), array('class' => 'btn btn-danger confirm')); ?>

			</div>
		</div>		
		<?=$this->form->end(); ?>



	</div>
</section>