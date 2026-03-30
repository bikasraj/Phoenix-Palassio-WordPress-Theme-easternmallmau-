<?php
/**
 * Template Name: Offers and Packages Page
 */
get_header();
?>

<div style="background:linear-gradient(135deg,#F5A623,#F8D272);min-height:280px;display:flex;align-items:center;justify-content:center;text-align:center;padding:40px 20px;position:relative;overflow:hidden;">
    <div style="position:relative;z-index:1;">
        <img src="<?php echo esc_url( PHOENIX_PALASSIO_URI . '/images/logo.svg' ); ?>" alt="Phoenix Palassio" style="height:60px;margin:0 auto 20px;" onerror="this.style.display='none'">
        <h1 style="font-family:var(--font-heading);font-size:5rem;font-weight:900;color:var(--black);letter-spacing:-1px;line-height:1;">OFFER</h1>
    </div>
</div>

<?php phoenix_breadcrumb(); ?>

<section class="offers-section">
    <div class="container">

        <!-- OFFERS -->
        <div style="margin-bottom:50px;">
            <div class="dine-header">
                <h2><?php esc_html_e( 'Offers', 'phoenix-palassio' ); ?></h2>
                <div class="filter-btn"><i class="fa-solid fa-sliders"></i> <span>FILTER</span></div>
            </div>
            <?php
            $offers = get_posts( array(
                'post_type'      => 'offer',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_key'       => '_offer_type_select',
                'meta_value'     => 'offer',
            ) );

            if ( empty( $offers ) ) : ?>
                <p style="font-size:.9rem;color:var(--gray);padding:20px 0;">No Offers found matching your criteria!</p>
            <?php else : ?>
                <div class="offers-grid">
                    <?php foreach ( $offers as $offer ) :
                        $price    = get_post_meta( $offer->ID, '_offer_price', true );
                        $validity = get_post_meta( $offer->ID, '_offer_validity', true ); ?>
                        <div class="offer-card">
                            <?php if ( has_post_thumbnail( $offer->ID ) ) : ?>
                                <?php echo get_the_post_thumbnail( $offer->ID, 'event-card' ); ?>
                            <?php else : ?>
                                <div style="width:100%;height:200px;background:var(--dark);display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#fff;font-weight:700;text-align:center;padding:15px;"><?php echo esc_html( $offer->post_title ); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="offer-card-body">
                                <h3><?php echo esc_html( $offer->post_title ); ?></h3>
                                <?php if ( $price ) : ?>
                                    <p class="offer-price"><?php echo esc_html( $price ); ?></p>
                                <?php endif; ?>
                                <?php if ( $validity ) : ?>
                                    <p class="offer-validity">Validity: <?php echo esc_html( $validity ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- PACKAGES -->
        <div>
            <div class="dine-header">
                <h2><?php esc_html_e( 'Packages', 'phoenix-palassio' ); ?></h2>
                <div class="filter-btn"><i class="fa-solid fa-sliders"></i> <span>FILTER</span></div>
            </div>
            <?php
            $packages = get_posts( array(
                'post_type'      => 'offer',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_key'       => '_offer_type_select',
                'meta_value'     => 'package',
            ) );

            if ( empty( $packages ) ) :
                $demo_packages = array(
                    array( 'name' => 'Mall Packages', 'price' => 'NOW ONLY@599', 'validity' => '30th June 2026' ),
                    array( 'name' => 'Mall Packages', 'price' => 'NOW ONLY@745', 'validity' => '30th June 2026' ),
                ); ?>
                <div class="packages-grid">
                    <?php foreach ( $demo_packages as $p ) : ?>
                        <div class="package-card">
                            <div style="width:100%;height:200px;background:linear-gradient(135deg,#1a1a2e,#0f3460);display:flex;align-items:center;justify-content:center;">
                                <span style="color:#fff;font-weight:700;font-size:1.1rem;"><?php echo esc_html( $p['name'] ); ?></span>
                            </div>
                            <div class="package-card-body">
                                <h3><?php echo esc_html( $p['name'] ); ?></h3>
                                <p class="offer-price"><?php echo esc_html( $p['price'] ); ?></p>
                                <p class="package-validity">Validity: <?php echo esc_html( $p['validity'] ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else : ?>
                <div class="packages-grid">
                    <?php foreach ( $packages as $pkg ) :
                        $price    = get_post_meta( $pkg->ID, '_offer_price', true );
                        $validity = get_post_meta( $pkg->ID, '_offer_validity', true ); ?>
                        <div class="package-card">
                            <?php if ( has_post_thumbnail( $pkg->ID ) ) : ?>
                                <?php echo get_the_post_thumbnail( $pkg->ID, 'event-card' ); ?>
                            <?php else : ?>
                                <div style="width:100%;height:200px;background:linear-gradient(135deg,#1a1a2e,#0f3460);display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#fff;font-weight:700;text-align:center;padding:15px;"><?php echo esc_html( $pkg->post_title ); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="package-card-body">
                                <h3><?php echo esc_html( $pkg->post_title ); ?></h3>
                                <?php if ( $price ) : ?>
                                    <p class="offer-price"><?php echo esc_html( $price ); ?></p>
                                <?php endif; ?>
                                <?php if ( $validity ) : ?>
                                    <p class="package-validity">Validity: <?php echo esc_html( $validity ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php get_footer(); ?>
