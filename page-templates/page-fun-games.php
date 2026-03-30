<?php
/**
 * Template Name: Fun and Games Page
 */
get_header();
?>

<div class="page-hero games-hero">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'hero-banner' ); } ?>
    <div class="page-hero-overlay" style="background:rgba(180,30,30,0.5);"></div>
    <div class="page-hero-content">
        <h1 style="font-size:4rem;font-weight:900;">GAMES</h1>
        <p style="font-size:1.2rem;font-weight:700;letter-spacing:3px;">NOW OPEN</p>
    </div>
</div>

<?php phoenix_breadcrumb(); ?>

<section class="entertainment-section">
    <div class="container">
        <div class="dine-header">
            <h2><?php esc_html_e( 'Fun & Games', 'phoenix-palassio' ); ?></h2>
            <div class="filter-btn"><i class="fa-solid fa-sliders"></i> <span>FILTER</span></div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;padding:20px 0;">
            <?php
            $games = get_posts( array(
                'post_type'      => 'entertainment',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_key'       => '_entertainment_type',
                'meta_value'     => 'fun_games',
            ) );

            if ( empty( $games ) ) :
                $demo = array(
                    array( 'name' => 'Timezone',           'cat' => 'Snow Parks', 'timing' => '11:00AM - 9:30PM'  ),
                    array( 'name' => 'House of Fear',      'cat' => 'Snow Parks', 'timing' => '11:00AM - 11:00PM' ),
                    array( 'name' => '9D Virtual Reality', 'cat' => 'Snow Parks', 'timing' => '11:00AM - 11:00PM' ),
                );
                foreach ( $demo as $g ) : ?>
                    <div style="display:flex;align-items:center;gap:15px;padding:15px;border-bottom:1px solid #eee;">
                        <div style="width:50px;height:50px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid fa-gamepad" style="color:#fff;font-size:1.2rem;"></i>
                        </div>
                        <div>
                            <h3 style="font-size:.95rem;font-weight:700;"><?php echo esc_html( $g['name'] ); ?></h3>
                            <p style="font-size:.75rem;color:var(--gray);"><?php echo esc_html( $g['cat'] ); ?> | <?php echo esc_html( $g['timing'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach;

            else :
                foreach ( $games as $g ) :
                    $timing = get_post_meta( $g->ID, '_entertainment_timing', true ); ?>
                    <div style="display:flex;align-items:center;gap:15px;padding:15px;border-bottom:1px solid #eee;">
                        <?php if ( has_post_thumbnail( $g->ID ) ) : ?>
                            <?php echo get_the_post_thumbnail( $g->ID, array( 50, 50 ), array( 'style' => 'width:50px;height:50px;object-fit:cover;border-radius:50%;flex-shrink:0;' ) ); ?>
                        <?php else : ?>
                            <div style="width:50px;height:50px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fa-solid fa-gamepad" style="color:#fff;"></i>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h3 style="font-size:.95rem;font-weight:700;"><?php echo esc_html( $g->post_title ); ?></h3>
                            <?php if ( $timing ) : ?>
                                <p style="font-size:.75rem;color:var(--gray);"><?php echo esc_html( $timing ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
