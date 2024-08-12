<?php
get_header();
?>

<div class="container worksteam-container row">
    <div class="col-9">

        <?php

        global $post;

        $user = wp_get_current_user();

        $freelancer = get_post_meta($post->ID, 'freelancer_id', true);
        $client = get_post_meta($post->ID, 'client_id', true);

        $from_user_id = $freelancer == $user->ID ? $client : $freelancer;

        $from_account_type = $freelancer == $user->ID ?  'freelancer' : 'buyer';

        $from_user = get_user_by('id', $from_user_id);

        $job = get_post($post->post_author);

        ?>
        <script>
            const from_user_id = <?= $from_user_id;?>;
            const job_id = <?= $post->post_author;?>;
       </script>
        <div class="workstream-top">
            <h1>Workstream with <a href="/<?= $from_account_type; ?>/?user_id=<?= $from_user_id; ?>"><?= $from_user->display_name; ?></a></h1>
            <h2><a href="<?= get_the_permalink($job->ID); ?>">#<?= $job->ID; ?> <?= $job->post_title; ?></a></h2>
        </div>
        <div class="workstream-messages">
            <?php

            $messages = new WP_Query(['post_type' => 'messages', 'meta_key' => 'thread_id', 'meta_value' =>  $post->ID, 'order' => 'ASC', 'posts_per_page' => -1]);

            global $message, $last_user_id;

            $last_user_id = null;
            $has_active_proposal = false;

            $has_accepted_proposal = false;

            foreach ($messages->posts as $message1) {
                $message = $message1;
            ?>
                <div class="row">
                    <div class="col-2">

                        <?= get_template_part('template-parts/messages/content', 'author'); ?>

                    </div>

                    <?php
                    if (get_post_meta($message->ID, 'type', true) == 'propsal') {
                       if( get_post_meta($message->ID,'status',true) == '' || get_post_meta($message->ID,'status',true) == 'accepted' ) {
                        $has_active_proposal = true;
                       }
                        get_template_part('template-parts/messages/content', 'proposal');
                    } else {

                        $user = get_user_by('id', $message->post_author);
    
                    ?>
                        <div class="small-message col-10">
                            <div class="message-content <?=  $user->ID == $from_user_id ? 'from' : '';?>">



                                <?= wpautop($message->post_content); ?>
                            </div>
                        </div>

                    <?php
                    }
                    ?>


                </div>
            <?php
            }
            ?>
        </div>
        <div class="response">
            <div class="response_type row space-between">
 
                <button data-target="new_message" type="button" data-target="add_message" class="active">Send message</button>
                <button id="select_proposal" data-target="new_proposal"  <?= $has_active_proposal ? 'disabled' : '';?> type="button">New Proposal</button>
                <button  <?= !$has_accepted_proposal ? 'disabled' : '';?> type="button" data-target="raise_invoice" class="">Raise Invoice</button>

                <button type="button">Raise Issue</button>

            </div>

          

            <div id="new_message" class="add_message">

                <div class="field">

                    <textarea id="message_text" placeholder="Enter your message" name="message"></textarea>
                    <p class="error-text">Message must be more than 5 characters</p>
                </div>

                <div class="row flex-end">

                    <button id="post_message" type="button" data-thread-id="<?= $post->ID; ?>" type="submit">SEND</button>
                </div>
            </div>
            <div id="new_proposal" class=" add_message">

                <div class="field">

                    <textarea id="propsoal_text" placeholder="Enter your proposal" name="proposal"></textarea>
                    <div class="row">
                        <div class="col-6">
                            <h3>Total Amount £</h3>
                            <input type="number" id="proposal_amount"/>
                        </div>
                        <div class="col-6">
                            <h3>Deposit £</h3>
                            <input type="number" id="deposit"/>
                        </div>
                    </div>
                    <p class="error-text">Message must be more than 5 characters</p>
                </div>

                <div class="row flex-end">

                    <button id="post_proposal" type="button" data-thread-id="<?= $post->ID; ?>" type="submit">SUBMIT PROPSAL</button>
                </div>
            </div>

        </div>
        
    </div>
    <div class="col-3">
            <div class="user-info">

                <?php

                $avatar = !empty(get_user_meta($from_user_id, 'avatar', true)) ? get_user_meta($from_user_id, 'avatar', true) : IMG_URL . '/default-avatar.jpg';
                
                ?>
                <div class="row">
                    <div style="background-image:url(<?= $avatar; ?>)" class="avatar"></div>

                    <div>
                        <h3><?= $from_user->display_name; ?></h3>
                        <p><?= get_user_meta($from_user_id, 'title', true) ?></p>
                    </div>
                </div>
                <div class="row space-between more-user-info">
                    <h4><?= get_user_meta($from_user_id, 'location', true) ?></h4>
                    <?php 
                    if($from_user->roles[0] == 'freelancer') {
                        ?>
                    <a>PORTFOLIO (4)</a>
                    <?php
                    }
                    ?>
                </div>
                <a href="/report/?user_id=<?= $from_user_id;?>">Report <?= $from_user->display_name;?></a>
            </div>
        </div>
</div>
<?php
get_footer();
?>