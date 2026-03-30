<?php
/**
 * Footer Template - Phoenix Palassio
 */
?>

<!-- SITE FOOTER -->
<footer class="site-footer">
    <div class="footer-top">
        <div class="container">
            <!-- Logo + Map -->
            <div class="footer-logo-area">
                <a href="<?php echo esc_url( home_url('/') ); ?>">
                    <?php if ( has_custom_logo() ):
                        the_custom_logo();
                    else: ?>
                    <img src="<?php echo PHOENIX_PALASSIO_URI; ?>/images/logo-white.png" alt="Phoenix Palassio" class="footer-logo">
                    <?php endif; ?>
                </a>
                <div class="footer-map">
                    <?php
                    $map_url = phoenix_get_option('mall_map_embed', '');
                    if ( $map_url ): ?>
                    <iframe src="<?php echo esc_url($map_url); ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <?php else: ?>
                    <iframe src="https://maps.google.com/maps?q=Phoenix+Palassio+Lucknow&output=embed" allowfullscreen="" loading="lazy"></iframe>
                    <?php endif; ?>
                </div>
                <div class="footer-transport-btns">
                    <a href="<?php echo esc_url( phoenix_get_option('ola_link', '#') ); ?>" class="btn-transport" target="_blank">OLA</a>
                    <a href="<?php echo esc_url( phoenix_get_option('uber_link', '#') ); ?>" class="btn-transport" target="_blank">UBER</a>
                </div>
            </div>

            <!-- Company Info -->
            <div class="footer-company">
                <h4><?php esc_html_e( 'DESTINY RETAIL MALL DEVELOPERS PRIVATE LIMITED,', 'phoenix-palassio' ); ?></h4>
                <p><strong><?php esc_html_e( 'Lucknow', 'phoenix-palassio' ); ?></strong></p>
                <?php if ( phoenix_get_option('mall_address') ): ?>
                <p>
                    <strong><?php esc_html_e( 'Registered Office Address:', 'phoenix-palassio' ); ?></strong><br>
                    <?php echo nl2br( esc_html( phoenix_get_option('mall_address') ) ); ?>
                </p>
                <?php endif; ?>
                <?php if ( phoenix_get_option('mall_address2') ): ?>
                <p>
                    <strong><?php esc_html_e( 'Mall Address:', 'phoenix-palassio' ); ?></strong><br>
                    <?php echo nl2br( esc_html( phoenix_get_option('mall_address2') ) ); ?>
                </p>
                <?php endif; ?>
            </div>

            <!-- Who We Are -->
            <div class="footer-links-col">
                <h4><?php esc_html_e( 'Who we are', 'phoenix-palassio' ); ?></h4>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'who-we-are',
                    'menu_class'     => '',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        echo '<ul>';
                        $links = array(
                            '#' => 'About Us',
                            '#' => 'Leasing',
                            '#' => 'Tourist',
                            '#' => 'Company Profile',
                        );
                        foreach ( array('About Us', 'Leasing', 'Tourist', 'Company Profile') as $item ) {
                            echo '<li><a href="#">' . esc_html($item) . '</a></li>';
                        }
                        echo '</ul>';
                    },
                ) );
                ?>
            </div>

            <!-- Get Involved -->
            <div class="footer-links-col">
                <h4><?php esc_html_e( 'Get Involved', 'phoenix-palassio' ); ?></h4>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'get-involved',
                    'menu_class'     => '',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        echo '<ul>';
                        foreach ( array('Contact Us', 'Career', 'Terms & Conditions', 'Privacy Policy', 'Investors') as $item ) {
                            echo '<li><a href="#">' . esc_html($item) . '</a></li>';
                        }
                        echo '</ul>';
                    },
                ) );
                ?>
            </div>

            <!-- Latest + Newsletter + Social -->
            <div class="footer-right-col">
                <div class="footer-links-col" style="margin-bottom:25px;">
                    <h4><?php esc_html_e( 'Latest', 'phoenix-palassio' ); ?></h4>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'latest',
                        'menu_class'     => '',
                        'container'      => false,
                        'fallback_cb'    => function() {
                            echo '<ul>';
                            foreach ( array('News', 'Blogs', 'Events') as $item ) {
                                echo '<li><a href="#">' . esc_html($item) . '</a></li>';
                            }
                            echo '</ul>';
                        },
                    ) );
                    ?>
                </div>

                <div class="footer-newsletter">
                    <h4><?php esc_html_e( 'Sign up for offer & event updates', 'phoenix-palassio' ); ?></h4>
                    <form class="newsletter-form" id="footer-newsletter-form" method="post">
                        <input type="email" name="email" placeholder="hello@gmail.com" required>
                        <button type="submit" aria-label="Subscribe"><i class="fa-solid fa-arrow-right"></i></button>
                        <?php wp_nonce_field('phoenix_nonce', 'phoenix_newsletter_nonce'); ?>
                    </form>
                    <div class="newsletter-message" style="display:none;font-size:0.78rem;margin-top:8px;color:var(--gold);"></div>
                </div>

                <div class="footer-social" style="margin-top:25px;">
                    <h4><?php esc_html_e( 'Follow Us', 'phoenix-palassio' ); ?></h4>
                    <div class="footer-social-links">
                        <?php if ( phoenix_get_option('facebook_url') ): ?>
                        <a href="<?php echo esc_url( phoenix_get_option('facebook_url') ); ?>" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if ( phoenix_get_option('twitter_url') ): ?>
                        <a href="<?php echo esc_url( phoenix_get_option('twitter_url') ); ?>" target="_blank" aria-label="Twitter/X"><i class="fab fa-x-twitter"></i></a>
                        <?php endif; ?>
                        <?php if ( phoenix_get_option('instagram_url') ): ?>
                        <a href="<?php echo esc_url( phoenix_get_option('instagram_url') ); ?>" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if ( phoenix_get_option('youtube_url') ): ?>
                        <a href="<?php echo esc_url( phoenix_get_option('youtube_url') ); ?>" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p>
                &copy; <?php echo esc_html( date('Y') ); ?> <?php echo esc_html( get_bloginfo('name') ); ?>.
                <?php esc_html_e( 'All Rights Reserved.', 'phoenix-palassio' ); ?>
                <?php if ( function_exists('get_privacy_policy_url') && get_privacy_policy_url() ) : ?>
                    | <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'phoenix-palassio' ); ?></a>
                <?php endif; ?>
                | <a href="<?php echo esc_url( home_url('/terms-conditions/') ); ?>"><?php esc_html_e( 'Terms &amp; Conditions', 'phoenix-palassio' ); ?></a>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
