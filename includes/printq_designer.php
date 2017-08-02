<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    class Printq_Designer {

        /**
         * The unique identifier of this plugin.
         *
         * @var string
         * @since 1.0.0
         */
        protected $plugin_name;

        /**
         * The current version of the plugin.
         *
         * @var string
         * @since 1.0.0
         */
        protected $plugin_version;

        /**
         * The loader that's responsible for maintaining and registering all hooks that power
         * the plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      Printq_Designer_Loader $loader Maintains and registers all hooks for the plugin.
         */
        protected $loader;

        public function __construct() {
            $this->plugin_name    = 'printq_designer';
            $this->plugin_version = PRINTQ_DESIGNER_VERSION;

            $this->loadDependencies();
            $this->setLocale();

            $this->init_hooks();
        }

        protected function init_hooks() {
            $this->loader->add_action( 'plugins_loaded', $this, 'plugins_loaded' );
            $this->loader->add_action( 'init', $this, 'create_post_types' );

            //this should be on designer_public but add to cart is made through ajax
            $this->loader->add_filter( 'woocommerce_add_cart_item_data', $this, 'add_item_meta', 10, 1 );
            $this->loader->add_filter( 'woocommerce_add_order_item_meta', $this, 'add_order_item_meta', 10, 3 );
            $this->loader->add_filter( 'woocommerce_add_cart_item', $this, 'change_item_folder', 10, 2 );

            $this->map_ajax_actions();
        }

        public function activate() {
            //create upload dir
            if( !file_exists( PRINTQ_UPLOAD_DIR ) || !is_dir( PRINTQ_UPLOAD_DIR ) ) {
                if( !wp_mkdir_p( PRINTQ_UPLOAD_DIR ) ) {
                    add_action( 'admin_init', array( $this, 'error_create_directory' ) );
                }
            }

            if( is_multisite() ) {
                update_site_option( 'printq_designer_version', $this->plugin_version );
            } else {
                update_option( 'printq_designer_version', $this->plugin_version );
            }


        }

        public function error_create_directory() {
            echo '<div id="message" class="error">';
            echo sprintf( __( 'Failed to create uploads directory. Please make sure you have write permissions on \'%s\'!', PQD_DOMAIN ), dirname( PRINTQ_UPLOAD_DIR ) );
            echo '</div>';
        }

        protected function map_ajax_actions() {
            if( /*is_admin() &&*/
                defined( 'DOING_AJAX' ) && DOING_AJAX
            ) {
                $action = isset( $_REQUEST['action'] ) ? sanitize_text_field( $_REQUEST['action'] ) : '';

                $req = str_replace( 'pqd_', '', $action );
                if( $req ) {
                    //might be grouped by directories
                    $controller_file = PRINTQ_CONTROLLERS_DIR . str_replace( '_', DIRECTORY_SEPARATOR, $req ) . '.php';
                    if( file_exists( $controller_file ) ) {
                        $req             = strtoupper( $req[0] ) . substr( $req, 1 );
                        $controller_name = 'Printq_Controller_' . $req;
                        require_once PRINTQ_CONTROLLERS_DIR . 'abstract.php';
                        @include_once $controller_file;
                        if( class_exists( $controller_name ) ) {
                            /** @var Printq_Controller_Abstract $controller */
                            $controller = new $controller_name();
                            $this->loader->add_action( "wp_ajax_$action", $controller, 'dispatch' );

                            $subaction = isset( $_REQUEST['subaction'] ) ? sanitize_text_field( $_REQUEST['subaction'] ) : 'index';
                            if( $subaction && $controller->hasNoPriv( $subaction ) ) {
                                $this->loader->add_action( "wp_ajax_nopriv_$action", $controller, 'dispatch' );
                            }
                        }
                    }
                }
            }
        }

        public function add_item_meta( $cart_item_data ) {
            require_once PRINTQ_HELPERS_DIR . 'pdf.php';
            if( isset( $_POST['pqd_content'] ) ) {

                $name                           = 'wp_item_' . md5( implode( '', $cart_item_data ) ) . '_' . mt_rand( 0, 100 );
                $pqd_content                    = $_POST['pqd_content'];
                $cart_item_data['pqd_pdf_data'] = array(
                    'folder' => $name
                );
                if( pqd_is_active() ) {
                    foreach( $pqd_content as &$svg ) {
                        $svg = stripslashes( $svg );
                    }

                    try {
                        $pdf = Printq_Pdf_Helper::generate_pdf( $pqd_content, $name, $name );
                        if( $pdf ) {
                            $cart_item_data['pqd_pdf_data']['pdf'] = sanitize_text_field( $pdf );
                        }
                    } catch( Exception $e ) {
                        die( $e->getMessage() );
                    }
                }

                //save preview in cart item folder
                if( isset( $_POST['pqd_image_preview'] ) ) {
                    $images                                   = Printq_Pdf_Helper::showPreview( $_POST['pqd_image_preview'], '.jpeg', $name );
                    $cart_item_data['pqd_pdf_data']['images'] = $images;
                }
            }

            return $cart_item_data;
        }

        protected static function delete_dir( $path ) {
            if( !is_dir( $path ) ) {
                return true;
            }
            if( substr( $path, strlen( $path ) - 1, 1 ) != '/' ) {
                $path .= '/';
            }
            $files = glob( $path . '*', GLOB_MARK );
            foreach( $files as $file ) {
                if( is_dir( $file ) ) {
                    self::delete_dir( $file );
                } else {
                    unlink( $file );
                }
            }

            return rmdir( $path );

        }

        public function change_item_folder( $cart_item_data, $cart_item_key ) {
            if( isset( $cart_item_data['pqd_pdf_data'], $cart_item_data['pqd_pdf_data']['folder'] ) ) {
                //rename directory
                $old_name = PRINTQ_UPLOAD_PREVIEWS_DIR . $cart_item_data['pqd_pdf_data']['folder'];
                $new_name = PRINTQ_UPLOAD_PREVIEWS_DIR . $cart_item_key;

                if( !defined( 'FS_CHMOD_FILE' ) ) {
                    define( 'FS_CHMOD_FILE', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 ) );
                }
                require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
                require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
                $wp_filesystem = new WP_Filesystem_Direct( new StdClass() );

                $result = $wp_filesystem->move( $old_name, $new_name );
                if( $result ) {
                    $cart_item_data['pqd_pdf_data']['folder'] = $cart_item_key;
                }
            }

            return $cart_item_data;
        }

        public function add_order_item_meta( $item_id, $values, $cart_item_key ) {
            if( isset( $values['pqd_pdf_data'] ) ) {
                wc_add_order_item_meta( $item_id, 'pqd_pdf_data', $values['pqd_pdf_data'], true );
            }
        }

        public function create_post_types() {
            register_post_type(
                'pqd_template',
                array(
                    'label'              => __( 'printQ Templates', PQD_DOMAIN ),
                    'labels'             => array(
                        'name'                  => __( 'printQ Templates', PQD_DOMAIN ),
                        'singular_name'         => __( 'printQ Template', PQD_DOMAIN ),
                        'add_new_item'          => __( 'Add new printQ Template', PQD_DOMAIN ),
                        'edit_item'             => __( 'Edit printQ Template', PQD_DOMAIN ),
                        'new_item'              => __( 'New printQ Template', PQD_DOMAIN ),
                        'view_item'             => __( 'View printQ Template', PQD_DOMAIN ),
                        'search_items'          => __( 'Search printQ Template', PQD_DOMAIN ),
                        'not_found'             => __( 'No printQ Template found', PQD_DOMAIN ),
                        'not_found_in_trash'    => __( 'No printQ Template found in trash', PQD_DOMAIN ),
                        'all_items'             => __( 'printQ Templates', PQD_DOMAIN ),
                        'insert_into_item'      => __( 'Insert into printQ Template', PQD_DOMAIN ),
                        'uploaded_to_this_item' => __( 'Upload to printQ Template', PQD_DOMAIN ),
                    ),
                    'description'        => __( 'Create awesome templates to use with printQ Editor', PQD_DOMAIN ),
                    'public'             => true,
                    'show_ui'            => true,
                    'show_in_menu'       => true,
                    'show_in_nav_menus'  => true,
                    'map_meta_cap'       => true,
                    'publicly_queryable' => false,
                    'capability_type'    => array( 'pqd_template', 'pqd_templates' ),
                    'capabilities'       => array(
                        'edit_post'              => 'edit_pqd_template',
                        'read_post'              => 'read_pqd_template',
                        'delete_post'            => 'delete_pqd_template',
                        'edit_posts'             => 'edit_pqd_templates',
                        'edit_others_posts'      => 'edit_others_pqd_templates',
                        'publish_posts'          => 'publish_pqd_templates',
                        'read_private_posts'     => 'read_private_pqd_templates',
                        'create_posts'           => 'edit_pqd_templates',
                        'read'                   => 'read',
                        'delete_posts'           => 'delete_pqd_templates',
                        'delete_private_posts'   => 'delete_private_pqd_templates',
                        'delete_published_posts' => 'delete_published_pqd_templates',
                        'delete_others_posts'    => 'delete_others_pqd_templates',
                        'edit_private_posts'     => 'edit_private_pqd_templates',
                        'edit_published_posts'   => 'edit_published_pqd_templates',
                    ),
                    'hierarchical'       => false,
                    'supports'           => array( 'title' ),
                )
            );
        }

        public function plugins_loaded() {
            if( is_multisite() ) {
                $printq_designer_version = get_site_option( 'printq_designer_version' );
            } else {
                $printq_designer_version = get_option( 'printq_designer_version' );
            }
            $administrator_role = get_role( 'administrator' );

            if( $printq_designer_version != $this->plugin_version ) {
                $printq_designer_manager = add_role( 'printq_designer_manager',
                                                     __( 'printQ Designer Manager', PQD_DOMAIN ),
                                                     array(
                                                         'edit_pqd_template'              => true,
                                                         'read_pqd_template'              => true,
                                                         'delete_pqd_template'            => true,
                                                         'edit_others_pqd_templates'      => true,
                                                         'publish_pqd_templates'          => true,
                                                         'read_private_pqd_templates'     => true,
                                                         'edit_pqd_templates'             => true,
                                                         'delete_pqd_templates'           => true,
                                                         'delete_private_pqd_templates'   => true,
                                                         'delete_published_pqd_templates' => true,
                                                         'delete_others_pqd_templates'    => true,
                                                         'edit_private_pqd_templates'     => true,
                                                         'edit_published_pqd_templates'   => true,
                                                     ) );

                if( null === $printq_designer_manager ) {
                    // Role exists, just update capabilities.
                    $printq_designer_manager = get_role( 'printq_designer_manager' );
                    $printq_designer_manager->add_cap( 'publish_pqd_templates', true );
                    $printq_designer_manager->add_cap( 'read_pqd_templates', true );
                    $printq_designer_manager->add_cap( 'edit_pqd_templates', true );
                    $printq_designer_manager->add_cap( 'delete_pqd_templates', true );
                }

                $shop_manager_role = get_role( 'shop_manager' );
                if( null != $shop_manager_role ) {
                    $shop_manager_role->add_cap( 'publish_pqd_templates', true );
                    $shop_manager_role->add_cap( 'read_pqd_templates', true );
                    $shop_manager_role->add_cap( 'edit_pqd_templates', true );
                    $shop_manager_role->add_cap( 'delete_pqd_templates', true );
                }


                if( is_multisite() ) {
                    update_site_option( 'printq_designer_version', $this->plugin_version );
                } else {
                    update_option( 'printq_designer_version', $this->plugin_version );
                }
            }
            if( null != $administrator_role ) {
                $administrator_role->add_cap( 'edit_pqd_template', true );
                $administrator_role->add_cap( 'read_pqd_template', true );
                $administrator_role->add_cap( 'delete_pqd_template', true );
                $administrator_role->add_cap( 'edit_others_pqd_templates', true );
                $administrator_role->add_cap( 'publish_pqd_templates', true );
                $administrator_role->add_cap( 'read_private_pqd_templates', true );
                $administrator_role->add_cap( 'edit_pqd_templates', true );
                $administrator_role->add_cap( 'delete_pqd_templates', true );
                $administrator_role->add_cap( 'delete_private_pqd_templates', true );
                $administrator_role->add_cap( 'delete_published_pqd_templates', true );
                $administrator_role->add_cap( 'delete_others_pqd_templates', true );
                $administrator_role->add_cap( 'edit_private_pqd_templates', true );
                $administrator_role->add_cap( 'edit_published_pqd_templates', true );
            }
        }

        public function deactivate() {

        }

        protected function loadDependencies() {
            require_once 'printq_designer_loader.php';
            $this->loader = new Printq_Designer_Loader();
        }

        /**
         * Define the locale for this plugin for internationalization.
         *
         * @since    1.0.0
         * @access   private
         */
        protected function setLocale() {
            $this->loader->add_action( 'plugins_loaded', $this, 'load_plugin_textdomain' );
        }

        public function load_plugin_textdomain() {
            load_plugin_textdomain(
                PQD_DOMAIN,
                false,
                PRINTQ_LANG_DIR
            );
        }

        /**
         * Run the loader to execute all of the hooks with WordPress.
         *
         * @since    1.0.0
         */
        public function run() {
            if( is_admin() ) {
                require_once 'admin/printq_designer_admin.php';
                $plugin = new Printq_Designer_Admin( $this->plugin_name, $this->plugin_version, $this->loader );
            } else {
                require_once 'public/printq_designer_public.php';
                $plugin = new Printq_Designer_Public( $this->plugin_name, $this->plugin_version, $this->loader );
            }
            $plugin->run();
        }
    }
