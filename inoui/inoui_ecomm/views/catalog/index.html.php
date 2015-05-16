<?php 
	$cover = rand(1, 11); 
?>

<div id="catalog" class="part" data-init="" style="background-image:url(/media/fonds/honore<?= $cover ?>.jpg);">

	<div class="overlay"></div>	

	<div class="container">
		<h1><?= $category->name(); ?>	</h1>
	</div>

	<div class="productList js-masonry" data-masonry-options='{ "itemSelector": ".block" }'>



		<?php foreach ($products as $key => $product): ?>
			

			<div class="block product size-medium">
			    <div class="main">
					<?=$this->html->link($this->html->image($product->thumbnail(), array('size'=>'180c', 'width'=>180, 'height'=>180, )), array('Catalog::product', 'slug'=>$product->slug, 'category'=>$product->category('slug'), 'library'=>'inoui_ecomm'), array('escape'=>false)); ?>
					<a href="<?= $this->url(array('Catalog::product', 'slug'=>$product->slug, 'category'=>$product->category('slug'), 'library'=>'inoui_ecomm')) ?>	">
			        	<div class="hoverinfo">

							<div class="title"><?= $product->title; ?></div>
							<div class="lower">
			                    <p class="money"><span class="actual"><?= $product->price; ?> €</span></p>
							</div>
						</div>
					</a>
				</div>
			</div>
		<?php endforeach ?>


	</div>

</div>
