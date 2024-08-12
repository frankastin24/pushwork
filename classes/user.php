<?php

class User
{
    function __construct()
    {
        add_action("wp_ajax_upload_image", array($this, "upload_image"));
        add_action("wp_ajax_nopriv_upload_image", array($this, "upload_image"));
        add_action("wp_ajax_register_freelancer", array($this, "register_freelancer"));
        add_action("wp_ajax_nopriv_register_freelancer", array($this, "register_freelancer"));

        add_action("wp_ajax_register_buyer", array($this, "register_buyer"));
        add_action("wp_ajax_nopriv_register_buyer", array($this, "register_buyer"));

        add_action("wp_ajax_update_meta", array($this, "update_meta"));
        add_action("wp_ajax_nopriv_update_meta", array($this, "update_meta"));
        add_action('init', array($this, 'add_custom_user_role'));
        add_action('wp', array($this, 'check_user_status'));
    }

    public function check_user_status()
    {

        global $post;

        if (is_user_logged_in() && !current_user_can('administrator')) {
            $user = wp_get_current_user();

            if ($user->roles[0] == 'freelancer') {



                if (get_user_meta($user->ID, 'verification', true) !== 'true') {



                    if (!$post ||   ($post && $post->post_name !== 'account-created')) {

                        wp_redirect('/account-created');
                        exit();
                    }
                } else if (get_user_meta($user->ID, 'title', true) == '') {

                    if (!$post ||   ($post && $post->post_name !== 'register-freelancer')) {

                        wp_redirect('/register-freelancer');
                        exit();
                    }
                }
            }
        }
    }

    public function update_meta()
    {

        $user = wp_get_current_user();

        update_user_meta($user->ID, 'avatar', $_POST['picture']);
        update_user_meta($user->ID, 'title', $_POST['title']);
        update_user_meta($user->ID, 'skills', $_POST['skills']);
        update_user_meta($user->ID, 'about', $_POST['about']);
        update_user_meta($user->ID, 'location', $_POST['location']);
        update_user_meta($user->ID, 'rate', $_POST['rate']);
        update_user_meta($user->ID, 'id', $_POST['id']);
        if (is_wp_error($user)) {
            echo json_encode(array('success' => false, 'message' => $user));
        } else {
            echo json_encode(array('success' => true, 'message' => $user));
        }
        die();
    }

    public function register_freelancer()
    {

        $verfify_code = hash('md5', $_POST['email']);

        $new_user_id = wp_insert_user(array(
            'user_login' => $_POST['email'],
            'user_pass' => $_POST['password'],
            'user_email' => $_POST['email'],
            'first_name' => '',
            'last_name' => '',
            'display_name' => $_POST['name'],
            'role' => 'freelancer',
            'meta_input' => array(
                'verification' => $verfify_code,
            )
        ));

        $mail_body = '<h1>Please verfify your email by clicking the link below</h1><a href="https://pushwork.co.uk/?verfify=' . $verfify_code . '">Click here</a>';

        wp_mail($_POST['email'], 'Pushwork Verify email address', $mail_body);


        if (is_wp_error($new_user_id)) {
            echo json_encode(array('success' => false, 'message' => $new_user_id));
        } else {
            echo json_encode(array('success' => true, 'message' => $new_user_id));
        }

        die();
    }
    public function register_buyer()
    {

        $verfify_code = hash('md5', $_POST['email']);

        $new_user_id = wp_insert_user(array(
            'user_login' => $_POST['email'],
            'user_pass' => $_POST['password'],
            'user_email' => $_POST['email'],
            'first_name' => '',
            'last_name' => '',
            'display_name' => $_POST['name'],
            'role' => 'buyer',
            'meta_input' => array(
                'verification' => $verfify_code,
            )
        ));

        $mail_body = '<h1>Please verfify your email by clicking the link below</h1><a href="https://pushwork.co.uk/?verfify=' . $verfify_code . '">Click here</a>';

        wp_mail($_POST['email'], 'Pushwork Verify email address', $mail_body);



        if (is_wp_error($new_user_id)) {
            echo json_encode(array('success' => false, 'message' => $new_user_id));
        } else {
            wp_clear_auth_cookie();
            wp_set_current_user($new_user_id);
            wp_set_auth_cookie($new_user_id);
            echo json_encode(array('success' => true, 'message' => $new_user_id));
        }

        die();
    }
    public function add_custom_user_role()
    {
        add_role(
            'freelancer',
            'Freelancer',
            array(
                'read' => true,
                'edit_posts' => false,
                'delete_posts' => false,
                'publish_posts' => false,
                'upload_files' => true,
            )
        );
        add_role(
            'buyer',
            'Buyer',
            array(
                'read' => true,
                'edit_posts' => false,
                'delete_posts' => false,
                'publish_posts' => false,
                'upload_files' => true,
            )
        );
    }

    public function upload_image()
    {

        $filepath = $_FILES['file']['tmp_name'];
        $fileSize = filesize($filepath);


        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $filetype = finfo_file($fileinfo, $filepath);

        $response = array();

        $allowedTypes = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg'
        ];

        if (!in_array($filetype, array_keys($allowedTypes))) {
            $response['success'] = false;
            $response['message'] = "File not allowed.";
            echo json_encode($response);
        }



        if ($fileSize > 20254333) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
            $response['success'] = false;
            $response['message'] = "The file is too large";
            echo json_encode($response);
            die();
        }


        require_once(ABSPATH . 'wp-admin/includes/admin.php');
        $response['success'] = true;
        $response['message'] = wp_handle_upload($_FILES['file'], array('test_form' => false));

        echo json_encode($response);
        die();
    }
}
