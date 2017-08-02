<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    if( !defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }

    class Printq_Settings extends WC_Settings_Page {

        /**
         * Constructor.
         */
        public function __construct() {

            $this->id    = 'printq';
            $this->label = __( 'PrintQ', PQD_DOMAIN );

            add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
            add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
            add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
            add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
            add_action( 'woocommerce_admin_field_printq_message', array( $this, 'custom_message' ) );
            add_action( 'woocommerce_admin_field_printq_logo', array( $this, 'logo_chooser' ) );
        }

        /**
         * Get sections.
         *
         * @return array
         */
        public function get_sections() {

            $sections = array(
                    '' => __( 'General', PQD_DOMAIN ),
            );


            return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
        }

        /**
         * Output the settings.
         */
        public function output() {
            global $current_section;

            $settings = $this->get_settings( $current_section );

            WC_Admin_Settings::output_fields( $settings );
        }

        /**
         * Save settings.
         */
        public function save() {
            global $current_section;

            $settings = $this->get_settings( $current_section );
            WC_Admin_Settings::save_fields( $settings );
        }

        /**
         * Get settings array.
         *
         * @param string $current_section
         *
         * @return array
         */
        public function get_settings( $current_section = '' ) {
            switch( $current_section ) {
                default:
                    $domain = parse_url( get_bloginfo( 'wpurl' ) );
                    if( isset( $domain['host'] ) ) {
                        $domain = $domain['host'];
                    } else {
                        $domain = get_bloginfo( 'wpurl' );
                    }
                    $settings = apply_filters( 'woocommerce_printq_general_settings', array(
                            array(
                                    'title' => __( 'General', PQD_DOMAIN ),
                                    'type'  => 'title',
                                    'id'    => 'printq_general_options'
                            ),
                            array(
                                    'type'    => 'printq_message',
                                    'message' => sprintf(
                                            __( 'Please visit <a href="%s" target="_blank">our site</a> if you want to enable print-ready PDFs', PQD_DOMAIN ),
                                            'http://en.web-to-printq.com/wp-designer/' )
                            ),
                            array(
                                    'title'    => __( 'API Key', PQD_DOMAIN ),
                                    'id'       => 'pqd[api_key]',
                                    'type'     => 'text',
                                    'default'  => 'd4e50764774e29872485766e00424390',
                                    'css'      => 'width: 250px;',
                                    'autoload' => false,
                                    'desc_tip' => true
                            ),
                            array(
                                    'title'     => __( 'Logo', PQD_DOMAIN ),
                                    'id'        => 'pqd[logo]',
                                    'type'      => 'printq_logo',
                                    'logo_type' => '',
                                    'default'   => '',
                                    'autoload'  => false,
                                    'desc_tip'  => true
                            ),
                            array(
                                    'title'     => __( 'Preload Logo', PQD_DOMAIN ),
                                    'id'        => 'pqd[logo_preload]',
                                    'type'      => 'printq_logo',
                                    'logo_type' => '_preload',
                                    'default'   => '',
                                    'autoload'  => false,
                                    'desc_tip'  => true
                            ),
                            array(
                                    'title'     => __( 'Logo small', PQD_DOMAIN ),
                                    'id'        => 'pqd[logo_small]',
                                    'type'      => 'printq_logo',
                                    'logo_type' => '_small',
                                    'default'   => '',
                                    'autoload'  => false,
                                    'desc_tip'  => true
                            ),
                            array(
                                    'title'    => __( 'Branding Color', PQD_DOMAIN ),
                                    'id'       => 'pqd[branding_color]',
                                    'type'     => 'color',
                                    'default'  => '#99d122',
                                    'autoload' => false,
                                    'desc_tip' => true
                            ),
                            array(
                                    'title'    => __( 'Sidebar Bg Color', PQD_DOMAIN ),
                                    'id'       => 'pqd[sidebar_bg_color]',
                                    'type'     => 'color',
                                    'default'  => '#213246',
                                    'autoload' => false,
                                    'desc_tip' => true
                            ),
                            array(
                                    'title'    => __( 'Sidebar Color Active', PQD_DOMAIN ),
                                    'id'       => 'pqd[sidebar_bg_color_active]',
                                    'type'     => 'color',
                                    'default'  => '#1b2939',
                                    'autoload' => false,
                                    'desc_tip' => true
                            ),
                            array(
                                    'title'    => __( 'Icon Color', PQD_DOMAIN ),
                                    'id'       => 'pqd[icon_color]',
                                    'type'     => 'color',
                                    'default'  => '#6CBFE8',
                                    'autoload' => false,
                                    'desc_tip' => true
                            ),
                            array(
                                    'type' => 'sectionend',
                                    'id'   => 'printq_general_options'
                            ),
                            array(
                                    'title' => __( 'Unsplash', PQD_DOMAIN ),
                                    'type'  => 'title',
                                    'id'    => 'printq_unsplash_options'
                            ),
                            array(
                                    'title'    => __( 'Unsplash ID', PQD_DOMAIN ),
                                    'id'       => 'pqd[unsplash_id]',
                                    'type'     => 'text',
                                    'default'  => '',
                                    'css'      => 'width: 250px;',
                                    'autoload' => false,
                                    'desc_tip' => true
                            ),
                            array(
                                    'type'    => 'printq_message',
                                    'message' => sprintf( __( 'Please add <b>\'%s\'</b> to Unsplash Redirect URI in order to use this feature.', PQD_DOMAIN ), get_bloginfo( 'wpurl' ) )
                            ),
                            array(
                                    'type' => 'sectionend',
                                    'id'   => 'printq_unsplash_options'
                            ),
                            array(
                                    'title' => __( 'Facebook', PQD_DOMAIN ),
                                    'type'  => 'title',
                                    'id'    => 'printq_facebook_options'
                            ),
                            array(
                                    'type'    => 'printq_message',
                                    'message' => sprintf( __( 'Please add <b>\'%s\'</b> to Facebook App allowed domains in order to use this feature.', PQD_DOMAIN ), $domain )
                            ),
                            array(
                                    'title'    => __( 'App ID', PQD_DOMAIN ),
                                    'id'       => 'pqd[facebook_app_id]',
                                    'type'     => 'text',
                                    'default'  => '',
                                    'css'      => 'width: 250px;',
                                    'autoload' => false,
                            ),
                            array(
                                    'type' => 'sectionend',
                                    'id'   => 'printq_facebook_options'
                            ),
                            array(
                                    'title' => __( 'Instagram', PQD_DOMAIN ),
                                    'type'  => 'title',
                                    'id'    => 'printq_instagram_options'
                            ),
                            array(
                                    'type'    => 'printq_message',
                                    'message' => sprintf(
                                            __( 'Please add <b>\'%s\'</b> to Instagram\'s \'Valid redirect URIs\' in order to use this feature.', PQD_DOMAIN ),
                                            get_bloginfo( 'wpurl' )
                                    )
                            ),
                            array(
                                    'title'    => __( 'Client ID', PQD_DOMAIN ),
                                    'id'       => 'pqd[instagram_api_key]',
                                    //'desc'     => sprintf( __( 'Remember to add \'%s\' to Facebook App domains', PQD_DOMAIN ), get_bloginfo( 'wpurl' ) ),
                                    'type'     => 'text',
                                    'default'  => '',
                                    'css'      => 'width: 250px;',
                                    'autoload' => false,
                            ),
                            array(
                                    'title'    => __( 'Client Secret', PQD_DOMAIN ),
                                    'id'       => 'pqd[instagram_api_secret]',
                                    //'desc'     => sprintf( __( 'Remember to add \'%s\' to Facebook App domains', PQD_DOMAIN ), get_bloginfo( 'wpurl' ) ),
                                    'type'     => 'text',
                                    'default'  => '',
                                    'css'      => 'width: 250px;',
                                    'autoload' => false,
                            ),
                            array(
                                    'type' => 'sectionend',
                                    'id'   => 'printq_instagram_options'
                            ),
                    ) );
                    break;
            }

            return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );
        }

        public function custom_message( $value ) {
            ?>
            <tr valign="top">
                <td colspan="2" class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?> <?php echo esc_attr( $value['class'] ); ?>">
                    <span class="description"><?php echo wp_kses_post( $value['message'] ); ?></span>
                </td>
            </tr>
            <?php
        }

        public function logo_chooser( $value ) {
            wp_enqueue_media();
            wp_enqueue_script( 'printq_designer_logo_chooser', pqd_js_url( 'admin_logo_chooser.js' ), array(
                    'jquery',
                    'wp-mediaelement'
            ), PRINTQ_DESIGNER_VERSION, true );
            wp_localize_script( 'printq_designer_logo_chooser', 'pqd_logo', array(
                    'title'                => __( 'Select a logo image', PQD_DOMAIN ),
                    'btn_text'             => __( 'Use this as logo', PQD_DOMAIN ),
                    'default_logo_small'   => PRINTQ_IMG_URL . 'logo_small.png',
                    'default_logo'         => PRINTQ_IMG_URL . 'logo.png',
                    'default_logo_preload' => PRINTQ_IMG_URL . 'logo_preload.png',
            ) );
            $target = str_replace( '.', '_', uniqid( 'pqd_logo_', true ) );

            // Custom attribute handling
            $custom_attributes = array();

            if( !empty( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) ) {
                foreach( $value['custom_attributes'] as $attribute => $attribute_value ) {
                    $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
                }
            }

            $field_description = WC_Admin_Settings::get_field_description( $value );
            extract( $field_description );
            /**
             * @var $tooltip_html
             * @var $description
             */
            $option_value = WC_Admin_Settings::get_option( $value['id'], $value['default'] );
            $attachment   = wp_get_attachment_image( $option_value, 'thumbnail', false, array( 'id' => $target . '-preview' ) );
            ?>
            <tr valign="top">
                <th scope="row" class="titledesc">
                    <label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
                    <?php echo $tooltip_html; ?>
                </th>
                <td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
                    <div>
                        <?php echo $attachment ? $attachment : '<img width="80" height="70" src="' . esc_attr( PRINTQ_IMG_URL . 'logo' . $value['logo_type'] . '.png' ) . '" class="attachment-thumbnail size-thumbnail" id="' . esc_attr( $target . '-preview' ) . '">' ?>
                    </div>
                    <div>
                        <button class="button-primary printq_media_choose_btn"
                                data-target="#<?php echo esc_attr($target); ?>"><?php printf( __( 'Change %s', PQD_DOMAIN ), $value['title'] ) ?></button>
                        <button class="button-secondary printq_media_clear_btn" data-type="<?php echo esc_attr( $value['logo_type'] ) ?>"
                                data-target="#<?php echo esc_attr( $target ); ?>"><?php _e( 'Remove', PQD_DOMAIN ) ?></button>
                    </div>
                    <input
                            name="<?php echo esc_attr( $value['id'] ); ?>"
                            id="<?php echo esc_attr( $target ); ?>"
                            type="hidden"
                            style="<?php echo esc_attr( $value['css'] ); ?>"
                            value="<?php echo esc_attr( $option_value ); ?>"
                            class="<?php echo esc_attr( $value['class'] ); ?>"
                            placeholder="<?php echo esc_attr( $value['placeholder'] ); ?>"
                            <?php echo implode( ' ', $custom_attributes ); ?>
                    /> <?php echo $description; ?>
                </td>
            </tr>
            <?php
        }
    }

    return new Printq_Settings();


