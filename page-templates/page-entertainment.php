<?php
/**
 * Template Name: Entertainment Page
 */
get_header();
phoenix_breadcrumb();
?>

<section class="entertainment-section">
    <div class="container">

        <!-- MOVIES -->
        <div class="ent-category">
            <div class="ent-category-header">
                <h2><?php esc_html_e( 'Movies', 'phoenix-palassio' ); ?></h2>
                <a href="#" class="view-all"><?php esc_html_e( 'VIEW ALL', 'phoenix-palassio' ); ?></a>
            </div>
            <?php
            $movies = get_posts( array(
                'post_type'      => 'entertainment',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
                'meta_key'       => '_entertainment_type',
                'meta_value'     => 'movies',
            ) );
            if ( empty( $movies ) ) : ?>
                <p class="no-content"><?php esc_html_e( 'No movies available.', 'phoenix-palassio' ); ?></p>
            <?php else : ?>
                <div class="fun-games-grid">
                    <?php foreach ( $movies as $m ) :
                        $timing = get_post_meta( $m->ID, '_entertainment_timing', true ); ?>
                        <div class="fun-game-card">
                            <?php if ( has_post_thumbnail( $m->ID ) ) : ?>
                                <?php echo get_the_post_thumbnail( $m->ID, 'restaurant-card' ); ?>
                            <?php else : ?>
                                <div style="width:100%;height:220px;background:var(--dark);display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#fff;font-weight:700;"><?php echo esc_html( $m->post_title ); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="fun-game-card-body">
                                <div class="game-info">
                                    <h3><?php echo esc_html( $m->post_title ); ?></h3>
                                    <?php if ( $timing ) : ?>
                                        <p class="timing"><?php echo esc_html( $timing ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- FUN & GAMES -->
        <div class="ent-category">
            <div class="ent-category-header">
                <h2><?php esc_html_e( 'Fun & Games', 'phoenix-palassio' ); ?></h2>
                <a href="<?php echo esc_url( home_url( '/fun-games/' ) ); ?>" class="view-all"><?php esc_html_e( 'VIEW ALL', 'phoenix-palassio' ); ?></a>
            </div>
            <?php
            $games = get_posts( array(
                'post_type'      => 'entertainment',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
                'meta_key'       => '_entertainment_type',
                'meta_value'     => 'fun_games',
            ) );

            if ( empty( $games ) ) :
                $demo_games = array(
                    array( 'name' => 'Timezone',           'timing' => '11:00AM - 9:30PM'  ),
                    array( 'name' => 'House of Fear',      'timing' => '11:00AM - 11:00PM' ),
                    array( 'name' => '9D Virtual Reality', 'timing' => '11:00AM - 11:00PM' ),
                ); ?>
                <div class="fun-games-grid">
                    <?php foreach ( $demo_games as $g ) : ?>
                        <div class="fun-game-card">
                            <div style="width:100%;height:220px;background:var(--dark);display:flex;align-items:center;justify-content:center;">
                                <span style="color:#fff;font-size:1.2rem;font-weight:700;"><?php echo esc_html( $g['name'] ); ?></span>
                            </div>
                            <div class="fun-game-card-body">
                                <div class="game-info">
                                    <h3><?php echo esc_html( $g['name'] ); ?></h3>
                                    <p class="timing"><?php echo esc_html( $g['timing'] ); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="fun-games-grid">
                    <?php foreach ( $games as $g ) :
                        $timing = get_post_meta( $g->ID, '_entertainment_timing', true ); ?>
                        <div class="fun-game-card">
                            <?php if ( has_post_thumbnail( $g->ID ) ) : ?>
                                <?php echo get_the_post_thumbnail( $g->ID, 'restaurant-card' ); ?>
                            <?php else : ?>
                                <div style="width:100%;height:220px;background:var(--dark);display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#fff;font-weight:700;"><?php echo esc_html( $g->post_title ); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="fun-game-card-body">
                                <div class="game-info">
                                    <h3><?php echo esc_html( $g->post_title ); ?></h3>
                                    <?php if ( $timing ) : ?>
                                        <p class="timing"><?php echo esc_html( $timing ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php get_footer(); ?>
