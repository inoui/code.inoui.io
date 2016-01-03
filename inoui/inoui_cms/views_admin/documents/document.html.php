<?php
use lithium\core\Environment;

$this->set(array('topActions'=>array(

	'save' => array(
        'title' => $t('Save document'),
        'url' => array('Documents::edit'),
        'options' => array('class'=>'btn btn-success action', 'data-action'=>'Admin.saveDocument')
    ),

	'cancel' => array(
        'title' => $t('Cancel'),
        'url' => array('Documents::index'),
        'options' => array('class'=>'btn btn-default')
    )


)));
	$this->title($t('Your documents'));
	// $this->html->script(array('/inoui_admin/js/vendor/medium-editor', '/inoui_admin/js/vendor/medium-editor-insert-plugin.min'), array('inline' => false));
	// $this->html->style(array('/inoui_admin/css/medium-editor.min', '/inoui_admin/css/medium-editor-insert-plugin.min'), array('inline' => false));

	$locales = Environment::get('locales');

?>

<div class="contentNoBg part" data-init="setUpMedium">

	<?php if (!is_null($document->_id)): ?>
		<?= $this->form->create($document, array('url'=>array('Documents::edit','id'=>$document->_id), 'type'=>'file', 'class'=>'', 'id'=>'frmDocuments'));?>
	<?php else: ?>
		<?= $this->form->create($document, array('url'=>array('Documents::add'), 'type'=>'file', 'class'=>'', 'id'=>'frmDocuments'));?>
	<?php endif; ?>

	    <div class=" ">
			<div class="row">

                <div class="col-sm-8">
					<?= $this->_render('element', 'edit'); ?>
				</div>


				<div class="col-sm-4">
					<section class="panel document-info">
						<header class="panel-heading"><?= $t('Document options') ?>	</header>
						<div class="panel-body">


							<div class="row">
								<div class="col-lg-4">
									<h5><?= $t('Status') ?>	</h5>


									<?= $this->form->checkbox('status', array(
										'data-toggle' => 'switch',
										'data-on-label' => $t('Online'),
										'data-off-label' => $t('Offline'),
									)) ?>


									<span class="help-block"><?= $t('Set status'); ?>	</span>

								</div>
								<div class="col-lg-8">
									<?=$this->form->field('position', array(
											'class' => 'form-control ',
                                    )); ?>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">

									<?=$this->form->hidden('channel_id'); ?>

								</div>
								<div class="col-lg-6">
										<?=$this->form->field('slug', array(
											'class' => 'form-control ',
										)); ?>

								</div>
							</div>


						</div>
					</section>

					<section class="panel hidden" align='center'>
						<header class="panel-heading">
						<?=$this->html->link($t('Preview document'), array('Documents::preview', 'slug'=>$document->slug, 'admin'=>null, 'library'=>'inoui_cms'), array('target'=>'_blank', 'class' =>'btn btn-large btn-info')); ?>
						</header>
					</section>

					<section class="panel document-info">
						<header class="panel-heading"><?= $t('Document files') ?>	</header>
						<div class="panel-body">

							<div data-url="<?= $this->url(array('Media::upload', 'library'=>'inoui_admin')) ?>" data-fk_type="documents" data-fk_id="<?= $document->_id ?>" class="dropzone"></div>

							<div class="media_list" id="file_receipt">
								<?= $this->_render('element', 'file-list', array(), array('controller' => 'media')); ?>
							</div>

						</div>
					</section>

				</div>
			</div>

	<?=$this->form->end(); ?>

</div>
