<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    class Printq_Designer_Admin {

        /**
         * @var string
         * @since 1.0.0
         */
        private $plugin_name;

        /**
         * @var string
         * @since 1.0.0
         */
        private $plugin_version;

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
            $this->plugin_name    = $plugin_name;
            $this->plugin_version = $version;
            $this->loader         = $loader;

            $this->define_admin_hooks();
        }

        private function define_admin_hooks() {
            $this->loader->add_action( 'add_meta_boxes', $this, 'add_metaboxes' );
            $this->loader->add_action( 'save_post', $this, 'save_template' );
            $this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_styles' );
            $this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
            $this->loader->add_action( 'woocommerce_product_data_panels', $this, 'add_product_panel' );
            $this->loader->add_action( 'woocommerce_process_product_meta', $this, 'save_product_meta' );
            $this->loader->add_action( 'woocommerce_after_order_itemmeta', $this, 'change_order_item_thumbnail', 10, 3 );

            $this->loader->add_filter( 'woocommerce_product_write_panel_tabs', $this, 'add_product_tab' );
            $this->loader->add_filter( 'woocommerce_get_settings_pages', $this, 'add_settings_tab' );
        }

        public function add_settings_tab( $sections ) {
            $sections['printq_designer'] = include_once( PRINTQ_INCLUDES_DIR . 'settings.php' );

            return $sections;
        }

        /**
         * @param WP_Post $post
         */
        public function add_metaboxes( $post ) {
            add_meta_box(
                    'pqd_template_settings',
                    __( 'Canvas Settings', PQD_DOMAIN ),
                    array( $this, 'render_meta_box_settings' ),
                    'pqd_template',
                    'normal',
                    'high'
            );
            add_meta_box(
                    'pqd_template_content',
                    __( 'Canvas', PQD_DOMAIN ),
                    array( $this, 'metabox_canvas' ),
                    'pqd_template',
                    'normal',
                    'high'
            );
        }

        public function change_order_item_thumbnail( $item_id, $item, $_product ) {
            if( isset( $item['pqd_pdf_data'] ) ) {
                if ( ! is_array( $item['pqd_pdf_data'] ) ) {
                    $content = unserialize( $item['pqd_pdf_data'] );
                } else {
                    $content = $item['pqd_pdf_data'];
                }
                if( isset( $content['images'] ) ) {
                    $folder      = isset( $content['folder'] ) ? $content['folder'] : '';
                    $images_list = $this->outputImages( $content['images'], $folder, $item_id );
                    echo '<div class="pqd_image_preview">' .
                         __( 'Preview images:', PQD_DOMAIN ) .
                         '<br/>' .
                         $images_list .
                         '</div>';
                }

                if( isset( $content['pdf'] ) ) {
                    $downloadPdfUrl = add_query_arg( array(
                                                             'action'    => 'design',
                                                             'subaction' => 'downloadPdf',
                                                             'pqd_nonce' => wp_create_nonce( 'pqd_nonce' ),
                                                             'pdf'       => $content['pdf']
                                                     ), get_admin_url( null, 'admin-ajax.php' ) );
                    echo '<div class="pqd_pdf_link"><a target="_blank" href="' . esc_attr( $downloadPdfUrl ) . '">' . __( 'Download PDF', PQD_DOMAIN ) . '</a></div>';
                }
            }
        }

        protected function outputImages( $images, $folder = '', $item_id = '' ) {
            $output = '';
            foreach( $images as $image ) {
                $full_url  = esc_attr( PRINTQ_UPLOAD_PREVIEWS_URL . $folder . '/' . $image['full'] );
                $thumb_url = isset( $image['thumb'] ) ? esc_attr( PRINTQ_UPLOAD_PREVIEWS_URL . $folder . '/' . $image['thumb'] ) : $full_url;
                $output .= '<a class="pqd_fancybox" ' .
                           'title="' . __( 'Page Preview', PQD_DOMAIN ) . '" ' .
                           'rel="pqd_fb_gallery-' . esc_attr( $item_id ) . '" ' .
                           'href="' . $full_url . '">' .
                           '<img width="50" height="50" alt="" src="' . esc_attr( $thumb_url ) . '" alt="' . __( 'Page Preview', PQD_DOMAIN ) . '"/>' .
                           '</a>';
            }


            return $output;

        }

        public function add_product_tab() {
            ?>
            <li class="inventory_tab advanced_options show_if_simple hide_if_downloadable"><a
                        href="#printq_designer"><?php _e( 'PrintQ Personalization', PQD_DOMAIN ); ?></a></li>
            <?php
        }

        public function add_product_panel() {
            global $post;
            $enable              = get_post_meta( $post->ID, 'pqd_enable', true );
            $available_templates = get_posts(
                    array(
                            'post_type'   => 'pqd_template',
                            'orderby'     => 'title',
                            'post_status' => 'publish',
                    )
            );
            $templates           = array(
                    '' => __( 'None', PQD_DOMAIN )
            );
            foreach( $available_templates as $tmp ) {
                $templates[$tmp->ID] = $tmp->post_title;
            }
            $template = get_post_meta( $post->ID, 'pqd_template', true );
            ?>
            <div id="printq_designer" class="panel woocommerce_options_panel">
                <div class="options_group">
                    <p class="form-field">
                        <?php woocommerce_wp_checkbox(
                                array(
                                        'id'          => 'pqd_enable',
                                        'value'       => $enable,
                                        'label'       => __( 'Enable', PQD_DOMAIN ),
                                        'cbvalue'     => 1,
                                        'description' => '&#8678; ' . __( "Check this to enable PrintQ Designer for this product", PQD_DOMAIN )
                                )
                        );
                            woocommerce_wp_select( array(
                                                           'id'      => 'pqd_template',
                                                           'value'   => $template,
                                                           'options' => $templates,
                                                           'label'   => 'Template'
                                                   ) );
                        ?>
                    </p>
                </div>
            </div>
            <?php
        }

        public function save_product_meta( $post_id ) {
            $pqd_enable   = isset( $_POST['pqd_enable'] ) ? 1 : 0;
            $pqd_template = isset( $_POST['pqd_template'] ) ? sanitize_text_field( $_POST['pqd_template'] ) : null;

            update_post_meta( $post_id, 'pqd_enable', $pqd_enable );
            update_post_meta( $post_id, 'pqd_template', $pqd_template );
        }

        /**
         * @param WP_Post $post
         */
        public function metabox_canvas( $post ) {
            $edit_template_url = add_query_arg(
                    array(
                            'action'       => 'pqd_design',
                            'pqd_nonce'    => wp_create_nonce( 'pqd_nonce' ),
                            'pqd_template' => $post->ID,
                            'post'         => $post->ID,
                            'is_admin'     => true,
                    ),
                    admin_url( 'admin-ajax.php' )
            );
            ?>
            <textarea style="display: none;" id="content" name="content"><?php echo esc_html( $post->post_content ) ?></textarea>
            <input class="button button-primary" id="pqd_edit_template" href="<?php echo esc_attr( $edit_template_url ) ?>" type="submit"
                   value="<?php _e( 'Edit template', PQD_DOMAIN ) ?>">
            <small class="pqd_notice"><?php _e( 'Please remember to save the template if you make changes to design!', PQD_DOMAIN ) ?></small>
            <?php
        }

        /**
         * Render Meta Box content.
         *
         * @param WP_Post $post The post object.
         *
         */
        public function render_meta_box_settings( $post ) {

            // Add an nonce field so we can check for it later.
            wp_nonce_field( 'pqd_template_metabox', 'pqd_template_metabox_nonce' );


            // Use get_post_meta to retrieve an existing value from the database.
            $post_meta = get_post_meta( $post->ID, 'pqd_template_settings', true );
            $width     = isset( $post_meta['width'] ) ? intval( $post_meta['width'] ) : 800;
            $height    = isset( $post_meta['height'] ) ? intval( $post_meta['height'] ) : 600;

            $default_block_options = array( 'move' => 0, 'resize' => 0, 'snap' => 0, 'rotate' => 0 );

            if( isset( $post_meta['block_options'] ) && is_array( $post_meta['block_options'] ) ) {
                $block_options = array_merge( $default_block_options, $post_meta['block_options'] );
            } else {
                $block_options = $default_block_options;
            }
            // Display the form, using the current value.
            ?>
            <div class="printq_mb_section clearfix">
                <label class="printq_mb_label" for="pqd_template_canvas_width_value">
                    <?php _e( 'Width', PQD_DOMAIN ); ?>
                </label>
                <div class="printq_mb_content"><input type="number"
                                                      id="pqd_template_canvas_width_value"
                                                      name="pqd_template_settings[width]"
                                                      min="1"
                                                      value="<?php echo esc_attr( $width ); ?>" size="25"/>
                </div>
            </div>
            <div class="printq_mb_section clearfix">
                <label class="printq_mb_label" for="pqd_template_canvas_height_value">
                    <?php _e( 'Height', PQD_DOMAIN ); ?>
                </label>
                <div class="printq_mb_content">
                    <input type="number"
                           id="pqd_template_canvas_height_value"
                           name="pqd_template_settings[height]"
                           min="1"
                           value="<?php echo esc_attr( $height ); ?>" size="25"/>
                </div><br/>
                <small class="pqd_notice"><?php _e( 'Please note that if you change width &amp; height values after you have edited the template you might get weird output', PQD_DOMAIN ) ?></small>
            </div>
            <div class="printq_mb_section clearfix">
                <div class="printq_mb_label">
                    <?php _e( 'Block Options', PQD_DOMAIN ); ?>:
                </div>
                <div class="printq_mb_content">
                    <label for="pqd_template_block_options_move_value">
                        <input type="checkbox"
                               id="pqd_template_block_options_move_value"
                               name="pqd_template_settings[block_options][move]"
                                <?php checked( $block_options['move'], 1 ) ?>
                               value="1"/>
                        <?php _e( 'Move', PQD_DOMAIN ); ?>
                    </label>
                    <span class="printq_separator"> | </span>
                    <label for="pqd_template_block_options_resize_value">
                        <input type="checkbox"
                               id="pqd_template_block_options_resize_value"
                               name="pqd_template_settings[block_options][resize]"
                                <?php checked( $block_options['resize'], 1 ) ?>
                               value="1"/>
                        <?php _e( 'Resize', PQD_DOMAIN ); ?>
                    </label>
                    <span class="printq_separator"> | </span>
                    <label for="pqd_template_block_options_snap_value">
                        <input type="checkbox"
                               id="pqd_template_block_options_snap_value"
                               name="pqd_template_settings[block_options][snap]"
                                <?php checked( $block_options['snap'], 1 ) ?>
                               value="1"/>
                        <?php _e( 'Snap', PQD_DOMAIN ); ?>
                    </label>
                    <span class="printq_separator"> | </span>
                    <label for="pqd_template_block_options_rotate_value">
                        <input type="checkbox"
                               id="pqd_template_block_options_rotate_value"
                               name="pqd_template_settings[block_options][rotate]"
                                <?php checked( $block_options['rotate'], 1 ) ?>
                               value="1"/>
                        <?php _e( 'Rotate', PQD_DOMAIN ); ?>
                    </label>
                </div><br/>
                <small class="pqd_notice"><?php _e( 'Check any of previous checkboxes to toggle default values for move, rotate, resize or snap block options', PQD_DOMAIN ) ?></small>
            </div>
            <?php if( pqd_is_active() ) {
                $enable_3d_preview = isset( $post_meta['enable_3d_preview'] ) ? intval( $post_meta['enable_3d_preview'] ) : 0;
                $model_3d          = isset( $post_meta['3d_model'] ) ? $post_meta['3d_model'] : '';
                $texture_3d        = isset( $post_meta['3d_texture'] ) ? $post_meta['3d_texture'] : '';
                ?>
                <div class="printq_mb_section">
                    <label class="printq_mb_label" for="pqd_template_enable_3d_preview_value">
                        <?php _e( 'Enable 3D Preview', PQD_DOMAIN ); ?>
                    </label>

                    <div class="printq_mb_content">
                        <select name="pqd_template_settings[enable_3d_preview]"
                                class="has_dependents"
                                data-dependent_key="enable_3d_preview"
                                id="pqd_template_enable_3d_preview_value">
                            <option value="0" <?php selected( $enable_3d_preview, 0 ) ?>><?php _e( 'No', PQD_DOMAIN ) ?></option>
                            <option value="1" <?php selected( $enable_3d_preview, 1 ) ?>><?php _e( 'Yes', PQD_DOMAIN ) ?></option>
                        </select>
                    </div>
                </div>
                <div class="printq_mb_section  pqd_is_dependent" data-depends="enable_3d_preview" data-depends_value="1">
                    <label class="printq_mb_label" for="pqd_template_3d_model_value">
                        <?php _e( '3D Model', PQD_DOMAIN ); ?>
                    </label>

                    <div class="printq_mb_content">
                        <?php $models = pqd_get_models(); ?>
                        <select name="pqd_template_settings[3d_model]" id="pqd_template_3d_model_value">
                            <?php foreach( $models as $model ) { ?>
                                <option value="<?php echo esc_attr( $model['id'] ) ?>" <?php selected( $model['id'], $model_3d ) ?>><?php echo esc_html( $model['name'] ) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="printq_mb_section pqd_is_dependent" data-depends="enable_3d_preview" data-depends_value="1">
                    <label class="printq_mb_label" for="pqd_template_3d_texture_value">
                        <?php _e( 'Texture', PQD_DOMAIN ); ?>
                    </label>

                    <div class="printq_mb_content">
                        <input type="text"
                               id="pqd_template_3d_texture_value"
                               name="pqd_template_settings[3d_texture]"
                               min="1"
                               value="<?php echo esc_attr( $texture_3d ); ?>"/>
                    </div>
                </div>
            <?php }
        }

        /**
         * Save the meta when the post is saved.
         *
         * @param int $post_id The ID of the post being saved.
         *
         * @return int
         */
        public function save_template( $post_id ) {

            /*
			 * We need to verify this came from the our screen and with proper authorization,
			 * because save_post can be triggered at other times.
			 */

            // Check if our nonce is set.
            if( !isset( $_POST['pqd_template_metabox_nonce'] ) ) {
                return $post_id;
            }

            $nonce = $_POST['pqd_template_metabox_nonce'];

            // Verify that the nonce is valid.
            if( !wp_verify_nonce( $nonce, 'pqd_template_metabox' ) ) {
                return $post_id;
            }

            /*
			 * If this is an autosave, our form has not been submitted,
			 * so we don't want to do anything.
			 */
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return $post_id;
            }

            // Check the user's permissions.
            if( 'pqd_template' == $_POST['post_type'] ) {
                if( !current_user_can( 'edit_pqd_templates', $post_id ) ) {
                    return $post_id;
                }
            }

            /* OK, it's safe for us to save the data now. */
            $params = $_POST['pqd_template_settings'];

            $block_options = isset( $params['block_options'] ) && is_array( $params['block_options'] ) ? $params['block_options'] : array();

            $move   = isset( $block_options['move'] ) ? 1 : 0;
            $resize = isset( $block_options['resize'] ) ? 1 : 0;
            $snap   = isset( $block_options['snap'] ) ? 1 : 0;
            $rotate = isset( $block_options['rotate'] ) ? 1 : 0;

            // Sanitize the user input.
            $to_save = array(
                    'width'         => sanitize_text_field( $params['width'] ),
                    'height'        => sanitize_text_field( $params['height'] ),
                    'block_options' => array(
                            'move'   => $move,
                            'resize' => $resize,
                            'snap'   => $snap,
                            'rotate' => $rotate
                    )
            );

            if( pqd_is_active() ) {
                $to_save['enable_3d_preview'] = sanitize_text_field( $params['enable_3d_preview'] );
                if( $to_save['enable_3d_preview'] == 1 ) {
                    $to_save['3d_model']   = sanitize_text_field( $params['3d_model'] );
                    $to_save['3d_texture'] = sanitize_text_field( $params['3d_texture'] );
                }
            }

            // Update the meta field.
            update_post_meta( $post_id, 'pqd_template_settings', $to_save );

            return $post_id;
        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles() {
            $cpt = pqd_get_current_post_type();
            if( $cpt == 'pqd_template' || $cpt == 'shop_order' ) {
                wp_enqueue_style( 'pqd_main_css', pqd_css_url( 'admin_main.min.css' ), array(), $this->plugin_version, 'all' );
                wp_enqueue_style( 'pqd_fancybox_css', pqd_css_url( 'jquery.fancybox.min.css' ), array(), $this->plugin_version, 'all' );
            }
        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts() {
            $cpt = pqd_get_current_post_type();
            if( $cpt == 'pqd_template' || $cpt == 'shop_order' ) {
                wp_enqueue_script( 'pqd_fancybox_js', pqd_js_url( 'jquery.fancybox.min.js' ), array( 'jquery' ), $this->plugin_version, true );
                wp_enqueue_script( 'pqd_edit_template_main', pqd_js_url( 'admin_main.min.js' ), array(
                        'jquery',
                        'pqd_fancybox_js'
                ), $this->plugin_version, true );
                wp_localize_script( 'pqd_edit_template_main', 'pqd_admin', array(
                        'wrong_width'       => __( 'Canvas width must be larger than or equal to 1!' ),
                        'wrong_height'      => __( 'Canvas height must be larger than or equal to 1!' ),
                        'wrong_3d_model'    => __( 'Please select a 3D model!' ),
                        'wrong_3d_texture'  => __( 'Please enter default texture!' ),
                        'fb_title_template' => __( 'Page {index} preview' ),
                ) );
            }

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
