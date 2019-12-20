<?php

function immobiliare_enqueue_styles() {
	// Ajouter Bootstrap ici via le CDN
	wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
    // Ajout de la police
    wp_enqueue_style( 'nunito', 'https://fonts.googleapis.com/css?family=Nunito&display=swap' );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );

    // On supprimer le jQuery de WordPress
    wp_deregister_script( 'jquery' );
    // JavaScript dans le footer
    wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.4.1.min.js', [], false, true );
    wp_enqueue_script( 'popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', [], false, true );
    wp_enqueue_script( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', ['jquery'], false, true );
    // On ajoute notre JS
    wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js', [], false, true );
}

add_action( 'wp_enqueue_scripts', 'immobiliare_enqueue_styles' );

// On supprime la meta qui affiche la version de WordPress
// dans le <head> et aussi sur le flux RSS
function remove_wordpress_version() {
    return '';
}

add_filter('the_generator', 'remove_wordpress_version');

// Image à la une
add_theme_support( 'post-thumbnails' );

// Ajout d'un emplacement de menu
function register_my_menu() {
    register_nav_menu('main-menu', 'Menu principal');
}

add_action( 'init', 'register_my_menu' );

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}

add_action( 'after_setup_theme', 'register_navwalker' );

// Add logo
add_theme_support( 'custom-logo' );

// Background
add_theme_support( 'custom-background' );


// Ajout de la table "biens"
function register_housing() {
    register_post_type('housing', [
        'label' => 'Biens immobiliers',
        'labels' => [
            'name' => 'Biens immobiliers',
            'singular_name' => 'Bien immobilier',
            'all_items' => 'Tous les biens',
            'add_new_item' => 'Ajouter un bien',
            'edit_item' => 'Éditer le bien',
            'new_item' => 'Nouveau bien',
            'view_item' => 'Voir le bien',
            'search_items' => 'Rechercher parmi les biens',
            'not_found' => 'Pas de bien trouvé',
            'not_found_in_trash' => 'Pas de bien dans la corbeille'
        ],
        'public' => true,
        'supports' => ['title', 'editor', 'author', 'thumbnail'],
        'has_archive' => true,
        'show_in_rest' => true, // Si on veut activer Gutenberg
        'menu_icon' => 'dashicons-admin-home'
    ]);

    register_taxonomy('city', 'housing', [
        'label' => 'Villes',
        'labels' => [
            'name' => 'Villes',
            'singular_name' => 'Ville',
            'all_items' => 'Toutes les villes',
            'edit_item' => 'Éditer la ville',
            'view_item' => 'Voir la ville',
            'update_item' => 'Mettre à jour la ville',
            'add_new_item' => 'Ajouter une ville',
            'new_item_name' => 'Nouvelle ville',
            'search_items' => 'Rechercher parmi les villes',
            'popular_items' => 'Villes les plus utilisées'
        ],
        'hierarchical' => false,
        'show_in_rest' => true, // Pour Gutenberg
    ]);
}

add_action( 'init', 'register_housing' );
