<?php
use inoui_admin\models\Contents;
?>

<h3>Gestion - <?= $contentStructure['name']; ?></h3>


<?= $this->html->link('Ajouter une nouvelle entrée', array('Contents::add', 'args'=>$type), array('class'=>'btn btn-success pull-right')); ?>



        <?= $this->form->select('filter-aides', 'types-d-aides', array(
            'empty' => 'Types d’aides',
            'class' => 'filter'
        )); ?>

        <?= $this->form->select('filter-works', 'works', array(
            'empty' => 'Catégorie de travaux',
            'source' => 'Contents',
            'class' => 'filter'
        )); ?>

        <?= $this->form->select('filter-benef', 'beneficiaires', array(
            'empty' => 'Bénéficiaire',
            'class' => 'filter'
        )); ?>

        <?= $this->form->select('filter-coll', 'collectif-individuel', array(
            'empty' => 'Catégorie',
            'class' => 'filter'
        )); ?>

    <br/><br/>
        <?php
        $conditions = array('type'=>'works');
        $aWork = Contents::find('list', compact('conditions'));

        ?>

<table class="table table-bordered table-striped" id="orderList">
    <thead>   
        <tr>
            <th>Nom de l'aide</th>
            <th>Type d'aide</th>
            <th>Type de travaux</th>
            <th>Bénéficiaire</th>
            <th>Catégorie</th>
            <th>Date de création</th>
            <th></th>            
        </tr>
    </thead>
    <tbody>
	    <?php foreach($contents as $content) :?>
		    <tr  class="filter <?= $content->type_aide; ?> <?= $content->benificiaires; ?> <?= $content->coll_indi; ?>
            <?php foreach ($content->type_travaux as $key => $work) {
                            echo $work . ' ';
                        } ?>">
                    <td>
                        <?= $content->title ?><br/>  
                        <small><?= $content->nom_aide ?>  </small>
                    </td>
                    <td><?= $content->getListValue('type_aide'); ?></td>
                    <td style="text-transform:lowercase">
                        <ul>
                        <?php foreach ($content->type_travaux as $key => $work) {
                            echo '<li>'.$aWork[$work].'</li>';
                        } ?>
                        </ul>
                    </td>
                    <td><?= $content->getListValue('benificiaires'); ?></td>
                    <td><?= $content->getListValue('coll_indi'); ?></td>


                <td><?= $this->time->to($content->created->sec, 'EEEE dd MMMM', array('locale'=>'fr')); ?></td>
				
                <td>
					<div class="make-switch  switch-mini" data-on="success" data-off="danger" data-on-label="En ligne" data-off-label="Hors<br/>ligne">

						<?php $ck = $content->status  ? 'checked="checked"':'' ?>
					    <input type="checkbox" <?= $ck ?> data-key="status_<?= $content->_id; ?>">
					</div><br/><br/>
<?= $this->html->link('Editer', array('Contents::edit', 'id'=>$content->_id), array('class'=>'btn btn-success ')); ?><br/><br/>
<?= $this->html->link('Supprimer', array('Contents::delete', 'id'=>$content->_id), array('class'=>'btn btn-danger confirm')); ?>
				</td>	

		    </tr>
	    <?php endforeach; ?>
    </tbody>
</table>
