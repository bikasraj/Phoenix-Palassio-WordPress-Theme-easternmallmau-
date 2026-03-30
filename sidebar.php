<?php if ( is_active_sidebar('sidebar-1') ) : ?>
<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>
<?php else : ?>
<aside id="secondary" class="widget-area">
    <section class="widget">
        <h3 class="widget-title" style="font-family:var(--font-heading);font-size:1rem;font-weight:700;margin-bottom:15px;padding-bottom:8px;border-bottom:2px solid var(--gold);"><?php esc_html_e('Recent Posts', 'phoenix-palassio'); ?></h3>
        <?php
        $recent = get_posts(array('posts_per_page' => 5));
        echo '<ul style="list-style:none;">';
        foreach ($recent as $post) {
            echo '<li style="padding:8px 0;border-bottom:1px solid #eee;"><a href="' . esc_url(get_permalink($post->ID)) . '" style="font-size:0.85rem;color:var(--black);">' . esc_html($post->post_title) . '</a></li>';
        }
        echo '</ul>';
        ?>
    </section>
</aside>
<?php endif;
