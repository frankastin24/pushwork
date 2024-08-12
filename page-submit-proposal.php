<?php
 $valid = true;

 if( strlen($_POST['proposal']) < 1 ) {
    $valid = false;
 }

 if( strlen($_POST['job_id']) < 1 ) {
    $valid = false;
 }

 if( strlen($_POST['proposal_amount']) < 1 ) {
    $valid = false;
 }
 if( strlen($_POST['deposit_amount']) < 1 ) {
    $valid = false;
 }

 if(!$valid) {
   wp_redirect( get_the_permalink( $_POST['job_id'] ) );
   die();
 }

 $freelancer = wp_get_current_user(  );
 $job = get_post($_POST['job_id']);

 $thread = array(
    'post_type' => 'message-threads',
    'post_title' => get_the_title($_POST['job_id']),
    'post_author' => $_POST['job_id'],
    'post_status' => 'publish',
    'post_content' =>'',
    'meta_input' => array(
        'client_id' => $job->post_author,
        'freelancer_id' => $freelancer->ID,
    )
    );

$thread_id = wp_insert_post(  $thread);


$propsal = array(
    'post_type' => 'messages',
    'post_title' => get_the_title($_POST['job_id']),
    'post_author' => $freelancer->ID,
    'post_status' => 'publish',
    'post_content' => sanitize_textarea_field( $_POST['proposal'] ),
    'meta_input' => array(
        'thread_id' =>$thread_id,
        'type' => 'propsal',
        'propsal_amount' => sanitize_text_field( $_POST['proposal_amount'] ),
        'deposit_amount' => sanitize_text_field( $_POST['deposit_amount'] ),

    )
    );

wp_insert_post( $propsal);

wp_redirect(  get_the_permalink($thread_id)); 

die();
