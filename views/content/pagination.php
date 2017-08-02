<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );
?>
<div id="paginationEditorContainer">
    <div class="editorPagination defaultPagination">
        <span id="firstPage" class="butt fa fa-step-backward"></span>
        <span id="prevPage" class="butt fa fa-caret-left"></span>
        <span id="currentPage" class="text"></span>
        <span id="delimitor" class="text"><?php _e( 'from', PQD_DOMAIN ) ?></span>
        <span id="totalPages" class="text"></span>
        <span id="nextPage" class="butt fa fa-caret-right"></span>
        <span id="lastPage" class="butt fa fa-step-forward"></span>
    </div>
</div>
<div class="paginationContainer" id="page_picker_editor">
    <ul class="pages">

    </ul>
    <div id="addResetContainer">
        <div class="group add_page_group clickAction hasTooltip" data-action="add_page" data-tooltip='add_page'>
            <a href="javascript:void(0);" class="icon printqicon-plus_icon">
            </a>
        </div>
        <div class="group delete_page_group clickAction hasTooltip" data-action="delete_page" data-tooltip='delete_page'>
            <a href="javascript:void(0);" class="icon printqicon-minus_icon"></a>
        </div>
    </div>
</div>

<div class="paginationPreviewContainer" id="page_picker_preview">
    <div class="allPagesPagination">
        <ul class="pages"></ul>
    </div>
</div>
