<?php
/**
 * Template Name: Dine Page
 */
get_header();
?>

<div class="page-hero dine-hero">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'hero-banner' ); } ?>
    <div class="page-hero-overlay"></div>
</div>

<?php phoenix_breadcrumb(); ?>

<section class="dine-section">
    <div class="container">
        <div class="dine-header">
            <h2><?php esc_html_e( 'Dine', 'phoenix-palassio' ); ?></h2>
            <div class="filter-btn">
                <i class="fa-solid fa-sliders"></i>
                <span><?php esc_html_e( 'FILTER', 'phoenix-palassio' ); ?></span>
            </div>
        </div>

        <div class="restaurants-grid" id="restaurants-grid">
            <?php
            $restaurants = get_posts( array(
                'post_type'      => 'restaurant',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            ) );

            if ( empty( $restaurants ) ) :
                $demo = array(
                    array( 'name' => 'Ishaara',        'floor' => 'Restaurant | Second Floor', 'veg' => true,  'nonveg' => true  ),
                    array( 'name' => 'Dobaraa',        'floor' => 'Restaurant | Second Floor', 'veg' => true,  'nonveg' => true  ),
                    array( 'name' => 'EIGHT',          'floor' => 'Restaurant | Second Floor', 'veg' => true,  'nonveg' => true  ),
                    array( 'name' => 'Punjab Grill',   'floor' => 'Restaurant | Second Floor', 'veg' => true,  'nonveg' => true  ),
                    array( 'name' => 'KFC',            'floor' => 'Restaurant | Third Floor',  'veg' => true,  'nonveg' => true  ),
                    array( 'name' => 'Pizza Hut',      'floor' => 'Restaurant | Second Floor', 'veg' => true,  'nonveg' => true  ),
                    array( 'name' => "Jamie's Pizzeria",'floor'=> 'Restaurant | Second Floor', 'veg' => false, 'nonveg' => false ),
                    array( 'name' => 'Cinnabon',       'floor' => 'Restaurant | Ground Floor', 'veg' => true,  'nonveg' => true  ),
                    array( 'name' => 'Burger King',    'floor' => 'Food Court | Third Floor',  'veg' => true,  'nonveg' => true  ),
                    array( 'name' => 'House of Candy', 'floor' => 'Restaurant | Third Floor',  'veg' => true,  'nonveg' => false ),
                    array( 'name' => 'Keventers',      'floor' => 'Food Court | Second Floor', 'veg' => true,  'nonveg' => false ),
                    array( 'name' => 'Subway',         'floor' => 'Food Court | Second Floor', 'veg' => true,  'nonveg' => true  ),
                );
                foreach ( $demo as $r ) : ?>
                    <div class="restaurant-item">
                        <div style="width:100%;height:180px;background:var(--dark);display:flex;align-items:center;justify-content:center;">
                            <span style="color:#fff;font-size:1.1rem;font-weight:700;"><?php echo esc_html( $r['name'] ); ?></span>
                        </div>
                        <div class="restaurant-item-body">
                            <h3><?php echo esc_html( $r['name'] ); ?></h3>
                            <?php echo phoenix_veg_nonveg_badges( $r['veg'], $r['nonveg'] ); ?>
                            <p class="type-floor"><?php echo esc_html( $r['floor'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach;

            else :
                foreach ( $restaurants as $r ) :
                    $floor   = get_post_meta( $r->ID, '_restaurant_floor', true );
                    $type    = get_post_meta( $r->ID, '_restaurant_type_text', true );
                    $veg     = ( get_post_meta( $r->ID, '_restaurant_veg', true ) === '1' );
                    $nonveg  = ( get_post_meta( $r->ID, '_restaurant_nonveg', true ) === '1' );

                    if ( $type && $floor ) {
                        $type_floor = $type . ' | ' . $floor;
                    } elseif ( $type ) {
                        $type_floor = $type;
                    } else {
                        $type_floor = $floor;
                    }
                    ?>
                    <div class="restaurant-item">
                        <a href="<?php echo esc_url( get_permalink( $r->ID ) ); ?>">
                            <?php if ( has_post_thumbnail( $r->ID ) ) : ?>
                                <?php echo get_the_post_thumbnail( $r->ID, 'restaurant-card' ); ?>
                            <?php else : ?>
                                <div style="width:100%;height:180px;background:var(--dark);display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#fff;font-weight:700;"><?php echo esc_html( $r->post_title ); ?></span>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="restaurant-item-body">
                            <h3><a href="<?php echo esc_url( get_permalink( $r->ID ) ); ?>"><?php echo esc_html( $r->post_title ); ?></a></h3>
                            <?php echo phoenix_veg_nonveg_badges( $veg, $nonveg ); ?>
                            <p class="type-floor"><?php echo esc_html( $type_floor ); ?></p>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>

        <div style="text-align:center;margin-top:40px;">
            <a href="#" class="view-more"><?php esc_html_e( 'VIEW MORE', 'phoenix-palassio' ); ?></a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
