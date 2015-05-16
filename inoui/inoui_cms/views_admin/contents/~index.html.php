<h3>Gestion - <?= $contentStructure['name']; ?></h3>


<?= $this->html->link('Ajouter une nouvelle entrée', array('Contents::add', 'args'=>$type), array('class'=>'btn btn-success pull-right')); ?>


<br/><br/>

<table class="table table-bordered table-striped" id="orderList">
    <thead>   
        <tr>
            <th>Titre</th>
            <th>Date de création</th>
<?php if($type == 'news'): ?>
            <th>Rubrique</th>
<?php endif; ?>
            <th>Status</th>
            <th></th>
            <th></th>            
        </tr>
    </thead>
    <tbody>
	    <?php foreach($contents as $content) :?>
		    <tr>
		        <td><?= $content->title; ?></td>
		        <td><?= $this->time->to($content->created->sec, 'EEEE dd MMMM', array('locale'=>'fr')); ?></td>
				<?php if($type == 'news'): ?>
		        	<td><?= $content->getListValue('category'); ?></td> 
				<?php endif; ?>
				<td>
					<div class="make-switch  switch-mini" data-on="success" data-off="danger" data-on-label="En ligne" data-off-label="Hors<br/>ligne">

						<?php $ck = $content->status  ? 'checked="checked"':'' ?>
					    <input type="checkbox" <?= $ck ?> data-key="status_<?= $content->_id; ?>">
					</div>

				</td>	
		        <td><?= $this->html->link('Editer', array('Contents::edit', 'id'=>$content->_id), array('class'=>'btn btn-success ')); ?></td>
		        <td><?= $this->html->link('Supprimer', array('Contents::delete', 'id'=>$content->_id), array('class'=>'btn btn-danger confirm')); ?></td>
		    </tr>
	    <?php endforeach; ?>
    </tbody>
</table>
