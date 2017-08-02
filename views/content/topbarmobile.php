<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );
?>
<nav id="editorTopbarContainerMobile" class="edit">
    <div class="topBarContent">
        <ul class="topBarActionsEdit topBarActions">
            <li class="disable_preview maximizeContainerMobile">
                <a href="javascript:void(0)" class="icon printqicon-maximizemenu maximizeMenu clickActionTopBar" data-action="changeState" data-state="sidebar_open"></a>
                <div class="preview_mask_responsive"></div>
            </li>
                <li class="disable_preview image addBlockMobile group create_image_group" id="addImageBlockMobile">
                <div class="fineuploader" style="display:none"></div>
                <a href="javascript:void(0)" class="icon printqicon-newimage clickActionTopBar" data-action="add_image">
                </a>
                <div class="preview_mask_responsive"></div>
            </li>
                <li class="disable_preview textflow addBlock group create_textline_group" id="addTextflowBlockMobile">
                 <a href="javascript:void(0)" class="icon printqicon-newtext-1 clickActionTopBar" data-action="add_text">
                </a>
                <div class="preview_mask_responsive"></div>
            </li>

        </ul>
	    <?php if ( ! isset( $_REQUEST['is_admin'] ) ) { ?>
            <div class="addtoCartButton">
                <a href="javascript:void(0)" class="icon printqicon-addtocart  clickActionTopBar" data-action="add_to_cart"></a>
            </div>
            <ul class="topBarActionsPreview topBarActions">
                <li data-id="edit" class="edit_state active">
                    <a href="javascript:void(0)" class="icon printqicon-edit editPersonalization centerChoice" data-action="edit_mode"></a>
                </li>
            </ul>
	    <?php } else { ?>
            <div class="saveTemplateButton">
                <a href="javascript:void(0)" class="icon printqicon-edit centerChoice savePersonalization">
                    <span><?php echo __( 'Save', PQD_DOMAIN ) ?></span>
                </a>
            </div>
        <?php } ?>

        <ul class="editTextActions">
            <li class="action clickActionHeader clickActionTopBar" data-action="notChangeText">
                <a href="javascript:void(0)">
                    <span><?php echo __( 'Back' ) ?></span>
                    <span class="icon printqicon-cancel"></span>
                </a>
            </li>
            <li class="action"></li>
            <li class="action clickActionHeader clickActionTopBar" data-action="changeText">
                <a href="javascript:void(0)">
                    <span><?php echo __( 'Ok' ) ?></span>
                    <span class="icon printqicon-ok"></span>
                </a>
            </li>
        </ul>
        <div class="current_action_info">Current Action Info</div>
        <ul class="topBarActions topBarEditText">
            <li class="done_edit">
                <a href="javascript:void(0)" class="icon printqicon-ok"></a>
            </li>
            <li class="cancel_edit">
                <a href="javascript:void(0)" class="icon printqicon-cancel"></a>
            </li>
        </ul>
    </div>
    <div class="pqd_no_display">
        <span id="pqd-upload-button"><input type="file" accept="image/*;capture=camera"/></span>
    </div>
</nav>
