<?php
/**
 * Homepage Template - Phoenix Palassio
 */
get_header();
?>

<!-- HERO SLIDER — Full screen width, dono layouts -->
<style>
.pp-hero-wrap{position:relative;width:100%;overflow:hidden;background:#111;line-height:0;}
.pp-hero-slide{display:none;width:100%;}
.pp-hero-slide.active{display:block;}
.pp-slide-split{display:flex;width:100%;min-height:85vh;}
.pp-slide-split .pp-slide-img{width:50%;overflow:hidden;flex-shrink:0;}
.pp-slide-split .pp-slide-img img{width:100%;height:100%;object-fit:cover;display:block;min-height:85vh;}
.pp-slide-split .pp-slide-content{width:50%;background:#fff;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 50px;text-align:center;}
.pp-slide-full{width:100%;line-height:0;}
.pp-slide-full img{width:100%;height:auto;display:block;}
.pp-hero-dots{position:absolute;bottom:20px;left:50%;transform:translateX(-50%);display:flex;gap:8px;z-index:20;}
.pp-hero-dot{width:10px;height:10px;border-radius:50%;background:rgba(255,255,255,.5);border:none;cursor:pointer;padding:0;transition:all .25s;}
.pp-hero-dot.active{background:var(--gold);transform:scale(1.25);}
@media(max-width:768px){
    .pp-slide-split{flex-direction:column;min-height:auto;}
    .pp-slide-split .pp-slide-img,.pp-slide-split .pp-slide-content{width:100%;}
    .pp-slide-split .pp-slide-img img{min-height:260px;max-height:50vw;}
    .pp-slide-split .pp-slide-content{padding:35px 25px;}
}
</style>
<div class="pp-hero-wrap" id="hero-slider">
    <?php
    $slides = get_posts( array( 'post_type'=>'slide', 'posts_per_page'=>10, 'orderby'=>'menu_order', 'order'=>'ASC', 'post_status'=>'publish' ) );
    if ( empty($slides) ) : ?>
        <div class="pp-hero-slide active" data-index="0">
            <div class="pp-slide-split">
                <div class="pp-slide-img" style="background:linear-gradient(135deg,#1a1a1a,#333);min-height:85vh;display:flex;align-items:center;justify-content:center;">
                    <p style="color:var(--gold);font-size:1.5rem;font-weight:700;">PHOENIX PALASSIO</p>
                </div>
                <div class="pp-slide-content">
                    <img src="<?php echo esc_url(PHOENIX_PALASSIO_URI.'/images/logo.svg'); ?>" alt="Phoenix Palassio" style="height:55px;margin-bottom:20px;" onerror="this.style.display='none'">
                    <h2 style="font-family:var(--font-heading);font-size:2.2rem;font-weight:700;line-height:1.2;margin-bottom:15px;color:var(--black);">SHOP WORTH &#8377;25,000 &amp; GET AN ASSURED SMART WATCH*</h2>
                    <p style="font-size:.82rem;color:#666;letter-spacing:1px;font-weight:600;">02<sup>ND</sup> MAR &ndash; 31<sup>ST</sup> MAR 2026</p>
                </div>
            </div>
        </div>
    <?php else:
        foreach($slides as $i=>$slide):
            $headline=get_post_meta($slide->ID,'_slide_headline',true);
            $period=get_post_meta($slide->ID,'_slide_offer_period',true);
            $link=get_post_meta($slide->ID,'_slide_link',true);
            $layout=get_post_meta($slide->ID,'_slide_layout',true);
            if(!$layout){$layout='split';}
            $ac=($i===0)?' active':'';
    ?>
        <div class="pp-hero-slide<?php echo $ac; ?>" data-index="<?php echo intval($i); ?>">
            <?php if($layout==='split'): ?>
                <div class="pp-slide-split">
                    <div class="pp-slide-img">
                        <?php if(has_post_thumbnail($slide->ID)): ?>
                            <?php echo get_the_post_thumbnail($slide->ID,'full',array('style'=>'width:100%;height:100%;object-fit:cover;display:block;min-height:85vh;')); ?>
                        <?php else: ?>
                            <div style="width:100%;min-height:85vh;background:linear-gradient(135deg,#1a1a1a,#333);"></div>
                        <?php endif; ?>
                    </div>
                    <div class="pp-slide-content">
                        <img src="<?php echo esc_url(PHOENIX_PALASSIO_URI.'/images/logo.svg'); ?>" alt="Phoenix Palassio" style="height:55px;margin-bottom:20px;" onerror="this.style.display='none'">
                        <?php if($headline): ?><h2 style="font-family:var(--font-heading);font-size:2.2rem;font-weight:700;line-height:1.25;margin-bottom:15px;color:var(--black);"><?php echo nl2br(esc_html($headline)); ?></h2><?php endif; ?>
                        <?php if($period): ?><p style="font-size:.82rem;color:#666;letter-spacing:1.5px;font-weight:600;margin-bottom:20px;"><?php echo esc_html($period); ?></p><?php endif; ?>
                        <?php if($link): ?><a href="<?php echo esc_url($link); ?>" class="btn-gold" style="margin-top:10px;"><?php esc_html_e('KNOW MORE','phoenix-palassio'); ?></a><?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="pp-slide-full">
                    <?php if(has_post_thumbnail($slide->ID)): ?>
                        <?php echo get_the_post_thumbnail($slide->ID,'full',array('style'=>'width:100%;height:auto;display:block;')); ?>
                    <?php else: ?>
                        <div style="width:100%;height:85vh;background:linear-gradient(135deg,#1a1a2e,#0d1b2a);"></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; endif; ?>
    <div class="pp-hero-dots" id="slider-dots"></div>
</div>
<script>
(function(){
    var slides=document.querySelectorAll('.pp-hero-slide');
    var dotsWrap=document.getElementById('slider-dots');
    var cur=0;
    if(slides.length<2)return;
    slides.forEach(function(_,i){
        var d=document.createElement('button');
        d.className='pp-hero-dot'+(i===0?' active':'');
        d.addEventListener('click',function(){go(i);});
        dotsWrap.appendChild(d);
    });
    function go(n){
        slides[cur].classList.remove('active');
        document.querySelectorAll('.pp-hero-dot')[cur].classList.remove('active');
        cur=(n+slides.length)%slides.length;
        slides[cur].classList.add('active');
        document.querySelectorAll('.pp-hero-dot')[cur].classList.add('active');
    }
    setInterval(function(){go(cur+1);},5000);
})();
</script>

<!-- FOR THE FASHIONISTA IN YOU -->
<section class="fashionista-section">
    <div class="container">
        <h2 class="section-title">For The Fashionista In You</h2>
        <div class="brand-carousel-wrapper" style="position:relative;overflow:hidden;">
            <div class="brand-carousel-track" id="fashionista-track">
                <?php
                $fashion_brands = get_posts( array(
                    'post_type'      => 'brand',
                    'posts_per_page' => 8,
                    'post_status'    => 'publish',
                ) );
                if ( empty( $fashion_brands ) ) :
                    $demo_fb = array( 'Lifestyle', 'Shoppers Stop', 'Westside', 'Forever 21', 'H&M', 'Zara' );
                    foreach ( $demo_fb as $bname ) : ?>
                        <div class="brand-card">
                            <div style="width:220px;height:200px;background:var(--gray-light);display:flex;align-items:center;justify-content:center;">
                                <span style="font-weight:700;font-size:1.1rem;color:var(--black);"><?php echo esc_html( $bname ); ?></span>
                            </div>
                            <div class="brand-card-info">
                                <p style="font-size:.8rem;font-weight:600;margin-bottom:6px;"><?php echo esc_html( $bname ); ?></p>
                                <a href="<?php echo esc_url( get_post_type_archive_link( 'brand' ) ); ?>" class="btn-gold">GO TO STORE</a>
                            </div>
                        </div>
                    <?php endforeach;
                else :
                    foreach ( $fashion_brands as $brand ) : ?>
                        <div class="brand-card">
                            <?php if ( has_post_thumbnail( $brand->ID ) ) {
                                echo get_the_post_thumbnail( $brand->ID, 'brand-card' );
                            } ?>
                            <div class="brand-card-info">
                                <p style="font-size:.8rem;font-weight:600;margin-bottom:6px;"><?php echo esc_html( $brand->post_title ); ?></p>
                                <a href="<?php echo esc_url( get_permalink( $brand->ID ) ); ?>" class="btn-gold">GO TO STORE</a>
                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
        <div class="carousel-nav">
            <button class="carousel-btn" id="fashionista-prev"><i class="fa-solid fa-chevron-left"></i></button>
            <div class="carousel-dots" id="fashionista-dots"></div>
            <button class="carousel-btn" id="fashionista-next"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- FOR THE FOOD CONNOISSEUR IN YOU -->
<section class="food-section">
    <div class="food-section-bg"></div>
    <div class="container" style="position:relative;">
        <h2 class="section-title">For The Food Connoisseur In You</h2>
        <div class="restaurant-cards">
            <?php
            $restaurants = get_posts( array(
                'post_type'      => 'restaurant',
                'posts_per_page' => 4,
                'post_status'    => 'publish',
            ) );
            if ( empty( $restaurants ) ) :
                $demo_r = array(
                    array( 'name' => 'Ishaara',     'timing' => '7:00AM - 11:00PM', 'type' => 'Restaurant | Second Floor' ),
                    array( 'name' => 'Dobaraa',     'timing' => '11:00AM - 11:00PM','type' => 'Restaurant | Second Floor' ),
                    array( 'name' => 'EIGHT',       'timing' => '11:00AM - 11:00PM','type' => 'Restaurant | Second Floor' ),
                    array( 'name' => 'Punjab Grill','timing' => '11:00AM - 11:00PM','type' => 'Restaurant | Second Floor' ),
                );
                foreach ( $demo_r as $r ) : ?>
                    <div class="restaurant-card">
                        <div style="width:100%;height:120px;background:var(--dark-mid);display:flex;align-items:center;justify-content:center;">
                            <span style="color:#fff;font-weight:600;"><?php echo esc_html( $r['name'] ); ?></span>
                        </div>
                        <div class="restaurant-card-body">
                            <h4><?php echo esc_html( $r['name'] ); ?></h4>
                            <div class="timing"><i class="fa-regular fa-clock"></i><?php echo esc_html( $r['timing'] ); ?></div>
                            <?php echo phoenix_veg_nonveg_badges( true, true ); ?>
                            <p class="floor-info"><?php echo esc_html( $r['type'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach;
            else :
                foreach ( $restaurants as $restaurant ) :
                    $timing = get_post_meta( $restaurant->ID, '_restaurant_timing', true );
                    $floor  = get_post_meta( $restaurant->ID, '_restaurant_floor', true );
                    $type   = get_post_meta( $restaurant->ID, '_restaurant_type_text', true );
                    $veg    = ( get_post_meta( $restaurant->ID, '_restaurant_veg', true ) === '1' );
                    $nonveg = ( get_post_meta( $restaurant->ID, '_restaurant_nonveg', true ) === '1' );
                    if ( $type && $floor ) { $tf = $type . ' | ' . $floor; } elseif ( $type ) { $tf = $type; } else { $tf = $floor; }
                    ?>
                    <div class="restaurant-card">
                        <?php if ( has_post_thumbnail( $restaurant->ID ) ) {
                            echo get_the_post_thumbnail( $restaurant->ID, 'brand-card' );
                        } ?>
                        <div class="restaurant-card-body">
                            <h4><?php echo esc_html( $restaurant->post_title ); ?></h4>
                            <?php if ( $timing ) : ?>
                                <div class="timing"><i class="fa-regular fa-clock"></i><?php echo esc_html( $timing ); ?></div>
                            <?php endif; ?>
                            <?php echo phoenix_veg_nonveg_badges( $veg, $nonveg ); ?>
                            <?php if ( $tf ) : ?>
                                <p class="floor-info"><?php echo esc_html( $tf ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
        <div style="text-align:center;margin-top:20px;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'restaurant' ) ); ?>" class="btn-gold"><?php esc_html_e( 'EXPLORE ALL RESTAURANTS', 'phoenix-palassio' ); ?></a>
        </div>
    </div>
</section>

<!-- BRANDS MARQUEE -->
<section class="brands-marquee-section">
    <div class="container">
        <div class="brands-marquee-wrapper">
            <div class="brands-marquee-track" id="brands-marquee">
                <?php
                $all_brands = get_posts( array( 'post_type' => 'brand', 'posts_per_page' => 20, 'post_status' => 'publish' ) );
                $brand_names = array( 'LifeStyles', 'FOREVER 21', 'Hush Puppies', 'HiDesign', 'Jack & Jones', 'Clarks', 'Da Milano', 'BIBA', 'AND' );
                if ( ! empty( $all_brands ) ) :
                    foreach ( array( $all_brands, $all_brands ) as $brand_set ) :
                        foreach ( $brand_set as $b ) :
                            if ( has_post_thumbnail( $b->ID ) ) :
                                echo get_the_post_thumbnail( $b->ID, array( 120, 40 ), array( 'alt' => esc_attr( $b->post_title ) ) );
                            else : ?>
                                <span style="font-weight:700;font-size:.9rem;color:var(--gray-dark);white-space:nowrap;padding:0 10px;"><?php echo esc_html( $b->post_title ); ?></span>
                            <?php endif;
                        endforeach;
                    endforeach;
                else :
                    $double = array_merge( $brand_names, $brand_names );
                    foreach ( $double as $bname ) : ?>
                        <span style="font-weight:700;font-size:.9rem;color:var(--gray-dark);white-space:nowrap;padding:0 10px;"><?php echo esc_html( $bname ); ?></span>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
        <div class="brands-marquee-footer">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'brand' ) ); ?>" class="btn-outline-gold">200+ BRANDS</a>
        </div>
    </div>
</section>

<!-- BLOGS -->
<section class="blogs-section">
    <div class="container">
        <h2 class="section-title">Blogs</h2>
        <div class="blogs-grid">
            <?php
            $blogs = get_posts( array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
            ) );
            foreach ( $blogs as $blog ) : ?>
                <article class="blog-card">
                    <a href="<?php echo esc_url( get_permalink( $blog->ID ) ); ?>">
                        <?php if ( has_post_thumbnail( $blog->ID ) ) :
                            echo get_the_post_thumbnail( $blog->ID, 'blog-thumb' );
                        else : ?>
                            <div style="width:100%;height:200px;background:var(--gray-light);display:flex;align-items:center;justify-content:center;">
                                <i class="fa-regular fa-image" style="font-size:2rem;color:var(--gray);"></i>
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="blog-card-body">
                        <h3><a href="<?php echo esc_url( get_permalink( $blog->ID ) ); ?>"><?php echo esc_html( $blog->post_title ); ?></a></h3>
                        <p class="blog-date"><?php echo get_the_date( 'd M Y', $blog->ID ); ?></p>
                        <a href="<?php echo esc_url( get_permalink( $blog->ID ) ); ?>" class="btn-gold"><?php esc_html_e( 'READ MORE', 'phoenix-palassio' ); ?></a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center;margin-top:30px;">
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn-outline-gold"><?php esc_html_e( 'EXPLORE ALL BLOGS', 'phoenix-palassio' ); ?></a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
