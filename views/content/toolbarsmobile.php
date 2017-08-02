<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );
    $is_admin = isset( $_REQUEST['is_admin'] );
    if( !$is_admin ) {
        //get template meta
        $template_id = isset( $_REQUEST['pqd_template'] ) ? intval( $_REQUEST['pqd_template'] ) : 0;
        $post_meta   = get_post_meta( $template_id, 'pqd_template_settings', true );
        if( isset( $post_meta['block_options'] ) ) {
            $block_options = (array) $post_meta['block_options'];
            $move          = isset( $block_options['move'] ) && intval( $block_options['move'] ) == 1 ? 1 : 0;
            $resize        = isset( $block_options['resize'] ) && intval( $block_options['resize'] ) == 1 ? 1 : 0;
            $snap          = isset( $block_options['snap'] ) && intval( $block_options['snap'] ) == 1 ? 1 : 0;
            $rotate        = isset( $block_options['rotate'] ) && intval( $block_options['rotate'] ) == 1 ? 1 : 0;
        } else {
            $move = $resize = $snap = $rotate = 0;
        }
    } else {
        //enable all block options for admin
        $move = $resize = $snap = $rotate = 1;
    }
?>
<div class="toolbarContainerMobile  toolbarMobile">
    <ul class="mobileDefaultMainToolbar textToolbarMobile">
        <li class="group fontname_group">
            <a href="javascript:void(0)" class="mainItem clickAction" data-state="fonts_edit" data-action="changeState">
                <div>
                    <span class="icon printqicon-font"></span>
                    <span class="title"><?php _e( 'Fonts', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group fontsize_group">
            <a href="javascript:void(0)" class="mainItem clickAction" data-state="fontsize_edit" data-action="changeState">
                <div>
                    <span class="icon printqicon-fontsize2"></span>
                    <span class="title"><?php _e( 'Font Size', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group position_group">
            <a href="javascript:void(0)" class="mainItem clickAction" data-state="position_edit" data-action="changeState">
                <div>
                    <span class="icon printqicon-layers"></span>
                    <span class="title"><?php _e( 'Position', PQD_DOMAIN ) ?></span>
                </div>
            </a>
        </li>
        <li class="group duplicate_group">
            <a href="javascript:void(0)" class="mainItem clickTextAction" data-action="duplicate">
                <div>
                    <span class="icon printqicon-duplicate"></span>
                    <span class="title"><?php _e( 'Duplicate', PQD_DOMAIN ) ?></span>
                </div>
            </a>
        </li>
        <li class="group decorations_group">
            <a href="javascript:void(0)" class="mainItem clickAction" data-state="decoration_edit"
               data-action="changeState">
                <div>
                    <span class="icon printqicon-underline"></span>
                    <span class="title"><?php _e( 'Decorations', PQD_DOMAIN ) ?></span>
                </div>
            </a>
        </li>
        <li class="group valignment_group">
            <a href="javascript:void(0)" class="mainItem clickAction" data-state="align_edit" data-action="changeState">
                <div>
                    <span class="icon printqicon-justify_align"></span>
                    <span class="title"><?php _e( 'Align', PQD_DOMAIN ) ?></span>
                </div>
            </a>
        </li>
        <li class="group transparency_group">
            <a href="javascript:void(0)" class="mainItem clickTextAction" data-state="transparency_edit"
               data-action="changeState">
                <div>
                    <span class="icon printqicon-opacity"></span>
                    <span class="title"><?php _e( 'Opacity', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group color_group">
            <a href="javascript:void(0)" class="mainItem clickTextAction" data-state="color_edit" data-action="changeState">
                <div>
                    <span class="icon printqicon-opacity"></span>
                    <span class="title"><?php _e( 'Color', PQD_DOMAIN ) ?></span>
                </div>
            </a>
        </li>
    </ul>
    <ul class="mobileDefaultMainToolbar subItem subItemPosition">
        <li class="group clickTextAction" data-action="position" data-state="bringtofront">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-bringtofront"></span>
                    <span class="title"><?php _e( 'Bring To Front', PQD_DOMAIN ) ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="position" data-state="bringforward">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-bringforward"></span>
                    <span class="title"><?php _e( 'Bring Forward', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="position" data-state="sendtoback">
            <a href="javascript:void(0)" class="mainItem">
                <div class="infos">
                    <span class="icon printqicon-sendtoback"></span>
                    <span class="title"><?php _e( 'Send To Back', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="position" data-state="sendbackward">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-sendbackward"></span>
                    <span class="title"><?php _e( 'Send Backward', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
    </ul>
    <ul class="mobileDefaultMainToolbar subItem subItemAlign">
        <li class="group clickTextAction" data-action="align" data-state="left">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-left_align"></span>
                    <span class="title"><?php _e( 'Left', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="align" data-state="center">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-center_align"></span>
                    <span class="title"><?php _e( 'Center', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="align" data-state="right">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-right_align"></span>
                    <span class="title"><?php _e( 'Right', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="align" data-state="justify">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-justify_align"></span>
                    <span class="title"><?php _e( 'Justify', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
    </ul>
    <ul class="mobileDefaultMainToolbar subItem subItemDecoration">
        <li class="group clickTextAction" data-action="decoration" data-state="italic">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-italic"></span>
                    <span class="title"><?php _e( 'Italic', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="decoration" data-state="bold">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-bold"></span>
                    <span class="title"><?php _e( 'Bold', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="decoration" data-state="normal">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-font"></span>
                    <span class="title"><?php _e( 'Normal', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="decoration" data-state="underline">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-underline"></span>
                    <span class="title"><?php _e( 'Underline', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
    </ul>
    <ul class="mobileDefaultMainToolbar subItem subItemFontSize">
        <li class="group clickTextAction" data-action="fontsizeIncrease">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-fontsize2"></span>
                    <span class="title"><?php _e( 'Increase', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group clickTextAction" data-action="fontsizeDecrease">
            <a href="javascript:void(0)" class="mainItem">
                <div>
                    <span class="icon printqicon-fontsize"></span>
                    <span class="title"><?php _e( 'Decrease', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
    </ul>
    <div class="mobileDefaultMainToolbar effectToolBarMobile">
        <div class="containerEffects">
            <ul class="mobileDefaultMainToolbar subItem subItemEffects">
            </ul>
        </div>
    </div>
    <div class="fontsContainerMobile">
        <div class="containerFonts">
            <ul class="mobileDefaultMainToolbar subItem subItemFonts">
                <?php $fonts = $this->getFonts(); ?>
                <?php foreach( $fonts as $font ): ?>
                    <li class="group clickTextAction" data-action="font" data-state="<?php echo $font; ?>">
                        <a href="javascript:void(0)" class="mainItem">
                            <div>
                                <span class="icon" style="font-family: <?php echo $font . ' !important;'; ?>">Ag</span>
                                <span class="title"><?php echo esc_html( $font ); ?></span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <ul class="mobileDefaultMainToolbar defaultToolbarMobile">
        <li class="group position_group">
            <a href="javascript:void(0)" class="mainItem clickDefaultAction" data-action='changeState' data-state="position_edit">
                <div>
                    <span class="icon printqicon-layers"></span>
                    <span class="title"><?php _e( 'Position', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group duplicate_group">
            <a href="javascript:void(0)" class="mainItem clickDefaultAction" data-action="duplicate">
                <div>
                    <span class="icon printqicon-duplicate"></span>
                    <span class="title"><?php _e( 'Duplicate', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group transparency_group">
            <a href="javascript:void(0)" class="mainItem clickDefaultAction" data-action='changeState' data-state="transparency_edit">
                <div>
                    <span class="icon printqicon-opacity"></span>
                    <span class="title"><?php _e( 'Opacity', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group color_group">
            <a href="javascript:void(0)" class="mainItem clickDefaultAction" data-action='changeState' data-state="color_edit">
                <div>
                    <span class="icon printqicon-opacity"></span>
                    <span class="title"><?php _e( 'Color', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
    </ul>
    <div class="mobileDefaultMainToolbar colorToolBarMobile">
        <div class="containerColors">
            <ul class="mobileDefaultMainToolbar subItem subItemtextColors">

                <li class="group">
                    <a href="javascript:void(0)" class="mainItem clickTextAction" data-action="change-color" data-colorid="4"
                       data-color="transparent">
                         <div class="color_placeholder" style="background-image: url('<?php echo PRINTQ_IMG_URL ?>transparent.png')">
                            <b class="icon printqicon-ok"></b>
                        </div>
                    </a>
                </li>
                <li class="group">
                    <a href="javascript:void(0)" class="mainItem clickTextAction" data-action="change-color" data-colorid="0" data-color="#fff">
                         <div class="color_placeholder" style="background-color: #fff">
                            <b class="icon printqicon-ok"></b>
                        </div>
                    </a>
                </li>
                <li class="group">
                    <a href="javascript:void(0)" class="mainItem clickTextAction" data-action="change-color" data-colorid="1" data-color="#00FFDE">
                         <div class="color_placeholder" style="background-color: #00FFDE">
                            <b class="icon printqicon-ok"></b>
                        </div>
                    </a>
                </li>
                <li class="group">
                    <a href="javascript:void(0)" class="mainItem clickTextAction" data-action="change-color" data-colorid="3" data-color="#cccccc">
                         <div class="color_placeholder" style="background-color: #cccccc">
                            <b class="icon printqicon-ok"></b>
                        </div>
                    </a>
                </li>
                <li class="group">
                    <a href="javascript:void(0)" class="mainItem clickTextAction" data-action="change-color" data-colorid="2" data-color="#213246">
                         <div class="color_placeholder" style="background-color: #213246">
                            <b class="icon printqicon-ok"></b>
                        </div>
                    </a>
                </li>
                <li class="group">
                    <a href="javascript:void(0)" class="mainItem clickTextAction" data-action="change-color" data-colorid="4" data-color="#000">
                         <div class="color_placeholder" style="background-color: #000">
                            <b class="icon printqicon-ok"></b>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="mobileDefaultMainToolbar toolbarTransparencyMobile">
        <div class="sliderMobile">
            <div class="transparency_slider_mobile">
            </div>
        </div>
    </div>
    <div class="toolbarImagesMobile">
        <ul class="mobileDefaultMainToolbar imagesToolbarMobile">
            <li class="group position_group clickImageAction" data-state="position_edit" data-action="changeState">
                <a href="javascript:void(0)" class="mainItem">
                    <div>
                        <span class="icon printqicon-layers"></span>
                        <span class="title"><?php _e( 'Position', PQD_DOMAIN ); ?></span>
                    </div>
                </a>
            </li>
            <li class="group transparency_group clickImageAction" data-state="transparency_edit" data-action="changeState">
                <a href="javascript:void(0)" class="mainItem">
                    <div>
                        <span class="icon printqicon-opacity"></span>
                        <span class="title"><?php _e( 'Opacity', PQD_DOMAIN ); ?></span>
                    </div>
                </a>
            </li>
            <li class="group effect_group clickImageAction" data-state="effect_edit" data-action="changeState">
                <a href="javascript:void(0)" class="mainItem">
                    <div>
                        <span class="icon printqicon-effects"></span>
                        <span class="title"><?php _e( 'Effects', PQD_DOMAIN ); ?></span>
                    </div>
                </a>
            </li>
            <li class="group duplicate_group clickImageAction" data-action="duplicate">
                <a href="javascript:void(0)" class="mainItem">
                    <div>
                        <span class="icon printqicon-duplicate"></span>
                        <span class="title"><?php _e( 'Duplicate', PQD_DOMAIN ); ?></span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="mobile_pagination custom_pagination PaginationContainerMobile">
        <div class="pagination content_manager_pagination_custom containerPagination">
            <ul id="customPagination">
            </ul>
        </div>
    </div>

    <div class="backgroundsContainerMobile mobileDefaultMainToolbar">
        <div class="backgroundsContainer">
            <ul class="mobileDefaultMainToolbar subItem subItemBackgrounds">
                    <li class="group">
                        <a href="javascript:void(0)" class="mainItem backgroundsMobileItem clickActionGeneral" data-action="change-background"
                           data-id="6" data-name="test">
                            <div class="background_image">
                                <b class="icon printqicon-ok"></b>
                              </div>
                        </a>
                    </li>
            </ul>
        </div>
    </div>

    <div class="shapesContainerMobile mobileDefaultMainToolbar">
        <div class="shapesContainer">
            <ul class="mobileDefaultMainToolbar subItem subItemShapes">
                <?php
                    $shapes     = array_slice( glob( PRINTQ_SHAPES_DIR . '*.svg' ), 0, 30 );
                    $categories = glob( PRINTQ_SHAPES_DIR . "*", GLOB_ONLYDIR );
                ?>
                <?php
                    foreach( $categories as $key => $category ):?>
                        <li class="group listItem" data-target="<?php echo esc_attr( basename( $category ) ); ?>">
                            <a href="javascript:void(0)"
                               class="mainItem shapesMobileItem clickDefaultAction"
                               data-state="category-shape" data-action="changeState"
                               style="<?php echo 'background: url(' . esc_attr( PRINTQ_SHAPES_URL . basename( $category ) . '.png' ) . ')'; ?>; -webkit-background-size: contain;background-size: contain;"
                               data-category="<?php echo esc_attr( basename( $category ) ); ?>"
                            >
                            </a>
                        </li>
                    <?php endforeach;
                ?>
            </ul>

            <ul class="mobileDefaultMainToolbar shapesMobileGalleryList"></ul>
        </div>
    </div>
    <ul class="mobileDefaultMainToolbar mainToolbarMobile">
            <li class="group mainToolbar_group">
                <a href="javascript:void(0)" class="mainItem clickDefaultAction" data-action="changeState" data-state="pagination">
                    <div>
                        <span class="icon printqicon-font"></span>
                        <span class="title"><?php _e( 'Pagination', PQD_DOMAIN ); ?></span>
                    </div>
                </a>
            </li>
            <li class="group mainToolbar_group">
                <a href="javascript:void(0)" class="mainItem clickDefaultAction" data-action="changeState" data-state="block_options">
                    <div>
                        <span class="icon printqicon-blockoptions"></span>
                        <span class="title"><?php _e( 'Block Options', PQD_DOMAIN ); ?></span>
                    </div>
                </a>
            </li>
        </ul>

    <ul class="mobileDefaultMainToolbar subItem subItemOptions">
        <li class="group draggable_group <?php echo $move ? 'active' : '' ?>">
            <a href="javascript:void(0)" class="mainItem  clickDefaultAction" data-action="movable_changer">
                <div>
                    <span class="icon printqicon-movable"></span>
                    <span class="title"><?php _e( 'Move', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group resizable_group <?php echo $resize ? 'active' : '' ?>">
            <a href="javascript:void(0)" class="mainItem  clickDefaultAction" data-action="resize_changer">
                <div>
                    <span class="icon printqicon-resizable"></span>
                    <span class="title"><?php _e( 'Resize', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group snap_group <?php echo $snap ? 'active' : '' ?>">
            <a href="javascript:void(0)" class="mainItem  clickDefaultAction" data-action="snap_changer">
                <div>
                    <span class="icon printqicon-snap"></span>
                    <span class="title"><?php _e( 'Snap', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
        <li class="group rotatable_group <?php echo $rotate ? 'active' : '' ?>">
            <a href="javascript:void(0)" class="mainItem  clickDefaultAction" data-action="rotate_changer">
                <div>
                    <span class="icon printqicon-rotatable"></span>
                    <span class="title"><?php _e( 'Rotatable', PQD_DOMAIN ); ?></span>
                </div>
            </a>
        </li>
    </ul>

</div>

<ul id="shapeItemMobileTemplate">
    <li class="group listItem empty">
        <a href="javascript:void(0)" class="mainItem shapesMobileItem clickActionGeneral" data-action="change-shape"
           style="-webkit-background-size: contain;background-size: contain;">
           <div class="shape_placeholder">
                <b class="icon printqicon-ok"></b>
           </div>
        </a>
    </li>
</ul>
