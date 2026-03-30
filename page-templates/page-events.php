<?php
/**
 * Template Name: Events Page
 */
get_header();
?>

<div class="page-hero events-hero">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'hero-banner' ); } ?>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <h1><?php esc_html_e( 'EVENTS', 'phoenix-palassio' ); ?></h1>
    </div>
</div>

<?php phoenix_breadcrumb(); ?>

<section class="events-section">
    <div class="container">
        <div class="dine-header">
            <h2><?php esc_html_e( 'Events', 'phoenix-palassio' ); ?></h2>
            <div class="filter-btn">
                <i class="fa-solid fa-sliders"></i>
                <span><?php esc_html_e( 'FILTER', 'phoenix-palassio' ); ?></span>
            </div>
        </div>

        <div class="events-grid">
            <?php
            $events = get_posts( array(
                'post_type'      => 'event',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'meta_value',
                'meta_key'       => '_event_date',
                'order'          => 'ASC',
            ) );

            if ( empty( $events ) ) : ?>
                <div class="event-card">
                    <div style="width:100%;height:200px;background:var(--gray-light);display:flex;align-items:center;justify-content:center;">
                        <span style="font-size:1rem;font-weight:700;text-align:center;padding:15px;">Phoenix Palassio Grand Table Tennis Tournament</span>
                    </div>
                    <div class="event-card-body">
                        <p class="event-category"><?php esc_html_e( 'Others', 'phoenix-palassio' ); ?></p>
                        <h3>Phoenix Palassio Grand Table Tennis Tournament</h3>
                        <p class="event-date">14 Mar 2026 <span style="color:var(--gray-dark);">| 9:00AM - 10:00PM</span></p>
                        <p class="event-price">&#8377; 100</p>
                    </div>
                </div>

            <?php else :
                foreach ( $events as $ev ) :
                    $date     = get_post_meta( $ev->ID, '_event_date', true );
                    $timing   = get_post_meta( $ev->ID, '_event_timing', true );
                    $price    = get_post_meta( $ev->ID, '_event_price', true );
                    $category = get_post_meta( $ev->ID, '_event_category', true );
                    ?>
                    <div class="event-card">
                        <a href="<?php echo esc_url( get_permalink( $ev->ID ) ); ?>">
                            <?php if ( has_post_thumbnail( $ev->ID ) ) : ?>
                                <?php echo get_the_post_thumbnail( $ev->ID, 'event-card' ); ?>
                            <?php else : ?>
                                <div style="width:100%;height:200px;background:var(--gray-light);display:flex;align-items:center;justify-content:center;">
                                    <span style="font-weight:700;padding:15px;text-align:center;"><?php echo esc_html( $ev->post_title ); ?></span>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="event-card-body">
                            <?php if ( $category ) : ?>
                                <p class="event-category"><?php echo esc_html( $category ); ?></p>
                            <?php endif; ?>
                            <h3><a href="<?php echo esc_url( get_permalink( $ev->ID ) ); ?>"><?php echo esc_html( $ev->post_title ); ?></a></h3>
                            <?php if ( $date ) : ?>
                                <p class="event-date">
                                    <?php echo esc_html( $date ); ?>
                                    <?php if ( $timing ) : ?>
                                        <span style="color:var(--gray-dark);">| <?php echo esc_html( $timing ); ?></span>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ( $price ) : ?>
                                <p class="event-price">&#8377; <?php echo esc_html( $price ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
