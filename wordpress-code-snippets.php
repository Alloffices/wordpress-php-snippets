1. Increase Memory Limit
define('WP_MEMORY_LIMIT', '96M');

2. Empty Trash Automatically
define('EMPTY_TRASH_DAYS', 5 );

3. Filter the Loop
<?php
	query_posts('
		showposts=5&amp;
		category_name=featured'
	);

	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p><?php the_content(); ?></p>
	<?php
	endwhile; else:
	endif;
	wp_reset_query();
?>

4. Loop within a loop

<?php
	if (have_posts()) :

	while (have_posts()) : the_post(); // the post loop
	$temp_query = $wp_query; // store it
	$args = array(
	'paged' => $paged, // paginates
	'post_type'=>'post',
	'posts_per_page' => 3,
	'order' => 'DESC'
	);
	$wp_query = new WP_Query($args);

	while ($wp_query->have_posts()) : $wp_query->the_post();
	// -- your new loop -- //
	>endwhile;

	if (isset($wp_query)) {$wp_query = $temp_query;} // restore loop
	>endwhile;

	endif;
?>

5. Detect Browser

<?php 
	add_filter('body_class','browser_body_class');
	function browser_body_class($classes) {

		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		if($is_lynx) $classes[] = 'lynx';

		elseif($is_gecko) $classes[] = 'gecko';

		elseif($is_opera) $classes[] = 'opera';

		elseif($is_NS4) $classes[] = 'ns4';

		elseif($is_safari) $classes[] = 'safari';

		elseif($is_chrome) $classes[] = 'chrome';

		elseif($is_IE) $classes[] = 'ie';

		else $classes[] = 'unknown';

		if($is_iphone) $classes[] = 'iphone';

		return $classes;
	}
?>

6. Detect Mobile Users

<?php 
include('mobile_device_detect.php');
$mobile = mobile_device_detect();

if ($mobile==true) {
	header( 'Location: http://your-website.com/?theme=Your_Mobile_Theme' ) ;
}
?>

7. Leverage Browser Caching using .htaccess

<?php 
## EXPIRES CACHING ##
ExpiresActive On
ExpiresByType image/jpg "access 1 year"
ExpiresByType image/jpeg "access 1 year"
ExpiresByType image/gif "access 1 year"
ExpiresByType image/png "access 1 year"
ExpiresByType text/css "access 1 month"
ExpiresByType application/pdf "access 1 month"
ExpiresByType text/x-javascript "access 1 month"
ExpiresByType application/x-shockwave-flash "access 1 month"
ExpiresByType image/x-icon "access 1 year"
ExpiresDefault "access 2 days"
## EXPIRES CACHING ##
?>

8. Include jQuery the right way

<?php wp_enqueue_script("jquery"); ?>

10. Simpler Login Address

<?php 
RewriteRule ^login$ http://yoursite.com/wp-login.php [NC,L]
?>

11. Limit Post Revisions

<?php
	# Maximum 5 revisions #
	define('WP_POST_REVISIONS', 5);
	# Disable revisions #
	define('WP_POST_REVISIONS', false);
?>

12. Set Autosave time

<?php
	# Autosave interval set to 5 Minutes #
	define('AUTOSAVE_INTERVAL', 300);
?>

13. Branding
<?php
	function my_custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image:url('.get_bloginfo('template_directory').'/images/custom-login-logo.gif) !important; }
	</style>';
	}
	add_action('login_head', 'my_custom_login_logo');
?>


14. Change Admin Logo

<?php
	function custom_admin_logo() {
	echo '<style type="text/css">
	#header-logo { background-image: url('.get_bloginfo('template_directory').'/images/admin_logo.png) !important; }
	</style>';
	}
	add_action('admin_head', 'custom_admin_logo');
?>

15. Change Footer Text in WP Admin

<?php
	function remove_footer_admin () {
	echo 'Siobhan is Awesome. Thank you <a href="http://wordpress.org">WordPress</a> for giving me this filter.';
	}
	add_filter('admin_footer_text', 'remove_footer_admin');
?>

16. Dynamic Copyright Date in Footer

<?php
	function comicpress_copyright() {

	global $wpdb;
	$copyright_dates = $wpdb->get_results("
	SELECT
	YEAR(min(post_date_gmt)) AS firstdate,
	YEAR(max(post_date_gmt)) AS lastdate
	FROM
	$wpdb->posts
	WHERE
	post_status = 'publish'
	");
	$output = '';

	if($copyright_dates) {
	$copyright = "&copy; " . $copyright_dates[0]->firstdate;

	if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
	$copyright .= '-' . $copyright_dates[0]->lastdate;
	}
	$output = $copyright;
	}

	return $output;
	}
?>

<!-- Then insert this into your footer: -->

<?php echo comicpress_copyright(); ?>

17.Add Favicon

<span style="font-weight: normal;"> </span>
<!-- // add a favicon to your -->
<?php
	function blog_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('wpurl').'/favicon.ico" />';
	}
	add_action('wp_head', 'blog_favicon');
?>

18. Remove Menus in WordPress Dashboard

<?php
	function remove_menus () {

	global $menu;
	$restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
	end ($menu);

	while (prev($menu)){
	$value = explode(' ',$menu[key($menu)][0]);

	if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
	}
	add_action('admin_menu', 'remove_menus');
?>

19. Hide update message

<?php
	add_action('admin_menu','wphidenag');
	function wphidenag() {
	remove_action( 'admin_notices', 'update_nag', 3 );
	}
?>

20. WordPress Relative Date

<!-- # For posts &amp; pages # -->
<?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
# For comments #
<?php echo human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' ago'; ?>

<!-- *------------------ -->
Navigation
<!-- *------------------ -->
21. Automatically Add a Search Box to Your Nav Menu
<?php 
	add_filter('wp_nav_menu_items','add_search_box', 10, 2);
	function add_search_box($items, $args) {
	ob_start();
	get_search_form();
	$searchform = ob_get_contents();
	ob_end_clean();
	$items .= '<li>' . $searchform . '</li>';

	return $items;
	}
?>

22. Breadcrumbs without a plugin

<!-- function.php -->
<?php 
	function the_breadcrumb() {
	echo '<ul id="crumbs">';

	if (!is_home()) {
	echo '<li><a href="';
	echo get_option('home');
	echo '">';
	echo 'Home';
	echo "</a></li>";

	if (is_category() || is_single()) {
	echo '<li>';
	the_category(' </li><li> ');

	if (is_single()) {
	echo "</li><li>";
	the_title();
	echo '</li>';
	}
	} elseif (is_page()) {
	echo '<li>';
	echo the_title();
	echo '</li>';
	}
	}

	elseif (is_tag()) {single_tag_title();}

	elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}

	elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}

	elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}

	elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}

	elseif (isset($_GET['paged']) &amp;&amp; !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}

	elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
	echo '</ul>';
	}
?>

<!-- Insert into header.php -->
<?php the_breadcrumb(); ?>

23. Pagination
<!-- Want pagination at the bottom of your blog? Insert this into your functions.php -->

<?php
	function my_paginate_links() {

	global $wp_rewrite, $wp_query;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	$pagination = array(
	'base' => @add_query_arg('paged','%#%'),
	'format' => '',
	'total' => $wp_query->max_num_pages,
	'current' => $current,
	'prev_text' => __('« Previous'),
	'next_text' => __('Next »'),
	'end_size' => 1,
	'mid_size' => 2,
	'show_all' => true,
	'type' => 'list'
	);

	if ( $wp_rewrite->using_permalinks() )
	$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

	if ( !empty( $wp_query->query_vars['s'] ) )
	$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	echo paginate_links( $pagination );
	}
?>

<!-- #----------------- -->
Analytics
<!-- #----------------- -->

24. Google Analytics Without Editing Theme

<?php
	add_action('wp_footer', 'ga');
	function ga() { ?>
	<!-- // Paste your Google Analytics code here -->
<?php } ?>

<!-- #__________________ -->
Search
<!-- #__________________ -->

25. Highlight search terms

<!-- This is a nice one. Power up your search functionality by highlighting the search term in the results.
Open search.php and find the the_title() function
Replace with: -->

<?php 
echo $title;
?>

<!-- Above the modified line add: -->
<?php
	<span style="white-space: pre;"> </span>$title <span style="white-space: pre;"> </span>= get_the_title();
	<span style="white-space: pre;"> </span>$keys= explode(" ",$s);
	<span style="white-space: pre;"> </span>$title <span style="white-space: pre;"> </span>= preg_replace('/('.implode('|', $keys) .')/iu',
	<span style="white-space: pre;"> </span>'<strong class="search-excerpt">\0</strong>',
	<span style="white-space: pre;"> </span>$title);
?>

<!-- Add the following to your style.css. Add: -->
<style>
	strong.search-excerpt { background: yellow; }
</style>

26. Exclude Posts and Pages from Search Results

<!-- Sometimes you don’t want all of your posts and pages appearing in your search results. Use this snippet to shun whichever ones you want. -->
<!-- // search filter -->
<?php
	function fb_search_filter($query) {

	if ( !$query->is_admin &amp;&amp; $query->is_search) {
	$query->set('post__not_in', array(40, 9) ); // id of page or post
	}

	return $query;
	}
	add_filter( 'pre_get_posts', 'fb_search_filter' );
?>
<!-- To exclude the subpage of a page you need to add it to the IS: -->
<!-- // search filter -->
<?php
	function fb_search_filter($query) {

	if ( !$query->is_admin &amp;&amp; $query->is_search) {
	$pages = array(2, 40, 9); // id of page or post
	// find children to id
	>foreach( $pages as $page ) {
	$childrens = get_pages( array('child_of' => $page, 'echo' => 0) );
	}
	// add id to array
	>for($i = 0; $i < sizeof($childrens); ++$i) { $pages[] = $childrens[$i]->ID;
	}
	$query->set('post__not_in', $pages );
	}

	return $query;
	}
	add_filter( 'pre_get_posts', 'fb_search_filter' );
?>

27. Disable WordPress Search

<?php
	function fb_filter_query( $query, $error = true ) {

	if ( is_search() ) {
	$query->is_search = false;
	$query->query_vars[s] = false;
	$query->query[s] = false;
	// to error
	>if ( $error == true )
	$query->is_404 = true;
	}
	}
	add_action( 'parse_query', 'fb_filter_query' );
	add_filter( 'get_search_form', create_function( '$a', "return null;" ) );
?>

<!-- #------------- -->
Posts
<!-- #------------- -->

28. Set a Maximum Word Count on Post Titles

<!-- Manage a blog with multiple users? Use this snippet to set a maximum word count on your titles. -->
<?php
	function maxWord($title){

	global $post;
	$title = $post->post_title;

	if (str_word_count($title) >= 10 ) //set this to the maximum number of words
	wp_die( __('Error: your post title is over the maximum word count.') );
	}
	add_action('publish_post', 'maxWord');
?>

29. Set Minimum Word Count on Posts

<?php
	function minWord($content){

	global $post;
	$num = 100; //set this to the minimum number of words
	$content = $post->post_content;

	if (str_word_count($content) < $num) wp_die( __('Error: your post is below the minimum word count.') ); } add_action('publish_post', 'minWord');
?>

30. Display Incremental Numbers Next to Each Published Post

<!-- This snippet lets you add numbers beside your posts. You could use Article 1, Article 2, Article 3; or Post 1, Post 2, Post 3; or whatever you want.

Add this to your functions: -->

<?php
	function updateNumbers() {

	global $wpdb;
	$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'post' ";
	$pageposts = $wpdb->get_results($querystr, OBJECT);
	$counts = 0 ;

	if ($pageposts):

	foreach ($pageposts as $post):
	setup_postdata($post);
	$counts++;
	add_post_meta($post->ID, 'incr_number', $counts, true);
	update_post_meta($post->ID, 'incr_number', $counts);

	endforeach;

	endif;
	}
	add_action ( 'publish_post', 'updateNumbers' );
	add_action ( 'deleted_post', 'updateNumbers' );
	add_action ( 'edit_post', 'updateNumbers' );
?>
<!-- Then add this within the loop: -->
<?php echo get_post_meta($post->ID,'incr_number',true); ?>

31. Shorten the excerpt

<!-- Think the excerpt is too long? Use this snippet to shorten it. This shortens it to 20 words. -->
<?php
	function new_excerpt_length($length) {

	return 20;
	}
	add_filter('excerpt_length', 'new_excerpt_length');
?>

<!-- #-------- -->
Lists of Posts
<!-- #-------- -->

32. Lists of Posts

<!-- Display Random Posts:
Shows a nice list of some random posts. Stop your long lost posts from being forgotten. Paste this wherever you want it. -->

<ul>
	<li>
		<h2>A random selection of my writing</h2>
		<ul>
			<?php
				$rand_posts = get_posts('numberposts=5&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;orderby=rand');
				foreach( $rand_posts as $post ) :
			?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php endforeach; ?>
		</ul>
	</li>
</ul>

33. List Upcoming Posts

<!-- Want to tantalize your readers with what you’ve got to come? What to display an event that’s happening in the future? This snippet will let you list which posts you have in draft. -->

<div id="zukunft">
	<div id="zukunft_header"><p>Future events</p></div>
	<?php query_posts('showposts=10&amp;post_status=future'); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div>
		<p class><b><?php the_title(); ?></b><?php edit_post_link('e',' (',')'); ?><br />
		<span><?php the_time('j. F Y'); ?></span></p>
	</div>
	<?php endwhile; else: ?><p>No future events scheduled.</p><?php endif; ?>
</div>

34. Show Related Posts

<?php
	$tags = wp_get_post_tags($post->ID);

	if ($tags) {
	echo 'Related Posts';
	$first_tag = $tags[0]->term_id;
	$args=array(
	'tag__in' => array($first_tag),
	'post__not_in' => array($post->ID),
	'showposts'=>1,
	'caller_get_posts'=>1
	);
	$my_query = new WP_Query($args);

	if( $my_query->have_posts() ) {

	while ($my_query->have_posts()) : $my_query->the_post(); ?>
	<p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
	<?php

	endwhile; wp_reset();
	}
	}
?>

35. Display Latest Posts

<?php query_posts('showposts=5'); ?>
<ul>
<?php while (have_posts()) : the_post(); ?>
<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
<?php endwhile;?>
</ul>

36. Custom Post Type

<!-- Using Custom Templates for CPT Archives and Single Entries
If you don’t like the appearance of the archive page for your custom post type, then you can use dedicated template for custom post type archive. To do that all you need to do is create a new file in your theme directory and name it archive-movies.php. Replace movies with the name of your custom post type.

For geting started, you can copy the contents of your theme’s archive.php file into archive-movies.php template and then start modifying it to meet your needs. Now whenever the archive page for your custom post type is accessed, this template will be used to display it.

Similarly, you can also create a custom template for your post type’s single entry display. To do that you need to create single-movies.php in your theme directory. Don’t forget to replace movies with the name of your custom post type.

You can get started by copying the contents of your theme’s single.php template into single-movies.php template and then start modifying it to meet your needs. -->

<!-- function.php -->
<?php
	/*
	* Creating a function to create our CPT
	*/
	 
	function custom_post_type() {
	 
	// Set UI labels for Custom Post Type
	    $labels = array(
	        'name'                => _x( 'Movies', 'Post Type General Name', 'twentythirteen' ),
	        'singular_name'       => _x( 'Movie', 'Post Type Singular Name', 'twentythirteen' ),
	        'menu_name'           => __( 'Movies', 'twentythirteen' ),
	        'parent_item_colon'   => __( 'Parent Movie', 'twentythirteen' ),
	        'all_items'           => __( 'All Movies', 'twentythirteen' ),
	        'view_item'           => __( 'View Movie', 'twentythirteen' ),
	        'add_new_item'        => __( 'Add New Movie', 'twentythirteen' ),
	        'add_new'             => __( 'Add New', 'twentythirteen' ),
	        'edit_item'           => __( 'Edit Movie', 'twentythirteen' ),
	        'update_item'         => __( 'Update Movie', 'twentythirteen' ),
	        'search_items'        => __( 'Search Movie', 'twentythirteen' ),
	        'not_found'           => __( 'Not Found', 'twentythirteen' ),
	        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
	    );
	     
	// Set other options for Custom Post Type
	     
	    $args = array(
	        'label'               => __( 'movies', 'twentythirteen' ),
	        'description'         => __( 'Movie news and reviews', 'twentythirteen' ),
	        'labels'              => $labels,
	        // Features this CPT supports in Post Editor
	        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
	        // You can associate this CPT with a taxonomy or custom taxonomy. 
	        'taxonomies'          => array( 'genres' ),
	        /* A hierarchical CPT is like Pages and can have
	        * Parent and child items. A non-hierarchical CPT
	        * is like Posts.
	        */ 
	        'hierarchical'        => false,
	        'public'              => true,
	        'show_ui'             => true,
	        'show_in_menu'        => true,
	        'show_in_nav_menus'   => true,
	        'show_in_admin_bar'   => true,
	        'menu_position'       => 5,
	        'can_export'          => true,
	        'has_archive'         => true,
	        'exclude_from_search' => false,
	        'publicly_queryable'  => true,
	        'capability_type'     => 'page',
	    );
	     
	    // Registering your Custom Post Type
	    register_post_type( 'movies', $args );
	 
	}
	 
	/* Hook into the 'init' action so that the function
	* Containing our post type registration is not 
	* unnecessarily executed. 
	*/
	 
	add_action( 'init', 'custom_post_type', 0 );
?>

<!-- Querying Custom Post Types -->

<?php 
	$args = array( 'post_type' => 'movies', 'posts_per_page' => 10 );
	$the_query = new WP_Query( $args ); 
	?>
	<?php if ( $the_query->have_posts() ) : ?>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	<h2><?php the_title(); ?></h2>
	<div class="entry-content">
	<?php the_content(); ?> 
	</div>
	<?php wp_reset_postdata(); ?>
	<?php else:  ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<!-- #---------- -->
Category
<!-- #---------- -->

36. Exclude Specific Category

<!-- It can sometimes come in handy to exclude specific categories from being displayed. -->

<?php query_posts('cat=-2'); ?>
<?php while (have_posts()) : the_post(); ?>
<!-- //the loop here -->
<?php endwhile;?>

<!-- #-------- -->
Security
<!-- #-------- -->

37. Force Users to Log in Before Reading a Post

<!-- If there are certain posts that you want to restrict, whether they for a few people only, or for paying subscribers, or whatever, you can use this snippet to force users to login to see them. Paste this into your functions file: -->

<?php 
	function my_force_login() {

	global $post;

	if (!is_single()) return;
	$ids = array(188, 185, 171); // array of post IDs that force login to read


	if (in_array((int)$post->ID, $ids) &amp;&amp; !is_user_logged_in()) {
	auth_redirect();
	}
	}
?>

<!-- And then put this at the top of your header: -->
<?php my_force_login(); ?>

38. Force SSL usage

<!-- If you’re concerned about your admin being accessed you could force SSL usage. You’ll need to make sure you can do this with your hosting. -->
<?php
	define('FORCE_SSL_ADMIN', true);
?>

39. Protect your wp-config.php

<!-- Use this snippet to protect the precious. Add this to your .htaccess file -->

<Files wp-config.php>
	order allow,deny
	deny from all
</Files>

40. Remove the WordPress version

<!-- his is especially helpful if you’re using an older version of WordPress. Best not tell anyone else that you are. -->
<?php
	function no_generator() { return ''; }
	add_filter( 'the_generator', 'no_generator' );
?>

41. Only allow your own IP address to access your admin
<!-- If you’ve got a static IP and you want to improve your security this is a good snippet. Don’t bother if you have a dynamic IP though. It would get very annoying. -->

<?php
	# my ip address only
	order deny,allow
	allow from MY IP ADDRESS (replace with your IP address)
	deny from all
?>

<!-- #----------- -->
Media
<!-- #----------- -->

42. Automatically use Resized Images instead of originals

<!-- Replace your uploaded image with the large image generated by WordPress. This will save space on your server, and save bandwidth if you link your thumbnail to the original image. I love things that speed up your website. -->

<?php
	function replace_uploaded_image($image_data) {
	// if there is no large image : return

	if (!isset($image_data['sizes']['large'])) return $image_data;
	// paths to the uploaded image and the large image

	$upload_dir = wp_upload_dir();
	$uploaded_image_location = $upload_dir['basedir'] . '/' .$image_data['file'];
	$large_image_location = $upload_dir['path'] . '/'.$image_data['sizes']['large']['file'];
	// delete the uploaded image

	unlink($uploaded_image_location);
	// rename the large image

	rename($large_image_location,$uploaded_image_location);
	// update image metadata and return them

	$image_data['width'] = $image_data['sizes']['large']['width'];
	$image_data['height'] = $image_data['sizes']['large']['height'];
	unset($image_data['sizes']['large']);

	return $image_data;
	}
	add_filter('wp_generate_attachment_metadata','replace_uploaded_image');
?>

43. 