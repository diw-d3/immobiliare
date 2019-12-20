<?php

// Reprendre le header (require...)
get_header();

the_post(); // Requête SQL qui récupère les informations de l'article

// Afficher le contenu de l'annonce sur 2 colonnes.
// La première colonne affiche l'image de l'annonce.
// La seconde colonne affiche le titre de l'annonce, la date, l'auteur et les catégories.
// Evidemment, on n'oublie pas le contenu de l'annonce
?>

<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<?php
				// Récupère l'url de l'image
				$image_url = wp_get_attachment_image_src(
					get_post_thumbnail_id( $post->ID ), 'large'
				);
				// On veut le chemin de l'image
				$image_url = $image_url[0];
			?>
			<img class="img-fluid" src="<?= $image_url; ?>" alt="<?php the_title(); ?>">
		</div>
		<div class="col-lg-6">
			<h1><?php the_title(); ?></h1>
			<p>Date : <?php the_date(); ?></p>
			<p>Auteur : <?php the_author(); ?></p>
			<p>Catégories : <?php the_category(); ?></p>

			<div>
				<?php the_content(); ?>
			</div>
		</div>
	</div>

	<a class="btn btn-primary mt-4" href="<?= get_post_type_archive_link( 'housing' ); ?>">Retour aux annonces</a>
</div>

<?php
// Reprendre le footer
get_footer();
