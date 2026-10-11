<?php
// 1. Исправлена версия файла (возвращаем false вместо null, если файла нет)
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
       // Заменяем ajax_vars на theme_vars и добавляем images_url
    wp_localize_script('theme-main', 'theme_vars', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
        'images_url' => get_stylesheet_directory_uri() . '/images' // Путь к папке images
    ));
});

add_filter('show_admin_bar', '__return_true');
add_theme_support('post-thumbnails');
add_theme_support('custom-logo');
add_theme_support('title-tag');
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));


function create_number_post_type() {
    register_post_type('number', array(
        'labels' => array(
            'name' => 'Номера',
            'singular_name' => 'Номер',
            'add_new' => 'Добавить номер',
            'edit_item' => 'Редактировать номер',
            'all_items' => 'Все номера',
            'menu_name' => 'Номера'
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-admin-home',
        'supports' => array('title', 'thumbnail'),
        'has_archive' => false,
    ));
}
add_action('init', 'create_number_post_type');


// 4. Добавление метабокса
function add_number_metabox() {
    add_meta_box(
        'number_details',
        'Карточка Номера',
        'render_number_metabox',
        'number',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_number_metabox');

function render_number_metabox($post) {
    wp_nonce_field('save_number_data', 'number_nonce');

    $fields = array(
        'start_price' => 'Начальная цена (стоимость права аренды):',
        'auction_step' => 'Шаг аукциона:',
        'rent_period' => 'Срок аренды:'
    );

    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<p><strong>' . esc_html($label) . '</strong><br>';
        echo '<textarea name="' . esc_attr($key) . '" rows="2" style="width:100%">' . esc_textarea($value) . '</textarea></p>';
    }

}

// 5. НОВАЯ ФУНКЦИЯ: Сохранение данных метабокса при обновлении записи
add_action('save_post', 'save_number_meta_data');
function save_number_meta_data($post_id) {
    // Проверка nonce
    if (!isset($_POST['number_nonce']) || !wp_verify_nonce($_POST['number_nonce'], 'save_number_data')) {
        return;
    }
    // Игнорируем автосохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Проверка прав пользователя
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Сохранение текстовых полей
    $fields = array('start_price', 'auction_step', 'rent_period', 'date_place', 'organizer', 'basis', 'subject', 'participation_rules', 'contact_info');
    foreach ($fields as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_textarea_field($_POST[$key]));
        }
    }

    // Сохранение галереи (массива URL)
    if (isset($_POST['number_gallery']) && is_array($_POST['number_gallery'])) {
        $clean_images = array();
        foreach ($_POST['number_gallery'] as $url) {
            $clean_url = esc_url_raw($url);
            if (!empty($clean_url)) {
                $clean_images[] = $clean_url;
            }
        }
        update_post_meta($post_id, 'number_gallery', $clean_images);
    } else {
        delete_post_meta($post_id, 'number_gallery');
    }
}

// 6. НОВАЯ ФУНКЦИЯ: Подключение медиазагрузчика и JS для кнопок "Выбрать" и "Удалить"
add_action('admin_enqueue_scripts', 'enqueue_admin_media_scripts_for_numbers');
function enqueue_admin_media_scripts_for_numbers($hook) {
    global $post;
    // Загружаем скрипты только при редактировании нашего типа записи
    if (($hook == 'post-new.php' || $hook == 'post.php') && isset($post->post_type) && $post->post_type === 'number') {
        wp_enqueue_media(); // Подключаем стандартный медиазагрузчик WP
        
        // Добавляем необходимый JS для работы кнопок
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Функция добавления нового поля для фото
            window.addImageField = function(containerId) {
                var html = '<p><input type="text" name="number_gallery[]" value="" style="width:70%" readonly /> <a href="#" class="upload-image button">Выбрать</a> <a href="#" class="remove-image" style="color:red; margin-left:5px;">Удалить</a></p>';
                $('#' + containerId).append(html);
            };

            // Обработчик кнопки "Выбрать"
            $(document).on('click', '.upload-image', function(e) {
                e.preventDefault();
                var $button = $(this);
                var custom_uploader = wp.media({
                    title: 'Выберите изображение',
                    button: { text: 'Использовать это изображение' },
                    multiple: false
                }).on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    $button.prev('input').val(attachment.url);
                }).open();
            });

            // Обработчик кнопки "Удалить"
            $(document).on('click', '.remove-image', function(e) {
                e.preventDefault();
                $(this).parent('p').remove();
            });
        });
        </script>
        <?php
    }
}