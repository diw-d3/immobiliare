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
    wp_enqueue_script( 'app', get_template_directory_uri() . '/assets/js/app.js', ['jquery'], false, true );
}

// On attache la fonction 'immobiliare_enqueue_styles' au hook 'wp_enqueue_scripts'
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

function init_meta_boxe() {
    add_meta_box( 'my_meta', 'Informations', 'display_meta_boxe', 'housing' );
}

function display_meta_boxe( $post ) {
    $price = get_post_meta( $post->ID, '_price', true );
    $surface = get_post_meta( $post->ID, '_surface', true );
    ?>
    <div>
        <label for="price">Prix : </label> <br />
        <input id="price" type="text" name="price" value="<?= $price; ?>" />
    </div> <br />

    <div>
        <label for="surface">Surface : </label> <br />
        <input id="surface" type="text" name="surface" value="<?= $surface; ?>" />
    </div>
<?php }

add_action( 'add_meta_boxes', 'init_meta_boxe' );

function save_meta_boxe( $id_post ) {
    if ( isset( $_POST['price'] ) ) {
        update_post_meta( $id_post, '_price', esc_html($_POST['price']) );
    }

    if ( isset( $_POST['surface'] ) ) {
        update_post_meta( $id_post, '_surface', esc_html($_POST['surface']) );
    }
}

add_action( 'save_post', 'save_meta_boxe' );

/*
CREATE TABLE `wordpress`.`af567_contact` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `reference` VARCHAR(255) NOT NULL , `housing_id` INT NOT NULL , `lastname` VARCHAR(255) NOT NULL , `firstname` VARCHAR(255) NOT NULL , `message` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
*/

// Ce hook est executé au moment où le back office de WP est chargé
add_action( 'admin_menu', 'contact_menu' );

function contact_menu() {
	add_menu_page( 'Demandes de contact', 'Demandes de contact', 'manage_options', 'demande-de-contact', 'contact_page' );
}

function contact_page() {
    global $wpdb;
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    } ?>

	<div class="wrap">
        <h1>Demandes de contact</h1>

        <?php $contacts = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contact"); ?>
            
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Référence</th>
                    <th>Annonce</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Message</th>
                </tr>
            </thead>
            <?php foreach ($contacts as $contact) { ?>
                <tr>
                    <td><?= $contact->id ?></td>
                    <td><?= $contact->reference ?></td>
                    <td>
                        <a target="_blank" href="<?php the_permalink($contact->housing_id) ?>">Voir l'annonce</a>
                    </td>
                    <td><?= $contact->lastname ?></td>
                    <td><?= $contact->firstname ?></td>
                    <td><?= $contact->message ?></td>
                </tr>
            <?php } ?>
        </table>
        
        1/ Récupérer la liste des demandes de contact
        2/ Parcourir cette liste et l'afficher dans un tableau HTML
	</div>
<?php }
