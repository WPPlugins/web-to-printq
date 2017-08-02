<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );
?>
<ul id="imageBarPlaceholder">
	<li class="galleryItem empty">
	    <div class="placeholder">
	        <span class="icon background_placeholder printqicon-background"></span>
	        <div class="actions">
	            <span class="pic drag icon printqicon-move_cursor"></span>
	            <span class="pic remove icon printqicon-delete"></span>
	        </div>
		    <div class="animation-container">
				<div class='loader-animation'>
					<?php for( $al = 0; $al < 24; $al ++ ): ?>
                        <div></div>
                    <?php endfor; ?>
				</div>
			</div>
	    </div>
	</li>
</ul>
<ul id="backImageBarPlaceholder">
	<li class="galleryItem backButton">
	    <div class="placeholder">
	        <span class="icon background_placeholder printqicon-backarrow"></span>
	    </div>
	</li>
</ul>
<ul id="imageBarFacebookInstagramPlaceholder">
	<li class="galleryItem empty">
	    <div class="placeholder">
	        <span class="icon background_placeholder printqicon-background"></span>
	        <div class="actions">
	            <span class="pic drag icon printqicon-move_cursor"></span>
	        </div>
		    <div class="animation-container">
				<div class='loader-animation'>
					<?php for( $al = 0; $al < 24; $al ++ ): ?>
                        <div></div>
                    <?php endfor; ?>
				</div>
			</div>
	    </div>
	</li>
</ul>
<ul id="imageBarPlaceholderFacebook">
	<li class="galleryItem empty">
	    <div class="placeholder">
	        <span class="icon background_placeholder printqicon-background"></span>
            <div class="actions">
	            <div class="itemTitle"></div>
            </div>
		    <div class="animation-container">
				<div class='loader-animation'>
					<?php for( $al = 0; $al < 24; $al ++ ): ?>
                        <div></div>
                    <?php endfor; ?>
				</div>
			</div>
	    </div>
	</li>
</ul>

<div class="galleryContainer">
    <input class="files-upload-input" type="file" multiple/>
    <div class="upload_helper">
        <p><?php _e( 'Drag & Drop to upload images', PQD_DOMAIN ); ?></p>
        <span></span>
    </div>
    <?php $social_count = 0; ?>
    <?php if( pqd_get_config( 'facebook_app_id' ) ) {
        $social_count ++; ?>
        <div class="uploadImagesContainer uploadFacebookContainer">
            <a href="javascript:void(0)" class="uploadImages"><span class="icon  printqicon-facebook"><span></a>
        </div>
    <?php } ?>

    <?php if( pqd_get_config( 'instagram_api_key' ) && pqd_get_config( 'instagram_api_secret' ) ) {
        $social_count ++; ?>
        <div class="uploadImagesContainer uploadInstagramContainer">
            <a href="javascript:void(0)" class="uploadImages"><span class="icon  printqicon-instagram"><span></a>
        </div>
    <?php } ?>
    <div class="uploadImagesContainer uploadLocalContainer drop-area active pqd_use_pad_<?php echo $social_count ?>">
        <a href="javascript:void(0)" class="uploadImages"><span class="icon  printqicon-upload"><span></a>
    </div>
    <div class="allImagesGallery pqd_use_pad_<?php echo intval($social_count) ?>">
        <div class="scrollable">
    <ul class="f-thm_images galleryImages">
        <?php
            $userImages = Printq_Gallery_Helper::getUserImages();

            $count = Printq_Gallery_Helper::$defaultImages;
            if( $userImages && $userImages['count'] > $count ) {
                $count = $userImages['count'];
            }

            $imageBarData = array();
            for( $i = 0; $i < $count; $i ++ ) {
                $hasImage  = isset( $userImages['files'][$i] ) ? $userImages['files'][$i] : false;
                $liClass   = 'galleryItem';
                $uniqueId  = '';
                $thumbPath = '';
                if( $hasImage ) {
                    $uimg = $userImages['files'][$i];
                    $liClass .= ' image imageContent';
                    $imagePath = $uimg['image'];
                    $image_src = $uimg['image_src'];
                    $thumbPath = $image_src;
                    $uniqueId  = 'preload_' . $uimg['image'] . '_image';
                    if( isset( $uimg['thumbnail'] ) && strlen( $uimg['thumbnail'] ) > 0 ) {
                        $thumbPath = $uimg['thumbnail'];
                    }
                    if( isset ( $uimg['other_infos'] ) && isset ( $uimg['other_infos']['working_image'] ) ) {
                        $workingImage = $uimg['other_infos']['working_image'];
                    } else {
                        $workingImage = '';
                    }
                    $imageBarData[] = array(
                            'imagePath'     => $imagePath,
                            'image_src'     => $image_src,
                            'uniqueId'      => $uniqueId,
                            'imageName'     => $uimg['image'],
                            'imageSid'      => $userImages['sid'],
                            'imageId'       => $uimg['id'],
                            'other_infos'   => $uimg['other_infos'],
                            'thumbnail'     => $thumbPath,
                            'working_image' => $workingImage,
                            'type'          => 'image',
                            'width'         => isset( $uimg['other_infos']['size']['width'] ) ? $uimg['other_infos']['size']['width'] : '',
                            'height'        => isset( $uimg['other_infos']['size']['height'] ) ? $uimg['other_infos']['size']['height'] : '',
                    );
                } else {
                    $liClass .= ' empty';
                }
                ?>
                <li class="<?php echo $liClass ?>" id="<?php echo esc_attr( $uniqueId ) ?>">
                <div
                        class="placeholder" data-original="<?php echo esc_url( $thumbPath ) ?>">
                    <span class="icon background_placeholder printqicon-background"></span>
                    <div class="actions">
                        <span class="pic drag icon printqicon-move_cursor"></span>
                        <span class="pic remove icon printqicon-delete"></span>
                    </div>
                    <div class="animation-container">
                        <div class='loader-animation'>
                            <?php for( $al = 0; $al < 24; $al ++ ): ?>
                                <div></div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php } ?>
    </ul>
        </div>
    </div>
    <div class="allFacebookAlbums pqd_use_pad_<?php echo intval( $social_count ) ?>">
        <div class="scrollable">
             <ul class="f-thm_images galleryImages">
            <?php
                $coutPlaceholders = 20;
                for( $i = 0; $i < $coutPlaceholders; $i ++ ) {
                    $liClass = 'galleryItem empty';
                    ?>
                    <li class="<?php echo esc_attr( $liClass ) ?>">
                        <div class="placeholder" data-original="<?php echo esc_url( $thumbPath ) ?>">
                            <span class="icon background_placeholder printqicon-background"></span>
                            <div class="actions">
                                <div class="itemTitle"></div>
                            </div>
                            <div class="animation-container">
                                <div class='loader-animation'>
                                    <?php for( $al = 0; $al < 24; $al ++ ): ?>
                                        <div></div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            ?>
        </ul>
        </div>
    </div>
    <div class="allFacebookAlbumsImages pqd_use_pad_<?php echo intval( $social_count ) ?>">
        <div class="scrollable">
            <ul class="f-thm_images galleryImages">
                <li class="galleryItem backButton">
                    <div class="placeholder">
                        <span class="icon background_placeholder printqicon-backarrow"></span>
                        <div class="actions">
                            <div class="text_actions"><?php _e( 'Back to Albums', PQD_DOMAIN ); ?></div>
                        </div>
                    </div>
                </li>
                <?php
                    $coutPlaceholders = 20;
                    for( $i = 0; $i < $coutPlaceholders; $i ++ ) {
                        $liClass = 'galleryItem empty';
                        ?>
                        <li class="<?php echo esc_attr( $liClass ) ?>">
                        <div
                                class="placeholder" data-original="<?php echo esc_url( $thumbPath ) ?>">
                            <span class="icon background_placeholder printqicon-background"></span>
                            <div class="actions">
                                <span class="pic drag icon printqicon-move_cursor"></span>
                            </div>
                            <div class="animation-container">
                                <div class='loader-animation'>
                                    <?php for( $al = 0; $al < 24; $al ++ ): ?>
                                        <div></div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                        <?php
                    }
                ?>
        </ul>
        </div>
    </div>
    <div class="allInstagramAlbumsImages pqd_use_pad_<?php echo intval( $social_count ) ?>">
        <div class="scrollable">
            <ul class="f-thm_images galleryImages">
            <?php
                $coutPlaceholders = 20;
                for( $i = 0; $i < $coutPlaceholders; $i ++ ) {
                    $liClass = 'galleryItem empty';
                    ?>
                    <li class="<?php echo esc_attr( $liClass ) ?>">
                        <div
                                class="placeholder" data-original="<?php echo esc_url( $thumbPath ) ?>">
                            <span class="icon background_placeholder printqicon-background"></span>
                            <div class="actions">
                                <span class="pic drag icon printqicon-move_cursor"></span>
                            </div>
                            <div class="animation-container">
                                <div class='loader-animation'>
                                    <?php for( $al = 0; $al < 24; $al ++ ): ?>
                                        <div></div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            ?>
        </ul>
        </div>
    </div>
</div>
<script>
    var userImages = <?php echo $userImages ? json_encode( $userImages ) : '[]'; ?>;
    var imageBarData = <?php echo $imageBarData ? json_encode( $imageBarData ) : '[]'; ?>;
</script>

