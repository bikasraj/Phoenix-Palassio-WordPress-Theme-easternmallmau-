<?php
/**
 * Archive template - routes to correct page template
 */

$post_type = get_query_var('post_type');

if ( $post_type === 'brand' ) {
    include( get_template_directory() . '/page-templates/page-brands.php' );
} elseif ( $post_type === 'restaurant' ) {
    include( get_template_directory() . '/page-templates/page-dine.php' );
} elseif ( $post_type === 'entertainment' ) {
    include( get_template_directory() . '/page-templates/page-entertainment.php' );
} elseif ( $post_type === 'event' ) {
    include( get_template_directory() . '/page-templates/page-events.php' );
} elseif ( $post_type === 'offer' ) {
    include( get_template_directory() . '/page-templates/page-offers.php' );
} else {
    get_header();
    phoenix_breadcrumb();
    ?>
    <main class="container" style="padding:60px 20px;">
        <h1 class="section-title"><?php post_type_archive_title(); ?></h1>
        <div class="brands-grid">
            <?php while ( have_posts() ) : the_post(); ?>
            <div>
                <?php if ( has_post_thumbnail() ) the_post_thumbnail('brand-card'); ?>
                <h3><?php the_title(); ?></h3>
            </div>
            <?php endwhile; ?>
        </div>
    </main>
    <?php
    get_footer();
}
