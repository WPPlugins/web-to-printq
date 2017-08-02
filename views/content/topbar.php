<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    /**
     * @var $this Printq_Controller_Design
     */
?>
<nav id="editorTopbarContainer">
    <div class="navbarTopLeft topBarContent">
        <ul>
            <li id="close" class="logoContainer hasTooltip" data-tooltip="close">
            </li>
            <li class="maximizeContainer">
                <a href="javascript:void(0)" class="icon printqicon-maximizemenu maximizeMenu">
                </a>
                <a href="javascript:void(0)" class="icon printqicon-backarrow minimizeMenu">
                </a>
            </li>
            <li class="projectInfo" id="paginationContainer_Edit_Preview">
                <div>
                    <div class="info">
                        <label class="projectName" id="current_page_name"></label>
                        <label class="projectCover"><?php echo __( 'Frontside', PQD_DOMAIN ) ?>></label>
                    </div>
                    <div class="load">
                        <span class="icon printqicon-selectdown"></span>
                    </div>

                </div>
            </li>
        </ul>
    </div>
    <div class="navbarCenter topBarContent">
        <ul>
            <?php if( !isset( $_REQUEST['is_admin'] )) { ?>
                <li class="active edit">
                    <a href="javascript:void(0)" class="centerChoice editPersonalization">
                        <span><?php echo __( 'Create your design', PQD_DOMAIN ) ?></span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="preview active">
                    <a href="javascript:void(0)" class="icon printqicon-edit centerChoice savePersonalization">
                        <span><?php echo __( 'Save', PQD_DOMAIN ) ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="navbarRight topBarContent">
        <ul class="group undo_redo_group" id="undoRedoContainer">
            <li class="active undoAction">
                <a href="javascript:void(0)" class="icon printqicon-undo undo">
                    <span class="title"><?php echo __( 'UNDO', PQD_DOMAIN ) ?></span>
                </a>
            </li>
            <li class="redoAction">
                <a href="javascript:void(0)" class="icon printqicon-redo redo">
                    <span class="title"><?php echo __( 'REDO', PQD_DOMAIN ) ?></span>
                </a>
            </li>
        </ul>
        <?php if( !isset( $_REQUEST['is_admin'] ) ) { ?>
        <ul id="addtoCartContainer">
            <li id="attach">
                <a href="javascript:void(0)" class="icon printqicon-addtocart">
                	<span class="title"><?php echo __( 'Add to Cart', PQD_DOMAIN ) ?></span>
                </a>
            </li>
        </ul>
        <?php } ?>
    </div>
</nav>
