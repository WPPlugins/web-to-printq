<?php
    defined( 'ABSPATH' ) or die( 'Are you trying to trick me?' );

    require_once PRINTQ_CONTROLLERS_DIR . 'abstract.php';

    class Printq_Controller_Instagram extends Printq_Controller_Abstract {

        protected $instagram = null;

        protected $config = array(
            'apiKey'      => null,
            'apiSecret'   => null,
            'grant_type'  => null,
            'apiCallback' => null,
        );

        protected function getConfig() {
            $this->config = array(
                'apiKey'      => pqd_get_config( 'instagram_api_key' ),
                'apiSecret'   => pqd_get_config( 'instagram_api_secret' ),
                'grant_type'  => 'authorization_code',
                'apiCallback' => add_query_arg( array(
                                                    'pqd'       => 'instagram',
                                                    'method'    => 'auth',
                                                    'pqd_nonce' => wp_create_nonce( 'pqd_nonce' ),
                                                ), get_home_url() ),
            );

            return $this->config;
        }

        protected function _construct() {
            $this->addNoPriv( array( 'index' ) );
            $this->addAllowDirect( 'index' );

            require_once PRINTQ_HELPERS_DIR . 'instagram.php';
            $this->instagram = new Printq_Instagram_Helper( $this->getConfig() );
        }

        public function indexAction() {
            session_start();
            $request     = $_REQUEST;
            $auth        = false;
            $method      = ( isset( $request['method'] ) ) ? sanitize_text_field($request['method']) : false;
            $data        = array();
            $meta        = array();
            $accessToken = $this->instagram->getAccessToken();
            $authUrl     = $this->instagram->getLoginUrl();

            if( isset( $request['code'] ) ) {
                $accessToken = $this->instagram->getOAuthToken( sanitize_text_field($request['code']), true );
            }
            if( !$accessToken ) {
                if( isset( $_SESSION['pqd_instagram_at'] ) ) {
                    $accessToken = sanitize_text_field($_SESSION['pqd_instagram_at']);
                } else {
                    $accessToken = null;
                }
            }

            $_SESSION['pqd_instagram_at'] = $accessToken;

            $this->instagram->setAccessToken( $accessToken );
            $user = $this->instagram->getUser( 0 );

            if( isset( $user['meta'] ) && $user['meta']['code'] == '200' ) {
                $response = $this->instagram->getUserMedia();
                $auth     = true;
                $meta     = $response['meta'];
                $data     = $response['data'];
            }

            $result = array(
                'auth'       => $auth,
                'meta'       => $meta,
                'data'       => $data,
                'pagination' => false,
                'authUrl'    => $authUrl
            );
            if( $method == 'auth' ) {
                print "
				<script>
				        window.opener.jQuery( '.allInstagramAlbumsImages' ).data( 'printq-instagramAlbumsImages' ).open();
				        window.close();
				</script>
				";
            } else {
                print json_encode( $result );
            }
        }

        public function clearAction() {
            unset( $_SESSION['pqd_instagram_at'] );
        }
    }
