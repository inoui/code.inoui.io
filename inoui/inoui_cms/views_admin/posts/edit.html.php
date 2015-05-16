<h3>Bonnes pratiques</h3>


	<div class="row">
		
		<?= $this->form->create($content, array('url'=>array('Posts::edit', 'id'=>$content->_id), 'type'=>'file', 'class'=>'form-horizontal'));?>

			<?=$this->form->field('label', array(
			    'placeholder' => $t('Label'),
			    'class'=>'span9',
			    'label' => 'Titre',
			)); ?>

		<div class="span9">
			
			
			<?php if (count($path)<4): ?>

			<?=$this->form->field('content', array(
			    'label' => 'Bonnes pratiques',
				'class'=>'wysiwyg',
				'type'=>'textarea'
			)); ?>

			<?php else: ?>


			<?=$this->form->field('duree', array(
			    'label' => 'Durée de l\'étape',
				'class'=>'span1',
				'help'=> array('title'=>'en mois', 'type'=>'inline')
			)); ?>



			<?=$this->form->field('coprojet', array(
			    'label' => 'Aide coprojet',
				'class'=>'wysiwyg',
				'type'=>'textarea'
			)); ?>

			<?php endif; ?>

			<?= $this->form->hidden('status', array('value'=>'brouillon')); ?>

			<div class="control-group">
			  <div class="controls">
			      <?= $this->form->submit('Enregistrer', array('class'=>'btn btn-success')); ?>
			  </div>
			</div>


		
		</div>
		<?=$this->form->end(); ?>
	
		<div class="span3">
			<?php if (count($path)==4): ?>

			<div id="uploader_div"></div>
			
			<div id="file_receipt">
				<?= $this->_render('element', 'file-list', array('files'=>$files), array('controller' => 'posts', 'library'=>'inoui_admin')); ?>				
			</div>
			<?php endif; ?>

		</div>
	
	</div>


<?= $this->form->hidden('attach_id', array('value'=>$content->_id)); ?>