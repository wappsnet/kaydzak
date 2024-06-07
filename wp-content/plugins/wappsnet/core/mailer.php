<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 8/27/16
 * Time: 9:02 PM
 */

namespace Wappsnet\Core;

class Mailer
{
    public static function sendMail($subject, $addresses, $message) {
        $headers[] = 'From: Batiste-Parfume <info@batiste-parfume.ru>';
        $headers[] = 'Cc: Batiste-Parfume <info@batiste-parfume.ru>';
        $headers[] = 'Cc: info@batiste-parfume.ru';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        if(is_array($addresses)) {
            foreach ($addresses as $address) {
                wp_mail($address, $subject, $message, $headers);
            }
        } else {
            wp_mail($addresses, $subject, $message, $headers);
        }
    }
}