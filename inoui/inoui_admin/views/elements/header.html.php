<?php 

use lithium\security\Auth;
use \lithium\storage\Session;
use \lithium\core\Environment;
use \lithium\net\http\Media;

$admin  = Auth::check('user');
$locales = Environment::get('locales');

?>

<!--header start-->
<header class="header white-bg">
      <div class="sidebar-toggle-box">
          <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
      </div>
      <!--logo start-->
      <a href="<?= $this->url(array('Dashboard::index', 'library' =>'inoui_admin')) ?>" class="logo">Inoui <span>admin</span></a>
      <!--logo end-->

      <div class="top-nav ">
          <!--search & user info start-->
		<ul class="nav pull-right top-menu">
           <li>
               <input type="text" class="form-control search" placeholder=" Search">
           </li>
				<?php if(count($locales)>1): ?>
           <li class="dropdown language">
               <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#">
                   <span class="username"><?= $locales[Environment::get('locale')] ?>	</span>
                   <b class="caret"></b>
               </a>

               <ul class="dropdown-menu">
					<?php foreach ($locales as $locale => $name): ?>
				        <li><?=$this->html->link($name, $this->_request->params); ?></li>
					<?php endforeach; ?>
               </ul>

           </li>
			<?php endif; ?>
           <!-- user login dropdown start-->
           <li class="dropdown">
               <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                   <span class="username"><?= $admin['email'] ?></span>
                   <b class="caret"></b>
               </a>
               <ul class="dropdown-menu extended logout">
                   <div class="log-arrow-up"></div>
                   <li class=""><a href="#"><i class=" icon-suitcase"></i>Profile</a></li>
                   <li><?=$this->html->link($t("Settings"), array('Preferences::index', 'library'=>'inoui_admin'), array('icon'=>'cog')); ?></li>
                   <li class=""><a href="#"><i class="icon-bell-alt"></i> Notification</a></li>
                   <li><?=$this->html->link($t('Log Out'), array('Users::logout', 'library'=>'inoui_users'), array('icon' => 'key')); ?></li>	

               </ul>
           </li>
           <!-- user login dropdown end -->
       </ul>
 <!--search & user info end-->
      </div>
  </header>
<!--header end-->

