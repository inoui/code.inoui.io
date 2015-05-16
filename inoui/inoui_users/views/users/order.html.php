<?php
use app\models\Orders;
$this->html->script(array('/inoui_admin/js/mylibs/Orders.js'), array('inline' => false));
?>
<ul class="nav nav-tabs">
    <li class=""><?= $this->html->link('Vos commandes', array('Users::index'));?></li>
    <li class="active"><a href="#">Commande #<?= $order->order_number; ?></a></li>
</ul>

<div class="tab-content">

    <div class="tab-pane active" id="facturation" >


<div class="row">
    <div class="span8">
        <h3>Tickets</h3> 
        <div class="well">
            <ul>
                <?php foreach($tickets as $ticket): ?>
                    <li><strong class="label label-info"><?= $ticket->event->name ?></strong> - <?= $ticket->rate->name ?> - <?= $ticket->first_name; ?> <?= $ticket->last_name; ?></span>        
                    <span style="float:right">    <i class="icon icon-download"></i> <?=$this->html->link('Download tickets', array('Users::tickets', 'id'=>$ticket->id, 'type' => 'pdf'), array('class'=>''));?></span>
                    </li>
                <?php endforeach; ?>
            </ul>            
            <p align="right"></p>
        </div>
    </div>
    <div class="span4">
        <h3>Adresse </h3> 
        <div class="well">
            <address>
                <strong><?= $order->fullname('delivery'); ?></strong>
            </address>
            <address>
                <?= $order->delivery_address1; ?><br/>
                <?= $order->delivery_address2; ?><br/>
                <?= $order->delivery_city; ?> <?= $order->delivery_post_code; ?><br/>
                <?= $order->country('delivery_country'); ?><br/>
                <abbr title="Phone">Tel:</abbr> <?= $order->delivery_phone; ?>
          </address>
        </div>
    </div>
</div>

<div class="row">

    <div class="span12">
        <div class="well">
            <h3>Details de la commande</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Events</th>
                        <th>Rate</th>
                        <th>Quantity</th>
                        <th>Price unitaire</th>
                        <th  class="right">Total TTC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($order->items as $item): ?> <tr>
                        <tr>
                            <td><?= $item->event->name;?></td>
                            <td><?= $item->rate->name;?></td>
                            <td><?= $item->quantity; ?></td>
                            <td><?= $item->price(); ?></td>
                            <td class="right"><?= $item->total(); ?></td>
                        </tr>                     
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="4"  class="right"><strong>Total de la commande</strong></td>
                        <td class="right"><span class="red"> <?= $order->total(); ?></span></td>
                    </tr> 


                </tbody>
            </table>

            <div class="well" align="right">
                <h3>Total de la commande <span class="btn btn-large btn-success "><?= $order->total(); ?></span></h3>
                
            </div>
        </div>
    </div>
    </div>
</div></div>
