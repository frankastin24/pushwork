<?php
get_header();

$user = wp_get_current_user();

$policeman = '2257 4';

global $post;

if($post->post_author == $user->ID) {
    $status = get_post_meta($post->ID, 'status', true) == 'open' ? 'Open for propsals' : 'Under review';
    ?>

    <div class="top-bar">
        <div class="container">
        <h1><?= $post->post_title;?></h1>

        <div class="row flex-end">
            <div class="right">
                <h4 class=""><?= $status;?></h4>
                <p class="">Project ID: <?= $post->ID;?></p>
            </div>
        </div>
        </div>
    </div>

    <?php

} else {
    ?>

    <div class="row">
        <div class="col-10">
            <h1><?= the_title(); ?><h1>
    
                  <?=    wpautop(  the_content()); ?>
    
                    <div class="propsal">
                        <h2>New Proposal</h2>
                        <form method="POST" action="/submit-proposal">
                        <h3>Enter your propsal details</h3>    
                        
                        <textarea name="proposal" placeholder="Enter your propasal"></textarea>
                        
                        <button type="button" id="attach_file">Attach files</button>
                        
                        <h2>Propsal Breakdown</h2>
                        
                        <?php 
    
                        global $post;
                        ?>
    
                        <input name="job_id" type="hidden" value="<?= $post->ID;?>"/>
                        <div class="propsal-amounts row">
                         
                                <p>Propsal amount:</p><input type="number" name="proposal_amount" />
                                <p>Deposit amount:</p><input type="number" name="deposit_amount" />
                                <button type="submit">Submit propsal</button>
                        </form>
                    </div>
        </div>
    </div>
    <?php

}
?>
</div>