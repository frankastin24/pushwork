<?php get_header();
?>
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<div class="small-container default-page">
    <div class="text-center">
        <h1 class="page-title"><?= the_title(); ?></h1>
    </div>


    <div class="content">
        <?php the_content(); ?>
    </div>
    <div class="fb-plug">
        <div class="fb-share-button" data-href="<?= home_url(add_query_arg(array(), $wp->request)); ?>" data-layout="button_count"></div>
    </div>
</div>

<div id="image-popup">
    <button id="nav-left">
    </button>
    <div id="image-popup-center">
        <button id="image-popup-close">×</button>

        <img src="" />
    </div>

    <button id="nav-right">
    </button>
</div>
<?php get_footer(); ?>