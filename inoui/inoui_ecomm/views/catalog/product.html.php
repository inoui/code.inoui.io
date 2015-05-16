<?php 
	$cover = rand(1, 11); 
?>

<div id="catalog" class="part" data-init="" style="background-image:url(/media/fonds/honore<?= $cover ?>.jpg);">

	<div class="overlay hide"></div>	

	<div class="productView">
		<div class="block black">
			
			
			
			<div class="container">

				<div class="productNav">
					<?=$this->html->link($t('« Back to ') . $product->category(), array('Catalog::index', 'category' => $product->category('slug')), array('class'=>'back')); ?>
					<?=$this->html->link($t('next →'), array('Catalog::index', 'category' => $product->category('slug')), array('class'=>'pull-right')); ?>
				</div>
				
				<hr class="dark"/>

				<div class="row">
					<div class="col-xs-7">
						<div class="zoom">
							<?=$this->html->link($this->html->image($product->thumbnail(), array('size'=>'600c', 'class'=>'img-responsive hero')), $product->thumbnail(), array('escape'=>false, 'class'=>'fancybox')); ?>
						</div>
						<hr class="dark"/>					
					
						<ul class="list-inline">
							<?php foreach ($product->images() as $image): ?>
								<li><?=$this->html->link($this->html->image($image->url(), array('size'=>'60c')), '#', array('escape'=>false, 'class'=>'action', 'data-action' => 'Admin.changeImage', 'data-src' => $image->url(array('size'=>'600c')))); ?></li>
							<?php endforeach; ?>
						</ul>
					
					
					</div>
					<div class="col-xs-5">

						<h1><?= $product->title ?>	</h1>
						<div class="pricearea">
	                        <span class="price" itemprop="price"><?= $product->price(); ?></span>
	                    </div>

						<hr class="dark"/>					
							
						<?php echo $product->description(); ?>
						
						<hr />
						
						<div class="quantity">

							<?= $this->form->create($product, array('url'=>array('Carts::add', 'library'=>'inoui_ecomm'), 'class'=>'form-inline'));?>
								<?=$this->form->hidden('_id');?>
								<?=$this->form->field('quantity', array(
									'value'=>1,
									'label' => array($t('Quantity') => array('class'=>'sr-only')),
									'class' => 'form-control input-lg '
								)); ?>

								<?=$this->form->submit($t('Add to cart'), array('class'=>'btn btn-warning')); ?>

							<?=$this->form->end(); ?>

						</div>
						

						
					</div>
				</div>
			
			
			</div>
		</div>

	</div>

</div>
