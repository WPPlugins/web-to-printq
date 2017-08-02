<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    class Printq_Designer_Public {

        /**
         * @var string
         * @since 1.0.0
         */
        private $plugin_name;

        /**
         * @var string
         * @since 1.0.0
         */
        private $version;

        /**
         * @var Printq_Designer_Loader
         * @since 1.0.0
         */
        private $loader;

        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         *
         * @param      string                 $plugin_name The name of this plugin.
         * @param      string                 $version     The version of this plugin.
         * @param      Printq_Designer_Loader $loader
         */
        public function __construct( $plugin_name, $version, $loader ) {
            $this->plugin_name = $plugin_name;
            $this->version     = $version;
            $this->loader      = $loader;

            $this->define_front_hooks();
        }

        /**
         * Register the stylesheets for the front area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles() {
            wp_enqueue_style( 'pqd_front_css', pqd_css_url( 'frontend.min.css' ), array(), $this->version, 'all' );
        }

        /**
         * Register the JavaScript for the front area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts() {
        }

        private function define_front_hooks() {
            $this->loader->add_action( 'init', $this, 'personalize', 10 );
            $this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
            $this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );
            $this->loader->add_filter( 'woocommerce_cart_item_thumbnail', $this, 'change_item_preview', 10, 2 );

            $this->loader->add_action( 'woocommerce_after_add_to_cart_button', $this, 'after_add_to_cart' );
            $this->loader->add_filter( 'woocommerce_loop_add_to_cart_link', $this, 'change_add_to_cart_link', 10, 2 );
        }

        public function personalize() {
            if( isset( $_REQUEST['pqd_personalize'] ) && $_REQUEST['pqd_personalize'] ) {
                require_once PRINTQ_CONTROLLERS_DIR . 'design.php';

                $controller = new Printq_Controller_Design();
                $controller->indexAction();
                exit;
            }

            //map direct actions
            if( isset( $_REQUEST['pqd'] ) && ( $req = sanitize_text_field( $_REQUEST['pqd'] ) ) ) {
                $controller_file = PRINTQ_CONTROLLERS_DIR . str_replace( '_', DIRECTORY_SEPARATOR, $req ) . '.php';
                if( file_exists( $controller_file ) ) {
                    $req             = strtoupper( $req[0] ) . substr( $req, 1 );
                    $controller_name = 'Printq_Controller_' . $req;
                    require_once PRINTQ_CONTROLLERS_DIR . 'abstract.php';
                    @include_once $controller_file;
                    if( class_exists( $controller_name ) ) {
                        /** @var Printq_Controller_Abstract $controller */
                        $controller = new $controller_name();
                        $subaction  = isset( $_REQUEST['subaction'] ) ? sanitize_text_field( $_REQUEST['subaction'] ) : 'index';
                        if( $subaction ) {
                            if( $controller->hasAllowDirect( $subaction ) ) {
                                $controller->dispatch( $subaction );
                            } else {
                                wp_die( 'Method NOT allowed!' );
                            }
                        } else {
                            wp_die( 'Method does not exist' );
                        }
                    } else {
                        wp_die( 'Controller does not exist' );
                    }
                } else {
                    wp_die( 'Controller does not exist' );
                }
                exit;
            }
        }

        public function after_add_to_cart() {
            /**
             * @var WC_Product $product
             */
            global $product;

            $enable_printq = get_post_meta( $product->get_id(), 'pqd_enable', true );
            $pqd_template  = get_post_meta( $product->get_id(), 'pqd_template', true );

            if( $enable_printq ) {
                if( pqd_template_exists( $pqd_template ) ) {
                    wc_enqueue_js( "$('button.single_add_to_cart_button').hide();" );
                    ?>
                    <input type="hidden" name="pqd_personalize" value="<?php echo esc_attr( $product->get_id() ); ?>"/>
                    <input type="hidden" name="pqd_template" value="<?php echo esc_attr( $pqd_template ); ?>"/>
                    <input type="hidden" name="post" value="<?php echo esc_attr( $product->get_id() ); ?>"/>
                    <button type="submit" id="pqd_action_btn_<?php echo esc_attr( $product->get_id() ) ?>"
                            class="button alt"><?php _e( 'Personalize', PQD_DOMAIN ) ?></button>
                    <?php
                }
            }
        }

        public function change_add_to_cart_link( $link, $product ) {

            $enable_printq = get_post_meta( $product->get_id(), 'pqd_enable', true );
            $pqd_template  = get_post_meta( $product->get_id(), 'pqd_template', true );

            if( $enable_printq ) {
                if( pqd_template_exists( $pqd_template ) ) {
                    $url     = add_query_arg(
                            array(
                                    'quantity'        => isset( $quantity ) ? $quantity : 1,
                                    'add-to-cart'     => $product->get_id(),
                                    'pqd_personalize' => $product->get_id(),
                                    'pqd_template'    => $pqd_template,
                                    'post'            => $product->get_id(),
                            ),
                            $product->get_permalink()
                    );
                    $buttons = sprintf( '<a rel="nofollow" href="%s" class="%s">%s</a>',
                                        esc_url( $product->get_permalink() ),
                                        esc_attr( isset( $class ) ? $class : 'button' ),
                                        esc_html( __( 'Read More', PQD_DOMAIN ) )
                    );
                    $buttons .= sprintf( '<a rel="nofollow" href="%s" class="%s">%s</a>',
                                         $url,
                                         esc_attr( isset( $class ) ? $class : 'button' ),
                                         __( 'Personalize', PQD_DOMAIN )
                    );

                    return $buttons;
                }
            }

            return $link;
        }

        public function change_item_preview( $image, $cart_item ) {
            if( isset( $cart_item['pqd_pdf_data'], $cart_item['pqd_pdf_data']['images'] ) ) {
                if( count( $cart_item['pqd_pdf_data']['images'] ) ) {
                    $image          = $cart_item['pqd_pdf_data']['images'][0];
                    $image_file     = isset( $image['thumb'] ) ? $image['thumb'] : $image['full'];
                    $image_base_url = isset( $cart_item['pqd_pdf_data']['folder'] ) ? PRINTQ_UPLOAD_PREVIEWS_URL . $cart_item['pqd_pdf_data']['folder'] . '/' : PRINTQ_UPLOAD_URL . '/';
                    $image_file     = $image_base_url . $image_file;

                    return '<div class="pqd_image_preview"><img width="50" height="50" src="' . esc_attr( $image_file ) . '"/></div>';
                }
            }

            return $image;
        }

        /**
         * @return Printq_Designer_Loader
         */
        public function getLoader() {
            return $this->loader;
        }

        /**
         * @param Printq_Designer_Loader $loader
         */
        public function setLoader( $loader ) {
            $this->loader = $loader;
        }

        public function run() {
            $this->loader->run();
        }

    }
