<?php

/**
 * Custom configuration
 */

function tc_register_newsletter_cpt()
{
    $labels = array(
        'name' => 'Newsletter',
        'singular_name' => 'Boletín',
        'menu_name' => 'Newsletter',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nuevo boletín',
        'edit_item' => 'Editar newsletter',
        'new_item' => 'Nuevo newsletter',
        'view_item' => 'Ver newsletter',
        'all_items' => 'Todos los newsletter',
        'search_items' => 'Buscar newsletter',
        'not_found' => 'No se encontraron newsletter',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'newsletter'),
        'supports' => array('title', 'editor', 'custom-fields', 'comments', 'author'),
        'menu_icon' => 'dashicons-email-alt',
    );

    register_post_type('newsletter', $args);
}
add_action('init', 'tc_register_newsletter_cpt');

function tc_enqueue_styles()
{
    wp_enqueue_style(
        'tailwind',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        array(),
        filemtime(get_stylesheet_directory()) . '/assets/css/style.css'
    );
}
add_action('wp_enqueue_scripts', 'tc_enqueue_styles');

function tc_google_adsense_script()
{
    if (wp_get_environment_type() === 'production') {
        // Google Adsense
        echo "
        <script async src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7144863238088863'
     crossorigin='anonymous'></script>
        ";
    }
}
add_action('wp_head', 'tc_google_adsense_script');

function tc_tracking_scripts()
{
    if (wp_get_environment_type() === 'production') {
        // Google Analytics
        echo "
        <!-- Google Analytics -->
        <script async src='https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID'></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'G-VS5CTEJ19C');
        </script>
        ";

        // Facebook pixel
        echo "
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '321230706915370');
          fbq('track', 'PageView');
        </script>
        <noscript><img height='1' width='1' style='display:none'
          src='https://www.facebook.com/tr?id=321230706915370&ev=PageView&noscript=1'
        /></noscript>
        ";
    }
}
add_action('wp_head', 'tc_tracking_scripts');

function tc_share_scripts()
{
    // ShareThis
    echo "
    <!-- ShareThis -->
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=674e3af256a0480019dfed6c&product=inline-share-buttons&source=platformhttps://platform-api.sharethis.com/js/sharethis.js#property=674e3af256a0480019dfed6c&product=inline-share-buttons&source=platformhttps://platform-api.sharethis.com/js/sharethis.js#property=674e3af256a0480019dfed6c&product=inline-share-buttons&source=platform' async='async'></script>
    ";
}
add_action('wp_head', 'tc_share_scripts');

function tc_enqueue_scripts()
{
    wp_enqueue_script(
        'subscribe-script',
        get_stylesheet_directory_uri() . '/assets/js/sendySubscribe.js',
        array(),
        filemtime(get_stylesheet_directory()) . '/assets/js/sendySubscribe.js',
        true
    );
}
add_action('wp_enqueue_scripts', 'tc_enqueue_scripts');

function tc_customize_body_classes($classes) {
    if (is_woocommerce()) {
        $classes = array_filter($classes, function($class) {
            return strpos($class, 'woocommerce') === false;
        });
    }
    return $classes;
}
add_filter('body_class', 'tc_customize_body_classes');

function tc_insert_subšcription_form($content)
{
    ob_start();
    get_template_part('template-parts/newsletter-form');
    $subscribe_form = ob_get_clean();

    if (is_singular('post')) {
        $content = $subscribe_form . $content;
    }

    return $content;
}
add_filter('the_content', 'tc_insert_subšcription_form');

function tc_add_share_buttons_after_content($content)
{
    if (is_singular('post')) {
        $share_buttons = '<div class="sharethis-inline-share-buttons dark:text-white mt-12"></div>';

        $content .= $share_buttons;
    }

    return $content;
}
add_filter('the_content', 'tc_add_share_buttons_after_content');

function tc_get_subscribers_count()
{
    $api_url = 'https://sendy.todoconta.com/api/subscribers/active-subscriber-count.php';
    $api_key = '5a7Ijeup4Dmx0S3QghQ3';
    $list_id = 'BuYr892LzE0bp763NocnWz4hxA';

    $response = wp_remote_post($api_url, array(
        'body' => array(
            'api_key' => $api_key,
            'list_id' => $list_id,
        )
    ));

    if (is_wp_error($response)) {
        return 0;
    }

    $body = wp_remote_retrieve_body($response);
    return intval($body);
}