<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );
    /**
     * @var Printq_Controller_Design $this
     */

    $tmpl_data = $this->get3DData();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once PRINTQ_VIEWS_DIR . 'head.php'; ?>
    </head>
    <body>
        <?php require_once PRINTQ_VIEWS_DIR . 'content/pagination.php'; ?>
        <div class="container">
            <div id="mainContent">
                <?php require_once PRINTQ_VIEWS_DIR . 'content/topbar.php'; ?>
                <?php require_once PRINTQ_VIEWS_DIR . 'content/topbarmobile.php'; ?>
                <?php require_once PRINTQ_VIEWS_DIR . 'content/sidebar.php'; ?>
                <?php require_once PRINTQ_VIEWS_DIR . 'content/sidebarmobile.php'; ?>
                <div id="subcontent" class="tab-content">
                    <div id="edit_tab" data-type="edit" class="tab_pane active">
	                
                        <?php require_once PRINTQ_VIEWS_DIR . 'content/content.php'; ?>
                        <?php require_once PRINTQ_VIEWS_DIR . 'content/toolbars.php'; ?>
                        <div class="toolbarsContainer">
                            <?php require_once PRINTQ_VIEWS_DIR . 'content/toolbarsmobile.php'; ?>
                        </div>
                    </div>
                     <div id="tdIframe">
                        <?php
                            if( isset( $tmpl_data['enable_3d_preview'] ) && $tmpl_data['enable_3d_preview'] == 1 ):?>
                                <div class="frame_preview">
                                    <?php
                                        $preview_3d_url = add_query_arg( array(
                                                                                 'action'    => 'pqd_design',
                                                                                 'subaction' => 'preview3d',
                                                                                 'model'     => $tmpl_data['3d_model'],
                                                                                 'pqd_nonce' => wp_create_nonce( 'pqd_nonce' )
                                                                         ), get_admin_url( null, 'admin-ajax.php' ) );
                                    ?>
                                    <iframe id="frame_3d" frameBorder="0" src="<?php echo esc_url( $preview_3d_url ) ?>">
                                </iframe>
                            </div>
                            <?php endif;
                        ?>
                    </div>

                </div>
                <?php require_once PRINTQ_VIEWS_DIR . 'content/gallery.php'; ?>
            </div>
        </div>

        <div id="loading-mask">
            <div class="loader printqBox" id="loading_mask_loader">
                <span class="message" style=""><?php _e( 'Please Wait...' ) ?></span>
                <div class="animation-container">
                    <div class='loader-animation'>
                        <?php for( $i = 0; $i < 24; $i ++ ): ?>
                            <div></div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tooltip" style="display:none">
            <?php require_once PRINTQ_VIEWS_DIR . 'content/tooltip.php'; ?>
        </div>
        <div class="curvedTextEditMode">
            <div class="printqBox containerCurved">
                <div class="editZone">
                    <textarea></textarea>
                </div>
                <div class="actions">
                    <button class="cancel_edit_text button btn-cart clickActionCurvedText" title="Cancel" type="button"
                            data-action="cancel_edit_text">
                        <span>
                            <span><?php _e( 'Cancel', PQD_DOMAIN ); ?></span>
                        </span>
                    </button>
                    <button class="ok_edit_text button btn-cart clickActionCurvedText" title="OK" type="button" data-action="ok_edit_text">
                        <span>
                            <span><?php _e( 'OK', PQD_DOMAIN ); ?></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <?php require_once PRINTQ_VIEWS_DIR . 'content/bottombarmobile.php'; ?>
        <?php require_once PRINTQ_VIEWS_DIR . 'content/objectList.php'; ?>

        <!-- PrintQ footer START -->
        <?php
            $this->_wp_scripts->do_footer_items();

            $this->_wp_styles->print_inline_style( 'pqd_designer', true );
            $this->_wp_styles->do_footer_items(); ?>
        <!-- PrintQ footer END -->

    </body>
</html>
