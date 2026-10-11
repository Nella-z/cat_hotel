<?php
function theme_asset_version($path) {
    $file = get_stylesheet_directory() . $path;
    return file_exists($file) ? filemtime($file) : false;
}

add_action('wp_enqueue_scripts', function () {
    $uri = get_stylesheet_directory_uri();
    
    wp_enqueue_style('theme-google-fonts', 'https://fonts.googleapis.com/css2?family=Bad+Script&family=Caveat:wght@400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Philosopher:ital,wght@0,400;0,700;1,400;1,700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap', array(), null);
    wp_enqueue_style('theme-swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css', array(), '12');
    wp_enqueue_style('theme-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4');

    wp_enqueue_style('theme-reset', $uri . '/assets/css/reset.css', array(), theme_asset_version('/assets/css/reset.css'));
    wp_enqueue_style('theme-style', $uri . '/assets/css/style.css', array('theme-reset', 'theme-google-fonts', 'theme-swiper', 'theme-leaflet'), theme_asset_version('/assets/css/style.css'));

    wp_enqueue_script('theme-swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js', array(), '12', true);
    wp_enqueue_script('theme-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true);

    wp_enqueue_script('theme-main', $uri . '/assets/js/main.js', array('jquery', 'theme-swiper', 'theme-leaflet'), theme_asset_version('/assets/js/main.js'), true);
    
    wp_localize_script('theme-main', 'theme_vars', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
         'images_url' => get_stylesheet_directory_uri() . '/assets/images' 
    ));
});

add_filter('show_admin_bar', '__return_true');
add_theme_support('post-thumbnails');
add_theme_support('custom-logo');
add_theme_support('title-tag');
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
