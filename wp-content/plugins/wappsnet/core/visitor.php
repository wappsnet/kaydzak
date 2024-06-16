<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 8/27/16
 * Time: 9:02 PM
 */

namespace Wappsnet\Core;

class Visitor
{
    protected static $responseErrors = Array();
    protected static $responseMessages = Array();
    protected static $responseLocation = false;
    protected static $responseData = Array();
    protected static $responseContent = null;

    protected static function getResponse() {
        return Array(
            'errors' => self::$responseErrors,
            'messages' => self::$responseMessages,
            'location' => self::$responseLocation,
            'data' => self::$responseData,
            'content' => self::$responseContent
        );
    }

    public static function register($request) {
        $langData = Parser::getConfig('lang');

        if(!empty($request)) {
            $requestData = Array(
                'email' =>  sanitize_email($request['email']),
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'phone' =>  $request['phone'],
                'password' => $request['password'],
            );

            if(email_exists($requestData["email"]) > 0) {
                self::$responseErrors['email'] = true;
                self::$responseMessages[] = $langData['user_already_exist'];
            } else {
                $user = wp_create_user(
                    $requestData["email"],
                    $requestData["password"],
                    $requestData["email"]
                );

                if (!empty($user)) {
                    $userObj = new \WP_User($user);
                    $userObj->set_role('customer');

                    update_user_meta($user, 'first_name', $requestData["first_name"]);
                    update_user_meta($user, 'last_name', $requestData["last_name"]);
                    update_user_meta($user, 'phone', $requestData["phone"]);

                    $subject  = $langData['reg_subject'];
                    $message  = $langData['reg_success'];
                    $message .= $langData['reg_data'];
                    $message .= $langData['login'].$requestData["email"];
                    $message .= $langData['password'].$requestData["password"];

                    Mailer::sendMail($subject, $requestData['mail'], $message);

                    self::$responseMessages[] = $langData['info_to_email'];
                } else {
                    self::$responseMessages[] = $langData['error_unexpected'];
                }
            }

            foreach($requestData as $key => $value) {
                if(!$value) {
                    self::$responseErrors[$key] = true;
                }
            }
        }

        return self::getResponse();
    }

    public static function login($data) {
        $langData = Parser::getConfig('lang');

        if(!empty($data)) {
            $email = sanitize_email($data['email']);
            $pass  = sanitize_text_field($data['password']);
            $user  = get_user_by('email', $email);

            if($user) {
                $signOnData = wp_signon(array(
                    "user_login" => $user->user_login, "user_password" => $pass
                ));

                if(is_wp_error($signOnData)) {
                    self::$responseErrors['email'] = true;
                    self::$responseErrors['password'] = true;
                    self::$responseMessages[] = $langData['wrong_login_data'];
                }
            } else {
                self::$responseErrors['email'] = true;
                self::$responseMessages[] = $langData['user_not_exist'];
            }
        }


        if(count(self::$responseErrors) == 0) {
            $linkData = Parser::getConfig('link');
            self::$responseLocation = $linkData['cabinet'];
        }

        return self::getResponse();
    }

    public static function forgot($data) {
        $langData = Parser::getConfig('lang');

        if(!empty($data)) {
            $email = sanitize_email($data['email']);
            $user  = get_user_by('email', $email);

            if($user) {
                $newPassword = wp_generate_password(6, false);
                wp_set_password($newPassword, $user->ID);

                $subject  = $langData['forgot_subject'];
                $message  = $langData['forgot_login'];
                $message .= $langData['login'];
                $message .= $langData['new_password'].$newPassword;

                Mailer::sendMail($subject, $email, $message);

                self::$responseMessages[] = $langData['pass_to_email'];
            } else {
                self::$responseErrors['email'] = true;
                self::$responseMessages[] = $langData['user_not_exist'];
            }
        } else {
            self::$responseErrors['email'] = true;
            self::$responseMessages[] = $langData['user_not_exist'];
        }

        return self::getResponse();
    }

    public static function change_password($data) {
        $langData = Parser::getConfig('lang');

        $currentUser = get_user_by('user_pass', $data['old_password']);

        print_r($currentUser);

        if(isset($currentUser)) {
            if(isset($data['new_password'])) {
                wp_set_password($data['new_password'], $currentUser->ID);
            } else {
                self::$responseErrors['user_password'] = true;
                self::$responseMessages[] = $langData['wrong_password'];
            }
        } else {
            self::$responseErrors['old_password'] = true;
            self::$responseMessages[] = $langData['permission_denied'];
        }

        if(count(self::$responseErrors) == 0) {
            self::$responseMessages[] = $langData['user_data_saved'];
        }

        return self::getResponse();
    }

    /**
     * save profile changes
     * @param $data
     * @return array
     */
    public static function saveUser($data) {
        $langData = Parser::getConfig('lang');

        $currentId = get_current_user_id();

        if(isset($data['user_id']) && $currentId == $data['user_id']) {
            if(isset($data['first_name'])) {
                if(sanitize_text_field($data['first_name'])) {
                    update_user_meta($currentId, 'first_name', $data['first_name']);
                } else {
                    self::$responseErrors['first_name'] = true;
                }
            }

            if(isset($data['last_name'])) {
                if(sanitize_text_field($data['last_name'])) {
                    update_user_meta($currentId, 'last_name', $data['last_name']);
                } else {
                    self::$responseErrors['last_name'] = true;
                }
            }

            if(isset($data['phone'])) {
                if(sanitize_text_field($data['phone'])) {
                    update_user_meta($currentId, 'phone', $data['phone']);
                } else {
                    self::$responseErrors['phone'] = true;
                }
            }

            if(isset($data['address'])) {
                if(sanitize_text_field($data['address'])) {
                    update_user_meta($currentId, 'address', $data['address']);
                } else {
                    self::$responseErrors['address'] = true;
                }
            }
        } else {
            self::$responseErrors['user_id'] = true;
            self::$responseMessages[] = $langData['permission_denied'];
        }

        if(count(self::$responseErrors) == 0) {
            self::$responseMessages[] = $langData['user_data_saved'];
        }

        return self::getResponse();
    }

    /**
     * create subscriber
     * @param $request
     * @return array
     */
    public static function subscribe($request) {
        global $shopper;

        if(!empty($request)) {
            $sanitizedEmail = sanitize_email($request['subscribe_email']);

            if(email_exists($sanitizedEmail) > 0) {
                self::$responseErrors['email'] = true;
                self::$responseMessages[] = $shopper['lang']['subscribe_exist'];
            } else {
                $pass = wp_generate_password(6, false);
                $user = wp_create_user($sanitizedEmail, $pass, $sanitizedEmail);

                if (!empty($user)) {
                    $subject = $shopper['lang']['subscribe_subject'];
                    $message = $shopper['lang']['subscribe_mail'];

                    Mailer::sendMail($subject, $sanitizedEmail, $message);

                    self::$responseMessages[] = $shopper['lang']['subscribe_success'];
                }
            }
        }

        return self::getResponse();
    }

    /**
     * logout user
     * @return array
     */
    public static function logoutUser() {
        wp_logout();

        if(count(self::$responseErrors) == 0) {
            $linkData = Parser::getConfig('link');
            self::$responseLocation = $linkData['login'];
        }

        return self::getResponse();
    }

    /**
     * get visitor data
     * @param $id
     * @return array
     */
    public static function get_visitor($id = null) {
        if(empty($id)) {
            $id = get_current_user_id();
        }

        $userInfo = Array(
            'user_id'     => null,
            'user_email'  => null,
            'user_nick'   => null,
            'user_date'   => null,
            'user_name'   => null,
            'user_first'  => null,
            'user_last'   => null,
            'user_phone'  => null,
            'user_address' => null,
        );

        if($id) {
            $userData = get_user_by('id', $id);
        } else {
            $userData = wp_get_current_user();
        }

        if($userData) {
            $userFirstName = get_user_meta($userData->ID, 'first_name', true);
            $userLastName = get_user_meta($userData->ID, 'last_name', true);
            $userPhone = get_user_meta($userData->ID, 'phone', true);
            $userAddress = get_user_meta($userData->ID, 'address', true);

            $userInfo['user_id']     = $userData->ID;
            $userInfo['user_email']  = $userData->user_email;
            $userInfo['user_nick']   = $userData->user_nicename;
            $userInfo['user_date']   = $userData->user_registered;
            $userInfo['user_name']   = $userFirstName." ".$userLastName;
            $userInfo['user_first']  = $userFirstName;
            $userInfo['user_last']   = $userLastName;
            $userInfo['user_phone']  = $userPhone;
            $userInfo['user_address']  = $userAddress;
        }

        return $userInfo;
    }

    /**
     * check user permission
     * @return int
     */
    public static function checkAllowUser() {
        global $post;

        if (!empty($post)) {
            $statusTypes = get_field('user_status', $post->ID);

            if (!empty($statusTypes)) {
                $currentUserId = get_current_user_id();

                $loginRequired = true;

                foreach ($statusTypes as $type) {
                    if ($type != 'authenticated') {
                        $loginRequired = false;
                    }
                }

                $linkData = Parser::getConfig('link');

                if ($loginRequired && !$currentUserId) {
                    if (wp_redirect($linkData['login'], 301)) {
                        exit();
                    }
                } else if (!$loginRequired && $currentUserId) {
                    if (wp_redirect($linkData['cabinet'], 301)) {
                        exit();
                    }
                }
            }
        }
    }

    /**
     * create comments
     * @param $request
     * @return array
     */
    public static function addComment($request) {
        $langData = Parser::getConfig('lang');

        if (!empty($request)) {
            $commentEmail  = sanitize_email($request['email']);
            $commentName   = sanitize_text_field($request['name']);
            $commentText   = sanitize_text_field($request['text']);

            if(!$commentEmail) {
                self::$responseErrors['email'] = true;
            }

            if(!$commentName) {
                self::$responseErrors['name'] = true;
            }

            if(!$commentText) {
                self::$responseErrors['text'] = true;
            }

            $commenter = email_exists($commentEmail);

            if (!$commenter) {
                $password  = wp_generate_password();
                $commenter = wp_create_user($commentEmail, $password, $commentName);

                $userObj = new \WP_User($commenter);
                $userObj->set_role('subscriber');
            }

            if (is_int($commenter) && $commenter > 0) {
                $commentTime = current_time('mysql');
                $commentData = Array(
                    'user_id' => $commenter,
                    'comment_date' => $commentTime,
                    'comment_author' => $commentName,
                    'comment_author_email' => $commentEmail,
                    'comment_content' => $commentText,
                    'comment_post_ID' => $request['post_id'],
                    'comment_approved' => 0
                );

                $comment = wp_insert_comment($commentData);

                if($comment) {
                    $subject = $langData['comment_subject'];
                    $message = $langData['comment_moderation_pre'];
                    $message .= $langData['comment_moderation_pro'];
                    Mailer::sendMail($subject, $commentEmail, $message);

                    self::$responseMessages[] = $langData['comment_moderation_pre'];
                } else {
                    self::$responseMessages[] = $langData['check_insert_data'];
                }
            } else {
                self::$responseMessages[] = $langData['check_insert_data'];
            }
        }

        return self::getResponse();
    }
}