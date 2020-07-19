<?php

// Traitement du formulaire
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $housing_id = $_POST['housing_id'];
    $reference = $_POST['reference'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $message = $_POST['message'];

    $errors = [];

    if (strlen($lastname) === 0) {
        $errors['lastname'] = 'Le nom n\'est pas valide';
    }

    if (strlen($firstname) === 0) {
        $errors['firstname'] = 'Le nom n\'est pas valide';
    }

    if (strlen($message) < 10) {
        $errors['message'] = 'Le message est trop court';
    }

    if (empty($errors)) {
        $success = 'Votre demande a été envoyé.';
        // Requête SQL pour insérer la demande de contact
        global $wpdb;
        // Prefixe de la base : $wpdb->prefix = af567_
        $wpdb->insert($wpdb->prefix.'contact', [
            'reference' => $reference,
            'housing_id' => $housing_id,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'message' => $message
        ]);
    }
}

// Require du fichier header.php
get_header(); ?>

	<?php var_dump($errors ?? null); var_dump($success ?? null);
        // On affiche toutes les erreurs du formulaire
        if (!empty($errors)) { ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $field => $error) {
                    echo $field . ' : ' . $error . '<br />';
                } ?>
            </div>
        <?php } ?>

    <?php if (isset($success)) {
        echo '<div class="alert alert-success">'.$success.'</div>';
    } ?>

    <div class="container">
    	<?php
    		if (have_posts()) : ?>
    			<div class="row">
	    			<?php while (have_posts()) : the_post(); ?>
	    				<div class="col-lg-12">
    						<?php
    							// Récupère l'url de l'image
    							$image_url = wp_get_attachment_image_src(
    								get_post_thumbnail_id( $post->ID ), 'large'
    							);
    							// On veut le chemin de l'image
    							$image_url = $image_url[0];
    						?>
						    <img class="card-img-top" src="<?= $image_url; ?>" alt="<?php the_title(); ?>">
						    <?php // the_post_thumbnail( [100, 100] ); ?>
						    <div class="card-body">
						        <h5 class="card-title"><?php the_title(); ?></h5>
						        <p class="card-text"><?php the_content(); ?></p>
						        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
						        	Voir l'article
						        </a>
								<button data-id="<?php the_ID(); ?>" data-title="<?php the_title(); ?>" type="button" class="btn btn-primary" data-toggle="modal" data-target="#housing-modal">Nous contacter</button>
						    </div>
	    				</div>
	    			<?php endwhile; ?>
    			</div>
    		<?php else :
    			echo '<h2>Pas d\'article</h2>';
    		endif;
    	?>
    	
    </div>

	<!-- Modal -->
    <div class="modal fade" id="housing-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contact</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="housing_id" id="housing_id">
                        <div class="form-group">
                            <label for="reference">Référence</label>
                            <input type="text" name="reference" id="reference" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Nom</label>
                            <input type="text" name="lastname" id="lastname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="firstname">Prénom</label>
                            <input type="text" name="firstname" id="firstname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
