<?php
/**
 * Template Name: Brands Page
 */
get_header();
?>

<div class="page-hero brands-hero">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail('hero-banner'); } ?>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <h1><?php esc_html_e( 'Brands', 'phoenix-palassio' ); ?></h1>
        <div class="page-hero-search">
            <div class="search-box">
                <input type="text" id="brand-search-input" placeholder="<?php esc_attr_e( 'Search brands', 'phoenix-palassio' ); ?>">
                <button id="brand-search-btn"><?php esc_html_e( 'SEARCH', 'phoenix-palassio' ); ?></button>
            </div>
        </div>
        <div class="filter-tabs" id="brand-filter-tabs">
            <button class="filter-tab active" data-filter="all"><?php esc_html_e( 'ALL BRANDS', 'phoenix-palassio' ); ?></button>
            <button class="filter-tab" data-filter="womens-fashion"><?php esc_html_e( "WOMEN'S FASHION", 'phoenix-palassio' ); ?></button>
            <button class="filter-tab" data-filter="mens-fashion"><?php esc_html_e( "MEN'S FASHION", 'phoenix-palassio' ); ?></button>
            <button class="filter-tab" data-filter="kids-fashion"><?php esc_html_e( "KID'S FASHION", 'phoenix-palassio' ); ?></button>
            <button class="filter-tab more-btn" data-filter="more"><i class="fa-solid fa-sliders"></i> <?php esc_html_e( 'MORE', 'phoenix-palassio' ); ?></button>
        </div>
    </div>
</div>

<?php phoenix_breadcrumb(); ?>

<section class="brands-section">
    <div class="container">
        <div class="brands-section-header">
            <div class="brands-count">
                <h2 id="brands-count-text">
                    <span id="brands-num"><?php echo intval( wp_count_posts('brand')->publish ); ?></span>
                    <?php esc_html_e( 'Brands Match Your Filter', 'phoenix-palassio' ); ?>
                </h2>
            </div>
            <div class="sort-btn"><i class="fa-solid fa-sort"></i></div>
        </div>

        <div class="brands-grid" id="brands-grid">
            <?php
            $brands = get_posts( array(
                'post_type'      => 'brand',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ) );

            if ( empty( $brands ) ) :
                $demo = array(
                    array( 'name' => '9D Virtual Reality',  'cat' => 'Games & FEC' ),
                    array( 'name' => 'ABC Chashmewale',     'cat' => 'Eyewear' ),
                    array( 'name' => 'Ada',                 'cat' => "Women's Fashion" ),
                    array( 'name' => 'Adidas',              'cat' => 'Sports & Fitness' ),
                    array( 'name' => 'ALDO',                'cat' => 'Bags & Luggage' ),
                    array( 'name' => 'Aldo Accessories',    'cat' => 'Foot Fashion' ),
                    array( 'name' => 'Allen Solly',         'cat' => 'General Fashion' ),
                    array( 'name' => 'Allen Solly Women',   'cat' => "Women's Fashion" ),
                    array( 'name' => 'American Eagle',      'cat' => 'General Fashion' ),
                    array( 'name' => 'American Tourister',  'cat' => 'Bags & Luggage' ),
                    array( 'name' => 'Angle and Rocket',    'cat' => 'Kids Fashion' ),
                    array( 'name' => 'Armani Exchange',     'cat' => 'General Fashion' ),
                );
                foreach ( $demo as $b ) : ?>
                    <div class="brand-item" data-brand-name="<?php echo esc_attr( strtolower( $b['name'] ) ); ?>" data-brand-cat="general">
                        <div class="brand-item-actions">
                            <span class="brand-icon-btn"><i class="fa-solid fa-phone"></i></span>
                            <span class="brand-icon-btn"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <div class="brand-item-logo">
                            <span style="font-size:1.2rem;font-weight:800;color:var(--black);"><?php echo esc_html( $b['name'] ); ?></span>
                        </div>
                        <h3><?php echo esc_html( $b['name'] ); ?></h3>
                        <p class="category"><?php echo esc_html( $b['cat'] ); ?></p>
                    </div>
                <?php endforeach;

            else :
                foreach ( $brands as $brand ) :
                    $phone    = get_post_meta( $brand->ID, '_brand_phone', true );
                    $floor    = get_post_meta( $brand->ID, '_brand_floor', true );
                    $cat_text = get_post_meta( $brand->ID, '_brand_category_text', true );
                    $terms    = get_the_terms( $brand->ID, 'brand_category' );

                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $cat_slug = $terms[0]->slug;
                        $cat_name = $terms[0]->name;
                    } else {
                        $cat_slug = 'all';
                        $cat_name = '';
                    }

                    if ( $cat_text ) {
                        $cat_disp = $cat_text;
                    } else {
                        $cat_disp = $cat_name;
                    }
                    ?>
                    <div class="brand-item" data-brand-name="<?php echo esc_attr( strtolower( $brand->post_title ) ); ?>" data-brand-cat="<?php echo esc_attr( $cat_slug ); ?>">
                        <div class="brand-item-actions">
                            <?php if ( $phone ) : ?>
                                <a href="tel:<?php echo esc_attr( $phone ); ?>" class="brand-icon-btn" title="Call"><i class="fa-solid fa-phone"></i></a>
                            <?php else : ?>
                                <span class="brand-icon-btn"><i class="fa-solid fa-phone"></i></span>
                            <?php endif; ?>
                            <span class="brand-icon-btn"><i class="fa-solid fa-location-dot"></i></span>
                        </div>
                        <div class="brand-item-logo">
                            <?php if ( has_post_thumbnail( $brand->ID ) ) : ?>
                                <?php echo get_the_post_thumbnail( $brand->ID, array( 140, 60 ) ); ?>
                            <?php else : ?>
                                <span style="font-size:1rem;font-weight:800;color:var(--black);text-align:center;"><?php echo esc_html( $brand->post_title ); ?></span>
                            <?php endif; ?>
                        </div>
                        <h3><?php echo esc_html( $brand->post_title ); ?></h3>
                        <?php if ( $cat_disp ) : ?>
                            <p class="category"><?php echo esc_html( $cat_disp ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>

        <div style="text-align:center;margin-top:30px;" id="brands-view-more-wrap">
            <a href="#" class="view-more" id="brands-view-more"><?php esc_html_e( 'VIEW MORE', 'phoenix-palassio' ); ?></a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
