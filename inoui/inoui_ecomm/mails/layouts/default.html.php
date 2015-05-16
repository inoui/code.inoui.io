<?php
use Lithium\core\Environment;
use inoui\models\Preferences;
$preferences = Preferences::get();
$locale = Environment::get('locale');
use \lithium\g11n\Message;
extract(Message::aliases());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Type 4</title>

<style type="text/css">

body {
	margin:0;
}
.ReadMsgBody { width: 100%;}
.ExternalClass {width: 100%;}


@media only screen and (max-width:599px){
table[class=main]{width:599px !important;}
table[class=banner]{width:579px !important;margin:10px auto 0;}
td[class=banner] img{display:block; width:100% !important; height:auto !important;}
td[class=col]{width:579px !important;text-align:center;display:block !important;}
td[class=icon]{width:579px !important;text-align:center;display:block !important;padding:0;}
td[class=colbutton]{width:579px !important;text-align:center;display:block !important;padding-bottom:20px;margin-top:-20px;}
td[class=button]{width:579px !important;text-align:center;padding-bottom:20px;display:block !important;margin-top:-20px;}
table[class=row]{width:579px !important;}
table[class=quote]{width:559px !important;display:block;}
td[class=cols]{width:549px !important;text-align:center;display:block;}
table[class=icons]{width:549px !important;text-align:center;display:block !important;}
table[class=rows]{width:540px !important;}
table[class=rowss]{width:250px !important;}
td[class=colss]{width:270px !important;text-align:center;}
table[class=social]{width:130px !important;margin:0 auto 10px;}
table[class=hidden],td[class=hidden]{display:none !important;}


}


@media only screen and (max-width:480px){
table[class=main]{width:480px !important;}
table[class=banner]{width:460px !important;margin:10px auto 0;}
td[class=banner] img{display:block; width:100% !important; height:auto !important;}
td[class=col]{width:460px !important;text-align:center;display:block !important;}
table[class=row]{width:460px !important;}
td[class=colbutton]{width:460px !important;text-align:center;display:block !important;padding-bottom:20px;margin-top:-20px;}
td[class=button]{width:460px !important;text-align:center;padding-bottom:20px;display:block !important;margin-top:-20px;}
table[class=rows]{width:430px !important;display:block;}
td[class=cols]{width:430px !important;text-align:center;display:block !important;}
table[class=quote]{width:440px !important;display:block;}
td[class=icon]{width:220px !important;display:block !important;float:left;padding:0 0 6px 7px;}
table[class=icons]{width:210px !important;display:block !important;}
table[class=rowss]{width:250px !important;display:block;margin:auto;}
td[class=colss]{width:460px !important;text-align:center;display:block !important;}
table[class=social]{width:160px !important;margin:0 auto 10px;}

table[class=hidden],td[class=hidden]{display:none !important;}

}


@media only screen and (max-width:320px){
table[class=main]{width:320px !important;}
table[class=banner]{width:300px !important;margin:10px auto 0;}
td[class=banner] img{display:block; width:100% !important; height:auto !important;}
td[class=col]{width:300px !important;text-align:center;display:block !important;}
td[class=colbutton]{width:300px !important;text-align:center;display:block !important;padding-bottom:20px;margin-top:-20px;}
td[class=button]{width:300px !important;text-align:center;padding-bottom:20px;display:block !important;margin-top:-20px;}
td[class=icon]{width:300px !important;text-align:center;display:block !important;padding:0;}
table[class=row]{width:300px !important;}
table[class=icons]{width:270px !important;text-align:center;display:block !important;}
table[class=rows]{width:250px !important;display:block;margin:auto;}
td[class=cols]{width:250px !important;text-align:center;display:block !important;}
table[class=quote]{width:280px !important;display:block;}
table[class=rowss]{width:250px !important;display:block;margin:auto;}
td[class=colss]{width:300px !important;text-align:center;display:block !important;}
table[class=social]{width:130px !important;margin:0 auto 10px;}

table[class=hidden],td[class=hidden]{display:none !important;}

}


</style></head>

<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000">
		<tr><td> 
			<table class="row" width="600" height="54" align="center" border="0" cellspacing="0" cellpadding="0"> 
				<tr> 
					<td width="250" align="left" class="col"> <?=$this->html->image('mail/logo-new.png', array('width' => '198', 'height' => '51')); ?> </td> 
					<td width="220" class="hidden"></td> <td align="right" valign="top" class="col" style="padding-top:14px;"> 
						<table width="50" border="0" cellpadding="3" cellspacing="0" class="social"> 
							<tr> 
								<td><a href="http://www.facebook.com/LAdorableCabinetDeCuriositesDeMonsieurHonore"><?=$this->html->image('mail/i_facebook.jpg', array('width' => '20', 'height' => '20', 'border'=>'0')); ?> </a></td>  
								<td><a href="http://www.pinterest.com/monsieurhonore/"><?=$this->html->image('mail/i_pinterest.jpg', array('width' => '20', 'height' => '20', 'border'=>'0')); ?></a></td> 
							</tr>
						</table> 
					</td>
				</tr>
			</table>
		</td></tr>
		<tr><td height="1" bgcolor="#626161">
			
		</td></tr>
	</table> <!--/ Top Panel -->
	
	<table class="main" width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000">
		<tr><td class="hidden" width="100%" height="20"></td></tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000">
		<tr> <td> 
			<table class="banner" width="600" align="center" border="0" cellspacing="0" cellpadding="0"> 
				<tr> <td class="banner">
					<a href="http://www.monsieur-honore.com/fr"><?=$this->html->image('mail/banner.jpg', array('width' => '600', 'height' => '400', 'border'=>'0')); ?></a>
				</td> </tr> </table> </td></tr></table><!--/ Banner --><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
				<tr><td> 
					<table class="row" width="600" height="90" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"> 
						<tr> <td width="420" valign="middle" class="col"> 
							<table class="rows" width="380" border="0" align="center" cellpadding="0" cellspacing="0"> 
								<tr> <td align="center" style="font-family:arial,tahoma,verdana;font-size:16px;line-height:18px;color:#6f7675;padding:18px 0;" >
									
									<p id=""><?= $subject ?>	</p>
								</td> </tr>
							</table> 
						</td> 
						<td valign="middle" class="button" style="padding-top:26px;"> 
							<table width="140" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000000"> 
								<tr> <td align="center" style="font-family:georgia,arial,serif;font-style:italic;font-size:17px;padding:10px;"> 
									<div>
										<?=$this->html->link($t('Visit shop'), array('Inoui::index', 'library'=>'app', 'locale'=>$locale), array('style' => 'color:#ffffff;text-decoration:none;')); ?>
									</div>
								</td> </tr>
							</table> <!--/ Button --> 
						</td> </tr>
					</table>
					
					<table class="row" width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">          <tr>
            			<td height="1" bgcolor="#ebe5d7"></td>
          			</tr>
 					<tr> <td width="100%" height="10">

	
	
						<?= $this->content(); ?>
						
						
						
						
					</td> </tr> 
					<tr> <td height="1" bgcolor="#ebebeb"></td> </tr>
				</table>
				
				
				
				<table class="row" width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff"> 
					<tr> <td class="col" style="padding:10px 0;">
						<table class="quote" width="580" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000000"> 
							<tr> 
								<td class="hidden" width="47" valign="top"><?=$this->html->image('mail/quote_left.jpg', array('width' => '47', 'height' => '68', 'border'=>'0')); ?></td> 
								<td width="100%"> 
									<table width="100%" border="0" cellspacing="0" cellpadding="0"> <tr> 
										<td align="center" style="font-family:georgia,arial,serif;font-style:italic;font-size:22px;color:#cecac1;padding:15px 20px 5px;" >
											L'Adorable <br />Cabinet de Curiosités <br />de Monsieur Honoré
										</td> </tr> 
										<tr> <td align="center" style="font-family:arial,georgia,serif;font-size:12px;color:#878686;line-height:18px;padding:0 20px;" >

											<?php if ($locale == 'fr'): ?>
													<p>Au cœur du 11eme arrondissement de Paris, à deux pas de la Bastille, Monsieur Honoré vous invite à découvrir son Adorable Cabinet de Curiosités.</p>					
											<?php else: ?>
													<p>In the heart of the 11th arrondissement in Paris, a few steps away from the Bastille, Monsieur Honoré invites you to discover his Adorable Cabinet de Curiosités.</p>
											<?php endif; ?>
		
					
										</td> </tr> 
										<tr> <td height="20"> </td> </tr> 
									</table> 
								</td> 
								<td class="hidden" width="47" valign="bottom">
									<?=$this->html->image('mail/quote_right.jpg', array('width' => '47', 'height' => '68', 'border'=>'0')); ?>
								</td> </tr>
							</table>
						</td></tr>
					</table>
					<table class="row" width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f8f8">
						<tr><td colspan="2" bgcolor="#ffffff" height="10"></td></tr> 
						<tr> <td width="359" align="center" valign="middle" class="cols" style="font-family:georgia,arial,serif;font-style:italic;font-size:17px;line-height:22px;padding:15px;color:#353535;" >
							
							
							
							<p>
								<?= $t('Opening times:') ?><br/>
								<?= $t('Opened every day') ?><br/>
								10.30 - 20:00								
						      	30 rue de Charonne <br />
								75011 Paris, France
							</p>


							</td> <td width="35%" align="center" valign="middle" class="colbutton" style="padding-top:17px;"> 
								<table width="140" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000000"> 
									<tr> <td align="center" style="font-family:georgia,arial,serif;font-style:italic;font-size:17px;padding:10px;" > 
										<div >
											<?=$this->html->link($t('Visit shop'), array('Inoui::index', 'library'=>'app', 'locale'=>$locale), array('style' => 'color:#ffffff;text-decoration:none;')); ?>
										</div>
									</td> </tr>
								</table> 
							</td> </tr>
						</table> 
						
						<table class="row" width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff"> 
							<tr> <td class="cols" width="359" style="font-family:georgia,arial,serif;font-style:italic;font-size:17px;line-height:22px;padding:15px;" > 
								<?=$this->html->link('www.monsieur-honore.com', '/'); ?>
								<?=$this->html->link('www.monsieur-honore.com', array('Inoui::index', 'library'=>'app', 'locale'=>$locale)); ?>

							</td> 
								<td width="35%" align="center" valign="top" class="col" style="padding-top:13px;"> 
									<table class="social" width="40" border="0" cellpadding="3" cellspacing="0"> <tr> 
									<td>
										<a href="http://www.facebook.com/LAdorableCabinetDeCuriositesDeMonsieurHonore"><?=$this->html->image('mail/if_facebook.jpg', array('width' => '20', 'height' => '20', 'border'=>'0')); ?></a>
									</td>  
									<td>
										<a href="http://www.pinterest.com/monsieurhonore/"><?=$this->html->image('mail/if_pinterest.jpg', array('width' => '20', 'height' => '20', 'border'=>'0')); ?></a>
									</td>  
								</tr></table> 
							</td> </tr></table> 
						</td></tr>
					<tr><td height="15"></td></tr> 
				<tr>
					<td height="80" align="center" valign="top" style="font-family:Arial,Georgia,serif;font-size:11px;color:#999;line-height:20px;" > Copyright &copy; Monsieur Honoré<br /> 
					</td>
				</tr>
			</table> 
		</body></html>
						
						
	