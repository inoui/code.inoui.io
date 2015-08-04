<?php
use lithium\core\Environment;
use lithium\util\Inflector;
$locale = Environment::get('locale');
$fields = isset($channel->schema->fields) ? $channel->schema->fields:[];


?>

<section class="panel" id="page-edit">
  <header class="panel-heading">
      <h2 class="editable" data-field="name" data-disable-toolbar="true" data-disable-return="true" data-placeholder="<?= $t('Page name') ?>">
        <?php echo $page->title; ?>
      </h2>       
  </header>
</section>



<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#p-content">Content</a>
            </li>
            <?php foreach ($fields as $key => $field): ?>
              <li>
                  <a data-toggle="tab" href="#p-<?= Inflector::slug($key); ?>"><?= $key; ?></a>
              </li>
            <?php endforeach; ?>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">


            <div id="p-content" class="tab-pane active">

              <header class="panel-heading">
                <h1 class="editable" data-field="title" data-disable-toolbar="true" data-disable-return="true" data-placeholder="<?= $t('Title') ?>">
                  <?php echo $page->title; ?>
                </h1>   
              </header>

              <div class="panel-body">
                <div class="editable"  data-field="intro" data-placeholder="<?= $t('Intro') ?>">
                  <?php echo $page->intro; ?>
                </div>
              </div>



              <div class="panel-body">
                <div class="editable mimages"  data-field="content" data-placeholder="<?= $t('content') ?>">
                  <?php echo $page->content; ?>
                </div>
              </div>

            </div>


            <?php foreach ($fields as $key => $field): ?>
            <div id="p-<?= Inflector::slug($key); ?>" class="tab-pane ">
                <?php foreach ($field as $key => $extra): ?>
                    <?=$this->form->field($key, (array)$extra); ?>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>



        </div>
    </div>
</section>


