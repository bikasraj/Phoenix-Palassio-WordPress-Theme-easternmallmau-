<?php
/**
 * Template Name: Gift Card Page
 */
get_header();
?>

<div style="background:linear-gradient(135deg,#0f0f1a,#1a1a3e,#0a2a50);padding:80px 0;text-align:center;color:#fff;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;opacity:.15;"></div>
    <div style="position:relative;z-index:1;" class="container">
        <h1 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:700;margin-bottom:15px;"><?php esc_html_e( 'BE SPOILT FOR CHOICE', 'phoenix-palassio' ); ?></h1>
        <p style="font-size:1.1rem;color:rgba(255,255,255,.8);max-width:500px;margin:0 auto 10px;"><?php esc_html_e( 'EXPERIENCE HAVING IT ALL', 'phoenix-palassio' ); ?></p>
        <a href="#buy-card" class="btn-gold" style="margin-top:25px;"><?php esc_html_e( 'BUY CARD', 'phoenix-palassio' ); ?></a>
    </div>
</div>

<?php phoenix_breadcrumb(); ?>

<!-- About Card -->
<section style="padding:60px 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
            <div>
                <h2 style="font-family:var(--font-heading);font-size:1.8rem;font-weight:600;margin-bottom:15px;"><?php esc_html_e( 'About card', 'phoenix-palassio' ); ?></h2>
                <p style="color:var(--gray-dark);line-height:1.8;margin-bottom:20px;"><?php esc_html_e( 'Phoenix Gift Cards give you the freedom to shop from a wide choice of brands, dine-in & enjoy all the entertainment.', 'phoenix-palassio' ); ?></p>
                <a href="#buy-card" class="btn-gold" id="buy-card"><?php esc_html_e( 'Buy Card', 'phoenix-palassio' ); ?></a>
            </div>
            <div style="background:linear-gradient(135deg,var(--gold-dark),var(--gold));border-radius:12px;height:200px;display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid fa-credit-card" style="font-size:5rem;color:rgba(255,255,255,.6);"></i>
            </div>
        </div>
    </div>
</section>

<!-- Why Buy -->
<section style="padding:60px 0;background:var(--off-white);">
    <div class="container">
        <h2 style="font-family:var(--font-heading);font-size:2rem;text-align:center;margin-bottom:50px;"><?php esc_html_e( 'Why buy a Phoenix Gift Card?', 'phoenix-palassio' ); ?></h2>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:30px;">
            <?php
            $why_items = array(
                array(
                    'icon'  => 'fa-bag-shopping',
                    'title' => 'Enjoy shopping above and beyond your imagination',
                    'desc'  => 'Shop from 200+ premium brands and experience retail therapy like never before at Phoenix Palassio.',
                ),
                array(
                    'icon'  => 'fa-users',
                    'title' => "There's so much more for the whole family to enjoy",
                    'desc'  => 'From entertainment to fine dining, there is something for every member of your family.',
                ),
                array(
                    'icon'  => 'fa-utensils',
                    'title' => 'Truly delicious, tangy food just a swipe away',
                    'desc'  => 'Redeem your gift card at our wide range of restaurants and food courts across the mall.',
                ),
            );
            foreach ( $why_items as $item ) : ?>
                <div style="background:var(--white);border-radius:8px;overflow:hidden;box-shadow:var(--shadow);">
                    <div style="height:160px;background:linear-gradient(135deg,var(--gold-dark),var(--gold));display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid <?php echo esc_attr( $item['icon'] ); ?>" style="font-size:3rem;color:rgba(255,255,255,.8);"></i>
                    </div>
                    <div style="padding:20px;">
                        <h3 style="font-size:1rem;font-weight:700;margin-bottom:10px;line-height:1.4;"><?php echo esc_html( $item['title'] ); ?></h3>
                        <p style="font-size:.85rem;color:var(--gray-dark);line-height:1.7;"><?php echo esc_html( $item['desc'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Corporate Enquiry -->
<section style="padding:60px 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
            <div style="background:var(--gold);padding:40px;border-radius:8px;">
                <h3 style="font-size:1.2rem;font-weight:700;color:#fff;margin-bottom:20px;"><?php esc_html_e( 'Corporate Enquiry', 'phoenix-palassio' ); ?></h3>
                <form method="post">
                    <input type="text" name="corp_name" placeholder="<?php esc_attr_e( 'Your Name', 'phoenix-palassio' ); ?>" style="width:100%;padding:12px 15px;background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);color:#fff;border-radius:4px;margin-bottom:12px;font-size:.85rem;outline:none;display:block;">
                    <input type="email" name="corp_email" placeholder="<?php esc_attr_e( 'Your Email', 'phoenix-palassio' ); ?>" style="width:100%;padding:12px 15px;background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);color:#fff;border-radius:4px;margin-bottom:12px;font-size:.85rem;outline:none;display:block;">
                    <input type="text" name="corp_company" placeholder="<?php esc_attr_e( 'Company Name', 'phoenix-palassio' ); ?>" style="width:100%;padding:12px 15px;background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);color:#fff;border-radius:4px;margin-bottom:12px;font-size:.85rem;outline:none;display:block;">
                    <input type="text" name="corp_amount" placeholder="<?php esc_attr_e( 'Amount Required', 'phoenix-palassio' ); ?>" style="width:100%;padding:12px 15px;background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);color:#fff;border-radius:4px;margin-bottom:12px;font-size:.85rem;outline:none;display:block;">
                    <textarea name="corp_message" placeholder="<?php esc_attr_e( 'Your Message', 'phoenix-palassio' ); ?>" rows="4" style="width:100%;padding:12px 15px;background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);color:#fff;border-radius:4px;margin-bottom:12px;font-size:.85rem;outline:none;resize:vertical;display:block;"></textarea>
                    <?php wp_nonce_field( 'phoenix_corporate_enquiry', 'corp_nonce' ); ?>
                    <button type="submit" style="background:var(--black);color:#fff;padding:12px 28px;border-radius:4px;font-weight:700;font-size:.85rem;cursor:pointer;border:none;"><?php esc_html_e( 'SUBMIT', 'phoenix-palassio' ); ?></button>
                </form>
            </div>
            <div>
                <p style="font-size:1.1rem;font-style:italic;line-height:1.9;color:var(--gray-dark);text-align:center;">
                    <?php esc_html_e( 'Phoenix Gift Card is a unique way for corporates to gift their employees, vendors and clients. It gives the receiver the freedom to shop from a wide range of brands, dine-in & enjoy all the entertainment.', 'phoenix-palassio' ); ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- FAQs -->
<section style="padding:60px 0;background:var(--off-white);">
    <div class="container">
        <h2 style="font-family:var(--font-heading);font-size:2rem;text-align:center;margin-bottom:40px;"><?php esc_html_e( 'Phoenix Gift Card - FAQs', 'phoenix-palassio' ); ?></h2>
        <div class="faq-list">
            <?php
            $faqs = array(
                array( 'q' => 'What is Phoenix Gift card?',                                        'a' => 'Phoenix Gift Card is a prepaid stored-value card which gives you the freedom to shop from a wide choice of brands, dine-in & enjoy all the entertainment at Phoenix Palassio.' ),
                array( 'q' => 'Where can I use this card?',                                        'a' => 'You can use the Phoenix Gift Card at all participating outlets in the mall. Check at the concierge for the list of accepted stores.' ),
                array( 'q' => 'How can I check the balance of the card?',                          'a' => 'You can check your card balance at any of our concierge desks within the mall or call our helpline.' ),
                array( 'q' => 'What is the validity of Phoenix Gift Card?',                        'a' => 'The Phoenix Gift Card is valid for 1 year from the date of purchase.' ),
                array( 'q' => 'What if I do not know the PIN for my Gift Card?',                   'a' => 'Please visit our concierge desk with your gift card and a valid ID proof for PIN reset assistance.' ),
                array( 'q' => 'Can I get a Phoenix Gift card refund?',                             'a' => 'Phoenix Gift Cards are non-refundable and non-transferable. The balance cannot be redeemed for cash.' ),
                array( 'q' => 'What are the denominations available for the Phoenix Gift Card?',   'a' => 'Phoenix Gift Cards are available in denominations of Rs.500, Rs.1000, Rs.2000, Rs.5000 and Rs.10,000.' ),
            );
            foreach ( $faqs as $faq ) : ?>
                <div class="faq-item">
                    <div class="faq-question">
                        <span><?php echo esc_html( $faq['q'] ); ?></span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer"><?php echo esc_html( $faq['a'] ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
