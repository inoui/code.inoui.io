<?php
use inoui\models\Media;
?>	
<section class="panel media-sidebar" data-spy="affix" data-offset-top="50">
    <header class="panel-heading">
		<?= $medium->name; ?>	
        <span class="tools pull-right">
          <div class="close"><a class="fa fa-times" href="javascript:;" data-toggle="col"></a></div>
      </span>
    </header>
    <div class="panel-body">
		<?= $this->html->image("/media/{$medium->basename}/{$medium->filename}", array('size'=>'300c100', 'class' => 'img-responsive')) ?>
		<?= $this->form->create($medium, array('url'=>array('Media::edit',  'id'=>$medium->_id), 'type'=>'file', 'class'=>'', 'data-submit' => 'ajax', 'data-c' => 'Admin.Media.imageSaved'));?>

			<?=$this->form->field('name', array(
				'label' => $t('Name'),
				'class' => 'form-control'
			)); ?>

			<?=$this->form->field('fk_type', array(
				'label' => $t('Category'),
				'class' => 'form-control change',
				'data-action' => 'Admin.Media.changeCat',
				'type' =>'select',
				'list' => Media::types()+array('===== New category')
			)); ?>

			<?=$this->form->input('new_fk_type', array(
				'label' => $t('New category'),
				'class' => 'form-control hidden'
			)); ?>

			<?=$this->form->field('alt', array(
				'label' => $t('Alternate text'),
				'class' => 'form-control'
			)); ?>

			<?=$this->form->field('caption', array(
				'label' => $t('Caption'),
				'class' => 'form-control'
			)); ?>

			<?=$this->form->field('description', array(
				'label' => $t('Description'),
				'type' => 'textarea',
				'class' => 'form-control'
			)); ?>

			<div class="actions">
				<?=$this->form->submit($t('Save'), array(
					'class' => 'btn btn-primary'
				)); ?>
				<?=$this->html->link($t('Delete'), array('Media::delete', 'id'=>$medium->_id), array('class' => 'action btn btn-danger confirm', 'data-action'=>'Admin.Media.deleteMedia', 'data-idd'=>$medium->_id)); ?>
			</div>

		<?=$this->form->end(); ?>

    </div>
</section>

