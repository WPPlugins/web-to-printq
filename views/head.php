<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );
    /**
     * @var Printq_Controller_Design $this
     */

    $product   = get_post( intval( isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : 0 ) );
    $pqd_nonce = wp_create_nonce( 'pqd_nonce' );

    $preload_logo = wp_get_attachment_image_url( pqd_get_config( 'logo_preload' ), 'full' );
    if( !$preload_logo ) {
        $preload_logo = PRINTQ_IMG_URL . 'logo_preload.png';
    }

    $this->enqueue_script( 'pqd_pace', pqd_js_url( 'pace.min.js' ) );
    $this->localize( 'pqd_pace', 'preloadLogo', $preload_logo );
    $this->_wp_scripts->do_head_items();
?>

<title><?php echo sprintf( __( 'Personalize %s', PQD_DOMAIN ), $product->post_title ) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0, user-scalable=no"/>
<meta name="csrf-token" content="<?php echo esc_attr( $pqd_nonce ); ?>">
<script type="text/template" id="pqd_qq_uploader">
    <div class="qq-uploader-selector qq-uploader">
        <div class="qq-upload-drop-area"><span class="upload_text">{dragZoneText}</span> <span class="upload_arrow"></span>
            <span class="upload_ico icon printqicon-upload qq-upload-button btn btn-success"></span></div>
        <span class="back-to-cloud-albums btn btn-success"></span>
        <span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>
        <ul class="qq-upload-list-selector qq-upload-list">
            <li>
                <div class="qq-progress-bar-container-selector">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                         class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <span class="qq-upload-file-selector qq-upload-file"></span>
                <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                <span class="qq-upload-size-selector qq-upload-size"></span>
                <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
                <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
                <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
            </li>
        </ul>
    </div>
</script>
<?php
    $upload_dir = wp_upload_dir();


    $uploadPhotoDirName = Printq_Design_Helper::getUserUploadDirectory();
    $uploadedDirPath    = PRINTQ_UPLOAD_URL;

    $projectData = $this->getTemplate();
    $projectName = isset( $_REQUEST['pqd_template'] ) ? intval( $_REQUEST['pqd_template'] ) : '';
    $project_id  = $projectName;

    $is_admin = isset( $_REQUEST['is_admin'] );
    $fonts    = $this->getFonts();

    $tmpl_data = $this->get3DData();
    $this->enqueue_style( 'pqd_designer', pqd_css_url( 'designer.min.css' ) );
    $this->enqueue_style( 'pqd_sweet_alert_sweetalert', pqd_css_url( 'sweetalert.min.css' ) );
    $this->enqueue_style( 'pqd_editor_icons', pqd_css_url( 'editor_icons.min.css' ) );
    $this->enqueue_style( 'pqd_pace', pqd_css_url( 'pace.min.css' ) );
    $this->enqueue_style( 'pqd_bottombar_mobile', pqd_css_url( 'bottombar_mobile.min.css' ) );
    $this->enqueue_style( 'pqd_default', pqd_css_url( 'default.min.css' ) );
    $this->enqueue_style( 'pqd_sidebar', pqd_css_url( 'sidebar.min.css' ) );
    $this->enqueue_style( 'pqd_personalization_mobile_designer', pqd_css_url( 'personalization_mobile_designer.min.css' ) );
    $this->enqueue_style( 'pqd_fineuploader-3.4.1', pqd_css_url( 'fineuploader-3.4.1.min.css' ) );
    $this->enqueue_style( 'pqd_toolbars', pqd_css_url( 'toolbars.min.css' ) );
    $this->enqueue_style( 'pqd_jquery-ui', pqd_css_url( 'jquery-ui.min.css' ) );
    $this->enqueue_style( 'pqd_custom_scrollbar', pqd_css_url( 'jquery.mCustomScrollbar.min.css' ) );
    $this->enqueue_style( 'pqd_google_fonts', 'https://fonts.googleapis.com/css?family=Abel|Abril+Fatface|Amatic+SC|Anton|Arimo|Cinzel|Dancing+Script|Dosis|Droid+Sans|Droid+Serif|Exo|Francois+One|Inconsolata|Indie+Flower|Josefin+Slab|Kaushan+Script|Lato|Lobster|Lora|Merriweather|Montserrat|News+Cycle|Noticia+Text|Noto+Sans|Open+Sans|Open+Sans+Condensed:300|Orbitron|Oswald|PT+Sans|PT+Sans+Narrow|Pacifico|Play|Poiret+One|Raleway|Roboto|Roboto+Condensed|Roboto+Mono|Roboto+Slab|Rokkitt|Shadows+Into+Light|Slabo+27px|Source+Sans+Pro|Titillium+Web|Ubuntu|Yanone+Kaffeesatz|Yellowtail' );
    $this->enqueue_style( 'pqd_theme_css', add_query_arg( array(
                                                                  'action'    => 'pqd_design',
                                                                  'subaction' => 'themecss',
                                                                  'pqd_nonce' => $pqd_nonce
                                                          ), get_admin_url( null, 'admin-ajax.php' ) ) );

    $this->_wp_styles->do_items();

    $this->enqueue_script( 'pqd_combined_scripts', pqd_js_url( 'combined_scripts.min.js' ), array(
            'jquery',
            'jquery-ui-widget',
            'jquery-ui-mouse'
    ) );
    $this->enqueue_script( 'pqd_fineuploader', pqd_js_url( 'jquery.fine-uploader.js' ), array( 'jquery' ) );
    $this->enqueue_script( 'pqd_fabric.1.4.5.39', pqd_js_url( 'fabric.1.4.5.39.min.js' ), array( 'jquery' ) );
    $this->enqueue_script( 'pqd_designer', pqd_js_url( 'designer.min.js' ), array(
            'jquery',
            'jquery-ui-widget',
            'jquery-ui-draggable',
            'jquery-ui-droppable',
            'jquery-ui-tooltip',
            'jquery-ui-slider'
    ) );
    $this->enqueue_script( 'pqd_designer_mobile', pqd_js_url( 'designer_mobile.min.js' ), array( 'pqd_designer' ) );
    $this->enqueue_script( 'pqd_mcustom_scrollbar', pqd_js_url( 'jquery.mCustomScrollbar.min.js' ), array( 'jquery' ) );
    $this->enqueue_script( 'pqd_lazysizes', pqd_js_url( 'lazysizes.min.js' ), array( 'jquery' ) );
    $this->enqueue_script( 'pqd_lazyload', pqd_js_url( 'lazyload.min.js' ), array( 'jquery' ) );
    $this->enqueue_script( 'pqd_chromoselector', pqd_js_url( 'chromoselector.min.js' ), array( 'jquery' ) );
    $this->enqueue_script( 'pqd_sweet_alert', pqd_js_url( 'sweet_alert/sweetalert.min.js' ) );
    $this->enqueue_script( 'pqd_replace_alert', pqd_js_url( 'sweet_alert/replace_alert.min.js' ) );
    $this->enqueue_script( 'pqd_popupWindow', pqd_js_url( 'jquery.popupWindow.min.js' ), array( 'jquery' ) );
    $this->enqueue_script( 'pqd_jquery-browser', pqd_js_url( 'jquery.browser.min.js' ), array( 'jquery' ) );

    $this->localize( 'pqd_designer', 'pqd_nonce', $pqd_nonce );
    $this->localize( 'pqd_designer', 'translateStrings', array(
            'page'                     => __( 'Page', PQD_DOMAIN ),
            'delete'                   => __( 'Delete', PQD_DOMAIN ),
            'addToCart'                => __( 'I have double-checked my data!', PQD_DOMAIN ),
            'areYouSure'               => __( 'Are you Sure?', PQD_DOMAIN ),
            'facebook'                 => array(
                    'notLoggedIn' => __( 'Are you Sure?', PQD_DOMAIN )
            ),
            'confirmDeletePageText'    => __( "Are you sure you want to delete this page?", PQD_DOMAIN ),
            'filtersName'              => array(
                    'Original'  => __( 'Original', PQD_DOMAIN ),
                    'Grayscale' => __( 'Grayscale', PQD_DOMAIN ),
                    'Sepia2'    => __( 'Sepia2', PQD_DOMAIN ),
                    'Sepia'     => __( 'Sepia', PQD_DOMAIN ),
                    'Invert'    => __( 'Invert', PQD_DOMAIN ),
                    'Emboss'    => __( 'Emboss', PQD_DOMAIN ),
                    'Sharpen'   => __( 'Sharpen', PQD_DOMAIN ),
                    'Blur'      => __( 'Blur', PQD_DOMAIN )
            ),
            'previewPageValidate'      => __( 'Please check all of your Pages before Add To Cart', PQD_DOMAIN ),
            'confirmAttach'            => __( 'You have to double-check your data', PQD_DOMAIN ),
            'error'                    => __( 'An error has occured', PQD_DOMAIN ),
            'deleteFail'               => __( 'Delete Failed', PQD_DOMAIN ),
            'save'                     => __( 'Save', PQD_DOMAIN ),
            'load'                     => __( 'Load', PQD_DOMAIN ),
            'alert_save'               => __( 'Please enter a Project Name', PQD_DOMAIN ),
            'save_complete'            => __( 'Project Saved!', PQD_DOMAIN ),
            'confirmDeleteProjectText' => __( 'Are you sure you want to delete this project?', PQD_DOMAIN ),
            'confirmLoadProjectText'   => __( 'Are you sure you want to load this project?', PQD_DOMAIN ),
            'projectLoaded'            => __( 'Project Successfully Loaded. Please click on close to get back to your design', PQD_DOMAIN ),
            'transparency_edit'        => __( 'Opacity', PQD_DOMAIN ),
            'align_edit'               => __( 'Align', PQD_DOMAIN ),
            'position_edit'            => __( 'Position', PQD_DOMAIN ),
            'fonts_edit'               => __( 'Fonts', PQD_DOMAIN ),
            'fontsize_edit'            => __( 'Font Size', PQD_DOMAIN ),
            'decoration_edit'          => __( 'Decorations', PQD_DOMAIN ),
            'effect_edit'              => __( 'Image Effects', PQD_DOMAIN ),
            'color_edit'               => __( 'Colors', PQD_DOMAIN ),
            'layouts'                  => __( 'Layouts', PQD_DOMAIN ),
            'shapes'                   => __( 'Shapes', PQD_DOMAIN ),
            'backgrounds'              => __( 'Backgrounds', PQD_DOMAIN ),
            'pagination'               => __( 'Pagination', PQD_DOMAIN ),
            'block_options'            => __( 'Block Options', PQD_DOMAIN ),
            'sweetAlert'               => array(
                    'confirmButtonText' => __( 'Yes!', PQD_DOMAIN ),
                    'cancelButtonText'  => __( 'No!', PQD_DOMAIN ),
                    'okButtonText'      => __( 'Ok', PQD_DOMAIN ),
            )
    ) );
    $this->localize( 'pqd_designer', 'tooltipTranslation', array(
            'add_page'       => array(
                    'title'       => __( 'Add Page', PQD_DOMAIN ),
                    'description' => __( 'A new page is added to designer!', PQD_DOMAIN )
            ),
            'save_project'   => array(
                    'title'       => __( 'Save Project', PQD_DOMAIN ),
                    'description' => __( 'Save this project', PQD_DOMAIN )
            ),
            'load_project'   => array(
                    'title'       => __( 'Load Project', PQD_DOMAIN ),
                    'description' => __( 'Select project to load', PQD_DOMAIN )
            ),
            'delete_page'    => array(
                    'title'       => __( 'Delete Page', PQD_DOMAIN ),
                    'description' => __( 'Current Page is deleted', PQD_DOMAIN )
            ),
            'add_layout'     => array(
                    'title'       => __( 'Layouts', PQD_DOMAIN ),
                    'description' => __( 'Select a layout', PQD_DOMAIN )
            ),
            'add_background' => array(
                    'title'       => __( 'Backgrounds', PQD_DOMAIN ),
                    'description' => __( 'Select a background', PQD_DOMAIN )
            ),
            'add_shape'      => array(
                    'title'       => __( 'Shapes', PQD_DOMAIN ),
                    'description' => __( 'Select a shape', PQD_DOMAIN )
            ),
            'add_curvedtext' => array(
                    'title'       => __( 'Curved Text', PQD_DOMAIN ),
                    'description' => __( 'Add a new curved text', PQD_DOMAIN )
            ),
            'add_text'       => array(
                    'title'       => __( 'TextBox', PQD_DOMAIN ),
                    'description' => __( 'Add a new text box', PQD_DOMAIN )
            ),
            'block_options'  => array(
                    'title'       => __( 'Block Options', PQD_DOMAIN ),
                    'description' => __( 'Change designer block options', PQD_DOMAIN )
            ),
            'drawing'        => array(
                    'title'       => __( 'Drawing', PQD_DOMAIN ),
                    'description' => __( 'Draw custom shapes or use free drawing', PQD_DOMAIN )
            ),
            'enable_resize'  => array(
                    'title'       => __( 'Resize', PQD_DOMAIN ),
                    'description' => __( 'Enable/Disable Resize Objects', PQD_DOMAIN )
            ),
            'enable_rotate'  => array(
                    'title'       => __( 'Rotate', PQD_DOMAIN ),
                    'description' => __( 'Enable/Disable Rotate Objects', PQD_DOMAIN )
            ),
            'enable_snap'    => array(
                    'title'       => __( 'Snap', PQD_DOMAIN ),
                    'description' => __( 'Enable/Disable Snap Objects', PQD_DOMAIN )
            ),
            'enable_move'    => array(
                    'title'       => __( 'Move', PQD_DOMAIN ),
                    'description' => __( 'Enable/Disable Move Objects', PQD_DOMAIN )
            ),
            'draw_circle'    => array(
                    'title'       => __( 'Circle', PQD_DOMAIN ),
                    'description' => __( 'Draw a Circle', PQD_DOMAIN )
            ),
            'close'          => array(
                    'title'       => __( 'Close', PQD_DOMAIN ),
                    'description' => __( 'Closes current edit screen without saving changes', PQD_DOMAIN )
            ),
            'draw_square'    => array(
                    'title'       => __( 'Square', PQD_DOMAIN ),
                    'description' => __( 'Draw a Square', PQD_DOMAIN )
            ),
            'draw_free'      => array(
                    'title'       => __( 'Free', PQD_DOMAIN ),
                    'description' => __( 'Unleash your imagination', PQD_DOMAIN )
            ),
            'image_quality'  => array(
                    'title'       => __( 'Image Quality', PQD_DOMAIN ),
                    'description' => __( 'Image Quality', PQD_DOMAIN )
            ),
            'download_pdf'   => array(
                    'title'       => __( 'Download PDF', PQD_DOMAIN ),
                    'description' => __( 'Download PDF', PQD_DOMAIN )
            ),
            'helper_element' => array(
                    'title'       => __( 'Helper', PQD_DOMAIN ),
                    'description' => __( 'Enable to set this element as a helper for your customers. ' .
                                         'Helper elements do not appear in added to cart products', PQD_DOMAIN )
            ),
            'locked_element' => array(
                    'title'       => __( 'Lock', PQD_DOMAIN ),
                    'description' => __( 'Enable this to prevent users from changing this element', PQD_DOMAIN )
            ),
    ) );
    $this->localize( 'pqd_designer', 'mediaUrl', PRINTQ_ASSETS_URL );
    $this->localize( 'pqd_designer', 'baseUrl', PRINTQ_URL );
    $this->localize( 'pqd_designer', 'fabricRotateUrl', PRINTQ_IMG_URL . 'logo.png' );
    $this->localize( 'pqd_designer', 'shapeUrlLocation', PRINTQ_SHAPES_URL );
    $this->localize( 'pqd_designer', 'backgroundUrl', '' );
    $this->localize( 'pqd_designer', 'deleteUserPhotoUrl', add_query_arg( array(
                                                                                  'action'    => 'pqd_design',
                                                                                  'subaction' => 'delete',
                                                                                  'pqd_nonce' => $pqd_nonce,
                                                                          ), get_admin_url( null, 'admin-ajax.php' ) ) );

    $user_photos_url       = add_query_arg( array(
                                                    'action'    => 'pqd_design',
                                                    'subaction' => 'upload',
                                                    'pqd_nonce' => $pqd_nonce,
                                            ), get_admin_url( null, 'admin-ajax.php' ) );
    $download_pdf_url      = add_query_arg( array(
                                                    'action'    => 'pqd_design',
                                                    'subaction' => 'downloadPdf'
                                            ), get_admin_url( null, 'admin-ajax.php' ) );
    $download_pdf_file_url = add_query_arg( array(
                                                    'action'    => 'pqd_design',
                                                    'subaction' => 'downloadPdfFile',
                                                    'file'      => ''
                                            ), get_admin_url( null, 'admin-ajax.php' ) );
    $instagramActionUrl    = add_query_arg( array(
                                                    'pqd'       => 'instagram',
                                                    'pqd_nonce' => $pqd_nonce,
                                            ), get_home_url() );

    $this->localize( 'pqd_designer', 'downloadPdfUrl', $download_pdf_url );
    $this->localize( 'pqd_designer', 'downloadPdfFileUrl', $download_pdf_file_url );
    $this->localize( 'pqd_designer', 'uploadUrlPhotoUrl', $user_photos_url );
    $this->localize( 'pqd_designer', 'instagramActionUrl', $instagramActionUrl );
    $this->localize( 'pqd_designer', 'unsplashActionUrl', add_query_arg( array(
                                                                                 'action'    => 'pqd_unsplash',
                                                                                 'subaction' => 'init_photos'
                                                                         ), get_admin_url( null, 'admin-ajax.php' ) ) );
    $this->localize( 'pqd_designer', 'searchUnsplashUrl', add_query_arg( array(
                                                                                 'action'    => 'pqd_unsplash',
                                                                                 'subaction' => 'search_photos'
                                                                         ), get_admin_url( null, 'admin-ajax.php' ) ) );
    if( !is_admin() && isset( $_REQUEST['post'] ) ) {
        if( isset( $_REQUEST['pqd_personalize'] ) ) {
            $_REQUEST['product_id'] = $_REQUEST['pqd_personalize'];
            unset( $_REQUEST['pqd_personalize'] );
        }
        if( isset( $_REQUEST['add-to-cart'] ) ) {
            $_REQUEST['product_id'] = $_REQUEST['add-to-cart'];
            unset( $_REQUEST['add-to-cart'] );
        }
        $this->localize( 'pqd_designer', 'addToCartUrl', add_query_arg( array( 'action' => 'woocommerce_add_to_cart' ), get_admin_url( null, 'admin-ajax.php' ) ) );
        $this->localize( 'pqd_designer', 'addToCartData', $_REQUEST );
    } else {
        $this->localize( 'pqd_designer', 'addToCartUrl', $_REQUEST );
        $this->localize( 'pqd_designer', 'addToCartData', array() );
    }
    $this->localize( 'pqd_designer', 'wc_pqd_cart_url', wc_get_cart_url() );
    $this->localize( 'pqd_designer', 'uploadUserPhotoUrl', $user_photos_url );
    $this->localize( 'pqd_designer', 'getUserPhotosUrl', $user_photos_url );
    $this->localize( 'pqd_designer', 'getShapesUrl', add_query_arg( array(
                                                                            'action'    => 'pqd_design',
                                                                            'subaction' => 'get_shapes'
                                                                    ), get_admin_url( null, 'admin-ajax.php' ) ) );
    $this->localize( 'pqd_designer', 'uploadedDirPath', $uploadedDirPath );
    $this->localize( 'pqd_designer', 'uploadPhotoDirName', $uploadPhotoDirName );
    $this->localize( 'pqd_designer', 'facebookAppId', pqd_get_config( 'facebook_app_id' ) );
    $this->localize( 'pqd_designer', 'deletePhotoText', __( 'Are you sure you want to delete this photo?', PQD_DOMAIN ) );
    $this->localize( 'pqd_designer', 'defaultEditorColors', array(
            array(
                    'title'     => 'White',
                    'RGB'       => '255,255,255',
                    'CMYK'      => '255,255,255',
                    'htmlRGB'   => '255,255,255',
                    'SPOT'      => 'Black',
                    'SPOT_TINT' => '1',
            ),
            array(
                    'title'     => 'TORQOISE',
                    'RGB'       => '0 255 222',
                    'CMYK'      => '0 255 222 0',
                    'htmlRGB'   => '0,255,222',
                    'SPOT'      => '',
                    'SPOT_TINT' => '',
            ),
            array(
                    'title'     => 'BLUE',
                    'RGB'       => '33 50 70',
                    'CMYK'      => '0 0 0 1',
                    'htmlRGB'   => '33,50,70',
                    'SPOT'      => '',
                    'SPOT_TINT' => '',
            ),
            array(
                    'title'     => 'GRAY',
                    'RGB'       => '204 204 204',
                    'CMYK'      => '0 1 1 0',
                    'htmlRGB'   => '204,204,204',
                    'SPOT'      => '',
                    'SPOT_TINT' => '',
            ),
            array(
                    'title'     => 'transparent',
                    'RGB'       => '0 1 0',
                    'CMYK'      => '1 0 1 0',
                    'htmlRGB'   => 'transparent',
                    'SPOT'      => '',
                    'SPOT_TINT' => '',
            ),
            array(
                    'title'     => 'BLUE',
                    'RGB'       => '0 0 0',
                    'CMYK'      => '0 0 0 1',
                    'htmlRGB'   => '0,0,0',
                    'SPOT'      => '',
                    'SPOT_TINT' => '',
            ),
            'black' =>
                    array(
                            'title'     => 'Black',
                            'RGB'       => '0 0 0',
                            'CMYK'      => '0 0 0 1',
                            'htmlRGB'   => '0,0,0',
                            'SPOT'      => 'Black',
                            'SPOT_TINT' => '1',
                    ),
            'white' =>
                    array(
                            'title'     => 'White',
                            'RGB'       => '1 1 1',
                            'CMYK'      => '0 0 0 0',
                            'htmlRGB'   => '255,255,255',
                            'SPOT'      => 'White',
                            'SPOT_TINT' => '1',
                    ),
    ) );

    if( !$is_admin ) {
        $template_data = get_post( $project_id, ARRAY_A );
        if( $template_data['post_content'] ) {
            $this->localize( 'pqd_designer', 'defaultThemeProduct', json_decode( $template_data['post_content'], 1 ) );
        } else {
            $this->localize( 'pqd_designer', 'defaultThemeProduct', array(
                    array(
                            'id'           => '3',
                            'theme_id'     => '3',
                            'content_type' => 'svg',
                            'content'      => '',
                            'page_number'  => '1',
                            'made_by'      => 'admin',
                            'width'        => '800',
                            'height'       => '600',
                            'svgfile'      => null,
                            'visited'      => true,
                    )
            ) );
        }
    }
    ob_start();
    //cannot add scalar values to localize
    if( $is_admin ) { ?>
        var defaultThemeProduct = window.parent.printqCurrentyEditContent;
    <?php } ?>
var defaultThemeID = JSON.parse( '\"1\"' ),
iframe_update = true,
previewType = '<?php echo isset( $tmpl_data['enable_3d_preview'] ) && $tmpl_data['enable_3d_preview'] == 1 ? 'tdpreview' : '' ?>',
rd_texture = '<?php echo isset( $tmpl_data['3d_texture'] ) ? $tmpl_data['3d_texture'] : '' ?>',
isFrontEndUser = <?php echo $is_admin ? 'false' : 'true' ?>,
admin = <?php echo $is_admin ? 'true' : 'false' ?>,
defaultBackgroundName = 'test.jpg',
pdfDesignerInfo = '',
allowFacebook = 1,
allowInstagram = 1,
allowBackgroundPdf = 1,
allowMouseZoomHandler = 1;
<?php
    $js = ob_get_clean();
    $this->_wp_scripts->add_inline_script( 'pqd_designer', $js, 'before' );
    $this->_wp_scripts->do_head_items();
?>
