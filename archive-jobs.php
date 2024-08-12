<?php
get_header();
?>

<div class="blue-bar">
        <form action="/jobs" method="get">
            <input placeholder="Search jobs..." name="s" type="text"/>
            <button type="submit">Search</button>
        </form>
    </div>

<div class="container main ">

    
    <div class="row">
        <div class="col-3">
            <div class="categories">
            <h3>Categories</h3>

            <a href="/jobs/?s=wordpress">WordPress</a>
            <a href="/jobs/?s=html">HTML</a>
            <a href="/jobs/?s=php">PHP</a>
            <a href="/jobs/?s=css">CSS</a>
            <a href="/jobs/?s=laravel">Laravel</a>
            </div>
        </div>
        <div class="col-9">
            <h3>Latest Jobs</h3>
            <?php
            
            $args = ['post_type' => 'jobs'];

            if(isset($_GET['s'])) {
                $args['s'] = $_GET['s'];
            }

            $query = new WP_Query($args);

            foreach($query->posts as $job) {

            
            $avatar = !empty(get_user_meta($job->post_author, 'avatar', true)) ? get_user_meta($job->post_author, 'avatar', true) : IMG_URL . '/default-avatar.jpg';
             $user = get_user_by('id',$job->post_author) ;  
            ?>
                    <a href="<?= get_the_permalink($job->ID); ?>">
                        <div class="top">
                            <div class="left row">
                                <div class="avatar" style="background-image:url(<?= $avatar;?>);"></div>
                                <p>by <?= $user->display_name;?></p>
                            </div>
                        </div>

                        <div class="middle">
                        <h2><?= get_the_title($job->ID); ?></h2>
                        <p><?= apply_filters('the_content', get_post_field('post_content', $job->ID)); ?></p>
                        </div>

                        <div class="bottom row">
                            <?php

                              $datetime = strtotime($job->post_date);

                            $since = timeAgo( $datetime);

                            $args = ['post_type' => 'message-threads','author' => $job->ID];
                
                            $query = new WP_Query($args);

                            $num_propsals = 0;
                
                            foreach($query->posts as $message_thread) {

                                
                                $messages = new WP_Query(['post_type' => 'messages', 'meta_key' => 'thread_id', 'meta_value' =>   $message_thread->ID, 'order' => 'ASC', 'posts_per_page' => -1]);
                                foreach($messages->posts as $message) {

                                    if(get_post_meta($message->ID,'type',true) == 'propsal' && get_post_meta($message->ID,'status',true) !== 'cancelled') {
                                        $num_propsals ++;
                                    }
                                }
                                 
                            }



                            ?>
                            <p><?=  $since;?></p>
                            <p><?= $num_propsals;?> proposal<?= $num_propsals > 1 ? 's' : '' ;?></p>
                        </div>
                    </a>
            <?php
                 }
            ?>
        </div>
    </div>
</div>