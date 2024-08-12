<?php
define('TEMPLATE_URI', get_template_directory_uri());
define('TEMPLATE_PATH', get_template_directory());

$session_id = session_id();
if(empty($session_id)) {
    session_start();
    $session_id = session_id();
}

global $errors;

$errors = array('email' => false,'password' => false);

if(isset($_GET['verfify'])) {
   
    $user_query =  get_users(['meta_key' => 'verification','meta_value' => $_GET['verfify']] );
   
    $user = $user_query[0];
    update_user_meta($user->ID,'verification','true');
   wp_clear_auth_cookie();
   wp_set_current_user ( $user->ID );
   wp_set_auth_cookie  ( $user->ID );
   wp_redirect('/');
   exit;
  
}

if(isset($_GET['logout'])) {
    wp_logout();
    wp_redirect(home_url());
    var_dump('here');
    exit;
}

if(isset($_POST['is_login'])) {

    
    $creds = array();
    $creds['user_login'] = $_POST['email'];
    $creds['user_password'] = $_POST['password'];
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );
    if ( is_wp_error($user) ){
        if( $user->get_error_message() == 'Unknown email address. Check again or try your username.'){
            $errors['email'] = true;
        }

        if(str_contains( $user->get_error_message() , 'The password you entered for the email address' )) {
            $errors['password'] = true;
        }

echo $user->get_error_message();

    } else {
        
        
        wp_clear_auth_cookie();
        wp_set_current_user ( $user->ID );
        wp_set_auth_cookie  ( $user->ID );
     
        wp_safe_redirect('/account-created');
        exit();

    }
    
    
}



define('IMG_URL', get_template_directory_uri() . '/img');

include TEMPLATE_PATH . '/classes/jobs.php';
include TEMPLATE_PATH . '/classes/skills.php';
include TEMPLATE_PATH . '/classes/messages.php';
include TEMPLATE_PATH . '/classes/user.php';

new Jobs();
new Skills();
new Messages();
new User();

add_action('after_setup_theme', 'pushwork_setup');

function wpdocs_set_html_mail_content_type() {
	return 'text/html';
}

add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );


function pushwork_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    $menus = array(
        'header-menu' => esc_html__('Header Menu', 'pushwork'),
        'footer-menu' => esc_html__('Footer Menu', 'pushwork'),
    );


    register_nav_menus($menus);
}

add_action('wp_enqueue_scripts', 'enqueue_scripts');

function enqueue_scripts()
{
    wp_enqueue_style('theme-style', get_stylesheet_uri(), [], time());

    wp_enqueue_style('google-font-asap', 'https://fonts.googleapis.com/css2?family=Asap:wght@200;300;400;500;600;700;800&display=swap', [], '2.2');
    wp_enqueue_style('google-font-marcellus', 'https://fonts.googleapis.com/css2?family=Marcellus&display=swap', [], '2.2');
    
    
    wp_enqueue_style('main-style', TEMPLATE_URI . '/scss/index.css', [], time());

    wp_enqueue_style('slick-style', TEMPLATE_URI . '/scss/slick.css', [], time());
    wp_enqueue_style('slick-theme-style', TEMPLATE_URI . '/scss/slick-theme.css', [], time());


    wp_enqueue_script('jquery');

    wp_enqueue_script('slick', TEMPLATE_URI . '/js/slick.js', ['jquery'], time(), true);

    wp_enqueue_script('post-job', TEMPLATE_URI . '/js/post-job.js', ['jquery'], time(), true);
 
    wp_enqueue_script('messages', TEMPLATE_URI . '/js/messages.js', ['jquery'], time(), true);
   
    wp_enqueue_script('register', TEMPLATE_URI . '/js/register.js', ['jquery'], time(), true);
   
    wp_enqueue_script('theme-script', TEMPLATE_URI . '/js/script.js', ['jquery'], time(), true);
}

add_action('admin_enqueue_scripts', 'enqueue_admin_script');

add_filter('woocommerce_get_checkout_order_received_url','my_order_received_url',0,2);
function my_order_received_url($return_url, $order){
   
    return '/messages/';
}
function enqueue_admin_script()
{
    wp_enqueue_script('admin-script', TEMPLATE_URI . '/js/admin.js', ['jquery'], time(), true);
}


function time_since($since) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'hour'),
        array(60 , 'minute'),
        array(1 , 'second')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    return $print;
}

function timeAgo($timestamp){
    $datetime1=new DateTime("now");
    $datetime2 = new DateTime();
     $datetime2->setTimestamp($timestamp);
    $diff=date_diff($datetime1, $datetime2);
    $timemsg='';
    if($diff->y > 0){
        $timemsg = $diff->y .' year'. ($diff->y > 1?"'s":'');

    }
    else if($diff->m > 0){
     $timemsg = $diff->m . ' month'. ($diff->m > 1?"'s":'');
    }
    else if($diff->d > 0){
     $timemsg = $diff->d .' day'. ($diff->d > 1?"'s":'');
    }
    else if($diff->h > 0){
     $timemsg = $diff->h .' hour'.($diff->h > 1 ? "'s":'');
    }
    else if($diff->i > 0){
     $timemsg = $diff->i .' minute'. ($diff->i > 1?"'s":'');
    }
    else if($diff->s > 0){
     $timemsg = $diff->s .' second'. ($diff->s > 1?"'s":'');
    }

$timemsg = $timemsg.' ago';
return $timemsg;
}
