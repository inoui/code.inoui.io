<section class="panel">
	<div class="panel-body">
			<div class="row">
                  <div class="col-md-2">
                      <section class="panel">
                          <div class="panel-body">
                          		<p>Upload image</p>
						</div>
                      </section>
                      <section class="panel">
                          <header class="panel-heading">
                              Category
                          </header>
                          <div class="panel-body">
                              <ul class="nav prod-cat">
								
                              </ul>
                          </div>
                      </section>

                  </div>
                  <div class="col-md-10">

                      <ul class="grid cs-style-3">
						<?php foreach ($media as $key => $medium): ?>

                          <li>
                              <figure>
								<?=$this->html->link($this->html->image("/media/{$medium->basename}/{$medium->filename}", array('size'=>'200c')), array('Media::edit', 'id'=>$medium->_id), array('data-toggle'=>'modal','data-target'=>'#modal-media', 'escape'=>false)); ?>
                                  <figcaption>
                                      <h3><?= $medium->name; ?></h3>
                                      <span>xxx </span>
										<?=$this->html->link($t('Edit'),array('Media::edit', 'id'=>$medium->_id), array('icon'=>'pencil','data-toggle'=>'modal','data-target'=>'#modal-media')); ?>
                                  </figcaption>
                              </figure>
                          </li>
						<?php endforeach ?>			

					</ul>
                  </div>
              </div>



		</div>	
</section>

<div id="modal-media" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?= $t("Media info"); ?></h4>
      </div>
      <div class="modal-body">
		135wqd
      </div>
      <div class="modal-footer">
		<?=$this->html->link($t('Save'), array('Controller::action'), array('class'=>'btn btn-danger')); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
