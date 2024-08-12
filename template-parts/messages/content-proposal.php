<?php
global $message;

$user = wp_get_current_user();


$role = $user->roles[0];


$status = !empty(get_post_meta($message->ID, 'status', true)) ? get_post_meta($message->ID, 'status', true) : false;
var_dump($status);

?>

<div class="proposal message col-10">
    <div class="message-content">
        <h3><?= get_the_date('', $message->ID); ?>
            <h1>Proposal</h1>

            <?= wpautop($message->post_content); ?>
    </div>

    <div class="proposal-info">


        <div class="row">
            <div class="col-9">
                <div class="deposit row space-between">
                    <p>Deposit requested:</p>
                    <p class="flex-end">
                        <b>£<?= get_post_meta($message->ID, 'deposit_amount', true); ?></b>
                    </p>
                </div>
                <div class="row proposal-id space-between">
                    <p>Propsal ID:</p>
                    <p class="flex-end proposal-id">
                        <b><?= $message->ID; ?></b>
                    </p>
                </div>
            </div>
            <div class="col-3">
                <p class="total-cost">Total cost:</p>
                <h2 class="flex-end">
                    £ <?= get_post_meta($message->ID, 'propsal_amount', true); ?>
                    </p>
            </div>
        </div>

        <?php 
          if($role == 'buyer' && !$status) {
        ?>
        <div class="accept">
             <button id="accept-proposal">ACCEPT</button>
             <button class="dropdown">
                
                <ul>
                    <li class="accept-peopsal">ACCEPT</li>
                    <li class="decline-peopsal">DECLINE</li>
                </ul>
             </button>
        </div>
        <?php
          }
        ?>
         <?php 
          if($role == 'freelancer' && !$status) {
        ?>
        <div class="accept">
             <button class="cancel-proposal">CANCEL</button>
        </div>
        <?php
          }
        ?>
         <?php 
          if($status == 'cancelled') {
        ?>
        <div class="cancelled">
             <h2>CANCELLED</h2>
        </div>
        <?php
          }
        ?>
         <?php 
          if($status == 'accepted') {
        ?>
        <div class="accepted">
             <h2>accepted</h2>
        </div>
        <?php
          }
        ?>
    </div>
</div>