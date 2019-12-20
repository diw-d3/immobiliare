<?php

/*
Plugin Name: Merry Christmas
Plugin URI: https://wp.boxydev.com/plugins/merry-christmas
Description: A plugin to put snow on WordPress.
Author: Matthieu Mota
Author URI: https://matthieumota.fr
Version: 1.0.0
*/

function snowfall_script() {
    wp_enqueue_script( 'snowfall', 'https://cdnjs.cloudflare.com/ajax/libs/JQuery-Snowfall/1.7.4/snowfall.jquery.min.js', ['jquery'] );
}

add_action( 'wp_enqueue_scripts', 'snowfall_script' );

// Executer le JS du plugin

function snowfall_print_script() { ?>
	<script>
		// On attends que le DOM soit chargé avant d'exécuter le code du JS
		window.addEventListener('DOMContentLoaded', function () {
			$(document).snowfall({
				flakeColor: 'cyan',
				flakeCount: 100,
				maxSize: 5,
				round: true,
				collection: '.card-img-top'
			});
		});
	</script>
<?php }

add_action('wp_print_scripts', 'snowfall_print_script');
