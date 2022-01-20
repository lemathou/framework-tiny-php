<div class="container">

<div class="row">
	<div class="logo col-6 col-md-4">
		<p><a href="/"><img src="/img/logo/ardeche-miniatures-logo.png" alt="Ardèche miniatures" style="padding-bottom: -20px;" /></a></p>
	</div>
	<div class="d-none d-md-block col-md-8" style="padding-right: 0;">
		<div class="slideshow">
			<img class="s show" src="/img/header_slideshow/viaduc-trains.jpg" alt="Viaduc et trains miniatures" />
			<img class="s" src="/img/header_slideshow/village-miniature.jpg" alt="Village miniature" />
			<img class="s" src="/img/header_slideshow/train-tunnel.jpg" alt="Train sortant du tunnel" />
			<img src="/img/layout/header_slideshow_mask.png" alt="" />
		</div>
	</div>
	<div class="contact col-6 col-lg-5 col-xl-12">
		<p class="text" style="height: 1em;">07130 Soyons - France</p>
	</div>
	<div class="contact col-6 col-lg-5 col-xl-12">
		<p class="text" style="height: 1em;">Tél. : 04 75 60 96 58</p>
	</div>
</div>

<div class="row">
	<div class="menu offset-xl-4 col-12 col-xl-8">
		<ul class="m">
		<?php foreach (menu()->select() as $m) { ?>
			<li class="m<?php echo $m->pos; ?>"><div><?php echo $m->page()->link(); ?></div></li>
		<?php } ?>
			<li class="m7"><div><a href="https://www.facebook.com/Jardin.des.Trains/" target="_blank"><img src="/img/icon/facebook.png" alt="Le Jardin des trains sur Facebook" width="20" /></a></div></li>
			<li class="m8"><div><a href="https://www.instagram.com/jardindestrains/" target="_blank"><img src="/img/icon/instagram.png" alt="Le Jardin des trains sur Instagram" width="35" /></a></div></li>
			<li class="m9"><div><a href="https://www.youtube.com/channel/UCKfR3jSZDcj1evbChTYHX5w" target="_blank"><img src="/img/icon/youtube.png" alt="Le Jardin des trains sur Youtube" width="25" /></a></div></li>
		</ul>
	</div>
</div>

</div>
