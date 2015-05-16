<?php
use inoui\models\Media;
?>	
<section class="panel media-sidebar" data-spy="affix" data-offset-top="50">
    <header class="panel-heading">
		<?= $t('Multiple files') ?>	
        <span class="tools pull-right">
          <div class="close"><a class="fa fa-times" href="javascript:;" data-toggle="col"></a></div>
      </span>
    </header>
    <div class="panel-body">
		
		<?= $this->form->create(null, array('url'=>array('Media::edit'), 'type'=>'file', 'class'=>'for-inline'));?>

			<?=$this->form->field('fk_type', array(
				'label' => $t('Category'),
				'class' => 'form-control change',
				'data-action' => 'Admin.changeOrderStatus',
				'type' =>'select',
				'list' => Media::types()
			)); ?>	

			<div class="actions">
				<?=$this->form->submit($t('Save'), array(
					'class' => 'btn btn-primary'
				)); ?>
				<?=$this->html->link($t('Delete all'), array('Media::delete'), array('class' => 'action btn btn-danger confirm', 'data-action'=>'Admin.Media.deleteMultipleMedia')); ?>
			</div>

		<?=$this->form->end(); ?>

    </div>
</section>

