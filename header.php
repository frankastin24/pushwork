<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
</head>
<?php
$post_name =  $post ? $post->post_name : '';
?>

<body <?php body_class($post_name); ?>>

    <?php wp_body_open(); ?>

    <header id="main-header" role="banner">

        <div class="container row flex-space-between">

            <a class="logo" href="<?= home_url(); ?>">
                <img src="<?= IMG_URL; ?>/logo.png" />
            </a>

            <div id="header-navigation" class="flex-end row">
            <a class="btn" href="/post-job/">Post Project</a>
                <?php

                if (is_user_logged_in()) {
                ?>
                   
                   
                    <div class="notifications">
                        <span class="bell"></span>

                        <ul class="list">
                            
                        </ul>
                        
                    </div>
                    <a class="" href="/messages">
                        <span class="message"></span>
                    </a>
                    <div class="account">
                        <span class="user"></span>
                        <div class="dropdown">
                        <a class="btn-blk" href="/dashboard">Dashboard</a>
                        <a class="btn-blk" href="/?logout=true">Logout</a>
                        </div>
                    </div>
                    

                <?php
                } else {
                ?>
                    <a class="btn-blk" href="/login/">Login</a>
                    <a class="btn-blk" href="/register-freelancer">Register as a freelancer</a>
                <?php
                }

                $user = wp_get_current_user();


                ?>
                
                <?php


                if ($user->ID !== 0 && $user->roles[0] == 'freelancer') {
                ?>
                    <a class="btn-blk" href="/jobs/">View jobs</a>
                <?php
                }
                ?>




            </div>
        </div>
    </header>