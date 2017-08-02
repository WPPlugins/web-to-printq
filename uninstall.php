<?php

    // If uninstall is not called from WordPress, exit
    if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
        exit();
    }

    $option_name = 'printq_designer';

    delete_option( 'printq_designer_version' );
    delete_option( 'pqd' );

    // For site options in Multisite
    delete_site_option( 'printq_designer_version' );
    delete_site_option( 'pqd' );

    function pqd_delete_dir( $path ) {
        if( !is_dir( $path ) ) {
            return true;
        }
        if( substr( $path, strlen( $path ) - 1, 1 ) != '/' ) {
            $path .= '/';
        }
        $files = glob( $path . '*', GLOB_MARK );
        foreach( $files as $file ) {
            if( is_dir( $file ) ) {
                pqd_delete_dir( $file );
            } else {
                unlink( $file );
            }
        }

        return rmdir( $path );
    }

    $upload_dir = wp_upload_dir();
    pqd_delete_dir( $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'pqd' . DIRECTORY_SEPARATOR );
