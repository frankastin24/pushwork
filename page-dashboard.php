<?php 
get_header();

$current_user = wp_get_current_user();

$first_name = explode(' ',$current_user->display_name)[0];

?>

<script>
    const User = {
        name : "<?= $current_user->display_name;?>",
        id : "<?= $current_user->ID;?>",
        sessionId : "<?= $session_id;?>",
        accountType : "<?= $current_user->roles[0]; ?>"
    }

</script>

<div id="pushwork-dash"></div>

<script src="<?= get_template_directory_uri(  );?>/dist/pushwork-dashboard.js"></script>


