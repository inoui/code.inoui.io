<?php $cover = rand(1, 11); ?>

<div id="catalog" class="part" data-init="" style="background-image:url(/media/fonds/honore<?= $cover ?>.jpg);">

	<div class="overlay hide"></div>	

	<div class="productView">
		<div class="block ">
			
			<div class="container">

				<h1 class="black"><?= $t('Checkout') ?>	</h1>
				<hr />
				<div class="row">
					<div class="col-xs-7 bg">

						<h5><?= $t('User information:') ?></h5>
						
						<?=$this->form->create($order, array('url'=>'Checkout::index')); ?>
						<div class="well">
							<div class="row">
								<div class="col-xs-6">
									<?=$this->form->field('first_name', array(
										// 'placeholder' => $t('Full name'),
										'label' => $t('First name*'),
										'class' => 'form-control'
									)); ?>
							  	</div>
								<div class="col-xs-6">

									<?=$this->form->field('last_name', array(
										// 'placeholder' => $t('Full name'),
										'label' => $t('Last name*'),
										'class' => 'form-control'
									)); ?>
								
								</div>
							</div>	
							<?=$this->form->field('email', array(
								// 'placeholder' => $t('Full name'),
								'label' => $t('Email address*'),
								'class' => 'form-control'
							)); ?>
						</div>
						<h5><?= $t('Shipping information:') ?></h5>
						<div class="well">
							<?=$this->form->field('shipping.address1', array(
								// 'placeholder' => $t('Full name'),
								'label' => $t('Address 1*'),
								'class' => 'form-control'
							)); ?>

							<?=$this->form->field('shipping.address2', array(
								// 'placeholder' => $t('Full name'),
								'label' => $t('Address 2'),
								'class' => 'form-control'
							)); ?>
							<div class="row">
								<div class="col-xs-8">
									<?=$this->form->field('shipping.city', array(
										// 'placeholder' => $t('Full name'),
										'label' => $t('City*'),
										'class' => 'form-control'
									)); ?>
							  	</div>
								<div class="col-xs-4">

									<?=$this->form->field('shipping.post_code', array(
										// 'placeholder' => $t('Full name'),
										'label' => $t('Post code*'),
										'class' => 'form-control'
									)); ?>
								
								</div>
							</div>	
						
							<?=$this->form->countrySelect('shipping.country', array(
								// 'placeholder' => $t('Full name'),
								'label' => $t('City*'),
								'class' => 'form-control'
							)); ?>
							<div class="checkbox">
							
							<?=$this->form->field('same_address', array(
								'label' => $t('Use for billing.'),
								'type' => 'checkbox',
								'checked' => 'checked'
							)); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">

							</div>
							<div class="col-xs-6" align="right">
								<?=$this->form->submit($t('Continue'), array('class'=>'btn btn-warning')); ?>
							</div>
						</div>						
						
						<?=$this->form->end(); ?>
						<hr />
					
					</div>
					<div class="col-xs-5">
						<h5><?= $t('Your order:') ?></h5>
						<ul class="list-unstyled well">
						<?php foreach ($cart->items as $key => $item): ?>
							<li><?=$this->html->link($item->product->title, array('Catalog::product', 'slug'=>$item->product->slug, 'category'=>$item->product->category('slug'))); ?> - <?= $item->quantity; ?> x <?= $item->product->price(); ?> ~ <strong><?= $item->total; ?></strong></li>
						<?php endforeach ?>
							<li><strong><?= $t('Total order:') ?></strong> <span class="label label-warning"><?= $cart->total() ?></span></li>
						</ul>

					</div>
				</div>
			
			
			</div>
		</div>

	</div>

</div>
