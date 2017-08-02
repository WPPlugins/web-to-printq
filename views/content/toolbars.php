<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    $is_admin = isset( $_REQUEST['is_admin'] );
    /**
     * @var Printq_Controller_Design $this
     */
?>
<div id="printqEditorToolbar" class="printqToolbar defaultPrintqEditorToolbar">
    <div class="printqToolbarTop toolbarSection">
            <div class="fontsContainer changer group fontname_group">
                <?php $fonts = $this->getFonts(); ?>
                <a class="current_font" href="javascript:void(0);"><span>Aventir Next LT Pro<span></a>
                <a style="font-size: 9px;float:right;" class="changeFont change icon printqicon-selectdown "></a>
                <ul>
                    <?php foreach( $fonts as $font ): ?>
                        <li data-action="fontname" data-fontname="<?php echo $font; ?>" class="clickAction"
                            style="font-family: <?php echo $font; ?>"><a
                                    href="javascript:void(0);"><?php echo $font; ?></a>
                            <span class="border_font"></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
                 <div class="group fontsize_group">
                <div class="changer pt">
                    <input id="fontsizeInput"/><label><?php echo 'pt'; ?>  </label>
                </div>
                <div class="changer standard buttons">
                    <div data-action="fontsize" data-type="increase" class="clickAction decreaseFont"><span class=>+</span></div>
                    <div data-action="fontsize" data-type="decrease" class="clickAction increaseFont"><span class=>-</span></div>
                </div>
            </div>
        <div class="group forecolor_group">
            <div class="forecolor_selector selector changer">
                <a class="current_color clickAction" data-action="color" href="javascript:void(0);">
                    <span class="colorChangerPreview" id="colorChangerPreview"></span>
                </a>
                <a class="changeForecolor change"></a>
            </div>
        </div>
        <div class="group moreText_group">
            <div class="changer">
                <a class="current" href="javascript:void(0)">
                    <span class="icon printqicon-more"></span>
                </a>
                <ul>
                    <li class="group clickAction">
                        <a href="javascript:void(0)">
                            <span class="icon printqicon-more"></span>
                        </a><span class="border_bottom"></span>
                    </li>
                    <li class="clickAction group" data-action="transparency">
                        <a href="javascript:void(0)">
                            <span class="icon printqicon-opacity"></span>
                        </a>
                        <span class="border_bottom"></span>
                    </li>

                    <li id="lineHeightElement" class="clickAction group" data-action="lineheight">
                        <a href="javascript:void(0)">
                            <span class="icon printqicon-spacing-1"></span>
                        </a>
                        <span class="border_bottom"></span>
                    </li>
                    <li id="letterSpacingElement" class="clickAction group normalTextOption" data-action="letterspacing">
                        <a href="javascript:void(0)">
                            <span class="icon printqicon-spacing"></span>
                        </a>
                        <span class="border_bottom"></span>
                    </li>
                    <li class="clickAction group curvedTextOption" data-action="change-radius">
                        <a href="javascript:void(0)">
                            <span class="icon printqicon-radiustext"></span>
                        </a>
                        <span class="border_bottom"></span>
                    </li>
                    <li class="clickAction group curvedTextOption" data-action="change-spacing">
                        <a href="javascript:void(0)">
                            <span class="icon printqicon-spacing"></span>
                        </a>
                        <span class="border_bottom"></span>
                    </li>
                    <li class="clickAction group curvedTextOption" data-action="change-reverse">
                        <a href="javascript:void(0)">
                            <span class="icon printqicon-reverse_text"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="printqToolbarBottom toolbarSection">
        <div class="group remove_block remove_block_group clickAction" data-action="delete">
            <a href="javascript:void(0);"><span class="icon printqicon-delete"></span></a>
        </div>
        <div class="group position_group">
            <div class="position_selector selector changer">
                <a class="current current_position" href="javascript:void(0)">
                <span class="icon printqicon-layers"><span>
                </a>
                <ul>
                    <li class="clickAction" data-action="position" data-position='bringtofront'><a
                                href="javascript:void(0);"><span class="icon printqicon-bringtofront"></span></a><span
                                class="border_bottom"></span></li>
                    <li class="clickAction" data-action="position" data-position='bringforward'><a
                                href="javascript:void(0);"><span class="icon printqicon-bringforward"></span></a><span
                                class="border_bottom"></span></li>
                    <li class="clickAction"><a href="javascript:void(0);"><span class="icon printqicon-layers"></span></a><span
                                class="border_bottom"></span></li>
                    <li class="clickAction" data-action="position" data-position='sendbackward'><a href="javascript:void(0);"><span
                                    class="icon printqicon-sendbackward"></span></a><span class="border_bottom"></span></li>
                    <li class="clickAction" data-action="position" data-position='sendtoback'><a
                                href="javascript:void(0);"><span class="icon printqicon-sendtoback"></span></a></li>
                </ul>
            </div>

        </div>
        <div class="group decorations_group">
            <div class="changer">
                <div data-action="decoration" data-type="boldText" class="bold clickAction active_icon">
                    <a class="bold" href="javascript:void(0);" style="font-weight: bold"><span
                                class="icon printqicon-bold"></span></a>
                </div>
                <div data-action="decoration" data-type="italicText" class="italic clickAction ">
                    <a class="italic" href="javascript:void(0);" style="font-style: italic"><span
                                class="icon printqicon-italic"></span></a>
                </div>
                <div data-action="decoration" data-type="underlineText" class="underline clickAction">
                    <a class="underline" href="javascript:void(0);"><span
                                class="icon printqicon-underline"></span></a>
                </div>
            </div>
        </div>
        <div class="group alignment_group">
            <div class="changer">
                    <div data-action="alignment" class="clickAction left_align" data-alignclass="htLeft" data-align="left">
                    <a href="javascript:void(0);"><span class="icon printqicon-left_align"></span></a>
                </div>
                    <div data-action="alignment" class="clickAction center_align" data-alignclass="htCenter" data-align="center">
                    <a href="javascript:void(0);"><span class="icon printqicon-center_align"></span></a>
                </div>
                    <div data-action="alignment" class="clickAction right_align" data-alignclass="htRight" data-align="right">
                    <a href="javascript:void(0);"><span class="icon printqicon-right_align"></span></a>
                </div>
                    <div data-action="alignment" class="clickAction justify_align" data-alignclass="htJustify" data-align="justify">
                    <a href="javascript:void(0);"><span class="icon printqicon-justify_align"></span></a>
                </div>
            </div>
        </div>
        <div class="group clone_group">
            <div class="changer">
                <div data-action="clone" class="clickAction">
                    <a href="javascript:void(0);">
                        <span class="icon icon printqicon-duplicate"></span>
                    </a>
                </div>
            </div>
        </div>
        <?php if( $is_admin ) { ?>
            <div class="group helper_group">
                <div class="changer">
                    <div data-action="helper" class="clickAction helper hasTooltip" data-tooltip="helper_element">
                        <a href="javascript:void(0);">
                            <span class="icon icon printqicon-logout"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="group locked_group">
            <div class="changer">
                <div data-action="locked" class="clickAction locker hasTooltip" data-tooltip="locked_element">
                    <a href="javascript:void(0);">
                        <span class="icon icon printqicon-reset_page"></span>
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<div class="printqDefaultToolbar printqToolbar">
    <div class="toolbarSection">
        <div class="group remove_block remove_block_group clickAction" data-action="delete">
            <a href="javascript:void(0);"><span class="icon printqicon-delete"></span></a>
        </div>
        <div class="group position_group">
            <div class="position_selector selector changer">
                <a class="current current_position" href="javascript:void(0);">
                    <span class="icon printqicon-layers"><span>
                </a>
                <ul>
                    <li class="clickAction" data-action="position" data-position='bringtofront'><a
                                href="javascript:void(0);"><span class="icon printqicon-bringtofront"></span></a><span
                                class="border_bottom"></span></li>
                    <li class="clickAction" data-action="position" data-position='bringforward'><a
                                href="javascript:void(0);"><span class="icon printqicon-bringforward"></span></a><span
                                class="border_bottom"></span></li>
                        <li class="clickAction"><a href="javascript:void(0);"><span class="icon printqicon-layers"></span></a><span
                                    class="border_bottom"></span></li>
                    <li class="clickAction" data-action="position" data-position='sendbackward'><a href="javascript:void(0);"><span
                                    class="icon printqicon-sendbackward"></span></a><span class="border_bottom"></span></li>
                    <li class="clickAction" data-action="position" data-position='sendtoback'><a
                                href="javascript:void(0);"><span class="icon printqicon-sendtoback"></span></a></li>
                </ul>
            </div>

        </div>
        <div class="group clone_group">
            <div class="changer">
                <div data-action="clone" class="clickAction">
                    <a href="javascript:void(0);">
                        <span class="icon icon printqicon-duplicate"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="group group_group">
                <div class="changer">
                    <div data-action="group" class="clickAction">
                        <a href="javascript:void(0);">
                            <span class="icon icon printqicon-blockoptions"></span>
                        </a>
                    </div>
                </div>
            </div>
        <div class="group ungroup_group">
                <div class="changer">
                    <div data-action="ungroup" class="clickAction">
                        <a href="javascript:void(0);">
                            <span class="icon icon printqicon-rotatable"></span>
                        </a>
                    </div>
                </div>
            </div>
        <div class="group transparency_group">
            <div class="changer">
                <div data-action="transparency" class="clickAction">
                    <a href="javascript:void(0);">
                        <span class="icon icon printqicon-opacity"></span>
                    </a>
                </div>
            </div>
        </div>
        <?php if( $is_admin ) { ?>
            <div class="group helper_group">
                <div class="changer">
                    <div data-action="helper" class="clickAction helper hasTooltip" data-tooltip="helper_element">
                        <a href="javascript:void(0);">
                            <span class="icon icon printqicon-logout"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="group locked_group">
                <div class="changer">
                    <div data-action="locked" class="clickAction locker hasTooltip" data-tooltip="locked_element">
                        <a href="javascript:void(0);">
                            <span class="icon icon printqicon-reset_page"></span>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="group forecolor_group">
            <div class="forecolor_selector selector changer">
                <a class="current_color clickAction" data-action="color" href="javascript:void(0);">
                    <span class="colorChangerPreview" id="colorChangerPreview"></span>
                </a>
                <a class="changeForecolor change"></a>
            </div>
        </div>
        </div>
</div>
<div id="printqColorPathsToolbar" class="printqBox">
    <div class="toolbarBody toolbarSection">
        <div class="containerColors">
            <ul class="colorListPaths">
            </ul>
        </div>
    </div>
</div>
<div id="printqImageEditorToolbar" class="printqToolbar">
    <div class="toolbarBody toolbarSection">
        <div class="toolbarPhotoEdit">
            <div class="group quality_block quality_block_group hasTooltip" data-tooltip="image_quality">
                <a href="javascript:void(0)">
                    <span class="icon printqicon-badsmiley"></span>
                </a>
            </div>
            <div class="group remove_block remove_block_group clickAction" data-action="delete">
                <a href="javascript:void(0)">
                    <span class="icon printqicon-delete"></span>
                </a>
            </div>
            <div class="group position_group">
            <div class="position_selector selector changer">
                <a class="current current_position" href="javascript:void(0)">
                <span class="icon printqicon-layers"><span>
                </a>
                 <ul>
                    <li class="clickAction" data-action="position" data-position='bringtofront'><a
                                href="javascript:void(0);"><span class="icon printqicon-bringtofront"></span></a><span
                                class="border_bottom"></span></li>
                    <li class="clickAction" data-action="position" data-position='bringforward'><a
                                href="javascript:void(0);"><span class="icon printqicon-bringforward"></span></a><span
                                class="border_bottom"></span></li>
                    <li class="clickAction"><a href="javascript:void(0);"><span class="icon printqicon-layers"></span></a><span
                                class="border_bottom"></span></li>
                    <li class="clickAction" data-action="position" data-position='sendbackward'><a href="javascript:void(0);"><span
                                    class="icon printqicon-sendbackward"></span></a><span class="border_bottom"></span></li>
                    <li class="clickAction" data-action="position" data-position='sendtoback'><a
                                href="javascript:void(0);"><span class="icon printqicon-sendtoback"></span></a></li>
                </ul>
            </div>

        </div>
            <div class="group  effects_group clickAction" data-action="effects">
                <a href="javascript:void(0)">
                    <span class="icon printqicon-effects"></span>
                </a>
            </div>
            <?php if( $is_admin ) { ?>
                <div class="group helper_group">
                    <div class="changer">
                        <div data-action="helper" class="clickAction helper hasTooltip" data-tooltip="helper_element">
                            <a href="javascript:void(0);">
                                <span class="icon icon printqicon-logout"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="group locked_group">
                    <div class="changer">
                        <div data-action="locked" class="clickAction locker hasTooltip" data-tooltip="locked_element">
                            <a href="javascript:void(0);">
                                <span class="icon icon printqicon-reset_page"></span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="group morePhoto_group">
                <div class="changer">
                    <a class="current" href="javascript:void(0)">
                        <span class="icon printqicon-more"></span>
                    </a>
                    <ul>
                            <li class="clickAction" data-action="clone">
                            <a href="javascript:void(0)">
                                <span class="icon printqicon-duplicate"></span>
                            </a>
                            <span class="border_bottom"></span>
                        </li>
                            <li class="clickAction">
                            <a href="javascript:void(0)">
                                <span class="icon printqicon-more"></span>
                            </a>
                            <span class="border_bottom"></span>
                        </li>
                            <li class="clickAction" data-action="transparency">
                            <a href="javascript:void(0)">
                                <span class="icon printqicon-opacity"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="printqEffectPicker">
    <div class="pickerInfo">
        <span class="icon printqicon-effects"></span>
    </div>
    <div class="pickerBody">
        <div class="effectGalleryBorder">
            <div class="allEffects">
                <ul class="effectGallery">
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="printqTransparencyPicker">
    <div class="pickerBody">
        <div class="leftContainer">
            <span class="icon printqicon-opacity"></span>
        </div>
        <div class="rightContainer">
            <div id="transparencySlider">
            </div>
        </div>
    </div>
</div>
<div id="printqSpacingPicker">
    <div class="pickerBody">
        <div class="leftContainer">
            <span class="icon printqicon-spacing"></span>
        </div>
        <div class="rightContainer">
            <div id="editor_curvedspacing_slider">
            </div>
        </div>
    </div>
</div>
<div id="printqRadiusPicker">
    <div class="pickerBody">
        <div class="leftContainer">
            <span class="icon printqicon-radiustext"></span>
        </div>
        <div class="rightContainer">
            <div id="editor_spacing_slider">
            </div>
        </div>
    </div>
</div>
<div id="printqLetterSpacingPicker">
    <div class="pickerBody">
        <div class="leftContainer">
            <span class="icon printqicon-spacing"></span>
        </div>
        <div class="rightContainer">
            <div id="letterSpacingSlider">
            </div>
        </div>
    </div>
</div>
<div id="printqLineHeightPicker">
    <div class="pickerBody">
        <div class="leftContainer">
            <span class="icon printqicon-spacing-1"></span>
        </div>
        <div class="rightContainer">
            <div id="lineHeightSlider">
            </div>
        </div>
    </div>
</div>
<div class="mainTabsColorContainer">
    <div class="tabsContainer">
        <div class="forecolor_tab color forecolor_group group clickAction" data-action="tab_forecolor"><?php _e( 'ABC', PQD_DOMAIN ) ?></div>
        <div class="background_tab  color bgcolor_group group icon printqicon-background_block clickAction" data-action="tab_bgcolor"></div>
    </div>
    <div class="colorContainer">
        <ul class="colorList">
            <li class="clickAction colorItem color" data-action="bordercolor" data-colorid="4"
                style="background-image: url('<?php echo esc_attr( PRINTQ_IMG_URL . 'transparent.png' ) ?>')">
                <b class="icon printqicon-ok"></b>
            </li>
            <li class="clickAction colorItem color" data-action="bordercolor" data-colorid="0" style="background-color: #fff">
                <b class="icon printqicon-ok"></b>
            </li>
            <li class="clickAction colorItem color" data-action="bordercolor" data-colorid="1" style="background-color: #00FFDE">
                <b class="icon printqicon-ok"></b>
            </li>
            <li class="clickAction colorItem color" data-action="bordercolor" data-colorid="3" style="background-color: #cccccc">
                <b class="icon printqicon-ok"></b>
            </li>
            <li class="clickAction colorItem color" data-action="bordercolor" data-colorid="2" style="background-color: #213246">
                <b class="icon printqicon-ok"></b>
            </li>
            <li class="clickAction colorItem color" data-action="bordercolor" data-colorid="5" style="background-color: #000">
                <b class="icon printqicon-ok"></b>
            </li>
            <li class="clickAction colorItem add_color" data-action="add-color">
                <b class="add_color_sign icon printqicon-plus_icon "></b>
            </li>
        </ul>
    </div>
</div>




