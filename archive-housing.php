<?php
// Require du fichier header.php
get_header(); ?>

    <div class="container">
    	<?php
    		if (have_posts()) : ?>
    			<div class="row">
	    			<?php while (have_posts()) : the_post(); ?>
	    				<div class="col-lg-3">
	    					<?php
    							// Récupère l'url de l'image
    							$image_url = wp_get_attachment_image_src(
    								get_post_thumbnail_id( $post->ID ), 'large'
    							);
    							// On veut le chemin de l'image
    							$image_url = $image_url[0];
    						?>
						    <img class="card-img-top" src="<?= $image_url; ?>" alt="<?php the_title(); ?>">
	    					<div class="card">
							    <?php // the_post_thumbnail( [100, 100] ); 
							    	$surface = get_post_meta( $post->ID, '_surface', true );
							    	$price = get_post_meta( $post->ID, '_price', true );

							    	if (empty($surface)) $surface = 1;
							    	if (empty($price)) $price = 0;

							    	$priceByM = $price / $surface;
							    ?>
							    <div class="card-body">
							    	<span class="text-muted"><?= $surface; ?> m²</span>
							        <h5 class="card-title mb-0"><?php the_title(); ?></h5>
							        <p class="mb-3 card-price">
							        	<?= number_format($price, 2, ',', ' '); ?> €
							        	(<?= number_format($priceByM, 2, ',', ' '); ?> € le m²)
							        </p>
							        <div class="card-text"><?php the_content(); ?></div>
							        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
							        	Voir l'annonce
							        </a>
							    </div>
							</div>
	    				</div>
	    			<?php endwhile; ?>
    			</div>
    		<?php else :
    			echo '<h2>Pas de biens en vente</h2>';
    		endif;
    	?>
    	
    </div>

<?php get_footer(); ?>
