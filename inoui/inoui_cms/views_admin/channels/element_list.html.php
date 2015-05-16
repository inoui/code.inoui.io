<section class="panel">
    
    <header class="panel-heading"><?= $this->title(); ?></header>

    <div class="list-group">
        <?php foreach ($channels as $key => $channel): ?>
            <?php
            $active = '';
            if (isset($this->_request->params['id'])&&$this->_request->params['id'] == $channel->_id) {
                $active = 'active';
            }
            ?>
            <a class="list-group-item <?= $active ?>    " href="<?= $this->url(array('Channels::edit', 'id'=>$channel->_id)); ?>">
                <h4 class="list-group-item-heading"><?= $channel->title(); ?>  </h4>
                <p class="list-group-item-text"><?= $this->time->to($channel->created, 'EEEE dd MMMM'); ?> </p>
            </a>
        <?php endforeach ?>
    </div>

</section>
