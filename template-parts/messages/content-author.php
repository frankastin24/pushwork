<?php

global $message, $last_user_id;

?>
<div class="author">

    <?php

    $user = get_user_by('id', $message->post_author);
    $avatar = get_user_meta($user->ID, 'avatar', true) ? get_user_meta($user->ID, 'avatar', true) : IMG_URL . '/default-avatar.jpg';
     if ($last_user_id !== $user->ID) {

        $last_user_id = $user->ID;
    ?>
        <div style="background-image:url(<?= $avatar; ?>);" class="avatar"></div>
        <h4><?= $user->display_name; ?></h4>
    <?php
    }
    ?>

</div>