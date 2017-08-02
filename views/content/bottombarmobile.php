<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );
?>
<nav id="editorBottomBarContainerMobile" class="edit">
    <div class="bottomBarContent confirmPanel">
        <ul class="bottomBarActions">
            <li class="itemBar clickActionFooter" data-state="notConfirm">
                <a href="javascript:void(0)" class="icon printqicon-cancel"></a>
                <div class="preview_mask_responsive"></div>
            </li>
            <li class="itemBar clickActionFooter" data-state="confirm">
                <a href="javascript:void(0)" class="icon printqicon-ok">
                </a>
                <div class="preview_mask_responsive"></div>
            </li>
        </ul>
    </div>
    <div class="bottomBarContent confirmSingleActionPanel">
        <div class="comfirmSingleActionContent">
            <a href="javascript:void(0)" class="icon printqicon-cancel clickDefaultAction" data-action="notConfirm-change">
            </a>
            <a href="javascript:void(0)" class="icon printqicon-ok clickDefaultAction" data-action="confirm-change">
            </a>
        </div>
    </div>
    <div class="bottomBarContent actionsPanel">
        <ul class="bottomBarActions">
            <li class="itemBar clickActionFooter" data-state="delete">
                <a href="javascript:void(0)" class="icon printqicon-delete"></a>
                <div class="preview_mask_responsive"></div>
            </li>
            <li class="itemBar edit_selection clickActionFooter" data-state="edit">
                <a href="javascript:void(0)" class="icon printqicon-edit">
                </a>
                <div class="preview_mask_responsive"></div>
            </li>
            <li class="itemBar clickActionFooter" data-state="release">
                <a href="javascript:void(0)" class="icon printqicon-ok">
                </a>
                <div class="preview_mask_responsive"></div>
            </li>
        </ul>
    </div>
</nav>

