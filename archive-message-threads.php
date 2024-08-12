<?php
get_header();

$user = wp_get_current_user();

$meta_query = array(
    'relation' => 'OR',
    array(
        'key'     => 'client_id',
        'value'   => $user->ID,
        'compare' => '='
    ),
    array(
        'key'     => 'freelancer_id',
        'value'   => $user->ID,
        'compare' => '='
    ),

);

$type = isset($_GET['type']) ? $_GET['type'] : 'all';

$all_threads_args = ['post_type' => 'message-threads', 'meta_query' => $meta_query];

$all_threads = new WP_Query($all_threads_args);


$found_threads_args = ['post_type' => 'message-threads', 'meta_query' => $meta_query];

if(isset($_GET['s'])) {
    $found_threads_args['s'] = $_GET['s'];
}

$found_threads = new WP_Query($found_threads_args);

$starred_threads = array();
$starred_thread_ids = array();

foreach($all_threads->posts as $thread) {

    $is_stared = new WP_Query(['post_type' => 'starred-threads' , 'post_author' => $user->ID, 'meta_key' => 'thread_id' ,'meta_value' =>  $thread->ID]);
    
    if(count($is_stared->posts) > 0) { 
        array_push($starred_threads,$thread);
        array_push($starred_thread_ids, $thread->ID);
    }
}


$archived_threads = new WP_Query(['post_status' => 'draft', 'post_type' => 'message-threads', 'meta_query' => $meta_query]);

if($type == 'archived') {
    $threads = $archived_threads->posts;
} else if ($type == 'starred') {
   $threads =  $starred_threads;
}else {
    $threads = $found_threads->posts;
}

?>
<div class="container threads row">
    <div class="col-3">

        <h3>Workstream filters</h3>
        <a href="/messages/?type=starred">Starred (<?= count($starred_threads);?>)</a>
        <a class="<?= $type == 'all' ? 'selected' : '';?>" href="/messages/">All Workstreams (<?= count($all_threads->posts); ?>) </a>
        <a class="<?= $type == 'archived' ? 'selected' : '';?>" href="/messages/?type=archived">Archived (<?= count($archived_threads->posts); ?>)</a>
        <a href="/messages/?type=with-escrow">With Escrow</a>
    </div>
    <div class="col-9">
        <h1>My Workstreams</h1>

        <form action="/messages/" method="get" class="search">
            <h6>SEARCH JOB TITLE</h6>
            <div class="row">
                <input name="s" placeholder="Type and hit enter" />
                <button type="submit" id="submit-search"><img src="<?= IMG_URL; ?>/search.svg" /> </button>
            </div>
        </form>
        
        <div class="row archive">
            <div class="select-all">
                <input type="checkbox" />
            </div>
            <?php
            if($type == 'archived') {
                ?>
                <button id="un-archive">UNARCHIVE</button>
                <?php
            } else {
              ?>
              <button id="archive">ARCHIVE</button>
              <?php
            }
            ?>
        </div>

        <?php

        if(count($threads) == 0) {
            ?>
             <div class="row thread">
               <p>Sorry no messages found</p>
            </div>
            <?php
        }

        foreach ($threads as $thread) {

            $freelancer = get_post_meta($thread->ID, 'freelancer_id', true);
            $client = get_post_meta($thread->ID, 'client_id', true);

            $from_user_id = $freelancer == $user->ID ? $client : $freelancer;

            $from_account_type = $freelancer == $user->ID ?  'freelancer' : 'buyer';

            $from_user = get_user_by('id', $from_user_id);

            $avatar = get_user_meta($from_user->ID, 'avatar', true) ? get_user_meta($from_user->ID, 'avatar', true) : IMG_URL . '/default-avatar.jpg';

            $last_message = new WP_Query(['post_type' => 'messages', 'meta_key' => 'thread_id', 'meta_value' =>  $thread->ID, 'posts_per_page' => 1]);
           
            $last_message = $last_message->posts[0];

        ?>

            <div class="row thread">
                <input type="checkbox" name="thread" value="<?= $thread->ID; ?>" />

                <div data-id="<?= $thread->ID; ?>" class="<?= in_array($thread->ID,$starred_thread_ids) ? 'is-starred' : '';?>  starred"></div>

                <div style="background-image:url(<?= $avatar; ?>)" class="avatar"></div>

                <a href="/<?= $from_account_type; ?>" class="display_name"> <?= $from_user->display_name; ?></a>

                <a href="<?= get_the_permalink($thread->ID); ?>">
                    <p class="title"><?= $thread->post_title; ?></p>
                    <p><?= substr($last_message->post_content, 0, 15); ?></p>
                </a>
                <p class="date"><?= get_the_date('F j g:i a',$last_message->ID);?><p>
                <h5></h5>
            </div>
        <?php

        }

        ?>
    </div>
</div>

<?php 

get_footer();
?>