<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    class Printq_Gallery_Helper {

        static $defaultImages  = 14;
        static $returnThumbs   = true;
        static $designerPhotos = true;
        static $order          = 'DESC';
        static $count          = 1000;

        static function getUserImages() {
            $request = array(
                'designerPhotos' => self::$designerPhotos,
                'returnThumbs'   => self::$returnThumbs,
                'order'          => self::$order,
                'count'          => self::$count
            );
            $result  = self::getUserUploadedPhotos( $request );
            if( $result['success'] ) {
                return $result['data'];
            }

            return false;
        }

        static function getUserUploadedPhotos( $post_data = array() ) {
            $success = false;
            $result  = null;
            try {
                $returnThumbs = ( isset( $post_data['returnThumbs'] ) && intval( $post_data['returnThumbs'] ) );

                $count       = isset( $post_data['count'] ) ? intval( sanitize_text_field( $post_data['count'] ) ) : 20;
                $sid         = isset( $post_data['sid'] ) && strlen( $post_data['sid'] ) > 1 ? sanitize_text_field( $post_data['sid'] ) : Printq_Design_Helper::getUserUploadDirectory();
                $returnFiles = array();

                $photos = get_posts( array(
                                         'posts_per_page' => max( - 1, $count ),
                                         'post_type'      => 'attachment',
                                         'meta_key'       => '_wp_attachment_context',
                                         'meta_value'     => $sid,
                                     ) );
                $index  = 0;
                foreach( $photos as $c ) {

                    $createdWorkingImage = wp_get_attachment_image_src( $c->ID, 'large', false );
                    $fullImage           = wp_get_attachment_image_src( $c->ID, 'full', false );
                    $other_infos         = array();

                    if( $fullImage ) {
                        $other_infos['size'] = array(
                            'width'  => $fullImage[1],
                            'height' => $fullImage[2]
                        );
                    }
                    $createdThumbnailImage = false;

                    if( $returnThumbs ) {
                        $createdThumbnailImage = wp_get_attachment_image_src( $c->ID, 'thumbnail', false );
                    }
                    $working_image = $createdWorkingImage ? $createdWorkingImage[0] : null;
                    if( $working_image ) {
                        $other_infos['working_image']       = $working_image;
                        $returnFiles[$index]['id']          = $c->ID;
                        $returnFiles[$index]['image_src']   = $fullImage[0];
                        $returnFiles[$index]['image']       = md5( $fullImage[0] );
                        $returnFiles[$index]['other_infos'] = $other_infos;
                        if( $returnThumbs && $createdThumbnailImage ) {
                            $returnFiles[$index]['thumbnail'] = $createdThumbnailImage[0];
                        }
                        $index ++;
                    }
                }
                $success = true;
                $result  = array(
                    'sid'   => $sid,
                    'count' => $index,
                    'files' => $returnFiles
                );
            } catch( Exception $e ) {
                $result = $e;
            }

            return array(
                'success' => $success,
                'data'    => $result
            );
        }
    }
