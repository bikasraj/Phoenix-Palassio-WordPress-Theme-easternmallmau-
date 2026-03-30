<?php
/**
 * Single Post Template
 */
get_header();
?>

<?php phoenix_breadcrumb(); ?>

<main class="container" style="padding:60px 20px;display:grid;grid-template-columns:1fr 300px;gap:50px;">
    <article>
        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <h1 style="font-family:var(--font-heading);font-size:2.2rem;font-weight:700;margin-bottom:15px;line-height:1.3;"><?php the_title(); ?></h1>
        <div style="font-size:0.8rem;color:var(--gray);margin-bottom:25px;display:flex;align-items:center;gap:15px;">
            <span><i class="fa-regular fa-calendar" style="margin-right:5px;"></i><?php the_date(); ?></span>
            <span><i class="fa-regular fa-user" style="margin-right:5px;"></i><?php the_author(); ?></span>
        </div>
        <?php if ( has_post_thumbnail() ) : ?>
        <div style="margin-bottom:30px;border-radius:8px;overflow:hidden;"><?php the_post_thumbnail('hero-banner', array('style'=>'width:100%;height:auto;')); ?></div>
        <?php endif; ?>
        <div style="line-height:1.9;font-size:0.95rem;color:var(--gray-dark);"><?php the_content(); ?></div>
        <?php endwhile; ?>
    </article>

    <aside>
        <?php get_sidebar(); ?>
    </aside>
</main>

<?php get_footer(); ?>
