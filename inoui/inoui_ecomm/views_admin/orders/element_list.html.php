<section class="panel">
	<header class="panel-heading tab-bg-dark-navy-blue ">
		<span class="wht-color"><?= $this->title(); ?></span>
		<ul class="nav nav-tabs pull-right">
			<li><?=$this->html->link($t('All'), array('Orders::index', 'args'=>array('status'=>'All')), array('class'=>' btn  btn-primary')); ?></li>
			<li><?=$this->html->link('', array('Orders::index', 'args'=>array('status'=>'pending')), array('class'=>' btn btn-default tooltips', 'icon'=>'clock-o', 'data-toggle'=>'tooltip', 'data-original-title'=>$t('Pending'))); ?>			 </li>	
			<li><?=$this->html->link('', array('Orders::index', 'args'=>array('status'=>'ready')), array('class'=>' btn btn-info tooltips', 'icon'=>'check', 'data-toggle'=>'tooltip', 'data-original-title'=>$t('Ready'))); ?>                   </li>
			<li><?=$this->html->link('', array('Orders::index', 'args'=>array('status'=>'shipped')), array('class'=>' btn btn-success tooltips', 'icon'=>'plane', 'data-toggle'=>'tooltip', 'data-original-title'=>$t('Shipped'))); ?>            </li>
			<li><?=$this->html->link('', array('Orders::index', 'args'=>array('status'=>'cancelled')), array('class'=>' btn btn-danger tooltips', 'icon'=>'ban', 'data-toggle'=>'tooltip', 'data-original-title'=>$t('Cancelled'))); ?>    </li>
			<li><?=$this->html->link('', array('Orders::index', 'args'=>array('status'=>'returned')), array('class'=>' btn btn-warning tooltips', 'icon'=>'share', 'data-toggle'=>'tooltip', 'data-original-title'=>$t('Returned'))); ?>      </li>
		</ul>

	</header>

    <table class="table table-striped table-advance table-hover" data-toggle="row">
        <thead>
	        <tr >
	            <th><i class="ic icon-bullhorn"></i> <?= $t('Order number'); ?>	</th>
	            <th class="hidden-phone"><i class="ic icon-question-circle"></i> <?= $t('Order name'); ?></th>
	            <th><i class="ic icon-bookmark"></i> <?= $t('Order total'); ?></th>
	            <th><i class=" ic icon-edit"></i> <?= $t('Order status'); ?></th>

	        </tr>
        </thead>
        <tbody>
			<?php foreach ($orders as $key => $order): ?>
        	<tr class="action" data-action="Admin.showOrder" data-href="<?= $this->url(array('Orders::edit', 'id'=>$order->_id)); ?>">
            	<td><a href="#">#<?= $order->order_number; ?></a><br/>
					<?= $this->time->to($order->created, 'EEEE dd MMMM'); ?>
				</td>
            	<td><?= $order->name() ?>	</td>
            	<td><?= $order->total(); ?>	</td>
            	<td><span class="label label-<?= $order->statusLabel() ?> label-mini"><?= $order->status ?></span></td>
        	</tr>
			<?php endforeach ?>
		</tbody>
	</table>	
</section>
