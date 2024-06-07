<?php

namespace Wappsnet\Core;

class Upload {
    public static function upload_images($file = array()) {

        $upload_image = wp_handle_upload($file, array('test_form' => false ));

        if(isset($upload_image['error']) || isset($upload_image['upload_error_handler'])) {
            return false;
        } else {

            $upload_name = $upload_image['file'];
            $upload_type = wp_check_filetype(basename($upload_name), null);

            $attachment = array(
                'guid'           => $upload_name,
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename($upload_name)),
                'post_mime_type' => $upload_type['type'],
                'post_status'    => 'inherit'
            );

            $attachment_id   = wp_insert_attachment($attachment, $upload_name);
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_name);

            wp_update_attachment_metadata($attachment_id, $attachment_data);

            if(0 < intval($attachment_id)) {
                return $attachment_id;
            }
        }

        return false;
    }

    public static function handle_upload($file) {
        if (!function_exists( 'wp_handle_upload')) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $overrides = array('test_form' => false);
        $moveFile  = wp_handle_upload($file, $overrides);

        return $moveFile;
    }
}