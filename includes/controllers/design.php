<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    require_once PRINTQ_CONTROLLERS_DIR . 'abstract.php';

    class Printq_Controller_Design extends Printq_Controller_Abstract {

        protected $_post = null;

        protected $_fonts = array();

        protected function _construct() {
            $this->addNoPriv( array( 'index', 'upload', 'get_shapes', 'delete', 'preview3d', 'themecss' ) );
        }

        public function indexAction() {
            require_once PRINTQ_VIEWS_DIR . 'layout.php';
        }

        public function uploadAction() {
            if( isset( $_FILES['qqfile'] ) || isset( $_POST['photo_url'] ) ) {
                $this->_processUpload();
            } else {
                echo json_encode( array( 'success' => false ) );
            }
        }

        public function deleteAction() {
            $id = intval( sanitize_text_field( $_POST['id'] ) );
            if( $id ) {

                $deleted = wp_delete_attachment($id, true);
                if( false === $deleted ) {
                    echo json_encode( array( 'success' => false ) );
                }
                else {
                    echo json_encode( array( 'success' => true ) );
                }
            } else {
                echo json_encode( array( 'success' => false ) );
            }
        }

        public function preview3dAction() {
            $model = sanitize_text_field( $_GET['model'] );
            if( file_exists( PRINTQ_3D_MODELS_DIR . $model ) ) {
                include PRINTQ_3D_MODELS_DIR . $model;
            }
        }

        public function hex2rgba( $color, $opacity = false ) {

            $default = 'rgb(153,209,34)';

            //Return default if no color provided
            if( empty( $color ) ) {
                return $default;
            }

            //Sanitize $color if "#" is provided
            if( $color[0] == '#' ) {
                $color = substr( $color, 1 );
            }

            //Check if color has 6 or 3 characters and get values
            if( strlen( $color ) == 6 ) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                return $default;
            }

            //Convert hexadec to rgb
            $rgb = array_map( 'hexdec', $hex );

            //Check if opacity is set(rgba or rgb)
            if( $opacity ) {
                if( abs( $opacity ) > 1 ) {
                    $opacity = 1.0;
                }
                $output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
            } else {
                $output = 'rgb(' . implode( ",", $rgb ) . ')';
            }

            //Return rgb(a) color string
            return $output;
        }

        public function themecssAction() {
            ob_start();
            include PRINTQ_VIEWS_DIR . 'themecss.php';
            $content = ob_get_clean();
            header( 'Content-Type: text/css; charset=UTF-8' );
            header( 'Etag: ' . md5( $content ) );
            echo $content;
            exit;
        }

        public function downloadPdfAction() {
            if( pqd_is_active() ) {
                $pdf = isset( $_GET['pdf'] ) ? sanitize_text_field( $_GET['pdf'] ) : '';
                if( !$pdf ) {
                    wp_die( __( 'Please specify a valid pdf', PQD_DOMAIN ) );
                }

                $pdf_url = PRINTQ_REST_URI . 'getPdf/' . $pdf;
                $pdf_url = add_query_arg( array( 'api_key' => pqd_get_config( 'api_key' ) ), $pdf_url );
                global $wp_version;
                $response = wp_remote_get( $pdf_url, array(
                    'timeout'    => 30,
                    'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url()
                ) );
                if( is_wp_error( $response ) ) {
                    wp_die( __( 'Cannot retrieve PDF! Please try again!', PQD_DOMAIN ) );
                }

                if( isset( $response['response']['code'] ) && $response['response']['code'] != 200 ) {
                    //error on rest server
                    wp_die( __( 'Cannot retrieve PDF data', PQD_DOMAIN ) );
                } else {
                    //pdf content in $response['body']
                    header( 'Content-Disposition: attachment; filename="' . $pdf . '"' );
                    header( 'Content-Type: application/pdf' );
                    header( 'Content-Length: ' . strlen( $response['body'] ) );
                    echo $response['body'];
                    exit;
                }
            }
        }

        private function _processUpload() {
            $result = null;

            //media upload
            try {
                $post_data   = $_POST;
                $isUrlUpload = ( isset( $post_data['isUrlUpload'] ) && intval( $post_data['isUrlUpload'] ) == 1 ) ? 1 : 0;
                $other_infos = ( isset( $post_data['other_infos'] ) && is_array( $post_data['other_infos'] ) ) ? $post_data['other_infos'] : array();

                if( isset( $post_data['sid'] ) && strlen( $post_data['sid'] ) > 1 ) {
                    $sid = sanitize_text_field( $post_data['sid'] );
                } else {
                    $sid = Printq_Design_Helper::getUserUploadDirectory();
                }

                if( !function_exists( 'media_handle_upload' ) ) {
                    require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
                    require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
                    require_once( ABSPATH . "wp-admin" . '/includes/media.php' );
                }
                if( $isUrlUpload ) {
                    if( !isset( $post_data['photo_url'] ) ) {
                        throw new Exception( 'Photo url missing!' );
                    }
                    $photo_url = esc_url_raw( urldecode( $post_data['photo_url'] ) );
                    $tmp_file  = download_url( $photo_url );
                    if( !is_wp_error( $tmp_file ) ) {
                        $tmp = md5( $photo_url );
                        $tmp .= '.' . pqd_get_image_ext_from_url( $photo_url );
                        $file_array = array(
                            'name'     => $tmp,
                            'tmp_name' => $tmp_file,
                        );

                        $media_id = media_handle_sideload( $file_array, 0, null, array( 'context' => $sid ) );
                        if( is_wp_error( $media_id ) ) {
                            @unlink( $file_array['tmp_name'] );
                            throw new Exception( implode( '. ', $media_id->get_error_messages() ) );
                        }
                    } else {
                        @unlink( $tmp_file );
                        throw new Exception( implode( '. ', $tmp_file->get_error_messages() ) );
                    }
                    //determine extension
                } else {
                    $media_id = media_handle_upload( 'qqfile', 0, array( 'context' => $sid ) );
                    if( is_wp_error( $media_id ) ) {
                        throw new Exception( implode( '. ', $media_id->get_error_messages() ) );
                    }
                }
                $createdThumbnail    = false;
                $createdWorkingImage = false;

                if( isset( $post_data['createThumbnail'] ) && intval( $post_data['createThumbnail'] ) == 1 ) {
                    $createdThumbnail = wp_get_attachment_image_src( $media_id, 'thumbnail', false );
                }
                if( isset( $post_data['createWorkingImage'] ) && $post_data['createWorkingImage'] == 1 ) {
                    $createdWorkingImage          = wp_get_attachment_image_src( $media_id, 'large', false );
                    $other_infos['working_image'] = $createdWorkingImage[0];
                }
                if( $createdWorkingImage ) {
                    $other_infos['working_image'] = $createdWorkingImage[0];
                }
                $fullImage = wp_get_attachment_image_src( $media_id, 'full', false );

                if( $fullImage ) {
                    $other_infos['size'] = array(
                        'width'  => intval( $fullImage[1] ),
                        'height' => intval( $fullImage[2] )
                    );
                }
                echo json_encode( array(
                                      'success'       => true,
                                      'id'            => $media_id,
                                      'path'          => $fullImage ? md5( $fullImage[0] ) : '',
                                      'src'           => $fullImage ? $fullImage[0] : '',
                                      'name'          => isset( $post_data['name'] ) ? sanitize_text_field( $post_data['name'] ) : '',
                                      'thumbnail'     => $createdThumbnail ? $createdThumbnail[0] : '',
                                      'other_infos'   => $other_infos,
                                      'loaded'        => false,
                                      'apiloaded'     => true,
                                      'sid'           => trim( $sid, '/' ),
                                      'working_image' => $createdWorkingImage ? $createdWorkingImage[0] : '',
                                  ) );
            } catch( Exception $e ) {
                echo json_encode( array( 'success' => false, 'message' => $e->getMessage() ) );
            }
            exit;
        }

        public function get_shapesAction() {
            $limit    = 20;
            $offset   = isset( $_POST['offset'] ) ? intval( $_POST['offset'] ) : 0;
            $category = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) . '/' : '';

            $shapes = array_slice( glob( PRINTQ_SHAPES_DIR . $category . '*.svg' ), $offset, $limit );

            foreach( $shapes as &$shape ) {
                $shape = basename( $shape );
            }

            echo json_encode( array(
                                  'success'  => 1,
                                  'shapes'   => $shapes,
                                  'category' => $category
                              ) );
        }

        public function getFonts() {
            return array(
                'Abel',
                'Abril Fatface',
                'Amatic SC',
                'Anton',
                'Arial',
                'Arimo',
                'Cinzel',
                'Dancing Script',
                'Dosis',
                'Open Sans Condensed',
                'Droid Serif',
                'Exo',
                'Francois One',
                'Inconsolata',
                'Indie Flower',
                'Josefin Slab',
                'Kaushan Script',
                'Lato',
                'Lobster',
                'Lora',
                'Merriweather',
                'Montserrat',
                'News Cycle',
                'Noticia Text',
                'Noto Sans',
                'Open Sans',
                'Orbitron',
                'Oswald',
                'PT Sans',
                'PT Sans Narrow',
                'Pacifico',
                'Play',
                'Poiret One',
                'Raleway',
                'Roboto',
                'Roboto Condensed',
                'Roboto Mono',
                'Roboto Slab',
                'Rokkitt',
                'Shadows Into Light',
                'Slabo 27px',
                'Source Sans Pro',
                'Titillium Web',
                'Ubuntu',
                'Yanone Kaffeesatz',
                'Yellowtail'
            );
        }

        public function getTemplate( $id = null ) {
            if( !$id ) {
                $id = intval( $_REQUEST['pqd_template'] );
            }
            $width  = isset( $_GET['width'] ) ? intval( $_GET['width'] ) : 800;
            $height = isset( $_GET['height'] ) ? intval( $_GET['height'] ) : 600;

            $post = get_post( $id, ARRAY_A );
            $json = '[]';
            if( $post ) {
                if( trim( $post['post_content'] ) ) {
                    $json = sanitize_text_field( $post['post_content'] );
                } else {
                    $json = '{}';
                }
            } else {
                if( $width && $height ) {
                    $json['width']  = $width;
                    $json['height'] = $height;
                } else {
                    $json = array(
                        'width'  => 800,
                        'height' => 600
                    );
                }
                $json['content_type'] = 'svg';
                $json['page_number']  = 1;
                $json['content']      = '';
                $json['visited']      = 0;
                $json                 = json_encode( array( $json ) );
            }

            return $json;
        }

        public function get3DData( $id = null ) {
            if( isset( $_GET['is_admin'] ) ) {
                //request from backend edit template
                $enable_3d     = isset( $_GET['3d_preview'] ) ? intval( $_GET['3d_preview'] ) == 1 : false;
                $model_3d      = isset( $_GET['3d_model'] ) ? sanitize_text_field( $_GET['3d_model'] ) : '';
                $model_texture = isset( $_GET['3d_texture'] ) ? sanitize_text_field( $_GET['3d_texture'] ) : '';

                $data = array(
                    'enable_3d_preview' => $enable_3d,
                    '3d_model'          => $model_3d,
                    '3d_texture'        => $model_texture
                );
            } else {
                //frontend, get template
                if( !$id ) {
                    $id = intval( $_REQUEST['pqd_template'] );
                }
                $meta = get_post_meta( $id, 'pqd_template_settings', true );

                $data = array(
                    'enable_3d_preview' => isset( $meta['enable_3d_preview'] ) ? intval( $meta['enable_3d_preview'] ) == 1 : false,
                    '3d_model'          => isset( $meta['3d_model'] ) ? esc_attr( $meta['3d_model'] ) : '',
                    '3d_texture'        => isset( $meta['3d_texture'] ) ? esc_attr( $meta['3d_texture'] ) : ''
                );
            }

            return $data;

        }

        public function getUserUploadDirectory() {
            session_start();
            $key      = 'mySq47234#@dfasd';
            $sid      = session_id();
            $customer = wp_get_current_user();

            if( $customer ) {
                $sid = $customer->ID;
            }
            $sid = md5( $sid . $key );

            return $sid;
        }
    }
