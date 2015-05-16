<?php
/**
 * li3_flash_message plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2010, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * Copy this file to `app/views/elements` to customize the output.
 */ 
?>
<div class="box box-<?php if(!empty($class)): ?><?=$class; ?><?php endif; ?>">
	<?=$message; ?>
</div>


<div class="alert alert-block alert-danger fade in">
    <button data-dismiss="alert" class="close close-sm" type="button">
        <i class="icon-remove"></i>
    </button>
	<?=$message; ?>
</div>