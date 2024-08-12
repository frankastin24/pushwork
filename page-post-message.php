<?php
if(!isset($_POST['thread_id'])) {
    return;
}
$user = wp_get_current_user(  );

$message = array(
    'post_type' => 'messages',
    'post_title' => '',
    'post_author' => $user->ID,
    'post_status' => 'publish',
    'post_content' => sanitize_text_field( $_POST['message'] ),
    'meta_input' => array(
        'thread_id' =>$_POST['thread_id'],
    )
    );

    wp_insert_post( $message);

    wp_redirect(  get_the_permalink($_POST['thread_id'])); 
