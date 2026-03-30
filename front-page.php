<?php
/**
 * Front Page Template - Phoenix Palassio
 * Exact replica of phoenixpalassio.com homepage
 */
get_header();
?>

<!-- ============================================================
     HERO SLIDER — Dono layouts full screen width fit
============================================================ -->
<style>
/* Hero slider — full width, no gaps */
.pp-hero-wrap {
    position: relative;
    width: 100%;
    line-height: 0;
    overflow: hidden;
    background: #111;
}
.pp-hero-slide {
    display: none;
    width: 100%;
}
.pp-hero-slide.active {
    display: block;
}
/* SPLIT layout — image left, text right */
.pp-slide-split {
    display: flex;
    width: 100%;
    min-height: 85vh;
}
.pp-slide-split .pp-slide-img {
    width: 50%;
    overflow: hidden;
    flex-shrink: 0;
}
.pp-slide-split .pp-slide-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    min-height: 85vh;
}
.pp-slide-split .pp-slide-content {
    width: 50%;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 50px;
    text-align: center;
}
/* FULL WIDTH layout — image only, 100% width, natural height */
.pp-slide-full {
    width: 100%;
    line-height: 0;
}
.pp-slide-full img {
    width: 100%;
    height: auto;
    display: block;
}
/* Hero dots */
.pp-hero-dots {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 20;
}
.pp-hero-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255,255,255,.5);
    border: none;
    cursor: pointer;
    padding: 0;
    transition: all .25s;
}
.pp-hero-dot.active {
    background: var(--gold);
    transform: scale(1.25);
}
/* Responsive */
@media (max-width: 768px) {
    .pp-slide-split { flex-direction: column; min-height: auto; }
    .pp-slide-split .pp-slide-img,
    .pp-slide-split .pp-slide-content { width: 100%; }
    .pp-slide-split .pp-slide-img img { min-height: 260px; max-height: 50vw; }
    .pp-slide-split .pp-slide-content { padding: 35px 25px; }
    .pp-slide-split .pp-slide-content h2 { font-size: 1.5rem !important; }
}
</style>

<div class="pp-hero-wrap" id="hero-slider">

    <?php
    $slides = get_posts( array(
        'post_type'      => 'slide',
        'posts_per_page' => 10,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ) );

    if ( empty( $slides ) ) :
    ?>
        <!-- Demo slide — no slides in DB yet -->
        <div class="pp-hero-slide active" data-index="0">
            <div class="pp-slide-split">
                <div class="pp-slide-img" style="background:linear-gradient(135deg,#f5f0e8,#d4c4a0);min-height:85vh;display:flex;align-items:center;justify-content:center;">
                    <p style="color:#8a6914;font-weight:700;letter-spacing:3px;font-size:.9rem;">PHOENIX PALASSIO</p>
                </div>
                <div class="pp-slide-content">
                    <img src="<?php echo esc_url( PHOENIX_PALASSIO_URI . '/images/logo.svg' ); ?>" alt="Phoenix Palassio" style="height:55px;margin-bottom:20px;" onerror="this.style.display='none'">
                    <h2 style="font-family:var(--font-heading);font-size:2.2rem;font-weight:700;line-height:1.2;margin-bottom:15px;color:var(--black);">SHOP WORTH &#8377;25,000 &amp; GET AN ASSURED SMART WATCH*</h2>
                    <p style="font-size:.82rem;color:#666;letter-spacing:1px;font-weight:600;">02<sup>ND</sup> MAR &ndash; 31<sup>ST</sup> MAR 2026</p>
                </div>
            </div>
        </div>

    <?php else :
        foreach ( $slides as $i => $slide ) :
            $headline   = get_post_meta( $slide->ID, '_slide_headline', true );
            $offer_text = get_post_meta( $slide->ID, '_slide_offer_text', true );
            $period     = get_post_meta( $slide->ID, '_slide_offer_period', true );
            $layout     = get_post_meta( $slide->ID, '_slide_layout', true );
            $link       = get_post_meta( $slide->ID, '_slide_link', true );
            if ( ! $layout ) { $layout = 'split'; }
            $active_class = ( $i === 0 ) ? ' active' : '';
    ?>
        <div class="pp-hero-slide<?php echo $active_class; ?>" data-index="<?php echo intval( $i ); ?>">

            <?php if ( 'split' === $layout ) : ?>
                <!-- SPLIT layout: left=image, right=text — full screen height -->
                <div class="pp-slide-split">
                    <div class="pp-slide-img">
                        <?php if ( has_post_thumbnail( $slide->ID ) ) : ?>
                            <?php echo get_the_post_thumbnail( $slide->ID, 'full', array( 'style' => 'width:100%;height:100%;object-fit:cover;display:block;min-height:85vh;' ) ); ?>
                        <?php else : ?>
                            <div style="width:100%;min-height:85vh;background:linear-gradient(135deg,#f5f0e8,#d4c4a0);"></div>
                        <?php endif; ?>
                    </div>
                    <div class="pp-slide-content">
                        <img src="<?php echo esc_url( PHOENIX_PALASSIO_URI . '/images/logo.svg' ); ?>" alt="Phoenix Palassio" style="height:55px;margin-bottom:20px;" onerror="this.style.display='none'">
                        <?php if ( $headline ) : ?>
                            <h2 style="font-family:var(--font-heading);font-size:2.2rem;font-weight:700;line-height:1.25;margin-bottom:15px;color:var(--black);"><?php echo nl2br( esc_html( $headline ) ); ?></h2>
                        <?php endif; ?>
                        <?php if ( $period ) : ?>
                            <p style="font-size:.82rem;color:#666;letter-spacing:1.5px;font-weight:600;margin-bottom:20px;"><?php echo esc_html( $period ); ?></p>
                        <?php endif; ?>
                        <?php if ( $link ) : ?>
                            <a href="<?php echo esc_url( $link ); ?>" class="btn-gold" style="margin-top:10px;"><?php esc_html_e( 'KNOW MORE', 'phoenix-palassio' ); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else : ?>
                <!-- FULL WIDTH layout: sirf image, 100% width, natural height, koi text nahi -->
                <div class="pp-slide-full">
                    <?php if ( has_post_thumbnail( $slide->ID ) ) : ?>
                        <?php echo get_the_post_thumbnail( $slide->ID, 'full', array( 'style' => 'width:100%;height:auto;display:block;' ) ); ?>
                    <?php else : ?>
                        <div style="width:100%;height:85vh;background:linear-gradient(135deg,#1a1a2e,#0d1b2a);"></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    <?php endforeach;
    endif; ?>

    <!-- Dots -->
    <div class="pp-hero-dots" id="slider-dots"></div>
</div>

<script>
(function(){
    var slides   = document.querySelectorAll('.pp-hero-slide');
    var dotsWrap = document.getElementById('slider-dots');
    var cur      = 0;
    if ( slides.length < 2 ) return;

    /* Build dots */
    slides.forEach(function(_, i){
        var d = document.createElement('button');
        d.className = 'pp-hero-dot' + (i===0?' active':'');
        d.addEventListener('click', function(){ go(i); });
        dotsWrap.appendChild(d);
    });

    function go(n){
        slides[cur].classList.remove('active');
        document.querySelectorAll('.pp-hero-dot')[cur].classList.remove('active');
        cur = (n + slides.length) % slides.length;
        slides[cur].classList.add('active');
        document.querySelectorAll('.pp-hero-dot')[cur].classList.add('active');
    }

    setInterval(function(){ go(cur+1); }, 5000);
})();
</script>


<!-- ============================================================
     FOR THE FASHIONISTA IN YOU
     Screenshot 2: Carousel with brand images — full bleed cards, "SEE MORE" buttons
     Nav arrows + dots below AND above next section
============================================================ -->
<section style="padding:50px 0 40px;background:#fff;">
    <div class="container">
        <h2 style="font-family:var(--font-heading);font-size:2rem;font-weight:600;text-align:center;margin-bottom:30px;letter-spacing:.5px;">For The Fashionista In You</h2>

        <div style="position:relative;">
            <!-- Carousel track -->
            <div style="overflow:hidden;">
                <div id="fashionista-track" style="display:flex;gap:0;transition:transform .4s ease;will-change:transform;">
                    <?php
                    $fashion_brands = get_posts( array(
                        'post_type'      => 'brand',
                        'posts_per_page' => 12,
                        'post_status'    => 'publish',
                    ) );

                    if ( empty( $fashion_brands ) ) :
                        $demo = array(
                            array( 'name' => 'Lifestyle',      'bg' => '#f5f0e8' ),
                            array( 'name' => 'The Collective', 'bg' => '#e8f0f5' ),
                            array( 'name' => 'Forever 21',     'bg' => '#f5e8f0' ),
                            array( 'name' => 'Westside',       'bg' => '#e8f5e8' ),
                            array( 'name' => 'H&M',            'bg' => '#f0e8f5' ),
                            array( 'name' => 'Zara',           'bg' => '#f5f5e8' ),
                        );
                        foreach ( $demo as $b ) : ?>
                            <div class="fashionista-slide" style="min-width:25%;position:relative;overflow:hidden;">
                                <div style="background:<?php echo esc_attr( $b['bg'] ); ?>;height:380px;display:flex;flex-direction:column;align-items:flex-start;justify-content:flex-end;padding:20px;position:relative;">
                                    <div style="position:absolute;top:15px;left:15px;background:rgba(0,0,0,.75);color:#fff;padding:6px 14px;font-size:.75rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;"><?php echo esc_html( $b['name'] ); ?></div>
                                    <a href="<?php echo esc_url( home_url( '/brands/' ) ); ?>" class="btn-gold" style="font-size:.72rem;padding:12px 24px;letter-spacing:2px;">SEE MORE</a>
                                </div>
                            </div>
                        <?php endforeach;
                    else :
                        foreach ( $fashion_brands as $brand ) :
                            $permalink = get_permalink( $brand->ID );
                    ?>
                            <div class="fashionista-slide" style="min-width:25%;position:relative;overflow:hidden;">
                                <div style="height:380px;position:relative;overflow:hidden;background:var(--gray-light);">
                                    <?php if ( has_post_thumbnail( $brand->ID ) ) : ?>
                                        <?php echo get_the_post_thumbnail( $brand->ID, 'restaurant-card', array( 'style' => 'width:100%;height:100%;object-fit:cover;display:block;' ) ); ?>
                                    <?php else : ?>
                                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f0ece4;">
                                            <span style="font-size:1.3rem;font-weight:800;color:#333;text-align:center;padding:20px;"><?php echo esc_html( $brand->post_title ); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Brand name label top left -->
                                    <div style="position:absolute;top:15px;left:15px;background:rgba(0,0,0,.75);color:#fff;padding:6px 14px;font-size:.72rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;"><?php echo esc_html( $brand->post_title ); ?></div>
                                    <!-- SEE MORE button bottom -->
                                    <div style="position:absolute;bottom:20px;left:50%;transform:translateX(-50%);">
                                        <a href="<?php echo esc_url( $permalink ); ?>" class="btn-gold" style="font-size:.72rem;padding:12px 28px;letter-spacing:2px;display:block;white-space:nowrap;">SEE MORE</a>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>

        <!-- Nav: arrows + dots — exactly like screenshot 2 -->
        <div style="display:flex;align-items:center;justify-content:center;gap:12px;margin-top:22px;">
            <button id="fashionista-prev" style="background:none;border:none;cursor:pointer;font-size:1rem;color:#333;padding:5px 10px;">&#8249;</button>
            <div id="fashionista-dots" style="display:flex;gap:7px;"></div>
            <button id="fashionista-next" style="background:none;border:none;cursor:pointer;font-size:1rem;color:#333;padding:5px 10px;">&#8250;</button>
        </div>
    </div>
</section>


<!-- ============================================================
     FOR THE FOOD CONNOISSEUR IN YOU
     Screenshot 3: Dark full-width bg with people dining photo,
     4 restaurant cards overlay on top, carousel dots + arrows below
============================================================ -->
<section id="food-section" style="position:relative;padding:50px 0 60px;overflow:hidden;">

    <!-- Full-bleed background image with dark overlay -->
    <div style="position:absolute;inset:0;z-index:0;">
        <?php
        $food_bg_post = get_posts( array( 'post_type' => 'restaurant', 'posts_per_page' => 1, 'post_status' => 'publish' ) );
        ?>
        <div style="position:absolute;inset:0;background:linear-gradient(to bottom, rgba(10,10,10,.55) 0%, rgba(10,10,10,.45) 100%);z-index:1;"></div>
        <div style="position:absolute;inset:0;background:url('') center/cover no-repeat;z-index:0;" id="food-bg-div"></div>
        <!-- Fallback dark gradient -->
        <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a0a00 0%,#2a1500 50%,#0a0a00 100%);z-index:-1;"></div>
    </div>

    <div class="container" style="position:relative;z-index:2;">
        <h2 style="font-family:var(--font-heading);font-size:2rem;font-weight:600;text-align:center;margin-bottom:35px;color:#fff;letter-spacing:.5px;">For The Food Connoisseur In You</h2>

        <!-- Restaurant cards — 4 per view, white card style -->
        <div style="position:relative;">
            <div style="overflow:hidden;">
                <div id="food-track" style="display:flex;gap:20px;transition:transform .4s ease;">
                    <?php
                    $restaurants = get_posts( array(
                        'post_type'      => 'restaurant',
                        'posts_per_page' => 12,
                        'post_status'    => 'publish',
                    ) );

                    if ( empty( $restaurants ) ) :
                        $demo_r = array(
                            array( 'name' => 'Ishaara',     'timing' => '11:00AM - 11:00PM' ),
                            array( 'name' => 'Dobaraa',     'timing' => '11:00AM - 11:00PM' ),
                            array( 'name' => 'EIGHT',       'timing' => '11:00AM - 11:00PM' ),
                            array( 'name' => 'Punjab Grill','timing' => '9:00AM - 11:00PM'  ),
                            array( 'name' => 'KFC',         'timing' => '11:00AM - 9:00PM'  ),
                            array( 'name' => 'Pizza Hut',   'timing' => '11:00AM - 11:00PM' ),
                            array( 'name' => 'Burger King', 'timing' => '11:00AM - 11:00PM' ),
                            array( 'name' => 'Subway',      'timing' => '11:00AM - 11:00PM' ),
                        );
                        foreach ( $demo_r as $r ) : ?>
                            <div class="food-slide" style="min-width:calc(25% - 15px);flex-shrink:0;">
                                <div style="background:#fff;border-radius:6px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.25);">
                                    <div style="height:160px;background:#ddd;display:flex;align-items:center;justify-content:center;">
                                        <span style="font-weight:700;color:#555;"><?php echo esc_html( $r['name'] ); ?></span>
                                    </div>
                                    <div style="padding:14px 16px;">
                                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                                            <h4 style="font-size:.92rem;font-weight:700;color:#111;"><?php echo esc_html( $r['name'] ); ?></h4>
                                            <div style="text-align:right;">
                                                <p style="font-size:.7rem;color:#666;line-height:1.5;"><?php echo esc_html( $r['timing'] ); ?><br><?php echo esc_html( $r['timing'] ); ?></p>
                                            </div>
                                        </div>
                                        <div style="display:flex;gap:6px;">
                                            <span style="width:10px;height:10px;border-radius:50%;background:#27ae60;display:inline-block;"></span>
                                            <span style="width:10px;height:10px;border-radius:50%;background:#e74c3c;display:inline-block;"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                    else :
                        foreach ( $restaurants as $rest ) :
                            $timing = get_post_meta( $rest->ID, '_restaurant_timing', true );
                            $floor  = get_post_meta( $rest->ID, '_restaurant_floor', true );
                            $veg    = ( get_post_meta( $rest->ID, '_restaurant_veg', true ) === '1' );
                            $nonveg = ( get_post_meta( $rest->ID, '_restaurant_nonveg', true ) === '1' );
                    ?>
                            <div class="food-slide" style="min-width:calc(25% - 15px);flex-shrink:0;">
                                <div style="background:#fff;border-radius:6px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.25);">
                                    <?php if ( has_post_thumbnail( $rest->ID ) ) : ?>
                                        <?php echo get_the_post_thumbnail( $rest->ID, 'brand-card', array( 'style' => 'width:100%;height:160px;object-fit:cover;display:block;' ) ); ?>
                                    <?php else : ?>
                                        <div style="height:160px;background:linear-gradient(135deg,#1a1a1a,#333);display:flex;align-items:center;justify-content:center;">
                                            <span style="color:#fff;font-weight:700;font-size:.9rem;"><?php echo esc_html( $rest->post_title ); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div style="padding:14px 16px;">
                                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;gap:8px;">
                                            <h4 style="font-size:.92rem;font-weight:700;color:#111;flex-shrink:0;"><?php echo esc_html( $rest->post_title ); ?></h4>
                                            <?php if ( $timing ) : ?>
                                                <div style="text-align:right;flex-shrink:0;">
                                                    <p style="font-size:.68rem;color:#777;line-height:1.6;"><?php echo esc_html( $timing ); ?><br><?php echo esc_html( $timing ); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div style="display:flex;gap:6px;align-items:center;">
                                            <?php if ( $veg ) : ?>
                                                <span style="width:10px;height:10px;border-radius:50%;background:#27ae60;display:inline-block;flex-shrink:0;"></span>
                                            <?php endif; ?>
                                            <?php if ( $nonveg ) : ?>
                                                <span style="width:10px;height:10px;border-radius:50%;background:#e74c3c;display:inline-block;flex-shrink:0;"></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>

        <!-- Food carousel nav -->
        <div style="display:flex;align-items:center;justify-content:center;gap:12px;margin-top:28px;">
            <button id="food-prev" style="background:none;border:none;cursor:pointer;font-size:1rem;color:#fff;padding:5px 10px;opacity:.8;">&#8249;</button>
            <div id="food-dots" style="display:flex;gap:7px;"></div>
            <button id="food-next" style="background:none;border:none;cursor:pointer;font-size:1rem;color:#fff;padding:5px 10px;opacity:.8;">&#8250;</button>
        </div>

        <!-- Explore All Restaurants button -->
        <div style="text-align:center;margin-top:30px;">
            <a href="<?php echo esc_url( home_url( '/dine/' ) ); ?>" style="display:inline-block;border:1px solid rgba(255,255,255,.6);color:#fff;padding:12px 30px;font-size:.75rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;transition:all .3s;border-radius:3px;" onmouseover="this.style.background='rgba(255,255,255,.15)'" onmouseout="this.style.background='transparent'"><?php esc_html_e( 'EXPLORE ALL RESTAURANTS', 'phoenix-palassio' ); ?></a>
        </div>
    </div>
</section>


<!-- ============================================================
     FEATURED BRANDS CAROUSEL + MARQUEE
     Screenshot 4: Brand cards carousel (image + GO TO STORE) + marquee logos below
============================================================ -->
<section style="padding:50px 0 0;background:#fff;">
    <div class="container">
        <!-- Brand image carousel — same style as fashionista but different brands shown -->
        <div style="position:relative;">
            <div style="overflow:hidden;">
                <div id="brands-carousel-track" style="display:flex;gap:0;transition:transform .4s ease;">
                    <?php
                    $all_brands = get_posts( array(
                        'post_type'      => 'brand',
                        'posts_per_page' => 16,
                        'post_status'    => 'publish',
                        'offset'         => 0,
                    ) );

                    if ( empty( $all_brands ) ) :
                        $demo_b = array(
                            array( 'name' => 'Umar',              'bg' => '#8B6914' ),
                            array( 'name' => 'Monsoon Collection','bg' => '#4a3728' ),
                            array( 'name' => 'M&S',               'bg' => '#e03030' ),
                            array( 'name' => 'Forever New',       'bg' => '#c5a47e' ),
                            array( 'name' => 'Allen Solly',       'bg' => '#1a3a5c' ),
                            array( 'name' => 'Adidas',            'bg' => '#111' ),
                        );
                        foreach ( $demo_b as $b ) : ?>
                            <div class="brands-carousel-slide" style="min-width:25%;flex-shrink:0;position:relative;overflow:hidden;height:380px;">
                                <div style="background:<?php echo esc_attr( $b['bg'] ); ?>;height:100%;display:flex;align-items:flex-end;padding:20px;">
                                    <a href="<?php echo esc_url( home_url('/brands/') ); ?>" class="btn-gold" style="font-size:.72rem;padding:12px 28px;letter-spacing:2px;">GO TO STORE</a>
                                </div>
                            </div>
                        <?php endforeach;
                    else :
                        foreach ( $all_brands as $brand ) : ?>
                            <div class="brands-carousel-slide" style="min-width:25%;flex-shrink:0;position:relative;overflow:hidden;height:380px;">
                                <?php if ( has_post_thumbnail( $brand->ID ) ) : ?>
                                    <?php echo get_the_post_thumbnail( $brand->ID, 'restaurant-card', array( 'style' => 'width:100%;height:100%;object-fit:cover;display:block;position:absolute;inset:0;' ) ); ?>
                                <?php else : ?>
                                    <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a1a1a,#333);display:flex;align-items:center;justify-content:center;">
                                        <span style="color:#fff;font-size:1.3rem;font-weight:800;text-align:center;padding:20px;"><?php echo esc_html( $brand->post_title ); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div style="position:absolute;bottom:20px;left:50%;transform:translateX(-50%);">
                                    <a href="<?php echo esc_url( get_permalink( $brand->ID ) ); ?>" class="btn-gold" style="font-size:.72rem;padding:12px 28px;letter-spacing:2px;white-space:nowrap;display:block;">GO TO STORE</a>
                                </div>
                            </div>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>

        <!-- Nav arrows + dots -->
        <div style="display:flex;align-items:center;justify-content:center;gap:12px;margin-top:22px;">
            <button id="brands-carousel-prev" style="background:none;border:none;cursor:pointer;font-size:1rem;color:#333;padding:5px 10px;">&#8249;</button>
            <div id="brands-carousel-dots" style="display:flex;gap:7px;"></div>
            <button id="brands-carousel-next" style="background:none;border:none;cursor:pointer;font-size:1rem;color:#333;padding:5px 10px;">&#8250;</button>
        </div>
    </div>
</section>

<!-- Brand logos marquee row — like screenshot 4 bottom -->
<section style="padding:28px 0;border-top:1px solid #eee;border-bottom:1px solid #eee;background:#fff;overflow:hidden;">
    <div style="display:flex;align-items:center;overflow:hidden;">
        <div id="brands-marquee" style="display:flex;align-items:center;gap:55px;animation:marqueeScroll 22s linear infinite;white-space:nowrap;width:max-content;">
            <?php
            $marquee_brands = get_posts( array( 'post_type' => 'brand', 'posts_per_page' => 20, 'post_status' => 'publish' ) );
            $demo_logos     = array( 'LifeStyles', 'FOREVER NEW', 'Hush Puppies', 'HIDESIGN', 'JACK&JONES', 'Clarks', 'DA MILANO', 'BIBA', 'AND', 'Adidas', 'Armani Exchange', 'Allen Solly' );

            if ( ! empty( $marquee_brands ) ) :
                $doubled = array_merge( $marquee_brands, $marquee_brands );
                foreach ( $doubled as $mb ) :
                    if ( has_post_thumbnail( $mb->ID ) ) :
                        echo get_the_post_thumbnail( $mb->ID, array( 110, 38 ), array( 'style' => 'height:38px;width:auto;object-fit:contain;filter:grayscale(30%);opacity:.75;flex-shrink:0;', 'alt' => esc_attr( $mb->post_title ) ) );
                    else : ?>
                        <span style="font-size:.85rem;font-weight:800;color:#444;letter-spacing:.5px;flex-shrink:0;"><?php echo esc_html( $mb->post_title ); ?></span>
                    <?php endif;
                endforeach;
            else :
                $doubled = array_merge( $demo_logos, $demo_logos );
                foreach ( $doubled as $logo ) : ?>
                    <span style="font-size:.85rem;font-weight:800;color:#444;letter-spacing:.5px;flex-shrink:0;"><?php echo esc_html( $logo ); ?></span>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
    <div style="text-align:center;margin-top:22px;">
        <a href="<?php echo esc_url( home_url( '/brands/' ) ); ?>" style="display:inline-block;border:1px solid #aaa;color:#333;padding:11px 30px;font-size:.76rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;transition:all .3s;border-radius:2px;" onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold)'" onmouseout="this.style.borderColor='#aaa';this.style.color='#333'">200+ BRANDS</a>
    </div>
</section>


<!-- ============================================================
     BLOGS SECTION
     Screenshot 5: "Blogs" heading + 3 blog cards carousel
     Blog card: full image top, title, date, READ MORE button
============================================================ -->
<section style="padding:55px 0 60px;background:#fff;">
    <div class="container">
        <h2 style="font-family:var(--font-heading);font-size:2rem;font-weight:600;text-align:center;margin-bottom:35px;letter-spacing:.5px;">Blogs</h2>

        <div style="position:relative;overflow:hidden;">
            <div id="blogs-track" style="display:flex;gap:30px;transition:transform .4s ease;">
                <?php
                $blogs = get_posts( array(
                    'post_type'      => 'post',
                    'posts_per_page' => 9,
                    'post_status'    => 'publish',
                ) );

                if ( ! empty( $blogs ) ) :
                    foreach ( $blogs as $blog ) : ?>
                        <div class="blog-carousel-slide" style="min-width:calc(33.333% - 20px);flex-shrink:0;">
                            <article style="overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);border-radius:4px;transition:transform .3s,box-shadow .3s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,.14)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(0,0,0,.08)'">
                                <a href="<?php echo esc_url( get_permalink( $blog->ID ) ); ?>" style="display:block;">
                                    <?php if ( has_post_thumbnail( $blog->ID ) ) : ?>
                                        <?php echo get_the_post_thumbnail( $blog->ID, 'blog-thumb', array( 'style' => 'width:100%;height:220px;object-fit:cover;display:block;' ) ); ?>
                                    <?php else : ?>
                                        <div style="height:220px;background:linear-gradient(135deg,#1a1a2e,#2a2a4e);display:flex;align-items:center;justify-content:center;">
                                            <i class="fa-regular fa-image" style="color:rgba(255,255,255,.3);font-size:2.5rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div style="padding:22px 20px;">
                                    <h3 style="font-family:var(--font-heading);font-size:1rem;font-weight:600;line-height:1.45;margin-bottom:8px;color:#111;">
                                        <a href="<?php echo esc_url( get_permalink( $blog->ID ) ); ?>" style="color:#111;"><?php echo esc_html( $blog->post_title ); ?></a>
                                    </h3>
                                    <p style="font-size:.74rem;color:#999;margin-bottom:16px;"><?php echo get_the_date( 'd M Y', $blog->ID ); ?></p>
                                    <a href="<?php echo esc_url( get_permalink( $blog->ID ) ); ?>" class="btn-gold" style="font-size:.7rem;padding:10px 22px;letter-spacing:2px;"><?php esc_html_e( 'READ MORE', 'phoenix-palassio' ); ?></a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach;
                else : ?>
                    <div style="min-width:100%;text-align:center;padding:40px;color:var(--gray);">
                        <i class="fa-regular fa-newspaper" style="font-size:2rem;margin-bottom:10px;display:block;"></i>
                        <p>Blog posts will appear here after import.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Blog carousel nav -->
        <div style="display:flex;align-items:center;justify-content:center;gap:12px;margin-top:28px;">
            <button id="blogs-prev" style="background:none;border:none;cursor:pointer;font-size:1.1rem;color:#333;padding:5px 10px;opacity:.7;">&#8249;</button>
            <div id="blogs-dots" style="display:flex;gap:7px;"></div>
            <button id="blogs-next" style="background:none;border:none;cursor:pointer;font-size:1.1rem;color:#333;padding:5px 10px;opacity:.7;">&#8250;</button>
        </div>

        <!-- Explore all blogs -->
        <div style="text-align:center;margin-top:28px;">
            <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" style="display:inline-block;border:1px solid #aaa;color:#333;padding:11px 30px;font-size:.76rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;transition:all .3s;border-radius:2px;" onmouseover="this.style.borderColor='var(--gold)';this.style.color='var(--gold)'" onmouseout="this.style.borderColor='#aaa';this.style.color='#333'"><?php esc_html_e( 'EXPLORE ALL BLOGS', 'phoenix-palassio' ); ?></a>
        </div>
    </div>
</section>


<!-- ============================================================
     HOMEPAGE CSS + CAROUSEL JS
============================================================ -->
<style>
/* Marquee animation */
@keyframes marqueeScroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
#brands-marquee:hover { animation-play-state: paused; }

/* Carousel dot styles */
.pp-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #ccc;
    cursor: pointer;
    transition: background .25s, transform .25s;
    border: none;
    padding: 0;
    display: inline-block;
}
.pp-dot.active {
    background: #e74c3c;
    transform: scale(1.25);
}

/* Hero slider dots */
.hero-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255,255,255,.5);
    cursor: pointer;
    border: none;
    padding: 0;
    transition: all .25s;
}
.hero-dot.active { background: var(--gold); transform: scale(1.2); }

/* Fashionista card hover */
.fashionista-slide { transition: transform .3s; }
.fashionista-slide:hover { transform: scale(1.02); z-index: 1; }

/* Brand card hover */
.brands-carousel-slide { transition: filter .3s; }
.brands-carousel-slide:hover { filter: brightness(1.08); }

/* Responsive */
@media (max-width: 900px) {
    .fashionista-slide,
    .brands-carousel-slide { min-width: 50% !important; }
    .food-slide { min-width: calc(50% - 10px) !important; }
    .blog-carousel-slide { min-width: calc(50% - 15px) !important; }
}
@media (max-width: 600px) {
    .fashionista-slide,
    .brands-carousel-slide { min-width: 100% !important; }
    .food-slide { min-width: 85% !important; }
    .blog-carousel-slide { min-width: 90% !important; }
}
</style>

<script>
(function() {

    /* ---- HERO SLIDER ---- */
    var heroSlides = document.querySelectorAll('.hero-slide');
    var heroDotsWrap = document.getElementById('slider-dots');
    var currentHero = 0;
    var heroInterval;

    if (heroSlides.length > 1) {
        heroSlides.forEach(function(_, i) {
            var dot = document.createElement('button');
            dot.className = 'hero-dot' + (i === 0 ? ' active' : '');
            dot.addEventListener('click', function() { goHero(i); });
            heroDotsWrap.appendChild(dot);
        });

        function goHero(n) {
            heroSlides[currentHero].classList.remove('active');
            document.querySelectorAll('.hero-dot')[currentHero].classList.remove('active');
            currentHero = (n + heroSlides.length) % heroSlides.length;
            heroSlides[currentHero].classList.add('active');
            document.querySelectorAll('.hero-dot')[currentHero].classList.add('active');
        }

        heroInterval = setInterval(function() { goHero(currentHero + 1); }, 5000);
    }

    /* ---- GENERIC CAROUSEL FACTORY ---- */
    function makeCarousel(trackId, prevId, nextId, dotsId, perView) {
        var track   = document.getElementById(trackId);
        var prev    = document.getElementById(prevId);
        var next    = document.getElementById(nextId);
        var dotsDiv = document.getElementById(dotsId);
        if (!track || !prev || !next) return;

        var slides    = track.children;
        var total     = slides.length;
        var cur       = 0;
        var maxSlide  = Math.max(0, total - perView);
        var numDots   = Math.ceil(total / perView);

        /* Build dots */
        for (var i = 0; i < numDots; i++) {
            (function(idx) {
                var dot = document.createElement('button');
                dot.className = 'pp-dot' + (idx === 0 ? ' active' : '');
                dot.addEventListener('click', function() { go(idx * perView); });
                dotsDiv.appendChild(dot);
            })(i);
        }

        function updateDots() {
            var activeDotIdx = Math.round(cur / perView);
            var allDots = dotsDiv.querySelectorAll('.pp-dot');
            allDots.forEach(function(d, i) {
                d.classList.toggle('active', i === activeDotIdx);
            });
        }

        function go(n) {
            cur = Math.max(0, Math.min(n, maxSlide));
            var slideW = slides[0] ? slides[0].offsetWidth : 0;
            track.style.transform = 'translateX(-' + (cur * slideW) + 'px)';
            updateDots();
        }

        prev.addEventListener('click', function() { go(Math.max(0, cur - perView)); });
        next.addEventListener('click', function() { go(Math.min(maxSlide, cur + perView)); });

        /* Touch support */
        var startX = 0;
        track.addEventListener('touchstart', function(e) { startX = e.touches[0].clientX; }, {passive:true});
        track.addEventListener('touchend', function(e) {
            var diff = startX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 40) { go(diff > 0 ? cur + perView : cur - perView); }
        }, {passive:true});

        /* Recalc on resize */
        window.addEventListener('resize', function() { go(cur); });
    }

    /* Init all carousels */
    var vw = window.innerWidth;
    var perViewBrands = vw < 600 ? 1 : vw < 900 ? 2 : 4;
    var perViewFood   = vw < 600 ? 1 : vw < 900 ? 2 : 4;
    var perViewBlogs  = vw < 600 ? 1 : vw < 900 ? 2 : 3;

    makeCarousel('fashionista-track',      'fashionista-prev',      'fashionista-next',      'fashionista-dots',      perViewBrands);
    makeCarousel('brands-carousel-track',  'brands-carousel-prev',  'brands-carousel-next',  'brands-carousel-dots',  perViewBrands);
    makeCarousel('food-track',             'food-prev',             'food-next',             'food-dots',             perViewFood);
    makeCarousel('blogs-track',            'blogs-prev',            'blogs-next',            'blogs-dots',            perViewBlogs);

})();
</script>

<?php get_footer(); ?>
