
<?php
use inoui\models\Media;
?>	

<?=$this->html->script(array('/inoui_cms/js/vendor/jquery.lazyload.min', '/inoui_cms/js/Inoui.Admin.Media'), array('inline'=>false)); ?>


<div class="row">
    <div class="col-md-3">
        <section class="panel">
            <div class="panel-body" align="center">
				<button type="button" class="btn btn-default btn-lg action" data-action="Admin.Media.showupload"><i class="fa fa-cloud-upload"></i> Upload</button>
            </div>
        </section>


	<section class="panel hidden" id="media-uploader">
	   <header class="panel-heading">
			<?= $t('File Upload'); ?>	
         		<div class="close"><a class="fa fa-times action" href="javascript:;" data-action="Admin.Media.showupload"></a></div>
	   </header>
	   <div class="panel-body">
		
			<div class="col-4">
				<?php $fk_type = isset($this->_request->params['args'][0])?$this->_request->params['args'][0]:''; ?>	
				<?=$this->form->field('fk_type', array(
					'label' => $t('Category'),
					'class' => 'form-control change',
					'data-action' => 'Admin.Media.changeCat',
					'type' =>'select',
					'value' => $fk_type,
					'list' => Media::types()+array('== New category')
				)); ?>

				<?=$this->form->input('new_fk_type', array(
					'label' => $t('New category'),
					'placeholder' => $t('Type In category'),
					'class' => 'form-control hidden'
				)); ?>
				<br>
				<div data-url="<?= $this->url(array('Media::upload', 'library'=>'inoui_admin')) ?>" data-fk_type="<?= $fk_type ?>" class="dropzone"></div>
			</div>


	   </div>
	</section>


        <section class="panel">
            <header class="panel-heading">
                Media Categories
            </header>
            <div class="panel-body">
				<ul class="nav prod-cat">
					<?php foreach ($mediaTypes as $key => $type): ?>
						<li><?=$this->html->link($type, array('Media::index', 'args' => $type), array('icon' => 'angle-right')); ?></li>
					<?php endforeach ?>
				</ul>
			</div>
		</section>
	</div>
	<div class="col-md-9">
		
		

		
		<div class="row" id="media-list">
			<div class="col-md-12" data-on="col-md-8">
		          <ul class="grid cs-style-3 sortable">
					<?php foreach ($media as $key => $medium): ?>
		              <li data-id="<?= $medium->_id ?>">
		                  <figure>
							<?=$this->html->link($this->html->image("http://placehold.it/200x200", array('class'=>'lazy', 'data-original'=>$medium->url(array('size'=>'200c')))), array('Media::edit', 'id'=>$medium->_id), array('class'=>'action', 'data-action' => 'Admin.Media.editMedia', 'escape'=>false)); ?>
							<figcaption>
								<h3><?= $medium->name; ?></h3>
								<span><?= $medium->fk_type; ?></span>
								<?=$this->html->link($t('Edit'),array('Media::edit', 'id'=>$medium->_id), array('icon'=>'pencil','class'=>'action', 'data-action' => 'Admin.Media.editMedia')); ?>
							</figcaption>
		                  </figure>
		              </li>
					<?php endforeach ?>
				</ul>


				
			</div>
			<div class="col-md-0" data-on="col-md-4" id="right-col">
				
			</div>
		</div>
		
		
	</div>
</div>

