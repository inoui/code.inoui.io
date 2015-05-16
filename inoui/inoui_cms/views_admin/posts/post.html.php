<?php 
use lithium\core\Environment;

$this->set(array('topActions'=>array(

	'save' => array(
        'title' => $t('Save post'),
        'url' => array('Posts::edit'),
        'options' => array('class'=>'btn btn-success action', 'data-action'=>'Admin.savePost')
    ),

	'cancel' => array(
        'title' => $t('Cancel'),
        'url' => array('Posts::index'),
        'options' => array('class'=>'btn btn-default')
    )


)));
	$this->title($t('Your posts'));
	$this->html->script(array('/inoui_admin/js/vendor/medium-editor.min', '/inoui_admin/js/vendor/medium-editor-images-plugin'), array('inline' => false));
	$this->html->style(array('/inoui_admin/css/medium-editor', '/inoui_admin/css/medium-editor-images-plugin'), array('inline' => false));
	
	$locales = Environment::get('locales');

?>

<div class="contentNoBg part" data-init="setUpMedium">


	<?= $this->form->create($post, array('url'=>array('Posts::edit','id'=>$post->_id), 'type'=>'file', 'class'=>'', 'id'=>'frmPosts'));?>
	
	
	    <div class=" ">
			<div class="row">
				<div class="col-sm-8">

					<section class="panel" id="post-edit">
						<?php if (count($locales)>1): ?>
							<?= $this->_render('element', 'edit_multilanguage'); ?>
						<?php else: ?>
							<?= $this->_render('element', 'edit'); ?>
						<?php endif ?>
					</section>

				</div>
				<div class="col-sm-4">
					<section class="panel post-info">
						<header class="panel-heading"><?= $t('Post options') ?>	</header>
						<div class="panel-body">

                            
					
							<div class="row">
								<div class="col-lg-6">
									<h5><?= $t('Status') ?>	</h5>
							
							
									<?= $this->form->checkbox('status', array(
										'data-toggle' => 'switch',
										'data-on-label' => $t('Post online'),
										'data-off-label' => $t('Post offline'),
									)) ?>	
							

									<span class="help-block"><?= $t('Set status'); ?>	</span>
							
								</div>
								<div class="col-lg-6">
									<h5><?= $t('Publication date') ?>	</h5>
									<?= $this->form->input('published', array(
										'class' => 'form-control form-control-inline input-medium default-date-picker',
										'data-on-label' => $t('Post online'),
										'data-on-label' => $t('Post offline'),
									)) ?>	
							

		                            <span class="help-block"><?= $t('Select date') ?>	</span>
							
								</div>
							</div>
							
							
							<?=$this->form->field('slug', array(
								'class' => 'form-control ',
								
							)); ?>
						</div>
					</section>
					
					<section class="panel" align='center'>
						<header class="panel-heading">
						<?=$this->html->link($t('Preview post'), array('Posts::preview', 'slug'=>$post->slug, 'admin'=>null, 'library'=>'inoui_cms'), array('target'=>'_blank', 'class' =>'btn btn-large btn-info')); ?>
						</header>
					</section>
					
					<section class="panel post-info">
						<header class="panel-heading"><?= $t('Post files') ?>	</header>
						<div class="panel-body">

							<div data-url="<?= $this->url(array('Media::upload', 'library'=>'inoui_admin')) ?>" data-fk_type="posts" data-fk_id="<?= $post->_id ?>" class="dropzone"></div>
							
							<div class="media_list" id="file_receipt">
								<?= $this->_render('element', 'file-list', array(), array('controller' => 'media')); ?>
							</div>
							
						</div>
					</section>
					
					

					<section class="panel hidden">
						<header class="panel-heading"><?= $t('Post versions') ?>	</header>
						<div class="panel-body">


							<ul>
								<?php foreach ($post->_versions as $key => $version): ?>
								<?php if(count($version)): ?>
								<li><?=$this->html->link($version->updated, array('Posts::edit', 'id'=>$post->_id)); ?></li>
								<?php endif; ?>
								<?php endforeach ?>

							</ul>
							
						</div>
					</section>
					
				</div>				
			</div>

	<?=$this->form->end(); ?>

</div>