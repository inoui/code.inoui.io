<?php
use inoui_admin\models\Contents;
?>

<h3>Nouvelle page <?= $type ?>	</h3>
<?= $this->form->create($content, array('url'=>array('Contents::edit', 'id'=>$content->_id), 'type'=>'file', 'class'=>'form-horizontal'));?>

<?=$this->form->hidden('type', array(
    'value' => $type
)); ?>
<?=$this->form->field('title', array(
    'placeholder' => $t('Titre'),
    'class'=>'span9',
    'label' => 'Titre',
)); ?>

	<div class="row">
		<div class="span8">
			
			<?php foreach($contentStructure['schema'] as $name => $schema): ?>

				<?= $this->form->field($name, $schema); ?>

			<?php endforeach; ?>



			<div class="control-group">
			  <div class="controls">
			      <?= $this->form->submit('Enregistrer', array('class'=>'btn btn-success')); ?>
			  </div>
			</div>
  
			
		</div>
		<div class="span4">
			<?php if(isset($contentStructure['has'])): ?>
				<?=$this->form->field('category', array(
					'list'=>Contents::distinct('category'),
					'empty' =>'Selectionner une catégorie',
					'type'=>'select'
				)); ?>


			
			<?php endif; ?>										
		</div>
	</div>

	




<?=$this->form->end(); ?>
