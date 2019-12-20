<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php bloginfo('name') . wp_title('-'); ?></title>
        <?php
        // Fonction qui charge tous les styles css de WP
        wp_head(); ?>
    </head>
    <body <?= body_class(); ?>>
    	<nav class="navbar navbar-expand-lg navbar-light bg-white">
		  <a class="navbar-brand" href="<?php echo home_url(); ?>">
		  	<?php
		  		// On récupère le logo en BO
		  		$custom_logo_id = get_theme_mod( 'custom_logo' );
				$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );

				if (false === $custom_logo_url) { // Si pas de logo, on affiche simplement le titre du site
					bloginfo('name');
				} else { ?>
					<img width="30" src="<?= esc_url( $custom_logo_url ) ?>" alt="<?php bloginfo('name'); ?>">
				<?php } ?>
		  </a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <?php
		  	wp_nav_menu( array(
			    'theme_location'  => 'main-menu',
			    'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
			    'container'       => 'div',
			    'container_class' => 'collapse navbar-collapse',
			    'container_id'    => 'navbarSupportedContent',
			    'menu_class'      => 'navbar-nav mr-auto',
			    'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
			    'walker'          => new WP_Bootstrap_Navwalker(),
			) );
		  ?>

		  <form class="form-inline my-2 my-lg-0">
	          <input class="form-control mr-sm-2" type="search" placeholder="Search">
	          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
	      </form>
		</nav>

    	<div class="container text-center">
    		<h1>Bienvenue sur le site <?php bloginfo('name'); ?></h1>
    		<p><?php bloginfo('description'); ?></p>
    	</div>
