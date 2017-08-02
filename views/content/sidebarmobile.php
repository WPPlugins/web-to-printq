<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );
?>
<aside class="asideMobile">
    <ul class="closeMenu">
    	<li class="back_from_editor">
            <a href="javascript:void(0)" class="clickActionSideBar" data-action="back_page">
                <span class="icon printqicon-backarrow"></span>
                <span class="title"><?php _e( 'Back', PQD_DOMAIN ) ?></span>
            </a>
        </li>
        <li class="close_sidebar clickActionSideBar" data-action="back_sidebar">
            <a href="javascript:void(0)">
                <span class="title"><?php _e( 'Back', PQD_DOMAIN ) ?></span>
                <span class="icon printqicon-cancel"></span>
            </a>
        </li>
    </ul>
    <ul class="mainMenu">
        <li class="group change_layout_group mainItem">
            <a href="javascript:void(0)" class="mainTrigger clickActionSideBar" data-action='changeState' data-state="shapes">
                <div class=" icon printqicon-shapes path1 path2">
                    <span class="title"><?php _e( 'Shapes', PQD_DOMAIN ) ?></span>
                </div>
            </a>
        </li>
        <li class="group add_page_group mainItem clickActionSideBar" data-action="add_page">
            <a href="javascript:void(0)" class="mainTrigger">
                <div class=" icon printqicon-addnewpage">
                    <span class="title"><?php _e( 'Add new Page', PQD_DOMAIN ) ?></span>
                </div>
            </a>
        </li>
        <li class="group delete_page_group mainItem clickActionSideBar" data-action="delete_page">
            <a href="javascript:void(0)" class="mainTrigger">
                <div class=" icon printqicon-deletepage">
                    <span class="title"><?php _e( 'Delete Page', PQD_DOMAIN ) ?></span>
                </div>
            </a>
        </li>
    </ul>
</aside>
