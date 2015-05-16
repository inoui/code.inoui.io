<?php
use inoui_admin\models\Stats;
use lithium\security\Auth;
use lithium\core\Libraries;
$admin  = Auth::check('user');
$eshop = Libraries::get('inoui_ecomm');


?>
<?php if($eshop): ?>
<div class="row state-overview">


    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-user"></i>
            </div>
            <div class="value">
                <h1 class="count"><?= Stats::totalUsers(); ?></h1>
                <p><?= $t('Newsletter users'); ?>	</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-tags"></i>
            </div>
            <div class="value">
                <h1 class=" count2"><?= Stats::orders(); ?></h1>
                <p>Sales</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="value">
                <h1 class=" count3"><?= Stats::orders('ready'); ?></h1>
                <p>New Order</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?= Stats::totalSales(); ?>	</h1>
                <p><?= $t('Total sales'); ?></p>
            </div>
        </section>
    </div>
</div>
<?php endif; ?>

	<div class="row">
		<!-- COLUMN 1 -->
		<div class="col-lg-4">

         <!--total earning start-->
         <div class="panel green-chart">
             <div class="panel-body">
                 <div class="chart">
                     <div class="heading">
                         <span><?= date('Y-m-d h:s') ?>	</span>
                         <strong>Hello </strong>
                     </div>
                     <div id="barchart"><canvas width="294" height="65" style="display: inline-block; width: 294px; height: 65px; vertical-align: top;"></canvas></div>
                 </div>
             </div>
             <div class="chart-tittle">
                 <span class="title">Welcome back <?= $admin['email'] ?>	</span>
                 <span class="value"></span>
             </div>
         </div>
         <!--total earning end-->
     </div>		<!-- /COLUMN 1 -->

		<!-- COLUMN 2 -->
		<div class="col-lg-8">
			<?php if($eshop): ?>
			
			<section class="panel">
				<div class="panel-body progress-panel">
                     <div class="task-progress">
                         <h1><?= $t('Latest sales'); ?></h1>
                     </div>
                 </div>
					
					<?php $orders = Stats::getLastOrders(5); ?>

					<table class="table table-hover personal-task">
					 <thead>
						<tr>
						   <th><i class="fa fa-user"></i> Client</th>
						   <th class="hidden-xs"><i class="fa fa-quote-left"></i> Sales Item</th>
						   <th><i class="fa fa-dollar"></i> Amount</th>
						   <th><i class="fa fa-bars"></i> Status</th>
						</tr>
					 </thead>
					 <tbody>
						
						<?php foreach ($orders as $key => $order): ?>
						<tr>
						   <td><?=$this->html->link("Order #{$order->order_number} - {$order->name()}", array('Orders::edit', 'id'=>$order->_id, 'library'=>'inoui_ecomm')); ?></td>
						   <td class="hidden-xs"><?= count($order->items) ?>	 <?= $tn('item', 'items', count($order->items)); ?></td>
						   <td>	<?= $order->total(); ?>	</td>
						   <td><span class="label label-success label-sm"><?= $order->status ?></span></td>
						</tr>
						<?php endforeach ?>

					 </tbody>
				</table>


			</section>
			
		<?php endif; ?>

					
		</div>
		<!-- /COLUMN 2 -->
	</div>
   <!-- /DASHBOARD CONTENT -->


</div>