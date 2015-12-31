<ul class="file-list ui-sortable list-inline">
    <?php if(isset($media) && count($media)): ?>
	<?php foreach ($media as $key => $medium): ?>
		<li data-id="<?= $medium->_id; ?>">
            <?= $this->html->image("/media/{$medium->basename}/{$medium->filename}", array('size'=>'100c')) ?>
			<div class="actions">
				<?=$this->html->link('',$medium->url(), array('icon'=>'pencil', 'target'=>'_blank')); ?>
				<?=$this->html->link('', array('Media::delete', 'id'=>$medium->_id, 'library' => 'inoui_admin'), array('icon'=>'trash-o', 'class'=>'action confirm', 'data-action'=>'Admin.deleteMedia')); ?>
			</div>

		</li>
	<?php endforeach ?>			
<?php endif; ?>
</ul>
