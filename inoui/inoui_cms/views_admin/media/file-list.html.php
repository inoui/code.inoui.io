<ul class="file-list ui-sortable list-inline">
	<?php foreach ($media as $key => $medium): ?>
		<li data-id="<?= $medium->_id; ?>">
            <?= $this->html->image("/media/{$medium->basename}/{$medium->filename}", array('size'=>'100c')) ?>
			<div class="actions">
				<?=$this->html->link('',$medium->url(), array('icon'=>'pencil', 'target'=>'_blank')); ?>
				<?=$this->html->link('', array('Media::delete', 'id'=>$medium->_id), array('icon'=>'trash', 'class'=>'action confirm', 'data-action'=>'Admin.Media.deleteMedia')); ?>
			</div>
		</li>
	<?php endforeach ?>			
</ul>
