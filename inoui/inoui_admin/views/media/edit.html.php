	

	<h3 align="center"><?= $medium->name; ?></h3>


	<div class="row">
		<div class="col-md-6">
			<?= $this->html->image("/media/{$medium->basename}/{$medium->filename}", array('size'=>'300x', 'class' => 'img-responsive')) ?>
		</div>
		<div class="col-md-6">
			
			<?= $this->form->create($medium, array('url'=>array('Channels::add'), 'type'=>'file', 'class'=>''));?>

				<?=$this->form->field('name', array(
					'label' => $t('Name'),

					'class' => 'form-control'
				)); ?>

				<?=$this->form->field('alt', array(
					'label' => $t('Alternate text'),
					'class' => 'form-control'
				)); ?>
				<?=$this->form->field('caption', array(
					'label' => $t('Alternate text'),
					'class' => 'form-control'
				)); ?>
				<?=$this->form->field('description', array(
					'label' => $t('Description'),
					'type' => 'text',
					'class' => 'form-control'
				)); ?>



			<?=$this->form->end(); ?>

			
		</div>
	</div>






