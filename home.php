<?php
/**
 * Template Name: Blog Archive
 */
get_header();
phoenix_breadcrumb();
?>
<section style="padding:60px 0;">
    <div class="container">
        <h1 class="section-title"><?php esc_html_e('Blog', 'phoenix-palassio'); ?></h1>
        <div class="blogs-grid">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article class="blog-card">
                <a href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) the_post_thumbnail('blog-thumb');
                    else: ?>
                    <div style="width:100%;height:200px;background:var(--gray-light);display:flex;align-items:center;justify-content:center;"><i class="fa-regular fa-image" style="font-size:2rem;color:var(--gray);"></i></div>
                    <?php endif; ?>
                </a>
                <div class="blog-card-body">
                    <h3><a href="<?php the_permalink(); ?>" style="color:var(--black);"><?php the_title(); ?></a></h3>
                    <p class="blog-date"><?php the_date('d M Y'); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn-gold"><?php esc_html_e('READ MORE', 'phoenix-palassio'); ?></a>
                </div>
            </article>
            <?php endwhile;
            else: ?>
            <p style="color:var(--gray);"><?php esc_html_e('No posts found.', 'phoenix-palassio'); ?></p>
            <?php endif; ?>
        </div>
        <div style="margin-top:40px;text-align:center;">
            <?php echo paginate_links(); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
