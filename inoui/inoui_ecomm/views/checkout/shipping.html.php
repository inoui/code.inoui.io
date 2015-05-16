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

						<h5><?= $t('Shipping method:') ?></h5>
						
						<?=$this->form->create($order, array('url'=>'Checkout::shipping')); ?>
						<div class="well">
							
							<?=$this->html->image('/inoui_ecomm/img/shipping/logo_colissimo_inter.png', array('alt' => 'Colissimo International')); ?>
							<div class="radio">
							  <label>
							    <input type="radio" name="shipping_rate" id="optionsRadios1" value="0" checked>
								<?= $t("Free shipping on Europe") ?>	
							  </label>
							</div>
							<div class="radio">
							  <label>
							    <input type="radio" name="shipping_rate" id="optionsRadios2" value="19.00">
								<?= $t("Rest of the world") ?> 	 <span class="label label-primary">€19.00</span>
							  </label>
							</div>
							
							
							
							
						</div>
						<?php if ($order->same_address != 1): ?>
						<h5><?= $t('Billing information:') ?></h5>
						<div class="well">

							<div class="row">
								<div class="col-xs-6">
									<?=$this->form->field('billing.first_name', array(
										// 'placeholder' => $t('Full name'),
										'label' => $t('First name*'),
										'class' => 'form-control'
									)); ?>
							  	</div>
								<div class="col-xs-6">

									<?=$this->form->field('billing.last_name', array(
										// 'placeholder' => $t('Full name'),
										'label' => $t('Last name*'),
										'class' => 'form-control'
									)); ?>
								
								</div>
							</div>	

							<?=$this->form->field('billing.company', array(
								// 'placeholder' => $t('Full name'),
								'label' => $t('Company'),
								'class' => 'form-control'
							)); ?>
						

							<?=$this->form->field('billing.address1', array(
								// 'placeholder' => $t('Full name'),
								'disabled' => $order->same_address,
								'label' => $t('Address 1*'),
								'class' => 'form-control'
							)); ?>

							<?=$this->form->field('billing.address2', array(
								// 'placeholder' => $t('Full name'),
								'disabled' => $order->same_address,								
								'label' => $t('Address 2'),
								'class' => 'form-control'
							)); ?>
							<div class="row">
								<div class="col-xs-8">
									<?=$this->form->field('billing.city', array(
										// 'placeholder' => $t('Full name'),
										'disabled' => $order->same_address,
										'label' => $t('City*'),
										'class' => 'form-control'
									)); ?>
							  	</div>
								<div class="col-xs-4">

									<?=$this->form->field('billing.post_code', array(
										// 'placeholder' => $t('Full name'),
								'disabled' => $order->same_address,										
										'label' => $t('Post code*'),
										'class' => 'form-control'
									)); ?>
								
								</div>
							</div>	
						
							<?=$this->form->countrySelect('billing.country', array(
								// 'placeholder' => $t('Full name'),
								'disabled' => $order->same_address,								
								'label' => $t('City*'),
								'class' => 'form-control'
							)); ?>
							
						</div>							
						<?php endif ?>
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
						<div class="well">
							<?=$this->html->link('', array('Carts::index'), array('icon'=>'pencil', 'class'=>'close')); ?>
							<ul class="list-unstyled ">
								<?php foreach ($cart->items as $key => $item): ?>
								<li><?=$this->html->link($item->product->title, array('Catalog::product', 'slug'=>$item->product->slug, 'category'=>$item->product->category('slug'))); ?> - <?= $item->quantity; ?> x <?= $item->product->price(); ?> ~ <strong><?= $item->total; ?></strong></li>
								<?php endforeach ?>
								
								
								
								
								<li><strong><?= $t('Total order:') ?></strong> <span class="label label-warning"><?= $cart->total() ?></span></li>
							</ul>
						</div>
						
						<h5><?= $t('Shipping information:') ?></h5>
						<div class="well">
							<?=$this->html->link('', array('Checkout::index'), array('icon'=>'pencil', 'class'=>'close')); ?>
							<address >
							  <strong><?= $order->name(); ?></strong> / 
							  <a href="mailto:<?= $order->email ?>	"><?= $order->email ?>	</a><br/>
								<?php echo $order->address('shipping'); ?>
							</address>

						</div>						
												
						<?php if (isset($order->billing)): ?>
							<h5><?= $t('Billing information:') ?></h5>
							<div class="well">
							  <strong><?= $order->name('billing'); ?></strong>
								<?=$this->html->link('', array('Checkout::index'), array('icon'=>'pencil', 'class'=>'close')); ?>
								<address >
									<?php echo $order->address('billing'); ?>
								</address>
							</div>
						<?php endif ?>
						

					</div>
				</div>
			
			
			</div>
		</div>

	</div>

</div>
