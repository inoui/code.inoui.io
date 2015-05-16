<?php	
	use inoui_ecomm\models\Products;
	use inoui_admin\models\Categories;


	$this->set(array('topActions'=>array(

		'inventory' => array(
	        'title' => $t('Manage inventory'),
	        'url' => array('Products::inventory', 'library'=>'inoui_admin', 'admin'=>true),
	        'options' => array('class'=>'btn btn-default')
	    ),

		'new' => array(
	        'title' => $t('Add product'),
	        'url' => array('Products::add', 'library'=>'inoui_admin', 'admin'=>true),
	        'options' => array('class'=>'btn btn-success')
	    )

	)));
	$this->title($t('Your products'));
	
	$categories = Categories::getSelect();
	$categories[''] = '';
	
?>


<section class="panel">

	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th>#</th>
	      <th> </th>
	      <th><?= $t('Product'); ?></th>
	      <th><?= $t('Price'); ?></th>
	      <th><?= $t('Category'); ?></th>
	      <th><?= $t('Status'); ?></th>
	    </tr>
	  </thead>
	  <tbody class="ui-sortable" data-class="products">
		<?php foreach ($products as $key => $product): ?>
		    <tr data-id="<?= $product->_id; ?>">
			  <td>#<?=$product->sku; ?></td>
		      <td>
				<?=$this->html->link($this->html->image($product->thumbnail(), array('size'=>'100c')), array('Products::edit', 'id'=>$product->_id), array('escape'=>false)); ?></td>
		      <td><?=$this->html->link($product->title, array('Products::edit', 'id'=>$product->_id)); ?></td>
		      <td><?= $product->price(); ?></td>
		      <td><?= $product->category(); ?></td>
		      <td><?= $product->status; ?></td>
		    </tr>
		<?php endforeach ?>
	  </tbody>
	</table>

</section>