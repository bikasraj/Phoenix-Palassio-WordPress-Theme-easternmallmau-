<?php
/**
 * Search Results Template
 */
get_header();
phoenix_breadcrumb();
?>

<section style="padding:60px 0;">
    <div class="container">
        <h1 style="font-family:var(--font-heading);font-size:2rem;margin-bottom:10px;">
            <?php printf( esc_html__('Search Results for: %s', 'phoenix-palassio'), '<em>' . get_search_query() . '</em>' ); ?>
        </h1>
        <p style="color:var(--gray);margin-bottom:40px;">
            <?php printf( esc_html__('%d results found', 'phoenix-palassio'), $wp_query->found_posts ); ?>
        </p>

        <?php get_search_form(); ?>

        <div style="margin-top:40px;display:grid;grid-template-columns:repeat(3,1fr);gap:25px;">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article style="border:1px solid #eee;border-radius:6px;overflow:hidden;transition:var(--transition);" onmouseover="this.style.boxShadow='var(--shadow)'" onmouseout="this.style.boxShadow='none'">
                <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog-thumb', array('style'=>'width:100%;height:180px;object-fit:cover;')); ?></a>
                <?php endif; ?>
                <div style="padding:20px;">
                    <span style="font-size:0.72rem;color:var(--gold);font-weight:700;text-transform:uppercase;letter-spacing:1px;"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></span>
                    <h2 style="font-size:1rem;font-weight:700;margin:8px 0;"><a href="<?php the_permalink(); ?>" style="color:var(--black);"><?php the_title(); ?></a></h2>
                    <p style="font-size:0.82rem;color:var(--gray-dark);line-height:1.6;"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                    <a href="<?php the_permalink(); ?>" style="display:inline-block;margin-top:12px;font-size:0.75rem;font-weight:700;color:var(--red);letter-spacing:0.5px;"><?php esc_html_e('READ MORE', 'phoenix-palassio'); ?></a>
                </div>
            </article>
            <?php endwhile;
            else : ?>
            <div style="grid-column:1/-1;text-align:center;padding:40px;">
                <i class="fa-solid fa-magnifying-glass" style="font-size:3rem;color:var(--gray);margin-bottom:20px;display:block;"></i>
                <h2 style="font-family:var(--font-heading);font-size:1.5rem;margin-bottom:10px;"><?php esc_html_e('Nothing Found', 'phoenix-palassio'); ?></h2>
                <p style="color:var(--gray-dark);"><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'phoenix-palassio'); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div style="margin-top:40px;text-align:center;">
            <?php
            echo paginate_links(array(
                'prev_text' => '&laquo; ' . __('Previous', 'phoenix-palassio'),
                'next_text' => __('Next', 'phoenix-palassio') . ' &raquo;',
            ));
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
