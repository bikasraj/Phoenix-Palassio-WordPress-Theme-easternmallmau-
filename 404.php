<?php
/**
 * 404 Page Template
 */
get_header();
?>

<section style="padding:100px 20px;text-align:center;">
    <div class="container">
        <h1 style="font-family:var(--font-heading);font-size:8rem;font-weight:900;color:var(--gold);line-height:1;">404</h1>
        <h2 style="font-family:var(--font-heading);font-size:2rem;margin-bottom:20px;"><?php esc_html_e('Page Not Found', 'phoenix-palassio'); ?></h2>
        <p style="color:var(--gray-dark);margin-bottom:30px;max-width:500px;margin-left:auto;margin-right:auto;"><?php esc_html_e("The page you're looking for doesn't exist or has been moved.", 'phoenix-palassio'); ?></p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-gold"><?php esc_html_e('Back to Home', 'phoenix-palassio'); ?></a>
    </div>
</section>

<?php get_footer(); ?>
