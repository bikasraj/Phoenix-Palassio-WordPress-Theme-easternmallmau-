/**
 * Phoenix Palassio - Main JavaScript
 */

jQuery(document).ready(function($) {

    /* ============================================
       HERO SLIDER
    ============================================ */
    var currentSlide = 0;
    var $slides = $('.hero-slide');
    var totalSlides = $slides.length;

    if (totalSlides > 1) {
        // Build dots
        var dotsHtml = '';
        for (var i = 0; i < totalSlides; i++) {
            dotsHtml += '<span class="slider-dot' + (i === 0 ? ' active' : '') + '" data-index="' + i + '"></span>';
        }
        $('#slider-dots').html(dotsHtml);

        // Auto advance
        var sliderInterval = setInterval(function() {
            nextSlide();
        }, 5000);

        // Dot click
        $(document).on('click', '.slider-dot', function() {
            currentSlide = parseInt($(this).data('index'));
            showSlide(currentSlide);
            clearInterval(sliderInterval);
            sliderInterval = setInterval(nextSlide, 5000);
        });

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        function showSlide(index) {
            $slides.removeClass('active');
            $slides.eq(index).addClass('active');
            $('.slider-dot').removeClass('active');
            $('.slider-dot[data-index="' + index + '"]').addClass('active');
        }
    }

    /* ============================================
       FASHIONISTA CAROUSEL
    ============================================ */
    var $track = $('#fashionista-track');
    var $items = $track.children();
    var itemsPerView = 4;
    var totalItems = $items.length;
    var currentCarousel = 0;
    var itemWidth = 0;

    function initCarousel() {
        itemWidth = $track.parent().width() / itemsPerView + 20;
        // Build dots
        var numDots = Math.ceil(totalItems / itemsPerView);
        var dotsHtml = '';
        for (var i = 0; i < numDots; i++) {
            dotsHtml += '<span class="carousel-dot' + (i === 0 ? ' active' : '') + '" data-ci="' + i + '"></span>';
        }
        $('#fashionista-dots').html(dotsHtml);
    }

    function moveCarousel(direction) {
        var maxStep = Math.ceil(totalItems / itemsPerView) - 1;
        currentCarousel = Math.max(0, Math.min(currentCarousel + direction, maxStep));
        var offset = currentCarousel * (itemWidth * itemsPerView);
        $track.css('transform', 'translateX(-' + offset + 'px)');
        $('.carousel-dot').removeClass('active');
        $('.carousel-dot[data-ci="' + currentCarousel + '"]').addClass('active');
    }

    $('#fashionista-next').on('click', function() { moveCarousel(1); });
    $('#fashionista-prev').on('click', function() { moveCarousel(-1); });
    $(document).on('click', '.carousel-dot', function() {
        var ci = parseInt($(this).data('ci'));
        currentCarousel = ci - 1;
        moveCarousel(1);
    });

    if ($track.length) initCarousel();

    /* ============================================
       MOBILE MENU
    ============================================ */
    $('#mobile-menu-toggle').on('click', function() {
        $('#mobile-nav').addClass('open');
        $('body').css('overflow', 'hidden');
    });

    $('#mobile-nav-close').on('click', function() {
        $('#mobile-nav').removeClass('open');
        $('body').css('overflow', '');
    });

    /* ============================================
       SEARCH OVERLAY
    ============================================ */
    $('#search-toggle').on('click', function() {
        $('#search-overlay').addClass('open').css({
            'position': 'fixed',
            'top': '0',
            'left': '0',
            'right': '0',
            'bottom': '0',
            'background': 'rgba(0,0,0,0.9)',
            'z-index': '9999',
            'display': 'flex',
            'align-items': 'center',
            'justify-content': 'center',
        });
        $('#search-overlay .search-form').css({'width': '600px', 'max-width': '90%'});
        $('body').css('overflow', 'hidden');
    });

    $('#search-close').on('click', function() {
        $('#search-overlay').removeClass('open').hide();
        $('body').css('overflow', '');
    });

    /* ============================================
       BRAND FILTER (Brands Page)
    ============================================ */
    $(document).on('click', '.filter-tab', function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        var filter = $(this).data('filter');

        if (filter === 'all') {
            $('.brand-item').show();
        } else {
            $('.brand-item').each(function() {
                var cat = $(this).data('brand-cat');
                if (cat && cat.indexOf(filter) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        updateBrandCount();
    });

    // Brand search
    $('#brand-search-btn').on('click', function() { filterBrandsBySearch(); });
    $('#brand-search-input').on('keyup', function(e) {
        if (e.key === 'Enter') filterBrandsBySearch();
    });

    function filterBrandsBySearch() {
        var query = $('#brand-search-input').val().toLowerCase().trim();
        if (!query) {
            $('.brand-item').show();
        } else {
            $('.brand-item').each(function() {
                var name = $(this).data('brand-name') || '';
                if (name.indexOf(query) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        updateBrandCount();
    }

    function updateBrandCount() {
        var visible = $('.brand-item:visible').length;
        $('#brands-num').text(visible);
    }

    /* ============================================
       CONCIERGE TABS
    ============================================ */
    $(document).on('click', '.concierge-tab', function() {
        var tab = $(this).data('tab');
        $('.concierge-tab').removeClass('active');
        $(this).addClass('active');
        $('.concierge-tab-content').hide();
        $('#tab-' + tab).show();
    });

    /* ============================================
       FAQ ACCORDION
    ============================================ */
    $(document).on('click', '.faq-question', function() {
        var $item = $(this).closest('.faq-item');
        $item.toggleClass('open');
        if ($item.hasClass('open')) {
            $item.find('.faq-answer').slideDown(200);
        } else {
            $item.find('.faq-answer').slideUp(200);
        }
    });

    /* ============================================
       NEWSLETTER FORM
    ============================================ */
    $('#footer-newsletter-form').on('submit', function(e) {
        e.preventDefault();
        var email = $(this).find('input[type="email"]').val();
        var nonce = $(this).find('#phoenix_newsletter_nonce').val();

        $.post(phoenixAjax.ajaxUrl, {
            action: 'phoenix_newsletter',
            email: email,
            nonce: nonce,
        }, function(response) {
            if (response.success) {
                $('.newsletter-message').text(response.data.message).show();
                $('#footer-newsletter-form input[type="email"]').val('');
            } else {
                $('.newsletter-message').text(response.data.message).show();
            }
        });
    });

    /* ============================================
       STICKY HEADER
    ============================================ */
    var $header = $('#site-header');
    var headerOffset = $('.top-bar').outerHeight() || 0;

    $(window).on('scroll', function() {
        if ($(window).scrollTop() > headerOffset) {
            $header.addClass('scrolled').css('box-shadow', '0 2px 20px rgba(0,0,0,0.15)');
        } else {
            $header.removeClass('scrolled').css('box-shadow', '0 2px 10px rgba(0,0,0,0.1)');
        }
    });

    /* ============================================
       SMOOTH SCROLL
    ============================================ */
    $('a[href*="#"]').not('[href="#"]').on('click', function(e) {
        var target = this.hash;
        if ($(target).length) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: $(target).offset().top - 80 }, 600);
        }
    });

    /* ============================================
       VIEW MORE - BRANDS
    ============================================ */
    var brandsPerPage = 12;
    var $allBrands = $('.brand-item');
    var totalBrands = $allBrands.length;

    if (totalBrands > brandsPerPage) {
        $allBrands.slice(brandsPerPage).hide();
        $('#brands-view-more').on('click', function(e) {
            e.preventDefault();
            $allBrands.show();
            $(this).parent().hide();
        });
    } else {
        $('#brands-view-more-wrap').hide();
    }

    /* ============================================
       SEARCH OVERLAY DISPLAY
    ============================================ */
    var $searchOverlay = $('#search-overlay');
    $searchOverlay.css({'display': 'none'});
    $searchOverlay.find('.search-form').css({
        'max-width': '600px',
        'width': '100%',
    });
    $searchOverlay.find('input[type="search"]').css({
        'width': '100%',
        'padding': '15px 20px',
        'font-size': '1.2rem',
        'border': 'none',
        'outline': 'none',
        'border-radius': '4px',
    });
    $searchOverlay.find('.search-submit').css({
        'padding': '12px 25px',
        'background': 'var(--gold)',
        'color': '#fff',
        'border': 'none',
        'border-radius': '4px',
        'margin-top': '10px',
        'cursor': 'pointer',
        'font-weight': '700',
    });

    // Style the search close button
    var $sc = $('#search-close');
    $sc.css({
        'position': 'absolute',
        'top': '20px',
        'right': '20px',
        'color': '#fff',
        'font-size': '2rem',
        'cursor': 'pointer',
        'background': 'none',
        'border': 'none',
    });

    /* ============================================
       ACTIVE MENU ITEM
    ============================================ */
    var currentPath = window.location.pathname;
    $('.main-nav a').each(function() {
        if ($(this).attr('href') && $(this).attr('href') !== '#' && currentPath.indexOf($(this).attr('href')) !== -1) {
            $(this).closest('li').addClass('current-menu-item');
        }
    });

});
