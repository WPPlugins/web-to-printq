<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    class Printq_Pdf_Helper {

        protected static $restUri = PRINTQ_REST_URI;

        public static function generate_pdf( $svg, $name, $path = '' ) {
            $data = array(
                'file'        => $name . '.pdf',
                'selection'   => $name,
                'file_output' => 'jpeg',
                'api_key'     => pqd_get_config( 'api_key' )
            );

            if( !empty( $svg ) ) {
                $results           = array();
                $data['image_svg'] = array();
                $data['svg']       = array();
                $upload_dir        = wp_upload_dir();
                foreach( $svg as $item_svg ) {
                    $item_svg = stripslashes( $item_svg );
                    //$xml      = new SimpleXMLElement( $item_svg );
                    if( !empty( $item_svg ) && strlen( $item_svg ) ) {
                        $local_svg = $item_svg;
                        $local_svg = str_replace( "_working", "", $local_svg );
                        preg_match_all( '/xlink:href=\"(.*?)\"/', $local_svg, $results );
                        //$local_svg = str_replace( $upload_dir['baseurl'], "", $local_svg );
                        if( isset( $results ) ) {
                            foreach( $results[1] as &$var ) {
                                if( !strpos( $var, 'base64' ) ) {
                                    $new_name                     = md5( $var );
                                    $local_svg                    = str_replace( $var, $new_name, $local_svg );
                                    $var                          = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $var );
                                    $data['image_svg'][$new_name] = $var;
                                }
                            }
                        }
                        array_push( $data['svg'], $local_svg );
                    }
                }
            }

            $alreadySent      = array();
            $blockAlreadySent = array();

			$files_to_send = array();
            if( isset( $data['image_svg'] ) && is_array( $data['image_svg'] ) ) {
                foreach( $data['image_svg'] as $file_name => $filePath ) {

                    if( file_exists( $filePath ) && !in_array( $file_name, $alreadySent ) && !in_array( $file_name, $blockAlreadySent ) ) {
                        $blockAlreadySent[] = $file_name;
                        if( class_exists( 'CURLFile' ) ) {
                            $file             = new CURLFile( realpath( $filePath ), '', $file_name );
							//workaround for build query below
							$files_to_send[ $file_name ] = $file;
                        } else {
                            $data[$file_name] = '@' . realpath( $filePath ) . ';filename=' . $file_name;
                        }
                    }
                }
            }
            unset( $data['image_svg'] );
            self::http_build_query_for_curl( $data, $curl_data );

			//add possible CURLFiles
			if ( count( $files_to_send ) ) {
				foreach ( $files_to_send as $name => $fData ) {
					$curl_data[ $name ] = $fData;
				}
			}

            $ch = curl_init( self::$restUri . 'preview' );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array( "Content-type: multipart/form-data" ) );
            curl_setopt( $ch, CURLOPT_TIMEOUT, 18000 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $curl_data );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            /*if( defined( 'CURLOPT_SAFE_UPLOAD' ) ) {
                curl_setopt( $ch, CURLOPT_SAFE_UPLOAD, false );
            }*/
            $response = curl_exec( $ch );
            curl_close( $ch );

            if(  $response === false ) {
                throw new Exception( __( 'Cannot make rest server request! Please try again', PQD_DOMAIN ) );
            }
            $body = json_decode( $response, true );

            //save pdf key in cart, don't download it
            if( isset( $body['result']['pdf'] ) && $body['result']['pdf'] ) {
                return $body['result']['pdf'];
            }

            return false;
        }

        protected static function http_build_query_for_curl( $arrays, &$new = array(), $prefix = null ) {

            if( is_object( $arrays ) ) {
                $arrays = get_object_vars( $arrays );
            }

            foreach( $arrays AS $key => $value ) {
                $k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
                if( is_array( $value ) || is_object( $value ) ) {
                    self::http_build_query_for_curl( $value, $new, $k );
                } else {
                    $new[$k] = $value;
                }
            }
        }

        public static function showPreview( $data, $extension, $path = '' ) {
            $images = array();

            if( !defined( 'FS_CHMOD_FILE' ) ) {
                define( 'FS_CHMOD_FILE', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 ) );
            }
            require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
            require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
            $wp_filesystem = new WP_Filesystem_Direct( new StdClass() );

            $tmp_dir = PRINTQ_UPLOAD_PREVIEWS_DIR;
            if( $path ) {
                $tmp_dir .= $path . DIRECTORY_SEPARATOR;
            }
            if( !file_exists( $tmp_dir ) ) {
                if( !wp_mkdir_p( $tmp_dir ) ) {
                    throw new Exception( __( 'Cannot create preview folder', PQD_DOMAIN ) );
                }
            }
            if( is_array( $data ) ) {
                foreach( $data as $image ) {
                    do {
                        $name = md5( microtime() );
                    } while( in_array( $name, $images ) );

                    $full  = $tmp_dir . $name . $extension;
                    $thumb = $tmp_dir . $name . '_thumb' . $extension;
                    $put   = $wp_filesystem->put_contents( $full, base64_decode( sanitize_text_field( $image ) ), FS_CHMOD_FILE );
                    if( $put ) {
                        //create thumbnail
                        $image_editor = wp_get_image_editor( $full );
                        $img_result   = array( 'full' => $name . $extension );
                        if( !is_wp_error( $image_editor ) ) {
                            $image_editor->resize( 50, 50, true );
                            $created = $image_editor->save( $thumb );
                            if( !is_wp_error( $created ) ) {
                                $img_result['thumb'] = $name . '_thumb' . $extension;
                            }
                        }
                        $images[] = $img_result;
                    }
                }
            } else {
                $name = md5( microtime() ) . $extension;
                $put  = $wp_filesystem->put_contents( $tmp_dir . $name, base64_decode( $data ) );
                if( $put ) {
                    $images = array( $name );
                }
            }

            return $images;
        }

    }
