<?php
/**
 * Default Page Template - Phoenix Palassio
 * Checks for assigned page template and loads it, otherwise shows standard page.
 */

$tpl = get_page_template_slug();

if ( $tpl ) {
    $tpl_file = get_template_directory() . '/' . $tpl;
    if ( file_exists( $tpl_file ) ) {
        include $tpl_file;
        return;
    }
}

/* Fallback: standard content page */
get_header();
phoenix_breadcrumb();
?>

<main class="container" style="padding:60px 20px;max-width:900px;">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h1 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:700;margin-bottom:30px;"><?php the_title(); ?></h1>
        <?php if ( has_post_thumbnail() ) : ?>
            <div style="margin-bottom:30px;border-radius:8px;overflow:hidden;"><?php the_post_thumbnail( 'hero-banner' ); ?></div>
        <?php endif; ?>
        <div style="line-height:1.9;font-size:.95rem;color:var(--gray-dark);"><?php the_content(); ?></div>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
