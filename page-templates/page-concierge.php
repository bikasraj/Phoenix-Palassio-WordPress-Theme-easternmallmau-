<?php
/**
 * Template Name: Concierge Services Page
 */
get_header();
?>

<div class="page-hero concierge-hero">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'hero-banner' ); } ?>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <h1><?php esc_html_e( 'Concierge Services', 'phoenix-palassio' ); ?></h1>
        <p><?php esc_html_e( 'We understand the needs of our customers & provide multiple services at our Concierge desk.', 'phoenix-palassio' ); ?></p>
    </div>
</div>

<?php phoenix_breadcrumb(); ?>

<section class="concierge-section">
    <div class="container">
        <div class="concierge-header">
            <h2><?php esc_html_e( 'Mall Services', 'phoenix-palassio' ); ?></h2>
            <div class="concierge-phone">
                <i class="fa-solid fa-phone"></i>
                <span><?php echo esc_html( phoenix_get_option( 'mall_phone', '0522-6667700' ) ); ?></span>
            </div>
        </div>

        <div class="concierge-tabs" id="concierge-tabs">
            <button class="concierge-tab active" data-tab="in-mall"><?php esc_html_e( 'IN-MALL EXPERIENCE', 'phoenix-palassio' ); ?></button>
            <button class="concierge-tab" data-tab="parking"><?php esc_html_e( 'PARKING & TRANSPORT', 'phoenix-palassio' ); ?></button>
            <button class="concierge-tab" data-tab="differently-abled"><?php esc_html_e( 'SERVICES FOR DIFFERENTLY ABLED', 'phoenix-palassio' ); ?></button>
            <button class="concierge-tab" data-tab="emergency"><?php esc_html_e( 'EMERGENCY SUPPORT', 'phoenix-palassio' ); ?></button>
        </div>

        <!-- IN-MALL -->
        <div class="concierge-tab-content" id="tab-in-mall">
            <div class="concierge-services-grid">
                <?php
                $in_mall = array(
                    array( 'icon' => 'fa-shield-halved',        'name' => '24 hour on site security'          ),
                    array( 'icon' => 'fa-circle-info',          'name' => 'HELP DESK'                         ),
                    array( 'icon' => 'fa-tablet-screen-button', 'name' => 'Digital directory'                 ),
                    array( 'icon' => 'fa-wifi',                 'name' => 'Free WiFi'                         ),
                    array( 'icon' => 'fa-suitcase',             'name' => 'DIGITAL BAGGAGE LOCKERS'           ),
                    array( 'icon' => 'fa-map',                  'name' => 'Mall guide'                        ),
                    array( 'icon' => 'fa-smoking',              'name' => 'Smoking zone'                      ),
                    array( 'icon' => 'fa-wheelchair',           'name' => 'Wheel chair'                       ),
                    array( 'icon' => 'fa-shoe-prints',          'name' => 'Shoe shiner Machine'               ),
                    array( 'icon' => 'fa-magnifying-glass',     'name' => 'Lost and found'                    ),
                    array( 'icon' => 'fa-gift',                 'name' => 'Gift packing'                      ),
                    array( 'icon' => 'fa-scissors',             'name' => 'Garment alteration service'        ),
                    array( 'icon' => 'fa-baby-carriage',        'name' => 'Child Care Rooms'                  ),
                    array( 'icon' => 'fa-charging-station',     'name' => 'EV Charging Station with DC Facility' ),
                    array( 'icon' => 'fa-droplet',              'name' => 'Drinking water'                    ),
                    array( 'icon' => 'fa-cart-shopping',        'name' => 'Kiddie carts'                      ),
                    array( 'icon' => 'fa-taxi',                 'name' => 'Cab booking'                       ),
                    array( 'icon' => 'fa-tag',                  'name' => 'Kids Safety Tags'                  ),
                    array( 'icon' => 'fa-couch',                'name' => 'VIP Lounge'                        ),
                    array( 'icon' => 'fa-person-carry-box',     'name' => 'Porter Services'                   ),
                    array( 'icon' => 'fa-mobile-screen',        'name' => 'Mobile Charging Station'           ),
                    array( 'icon' => 'fa-car',                  'name' => 'Car Spa Services / Vulcanizer On Call' ),
                    array( 'icon' => 'fa-wind',                 'name' => 'Aroma Architecture'                ),
                );
                foreach ( $in_mall as $s ) : ?>
                    <div class="concierge-service-item">
                        <div class="concierge-service-icon"><i class="fa-solid <?php echo esc_attr( $s['icon'] ); ?>"></i></div>
                        <h4><?php echo esc_html( $s['name'] ); ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- PARKING -->
        <div class="concierge-tab-content" id="tab-parking" style="display:none;">
            <div class="concierge-services-grid">
                <?php
                $parking = array(
                    array( 'icon' => 'fa-square-parking',   'name' => 'Ample Parking Space' ),
                    array( 'icon' => 'fa-car',               'name' => 'Valet Parking'       ),
                    array( 'icon' => 'fa-charging-station',  'name' => 'EV Charging'         ),
                    array( 'icon' => 'fa-taxi',              'name' => 'Taxi Assistance'     ),
                    array( 'icon' => 'fa-bus',               'name' => 'Bus Facility'        ),
                    array( 'icon' => 'fa-motorcycle',        'name' => 'Bike Parking'        ),
                );
                foreach ( $parking as $s ) : ?>
                    <div class="concierge-service-item">
                        <div class="concierge-service-icon"><i class="fa-solid <?php echo esc_attr( $s['icon'] ); ?>"></i></div>
                        <h4><?php echo esc_html( $s['name'] ); ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- DIFFERENTLY ABLED -->
        <div class="concierge-tab-content" id="tab-differently-abled" style="display:none;">
            <div class="concierge-services-grid">
                <?php
                $da = array(
                    array( 'icon' => 'fa-wheelchair',      'name' => 'Wheelchair Assistance' ),
                    array( 'icon' => 'fa-elevator',        'name' => 'Elevator Access'       ),
                    array( 'icon' => 'fa-accessible-icon', 'name' => 'Accessible Restrooms'  ),
                    array( 'icon' => 'fa-person-walking',  'name' => 'Personal Assistance'   ),
                );
                foreach ( $da as $s ) : ?>
                    <div class="concierge-service-item">
                        <div class="concierge-service-icon"><i class="fa-solid <?php echo esc_attr( $s['icon'] ); ?>"></i></div>
                        <h4><?php echo esc_html( $s['name'] ); ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- EMERGENCY -->
        <div class="concierge-tab-content" id="tab-emergency" style="display:none;">
            <div class="concierge-services-grid">
                <?php
                $emergency = array(
                    array( 'icon' => 'fa-fire-extinguisher',    'name' => 'Fire Safety'          ),
                    array( 'icon' => 'fa-kit-medical',          'name' => 'First Aid'            ),
                    array( 'icon' => 'fa-truck-medical',        'name' => 'Medical Emergency'    ),
                    array( 'icon' => 'fa-shield',               'name' => 'Security Response'    ),
                    array( 'icon' => 'fa-triangle-exclamation', 'name' => 'Emergency Evacuation' ),
                    array( 'icon' => 'fa-phone',                'name' => '24/7 Helpline'        ),
                );
                foreach ( $emergency as $s ) : ?>
                    <div class="concierge-service-item">
                        <div class="concierge-service-icon"><i class="fa-solid <?php echo esc_attr( $s['icon'] ); ?>"></i></div>
                        <h4><?php echo esc_html( $s['name'] ); ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<?php get_footer(); ?>
