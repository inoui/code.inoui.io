<?php 
use lithium\core\Environment;

$this->set(array('topActions'=>array(

	'save' => array(
        'title' => $t('Save page'),
        'url' => array('Pages::edit'),
        'options' => array('class'=>'btn btn-success action', 'data-action'=>'Admin.savePage')
    ),

	'cancel' => array(
        'title' => $t('Cancel'),
        'url' => array('Pages::index'),
        'options' => array('class'=>'btn btn-default')
    )


)));
	$this->title($t('Your pages'));
	// $this->html->script(array('/inoui_admin/js/vendor/medium-editor', '/inoui_admin/js/vendor/medium-editor-insert-plugin.min'), array('inline' => false));
	// $this->html->style(array('/inoui_admin/css/medium-editor.min', '/inoui_admin/css/medium-editor-insert-plugin.min'), array('inline' => false));
	
	$locales = Environment::get('locales');

?>

<div class="contentNoBg part" data-init="setUpMedium">

	<?php if (!is_null($page->_id)): ?>
		<?= $this->form->create($page, array('url'=>array('Pages::edit','id'=>$page->_id), 'type'=>'file', 'class'=>'', 'id'=>'frmPages'));?>
	<?php else: ?>
		<?= $this->form->create($page, array('url'=>array('Pages::add'), 'type'=>'file', 'class'=>'', 'id'=>'frmPages'));?>	
	<?php endif; ?>
	
	    <div class=" ">
			<div class="row">
				<div class="col-sm-8">


						<?php if (count($locales)>1): ?>
							<?= $this->_render('element', 'edit_multilanguage'); ?>
						<?php else: ?>
							<?php if($channel->slug && $channel->slug == 'blog-post'): ?>
								<?= $this->_render('element', 'editblog-post'); ?>	
							<?php else: ?>
								<?= $this->_render('element', 'edit'); ?>	
							<?php endif ?>
						<?php endif ?>

				</div>


				<div class="col-sm-4">
					<section class="panel page-info">
						<header class="panel-heading"><?= $t('Page options') ?>	</header>
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
									<?php if($channel->slug && $channel->slug == 'blog-post'): ?>
										<h5><?= $t('Publication date') ?></h5>
										<?= $this->form->input('published', array(
											'class' => 'form-control form-control-inline input-medium default-date-picker',
											'data-on-label' => $t('Post online'),
											'data-on-label' => $t('Post offline'),
										)) ?>	
								

			                            <span class="help-block"><?= $t('Select date') ?>	</span>
									<?php endif; ?>							
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">

									<?=$this->form->field('channel_id', array(
										'label' => $t('Page type'),
										'class' => 'change form-control',
										'data-action' => 'Admin.onChannelSelect',
										// 'type' => 'nestedSelect',
										'list' => $channels,
										'empty' => $t('Select a product type')
									)); ?>

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
						<?=$this->html->link($t('Preview page'), array('Pages::preview', 'slug'=>$page->slug, 'admin'=>null, 'library'=>'inoui_cms'), array('target'=>'_blank', 'class' =>'btn btn-large btn-info')); ?>
						</header>
					</section>
					
					<section class="panel page-info">
						<header class="panel-heading"><?= $t('Page files') ?>	</header>
						<div class="panel-body">

							<div data-url="<?= $this->url(array('Media::upload', 'library'=>'inoui_admin')) ?>" data-fk_type="pages" data-fk_id="<?= $page->_id ?>" class="dropzone"></div>
							
							<div class="media_list" id="file_receipt">
								<?= $this->_render('element', 'file-list', array(), array('controller' => 'media')); ?>
							</div>
							
						</div>
					</section>
										
				</div>				
			</div>

	<?=$this->form->end(); ?>

</div>