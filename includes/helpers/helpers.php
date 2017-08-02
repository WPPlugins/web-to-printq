<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    require_once PRINTQ_HELPERS_DIR . 'design.php';
    require_once PRINTQ_HELPERS_DIR . 'gallery.php';

    /**
     * @param string $file
     *
     * @return string
     */
    function pqd_js_url( $file = '' ) {
        if( $file ) {
            return PRINTQ_JS_URL . $file;
        } else {
            return '';
        }
    }


    /**
     * @param string $file
     *
     * @return string
     */
    function pqd_css_url( $file = '' ) {
        if( $file ) {
            return PRINTQ_CSS_URL . $file;
        } else {
            return '';
        }
    }

    function pqd_template_exists( $template_id ) {
        global $wpdb;

        return $wpdb->get_var( $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d  AND post_type = 'pqd_template'", $template_id ) );
    }

    function pqd_get_config( $name, $default = null ) {
        if( is_multisite() ) {
            $options = get_blog_option( get_current_blog_id(), 'pqd', array() );
        } else {
            $options = get_option( 'pqd', array() );
        }

        if( isset( $options[$name] ) ) {
            return $options[$name];
        }

        return $default;
    }

    function pqd_is_active() {
        return pqd_get_config( 'api_key' ) == 'd4e50764774e29872485766e00424390';
    }

    function pqd_get_current_post_type() {
        global $post, $typenow, $current_screen;

        //we have a post so we can just get the post type from that
        if( $post && $post->post_type ) {
            return $post->post_type;
        } //check the global $typenow - set in admin.php
        elseif( $typenow ) {
            return $typenow;
        } //check the global $current_screen object - set in sceen.php
        elseif( $current_screen && $current_screen->post_type ) {
            return $current_screen->post_type;
        } //lastly check the post_type querystring
        elseif( isset( $_REQUEST['post_type'] ) ) {
            return sanitize_key( $_REQUEST['post_type'] );
        }

        //we do not know the post type!
        return null;
    }

    function pqd_get_models() {
        $models = array();
        if( pqd_is_active() ) {
            $files = glob( PRINTQ_3D_MODELS_DIR . '*.php' );
            foreach( $files as $file ) {
                $model_data         = pathinfo( $file );
                $model_data['id']   = $model_data['basename'];
                $model_data['name'] = preg_replace( '/(\.\w+)$/', '', $model_data['basename'] );
                $models[]           = $model_data;
            }
        }

        return $models;
    }

    function pqd_get_image_ext_from_url( $photo_url ) {
        $url = parse_url( $photo_url );
        $ext = '';

        if( isset( $url['path'] ) ) {
            preg_match( '/\.([a-zA-Z]{0,4})$/', $url['path'], $matches );
            //facebook, instagram
            if( count( $matches ) ) {
                $ext .= $matches[1];

                return $ext;
            }
        }
        if( isset( $url['query'] ) ) {
            //might be unsplash image
            parse_str( $url['query'], $query_vars );
            if( isset( $query_vars['fm'] ) ) {
                $ext .= $query_vars['fm'];

                return $ext;
            }
        }
        //try to get extension from headers
        $headers      = get_headers( $photo_url, true );
        $content_type = isset( $headers['Content-Type'] ) ? $headers['Content-Type'] : '';
        $imageTypes   = array(
            'image/jpeg' => 'jpeg',
            'image/jpg'  => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif'
        );
        if( $content_type && array_key_exists( $content_type, $imageTypes ) ) {
            $ext .= $imageTypes[$content_type];

            return $ext;
        }

        return $ext;
    }
