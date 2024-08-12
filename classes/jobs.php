<?php

class Jobs {
    function __construct() {
        add_action('init', [$this,'register_post_type']);
        add_action("wp_ajax_save_job", array($this, "save_job"));
        add_action("wp_ajax_nopriv_save_job", array($this, "save_job"));
    }
    public function save_job() {
        $valid = true;
        if($_POST['publish'] == 'true') {
            if( strlen($_POST['title']) < 5 ) {
                $valid = false;
             }
             if( strlen($_POST['description']) < 20 ) {
                $valid = false;
             }
             if( strlen($_POST['skills']) < 2 ) {
                $valid = false;
             }      
             if( strlen($_POST['budget']) < 1 ) {
                $valid = false;
             }
    
             if(!$valid) {
                echo  'error';
                return;
             }
        }

    
         $user = wp_get_current_user();

         $status = $_POST['publish'] ? 'publish' : 'draft';
         
         $job = array(
            'post_type' => 'jobs',
            'post_title' => sanitize_text_field( $_POST['title']),
            'post_author' => $user->ID,
            'post_status' => $status,
            'post_content' =>sanitize_textarea_field( $_POST['description']),
            'post_name' => sanitize_text_field( $_POST['title']),
            'meta_input' => array(
                'type' => sanitize_text_field( $_POST['type']),
                'skills' =>sanitize_text_field( $_POST['skills']),
                'duration' => sanitize_text_field($_POST['duration']),
                'budget' => sanitize_text_field($_POST['budget']),
                'questions' => sanitize_text_field($_POST['questions']),
                'approved' => 'false',
            )
            );
            if($_POST['id']) {
                $job['ID'] = $_POST['id'];
            }

        $post_id = wp_insert_post(  $job);
        echo $post_id;
        die();

    }
    public function register_post_type()  {

            register_post_type(
                'jobs',
                array(
                    'labels' => array(
                        'name' => __('Jobs', 'textdomain'),
                        'singular_name' => __('Job', 'textdomain'),
                        'add_new' => __('Add Job'),
                        'add_new_item' => __('Add Job'),
                        'view_item' => __('View All Jobs'),
                        'edit_item' => __('Edit Job'),
                        'search_items' => __('Search Jobs'),
                        'not_found' => __('Job not found'),
                        'not_found_in_trash' => __('Job not found in trash')

                    ),
                    'public' => true,
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => 21,
                    'rewrite' => array('slug' => 'jobs', 'with_front' => true),
                    'show_ui' => true,
                    'show_in_rest' => true,
                    'supports' => array(
                        'title',
                        'editor',
                        'custom-fields'
                    )
                )
            );
            
            
        }

}