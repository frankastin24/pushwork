

<?php 

add_shortcode('fa-filters', function() {
	
	ob_start();
	  $categories = get_categories();

        foreach ($categories as $category) {

        ?>

            <a class="cat" style="display: inline-block;
    padding: 20px;
    border-radius: 10px;
    background: red;
    color: #FFF;
    margin-right: 20px;
    height: 60px;" data-slug="<?= $category->slug;?>"><?= $category->name; ?></a>
			
			<script>
			
			$('.cat').on('click', () => {
				
			})
			</script>

        <?php
        }
	$content = ob_get_contents();
	ob_clean();
	
	return $content;
	
	
});

function get_html(posts) {
	$html = '';

/* 	foreach($posts as $post) {
		$html.= 
	} */
	
	
}
 

function get_posts() {
	

    $query = new WP_Query(['post_type' => 'post', 'posts_per_page' => -1  ]);
	
	return $query->posts;
	

}

