<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php bloginfo('name') . wp_title('-'); ?></title>
        <?php
        // Fonction qui charge tous les styles css de WP
        wp_head(); ?>
    </head>
    <body>
    	<h1>Bienvenue sur le site <?php bloginfo('name'); ?></h1>
    	<p><?php bloginfo('description'); ?></p>
