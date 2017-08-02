<?php
    $brandingColor        = pqd_get_config( 'branding_color', '#99d122' );
    $sidebarBgColor       = pqd_get_config( 'sidebar_bg_color', '#213246' );
    $iconColor            = pqd_get_config( 'icon_color', '#6CBFE8' );
    $sidebarBgColorActive = pqd_get_config( 'sidebar_bg_color_active', '#1b2939' );
    $smalllogo            = wp_get_attachment_image_url( pqd_get_config( 'logo_small' ), 'full' );
    if( !$smalllogo ) {
        $smalllogo = PRINTQ_IMG_URL . 'logo_small.png';
    }
    $largelogo = wp_get_attachment_image_url( pqd_get_config( 'logo' ), 'full' );
    if( !$largelogo ) {
        $largelogo = PRINTQ_IMG_URL . 'logo.png';
    }
?>
.logoContainer {
background-image: url('<?php echo $smalllogo ?>');
}
.expand .logoContainer {
background-image: url('<?php echo $largelogo ?>');
}
aside.sidebar,
aside.sidebar ul.mainMenu,
aside.sidebar ul.mainMenu li.mainItem a.mainTrigger div.icon.inactive,
aside.sidebar ul.mainMenu li.mainItem a.zoomInContainer div.icon.inactive,
aside.sidebar ul.mainMenu li.mainItem a.zoomOutContainer div.icon.inactive,
aside.sidebar div.submenu > ul li.subItem a.subTrigger,
aside.sidebar .layoutsGalleryMask,
aside.sidebar .shapesGalleryMask,
aside.sidebar .backgroundsGalleryMask,
aside.sidebar .layoutsGallery ul.layoutsGalleryList li.listItem a.container,
aside.sidebar .backgroundsGallery ul.backgroundsGalleryList li.listItem a.container,
aside.sidebar ul.mainMenu li.mainItem.disabled a.mainTrigger div.icon.active,
aside.sidebar #loadProjectFrame,
aside.sidebar #saveProjectFrame,
aside.sidebar div.submenu > ul li.subItem a.subTrigger,
aside.sidebar ul.mainMenu li.mainItem a.mainTrigger div.icon.inactive,
aside.sidebar .layoutsGalleryMask,
aside.asideMobile ul,
.ppmt aside.asideMobile ul li,
.ppmt aside.asideMobile #saveProjectFrameMobile,
.ppmt aside.asideMobile #loadProjectFrameMobile,
.ppmt #editorBottomBarContainerMobile,
.ppmt #editorTopbarContainerMobile,
.ppmt #editorTopbarContainerMobile a,
.ppmt #editorTopbarContainerMobile .current_action_info,
.ppmt .editTextActions,
.ppmt #editorBottomBarContainerMobile a,
body.ppmt.ppmt-preview #editorTopbarContainerMobile .topBarContent .topBarActions li.edit_state a,
.ppmt aside.asideMobile,
body.preview_area #editorTopbarContainerMobile .topBarContent .topBarActions li.edit_state a
{
background-color : <?php echo $sidebarBgColor ?>;
}

aside.sidebar ul.mainMenu li.mainItem a.mainTrigger div.icon.active,
aside.sidebar div.submenu > ul li.subItem.active a.subTrigger,
aside.sidebar .layoutsGallery,
aside.sidebar .backgroundsGallery,
aside.sidebar .shapesGallery,
.ppmt #editorTopbarContainerMobile .topBarContent .topBarActions li.edit_state a,
body.ppmt.ppmt-preview #editorTopbarContainerMobile .topBarContent .topBarActions li.preview_state a,
.ppmt .mobile_pagination .pagination ul > .active > a

{
background-color : <?php echo $sidebarBgColorActive ?>;
}

body.preview_area #editorTopbarContainerMobile .topBarContent .topBarActions li.preview_state a{
background-color : <?php echo $sidebarBgColorActive ?> !important;
}

aside.sidebar ul.mainMenu li.mainItem a.mainTrigger div.icon.inactive,
aside.sidebar ul.mainMenu li.mainItem a.zoomInContainer div.icon.inactive,
aside.sidebar ul.mainMenu li.mainItem a.zoomOutContainer div.icon.inactive,
aside.sidebar ul.mainMenu li.mainItem span.zoom_percent,
aside.sidebar ul.mainMenu li.mainItem a.mainTrigger div.icon.active,
aside.sidebar div.submenu > ul li.subItem a.subTrigger,
aside.sidebar div.submenu > ul li.subItem.active a.subTrigger,
aside.sidebar ul.mainMenu li.mainItem.disabled a.mainTrigger div.icon.active,
aside.sidebar ul.mainMenu li.mainItem.disabled a.mainTrigger:hover div.icon.inactive,
.printqToolbar .toolbarSection .group .icon, #printqImageEditorToolbar .group .icon,
#printqImagePicker.myphotos .pickerInfo.myphotos-btn span,
#printqImagePicker.instagram .pickerInfo.instagram-btn span,
#printqImagePicker.facebook .pickerInfo.facebook-btn span,
#printqImagePicker.fotolia .pickerInfo.fotolia-btn span,
#printqImagePicker.selectbox .pickerInfo.selectbox-btn span,
#printqEffectPicker .pickerInfo span, #printqImagePicker .pickerInfo span,
#printqTransparencyPicker .leftContainer span,
#printqRadiusPicker .leftContainer span,
#printqSpacingPicker .leftContainer span,
#printqImagePicker .pickerBody .imageUploadSection .upload_ico,
.changer.buttons,
.printqToolbar .printqtoolbarTop .fontsContainer .changeFont,
.printqToolbar .printqtoolbarTop .group .icon,
.printqToolbar .printqtoolbarBottom .group .icon,
.mainTabsColorContainer .forecolor_tab ,
.mainTabsColorContainer .background_tab,
.printqDefaultToolbar  .group .icon,
.ppmt #editorTopbarContainerMobile .topBarContent .topBarActions li.edit_state a,
body.ppmt.ppmt-preview #editorTopbarContainerMobile .topBarContent .topBarActions li.preview_state a,
.ppmt #editorBottomBarContainerMobile a,
.ppmt .toolbarsContainer .textToolbarMobile li.group a,
.ppmt .toolbarsContainer .imageToolbarMobile li.group a,
.ppmt .toolbarsContainer .imagesToolbarMobile li.group a,
.ppmt .toolbarsContainer .defaultToolbarMobile li.group a,
.ppmt .toolbarsContainer .mainToolbarMobile li.group a,
.ppmt .subItemOptions li.group a,
.ppmt .toolbarsContainer .textToolbarMobile li.group a,
.ppmt .mobileDefaultMainToolbar li.group a.active,
body.ppmt.ppmt-preview #editorTopbarContainerMobile .topBarContent .topBarActions li.edit_state a,
.ppmt .toolbarTransparencyMobile .sliderMobile .ui-state-default,
.ppmt .toolbarTransparencyMobile .sliderMobile .ui-state-default,
.ppmt .toolbarCropMobile .sliderMobile .ui-state-default,
.ppmt .toolbarCropMobile .sliderMobile .ui-state-default,
.ppmt .subItemtextColors li.group a.mainItem.active .color_placeholder b,
.mobileDefaultMainToolbar.subItemLayouts li.group a.mainItem.active b,
.mobileDefaultMainToolbar.subItemShapes li.group a.mainItem.active b,
.mobileDefaultMainToolbar.subItemBackgrounds li.group a.mainItem.active b,
.tooltipDescription p,
.paginationContainer .pages li.page.current_page a,
.navbarCenter ul li a
{
color : <?php echo $iconColor ?>;
}

.loader-animation > div,
#printqImageEditorToolbar .resizeImageGroup #slider,
#printqTransparencyPicker .rightContainer #transparencySlider,
#printqRadiusPicker .rightContainer #editor_spacing_slider,
#printqSpacingPicker .rightContainer #editor_curvedspacing_slider
.ppmt .toolbarTransparencyMobile .sliderMobile .ui-widget-content,
.ppmt .toolbarTransparencyMobile .sliderMobile .ui-widget-content,
.ppmt .toolbarCropMobile .sliderMobile .ui-widget-content,
.ppmt .toolbarCropMobile .sliderMobile .ui-widget-content {
background-color : <?php echo $iconColor ?>;
}

#printqImageEditorToolbar .resizeImageGroup .ui-state-default,
#printqTransparencyPicker .rightContainer .ui-state-default,
#printqRadiusPicker .rightContainer .ui-state-default,
#printqSpacingPicker .rightContainer .ui-state-default,
.ppmt .mobileDefaultMainToolbar li.group a.active,
.ppmt .toolbarTransparencyMobile .sliderMobile .ui-state-default,
.ppmt .toolbarTransparencyMobile .sliderMobile .ui-state-default,
.ppmt .toolbarCropMobile .sliderMobile .ui-state-default,
.ppmt .toolbarCropMobile .sliderMobile .ui-state-default{
border-color : <?php echo $iconColor ?>;
}

aside.sidebar .layoutsGallery a.container u,
aside.sidebar .backgroundsGallery  a.container u,
aside.sidebar .shapesGallery  a.container u{
border-color : <?php echo $brandingColor ?>;
}

aside.sidebar .layoutsGallery a.container u {
box-shadow: 0px 0px 7px 3px <?php echo $this->hex2rgba( $brandingColor, 0.35 ) ?>;
}

.logoContainer,
button.button,
#printqImageEditorToolbar .resizeImageGroup .ui-widget-content, #printqTransparencyPicker .rightContainer .ui-widget-content,
.navbarTopLeft ul .logoContainer,
.navbarCenter ul li .effectbarLeftRight,
.navbarCenter ul li .effectbarRightLeft,
body.expand .navbarTopLeft ul li.maximizeContainer,
.ui-resizable-handle,
aside.sidebar .layoutsGallery .container .icon,
aside.sidebar .backgroundsGallery  .container .icon,
#printqImagePicker .imageGallery .imageContainer .actions .pic.select,
#printqEffectPicker .effectGallery li.effectContainer .ico,
.galleryContainer .galleryImages li.galleryItem div.placeholder .actions .pic.drag,
.ppmt aside.asideMobile ul.closeMenu li {
background-color : <?php echo $brandingColor ?>;
}

.sweet-alert button,
.ui-rotatable-handle {
background-color: <?php echo $brandingColor ?>!important;
}
aside.sidebar ul.mainMenu li.mainItem a.mainTrigger:hover div.icon.inactive,
aside.sidebar ul.mainMenu li.mainItem a.zoomInContainer:hover div.icon.inactive,
aside.sidebar ul.mainMenu li.mainItem a.zoomOutContainer:hover div.icon.inactive,
aside.sidebar ul.mainMenu li.mainItem a.mainTrigger:hover div.icon.active,
aside.sidebar div.submenu > ul li.subItem a.subTrigger:hover,
aside.sidebar div.submenu > ul li.subItem.active a.subTrigger span.icon,
.printqToolbar .group .current a span.icon,
.tabsContainer div.current,
.navbarRight ul li.active a,
.navbarCenter ul li.active a,
.paginationContainer .pages li.page span.icon,
.paginationPreviewContainer .pages li.page span.icon,
.printqToolbar .fontsContainer ul li a:hover,
.navbarRight ul#addtoCartContainer li a,
.colorContainer .colorList .current_color.colorItem b,
#printqImagePicker.myphotos .pickerInfo.myphotos-btn span,
#printqImagePicker.instagram .pickerInfo.instagram-btn span,
#printqImagePicker.facebook .pickerInfo.facebook-btn span,
#printqImagePicker.fotolia .pickerInfo.fotolia-btn span,
#printqImagePicker.selectbox .pickerInfo.selectbox-btn span,
.paginationPreviewContainer .pages li.page.current_page a,
.ppmt .mobile_pagination .pagination ul > li.active > a{
color : <?php echo $brandingColor ?> !important;
}

.ppmt .mobileDefaultMainToolbar li.group.active a {
color : <?php echo $brandingColor ?>;
}
.ppmt .ui-resizable-handle {
border : 10px solid <?php echo $this->hex2rgba( $brandingColor ) ?>;
}

.enable-edit .page div.page_blocks.editable.edit u{
border : 1px dashed <?php echo $this->hex2rgba( $brandingColor ) ?>;
}
