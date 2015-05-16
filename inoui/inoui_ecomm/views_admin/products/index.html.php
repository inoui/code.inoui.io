<?php	
	use inoui_ecomm\models\Products;
	use inoui_admin\models\Categories;


	$this->set(array('topActions'=>array(

		'inventory' => array(
	        'title' => $t('Manage inventory'),
	        'url' => array('Products::inventory', 'library'=>'inoui_ecomm', 'admin'=>true),
	        'options' => array('class'=>'btn btn-default btn-sm')
	    ),

		'new' => array(
	        'title' => $t('Add product'),
	        'url' => array('Products::add', 'library'=>'inoui_ecomm', 'admin'=>true),
	        'options' => array('class'=>'btn btn-success btn-sm')
	    )

	)));
	$this->title($t('Your products'));
	
	// $categories = Categories::getSelect();
	// $categories[''] = '';
	
?>

<div class="row">
    <div class="col-md-3">
        <section class="panel">
            <div class="panel-body">
				<?=$this->form->create(null, array('url'=>'Products::search')); ?>
                	<input type="text" name="query" placeholder="Keyword Search" class="form-control">
				<?=$this->form->end(); ?>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">
                Category
            </header>
            <div class="panel-body">
                <?= $this->html->nestedList($categories, array('Products::index', 'args'=>'slug'), array('class' => 'nav prod-cat')); ?>
			</div>
		</section>
	</div>
	
    <div class="col-md-9">
        <section class="panel">
            <div class="panel-body">
	
                <div class="pro-sort">
                    <label class="pro-lab">Sort By</label>
                    <select class="styled" >
                        <option>Default Sorting</option>
                        <option>Date</option>
                        <option>Price Low to High</option>
                        <option>Price High to Low</option>
                    </select>
                </div>

                <div class="pull-right">
				        <?=$this->Paginator->paginate(array('class'=>'pagination pagination-sm pro-page-list'));?>
                </div>

            </div>
        </section>

		<div class="row product-list">

			<?php foreach ($products as $key => $product): ?>
            <div class="col-md-4">
                <section class="panel">
                    <div class="pro-img-box">

						<?=$this->html->link($this->html->image($product->thumbnail(), array('size'=>'400x400')), array('Products::edit', 'id'=>$product->_id), array('escape'=>false)); ?></td>
                        <?php if($product->isOnSale()): ?>
                            <a href="#" class="isOnSale"></a>
                        <?php else: ?>
                            <a href="#" class="isNotOnSale"></a>
                        <?php endif; ?>
                    </div>

                    <div class="panel-body text-center">
                        <h4>
							<?=$this->html->link($product->title, array('Products::edit', 'id'=>$product->_id), array('class'=>'pro-title')); ?>
                        </h4>
                        <p class="price"><?= $product->price(); ?></p>
                    </div>
                </section>
            </div>
			<?php endforeach ?>

        </div>
		
		




    </div>
	
</div>