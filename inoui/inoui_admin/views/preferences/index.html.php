<div class="row">
     <aside class="profile-nav col-lg-3">
         <section class="panel">
             <div class="user-heading round">
                 <a href="#">
				<?=$this->html->image('/media/logo.jpg', array('size'=>'112c112')); ?>
                 </a>
                 <h1><?= $preferences->title ?></h1>
                 <p><?= $preferences->site_name ?></p>
             </div>

             <ul class="nav nav-pills nav-stacked">
                 <li class="active"><a href="#"> <i class="fa fa-edit"></i> <?= $t('Preferences'); ?>	</a></li>
                 <li><a href="#"> <i class="fa fa-user"></i> <?= $t('Profile'); ?>	</a></li>
                 <li><a href="#"> <i class="fa fa-edit"></i> Seo</a></li>
             </ul>

         </section>
     </aside>
	<?= $this->form->create($user, array('url'=>array('Preferences::index')));?>
     <aside class="profile-nav col-lg-9">

		<section class="panel" id="preferences">

			<header class="panel-heading"><?= $t('Preferences') ?></header>

			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">

						
						<h4><?= $t('Website'); ?>	</h4>


						<?=$this->form->field('preferences.url', array(
							'label' => $t('Blog url'),
							'class' => 'form-control'
						)); ?>


						<?=$this->form->field('preferences.facebook', array(
							'label' => $t('Facebook url'),
							'class' => 'form-control'
						)); ?>


						<?=$this->form->field('preferences.twitter', array(
							'label' => $t('Twitter account'),
							'class' => 'form-control'
						)); ?>
						
						
						<div data-url="<?= $this->url(array('Media::upload', 'library'=>'inoui_admin')) ?>" data-fk_type="preferences" data-fk_id="<?= $user->_id ?>" class="dropzone"></div>
						<div class="media_list" id="file_receipt">
							<?= $this->_render('element', 'file-list', array(), array('controller' => 'media')); ?>
						</div>

						
					</div>
					<div class="col-sm-6">
						<h4><?= $t('Right column'); ?>	</h4>


						<?=$this->form->field('preferences.title', array(
							'label' => $t('Title'),
							'class' => 'form-control'
						)); ?>

						<?=$this->form->field('preferences.content', array(
							'label' => $t('Content'),
							'type' => 'textarea',
							'style' => 'height:300px',
							'class' => 'form-control'
						)); ?>
						


					</div>
				</div>
			</div>


		</section>

		
		
		<section class="panel" id="profile">
			<header class="panel-heading"><?= $t('Profile') ?></header>
			
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						
						<?=$this->form->field('profile.address', array(
							'label' => $t('Adress'),
							'class' => 'form-control'
						)); ?>

						<?=$this->form->field('profile.address2', array(
							'label' => $t('Adress2'),
							'class' => 'form-control'
						)); ?>

						<?=$this->form->field('profile.city', array(
							'label' => $t('City'),
							'class' => 'form-control'
						)); ?>

						<?=$this->form->field('profile.postcode', array(
							'label' => $t('Post code'),
							'class' => 'form-control'
						)); ?>


					</div>
					<div class="col-sm-6">

						<?=$this->form->field('profile.tel', array(
							'label' => $t('Tel'),
							'class' => 'form-control'
						)); ?>

						<?=$this->form->field('profile.email', array(
							'label' => $t('Email'),
							'class' => 'form-control'
						)); ?>

						<?=$this->form->field('profile.website', array(
							'label' => $t('Website'),
							'class' => 'form-control'
						)); ?>

						
					</div>
				</div>
			</div>
			
		</section>
		
		<section class="panel" id="seo">
			
			<header class="panel-heading"><?= $t('Seo') ?></header>
			
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						
						<?=$this->form->field('seo.title', array(
							'label' => $t('Website title'),
							'class' => 'form-control'
						)); ?>

						<?=$this->form->field('seo.description', array(
							'label' => $t('Website description'),
							'class' => 'form-control'
						)); ?>

						<?=$this->form->field('seo.keywords', array(
							'label' => $t('Website keywords'),
							'class' => 'form-control'
						)); ?>


					</div>
					<div class="col-sm-6">


						
					</div>
				</div>
			</div>

			
		</section>
		
		
		<section class="panel" id="seo">
			<?=$this->form->submit($t('Save'), array(
				'class' => 'btn btn-primary'
			)); ?>

		</section>
		


     </aside>
	<?=$this->form->end(); ?>
 </div>