<?php
use lithium\core\Environment;
use lithium\util\Inflector;
$locale = Environment::get('locale');
// $fields = isset($channel->schema->fields) ? $channel->schema->fields:[];
?>

<section class="panel" id="document-edit">
  <header class="panel-heading">
      <h2 class="editable" data-field="name" data-disable-toolbar="true" data-disable-return="true" data-placeholder="<?= $t('Document name') ?>">
        <?php echo $document->title; ?>
      </h2>
  </header>
</section>



<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <?php foreach ($channel->schema as $key => $block): ?>
              <li>
                  <a data-toggle="tab" href="#p-<?= Inflector::slug($key); ?>"><?= $key; ?></a>
              </li>
            <?php endforeach; ?>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">

            <?php foreach ($channel->schema as $key => $fields): ?>
                <div id="p-<?= Inflector::slug($key); ?>" class="tab-pane ">
                    <?php foreach ($fields as $fieldId => $options): ?>
                        <?=$this->form->field($fieldId, (array)$options); ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>



        </div>
    </div>
</section>
