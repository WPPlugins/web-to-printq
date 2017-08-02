<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    class Printq_Controller_Unsplash extends Printq_Controller_Abstract {

        protected $unsplashId;

        protected $host;

        protected function _construct() {
            $this->unsplashId = pqd_get_config( 'unsplash_id' );

            $this->host = "http://api.unsplash.com/photos/";
            if( empty( $this->unsplashId ) ) {
                $result = array( 'success' => 0, 'message' => __( 'No Unsplash id provided!', PQD_DOMAIN ) );
                echo json_encode( $result );
                exit;
            }

            $this->addNoPriv( array( 'init_photos', 'searchUnsplash', 'getImagesPerCategory' ) );
        }

        public function init_photosAction() {
            $result = array( 'success' => 0, 'photos' => array() );

            $data     = array();
            $per_page = isset( $_REQUEST['photosNumber'] ) ? intval( $_REQUEST['photosNumber'] ) : 20;
            $page     = isset( $_REQUEST['page'] ) ? intval( $_REQUEST['page'] ) : 1;
            $query    = isset( $_REQUEST['query'] ) ? sanitize_text_field( $_REQUEST['query'] ) : null;

            $data["per_page"] = $per_page;
            $data["page"]     = $page;
            $data["query"]    = $query;
            $link             = $this->createLink( $data );
            $response         = wp_remote_get( rtrim( $link ) );
            if( !is_wp_error( $response ) ) {
                $photos = json_decode( $response['body'], true );
                if( is_array( $photos ) && count( $photos ) ) {
                    $photos = $this->parsePhotos( $photos );
                    $result = array( 'success' => 1, 'photos' => $photos );
                }
                else {
                    $result = array( 'success' => 1, 'photos' => array() );
                }
            }
            echo json_encode( $result );
        }

        public function parsePhotos( $photos ) {
            $images = array();
            foreach( $photos as $key => $photo ) {

                $image          = array(
                    'id'     => $photo['id'],
                    'width'  => $photo['width'],
                    'height' => $photo['height'],
                    'urls'   => $photo['urls'],
                );
                $image_uploaded = $this->imageUploaded( $photo );
                if( $image_uploaded && is_array( $image_uploaded ) ) {
                    $image = array_merge( $image, $image_uploaded );
                }
                $images[] = $image;
            }

            return $images;
        }

        public function imageUploaded( $photo ) {
            if( isset( $photo['urls']['raw'] ) ) {
                $existing_photo = get_posts(
                    array(
                        'post_type'      => 'attachment',
                        'posts_per_page' => 1,
                        'meta_key'       => '_wp_attachment_context',
                        'meta_value'     => 'unsplash',
                        'post_name__in'  => array( md5( $photo['urls']['raw'] ) )
                    )
                );

                if( $existing_photo ) {
                    $photo           = $existing_photo[0];
                    $full_image      = wp_get_attachment_image_src( $photo->ID, 'full', false );
                    $working_image   = wp_get_attachment_image_src( $photo->ID, 'large', false );
                    $thumbnail_image = wp_get_attachment_image_src( $photo->ID, 'thumbnail', false );

                    return array(
                        'wasUpload'     => 1,
                        'image_src'     => $full_image[0],
                        'working_image' => $working_image[0],
                        'thumb'         => $thumbnail_image[0],
                    );
                }
            }

            return false;
        }

        public function createLink( $data ) {
            $link = $this->host;
            if( is_array( $data ) && count( $data ) ) {
                if( $data['query'] ) {
                    $link .= "/search";

                }
                $data['client_id'] = $this->unsplashId;
                $link .= '?' . http_build_query( $data );
            }

            return $link;
        }

        public function getImagesPerCategoryAction() {

        }
    }
