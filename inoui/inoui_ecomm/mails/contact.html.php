<?php
use Lithium\core\Environment;
$locale = Environment::get('locale');
use \lithium\g11n\Message;
extract(Message::aliases());
?>



<table width="100%" border="0" cellpadding="20">
  <tr>
    <td>

			<h2><?=$this->html->link("{$name} {$email}", "mailto:{$email}"); ?></h2>
			<p><?= $message ?>	</p>	


		</td>
	</tr>
</table>