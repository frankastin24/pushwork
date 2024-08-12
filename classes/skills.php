<?php

class Skills {
    function __construct() {
        add_action('init', [$this,'register_post_type']);
    }
    public function register_post_type()  {

            register_post_type(
                'skills',
                array(
                    'labels' => array(
                        'name' => __('Skills', 'textdomain'),
                        'singular_name' => __('Skill', 'textdomain'),
                        'add_new' => __('Add Skill'),
                        'add_new_item' => __('Add Skill'),
                        'view_item' => __('View All Skills'),
                        'edit_item' => __('Edit Skill'),
                        'search_items' => __('Search Skills'),
                        'not_found' => __('Skill not found'),
                        'not_found_in_trash' => __('Skill not found in trash')

                    ),
                    'public' => true,
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => 21,
                    'rewrite' => array('slug' => 'skills'),
                    'show_ui' => true,
                    'show_in_rest' => true,
                    'supports' => array(
                        'title',
                    )
                )
            );
            
            
        }

}