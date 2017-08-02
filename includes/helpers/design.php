<?php
	defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

	class Printq_Design_Helper {

		static function getUserUploadDirectory() {
			$key = 'mySq47234#@dfasd';

			$customer = get_current_user_id();
			if ( $customer ) {
				$sid = $customer;
			} else {
				if ( ! ( $sid = session_id() ) ) {
					session_start();
					$sid = session_id();
				}
			}

			$sid = md5( $sid . $key );

			return $sid;
		}

		static function getUploadedImageUrl() {
			return PRINTQ_UPLOAD_URL;
		}

		static function getProjectSize( $type ) {
			$size = array();
			switch ( $type ) {
				case 'a4':
					$size['width']  = 793;
					$size['height'] = 1122;
					break;
				case 'blog':
					$size['width']  = 800;
					$size['height'] = 1200;
					break;
				case 'card':
					$size['width']  = 560;
					$size['height'] = 396;
					break;
				case 'email':
					$size['width']  = 600;
					$size['height'] = 200;
					break;
				case 'facebookCover':
					$size['width']  = 851;
					$size['height'] = 315;
					break;
				case 'facebookPost':
					$size['width']  = 940;
					$size['height'] = 788;
					break;
				case 'poster':
					$size['width']  = 1587;
					$size['height'] = 2245;
					break;
				case 'social':
					$size['width']  = 800;
					$size['height'] = 800;
					break;
				default:
					$size['width']  = 800;
					$size['height'] = 600;
					break;
			}

			return $size;
		}
	}
