<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    define( 'PQD_DOMAIN', 'printq_designer' );

    //must end with /
    define( 'PRINTQ_REST_URI', 'http://personalisation.cloudlab.ag/wp_personalization/public/' );

    define( 'PRINTQ_INCLUDES_DIR', dirname( __FILE__ ) . DIRECTORY_SEPARATOR );

    $upload_dir = wp_upload_dir();

    define( 'PRINTQ_UPLOAD_DIR', $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'pqd' . DIRECTORY_SEPARATOR );
    define( 'PRINTQ_UPLOAD_PREVIEWS_DIR', PRINTQ_UPLOAD_DIR . 'previews' . DIRECTORY_SEPARATOR );
    define( 'PRINTQ_UPLOAD_URL', $upload_dir['baseurl'] . '/pqd/' );
    define( 'PRINTQ_UPLOAD_PREVIEWS_URL', PRINTQ_UPLOAD_URL . 'previews/' );

    define( 'PRINTQ_LANG_DIR', PRINTQ_ROOT . 'languages' . DIRECTORY_SEPARATOR );
    define( 'PRINTQ_CONTROLLERS_DIR', PRINTQ_INCLUDES_DIR . 'controllers' . DIRECTORY_SEPARATOR );
    define( 'PRINTQ_VIEWS_DIR', PRINTQ_ROOT . 'views' . DIRECTORY_SEPARATOR );
    define( 'PRINTQ_HELPERS_DIR', PRINTQ_INCLUDES_DIR . 'helpers' . DIRECTORY_SEPARATOR );
    define( 'PRINTQ_ASSETS_DIR', PRINTQ_ROOT . 'assets' . DIRECTORY_SEPARATOR );
    define( 'PRINTQ_FONTS_DIR', PRINTQ_ASSETS_DIR . 'fonts' . DIRECTORY_SEPARATOR );
    define( 'PRINTQ_SHAPES_DIR', PRINTQ_ASSETS_DIR . 'shapes' . DIRECTORY_SEPARATOR );
    define( 'PRINTQ_3D_MODELS_DIR', PRINTQ_ASSETS_DIR . '3d_models' . DIRECTORY_SEPARATOR );

    define( 'PRINTQ_ASSETS_URL', PRINTQ_URL . 'assets/' );
    define( 'PRINTQ_3D_MODELS_URL', PRINTQ_ASSETS_URL . '3d_models/' );
    define( 'PRINTQ_FONTS_URL', PRINTQ_ASSETS_URL . 'fonts/' );
    define( 'PRINTQ_SHAPES_URL', PRINTQ_ASSETS_URL . 'shapes/' );
    define( 'PRINTQ_CSS_URL', PRINTQ_ASSETS_URL . 'css/' );
    define( 'PRINTQ_JS_URL', PRINTQ_ASSETS_URL . 'js/' );
    define( 'PRINTQ_IMG_URL', PRINTQ_ASSETS_URL . 'images/' );

    require_once PRINTQ_HELPERS_DIR . 'helpers.php';
