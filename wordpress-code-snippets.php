*******************************
Config file **************************************
*******************************
1. Increase Memory Limit
define('WP_MEMORY_LIMIT', '96M');

2. Empty Trash Automatically
define('EMPTY_TRASH_DAYS', 5 );

Block Bad Users From Accessing Your WordPress:

Order Allow,Deny
Deny from all

------OR------

order allow,deny
deny from 192.168.1.2
deny from 10.130.130.6
deny from 172.16.130.106
allow from all

*******************************
Authentication Unique Keys and Salts
*******************************

URL: https://api.wordpress.org/secret-key/1.1/salt/
<!--
define('AUTH_KEY',         '|B `gXmdr;v:m<KqDgDWiAPhAw-hy+g1?U^xyA+s]- :(M$uns^RunWojgSWR4 7');
define('SECURE_AUTH_KEY',  'gLBtj+2%SKJmmJf5|F$ky93t,WC.#pmf}Rx|u3NEUFg}*=]K>FYy;fI!/v8F)Wr0');
define('LOGGED_IN_KEY',    'z`5bsV,!Tt$aOLN&]96Xz2z_BBokJN0W3S>;YP:OH19)]?;DWE|TMU)DDzZ{lpNU');
define('NONCE_KEY',        '|^yQy5k4Lt5%N8m1DxmW]tD#o7E~hKlp<l*C>:7Z0`gr{~#G/yimk_rrcTO+D#+H');
define('AUTH_SALT',        'Ld+s}7F.ihu)4p(ll<>D{tW-QbS$*k0;g8=Nx7@DsPS|Q8i%v*T^r|Ztg)G|39y6');
define('SECURE_AUTH_SALT', 'v`-HbT1X!R5x>%|V,Rz^:BrLN!^p<xl+%@|ztx!Ij3Rr9,x|4V7kqs$FDe@^?RtL');
define('LOGGED_IN_SALT',   '^%|fG1rp2,9zeV,< CGXU+@07J.+XoY3K9c:YY0@/<^9lh0VE/--!aGR:-Y|kFm,');
define('NONCE_SALT',       '!~+[>H_>4]rbzJ?nbI,t;#AXcc0ysPO!99&A6szV`Z<R`Q!?/79_MyG<]D/e/|/h'); 
-->

*******************************
WordPress Database Table prefix
*******************************

The default value, as seen below, is “wp_”:

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

*******************************
Automated Trash
*******************************

define('EMPTY_TRASH_DAYS', 7); // empty weekly

define('EMPTY_TRASH_DAYS', 0); // disable trash

*******************************
Blog Address and Site Address
*******************************

define('WP_HOME', 'https://digwp.com'); // no trailing slash
define('WP_SITEURL', 'https://digwp.com');  // no trailing slash

*******************************
Debugging WordPress
*******************************

define('WP_DEBUG', true); // debugging mode: 'true' = enable; 'false' = disable

*******************************
Increase PHP Memory
*******************************

define('WP_MEMORY_LIMIT', '64M');
define('WP_MEMORY_LIMIT', '96M');
define('WP_MEMORY_LIMIT', '128M');
define('WP_MEMORY_LIMIT', '256M');

*******************************
Disable the theme and plugin editor
*******************************

define('DISALLOW_FILE_EDIT',true);

*******************************
Make URLs SEO-friendly and future-proof
*******************************

<Files magic>
	ForceType application/x-httpd-php5
</Files>

*******************************
Improve caching for better site speed
*******************************

<FilesMatch ".(flv|gif|jpg|jpeg|png|ico|swf|js|css|pdf)$">
	Header set Cache-Control "max-age=28800"
</FilesMatch>

*******************************
GZIP compression - make your site load faster
*******************************

<ifModule mod_gzip.c>
mod_gzip_on Yes
  mod_gzip_dechunk Yes
  mod_gzip_item_include file \.(html?|txt|css|js|php|pl)$
  mod_gzip_item_include handler ^cgi-script$
  mod_gzip_item_include mime ^text/.*
  mod_gzip_item_include mime ^application/x-javascript.*
  mod_gzip_item_exclude mime ^image/.*
  mod_gzip_item_exclude rspheader ^Content-Encoding:.*gzip.*
</ifModule>

*******************************
Redirect 301
*******************************

Redirect 301 / http://www.newsite.com/
Redirect 301 /old.htm /new.htm

Make sure Keep-Alive is turned on in your server config.
<ifModule mod_headers.c> Header set Connection keep-alive </ifModule>

*******************************

*******************************



*******************************
Redirect 301
*******************************


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

<!-- #----------- -->
Display Search Terms from Google Users
<!-- #----------- -->

Do you want to display a custom welcome message and search terms 
for users coming from Google search? While there’s probably a 
plugin for this, we have created a quick code snippet that you can use 
to display search terms from Google users in WordPress.

Instructions:

All you have to do is add this code to your theme’s index.php file:

<?php
$refer = $_SERVER["HTTP_REFERER"];
if (strpos($refer, "google")) {
    $refer_string = parse_url($refer, PHP_URL_QUERY);
    parse_str($refer_string, $vars);
    $search_terms = $vars['q'];
    echo 'Welcome Google visitor! You searched for the following terms to get here: ';
    echo $search_terms;
};
?>


<!-- #----------- -->
Detect Which Browser Your WordPress Visitors are Using
<!-- #----------- -->

If you want to use different stylesheets for different browsers, 
then this is a snippet you could use. It detects the browser your 
visitors are using and creates a different class for each browser. 
You can use that class to create custom stylesheets.

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

<!-- #----------- -->
Reset Your WordPress Password
<!-- #----------- -->

What would you do if you forget your WordPress Admin 
Password and you no longer have access to the admin area? 
To fix this all you have to do is jump to your PhpMyAdmin 
Sql-window and run the following command.

UPDATE `wp_users` SET `user_pass` = MD5('NEW_PASSWORD') WHERE `wp_users`.`user_login` =`YOUR_USER_NAME` LIMIT 1;

<!-- #----------- -->
Screenshots of External WordPress Pages Without a Plugin
<!-- #----------- -->

This is a very simple URL script that will generate a screenshot of any website. Here is the URL:

To see what the link above does, click here:
https://s.wordpress.com/mshots/v1/http%3A%2F%2Fgoogle.com%2F?w=500

<!-- #----------- -->
List Scheduled/Future WordPress Posts
<!-- #----------- -->

Paste the code anywhere on your template where you want 
your scheduled posts to be listed, changing the max number 
or displayed posts by changing the value of showposts in 
the query.

<?php
$my_query = new WP_Query('post_status=future&order=DESC&showposts=5');
if ($my_query->have_posts()) {
    while ($my_query->have_posts()) : $my_query->the_post();
        $do_not_duplicate = $post->ID; ?>
        <li><?php the_title(); ?></li>
    <?php endwhile;
}
?>

<!-- #----------- -->
Custom WordPress Excerpts
<!-- #----------- -->

Sometimes you may need to limit how many words are in the excerpt, 
with this snippet you can create your own custom excerpt (my_excerpts) 
replacing the original.

Paste this code in functions.php.

<?php add_filter('the_excerpt', 'my_excerpts');
function my_excerpts($content = false) {
            global $post;
            $mycontent = $post->post_excerpt;
 
            $mycontent = $post->post_content;
            $mycontent = strip_shortcodes($mycontent);
            $mycontent = str_replace(']]>', ']]&gt;', $mycontent);
            $mycontent = strip_tags($mycontent);
            $excerpt_length = 55;
            $words = explode(' ', $mycontent, $excerpt_length + 1);
            if(count($words) > $excerpt_length) :
                array_pop($words);
                array_push($words, '...');
                $mycontent = implode(' ', $words);
            endif;
            $mycontent = '<p>' . $mycontent . '</p>';
// Make sure to return the content
    return $mycontent;
}
?>

<!-- #----------- -->
Custom Title Length
<!-- #----------- -->

This snippet will allow you to customise 
the length (by the number of characters) of your post title.

Paste this code into the functions.php:

function ODD_title($char)
    {
    $title = get_the_title($post->ID);
    $title = substr($title,0,$char);
    echo $title;
    }

To use this function all you have to do is paste the below code
into your theme files, remembering to change the ’20’ to what 
ever character amount you require:

<?php ODD_title(20); ?>

<!-- #----------- -->
Display an External RSS Feed in WordPress
<!-- #----------- -->

This snippet will fetch the latest entries of any specified feed url.

<?php include_once(ABSPATH.WPINC.'/rss.php');
wp_rss('http://wpforums.com/external.php?type=RSS2', 5); ?>

This code takes the rss.php file that is built into WordPress (used 
for widgets). It is set to display the most recent 5 posts from the 
RSS feed ‘http://example.com/external.php?type=RSS2’.


<!-- #----------- -->
WordPress Breadcrumbs Without a Plugin
<!-- #----------- -->

Breadcrumbs can be a useful navigation technique that 
offers link to the previous page the user navigated through 
to arrive at the current post/page. There are plugins you 
could use, but the code snippet below could be an easier solution.

Paste this code into your functions.php file.

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
elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
echo '</ul>';
}
Then paste the calling code below, wherever you would like the breadcrumbs to appear (typically above the title tag).

<?php the_breadcrumb(); ?>


<!-- #----------- -->
Custom WooCommerce Shop.php Featured Products Loop 
<!-- #----------- -->

Little snippet will loop through the featured products and show on home page
or a template page for example.

<?php

$meta_query  = WC()->query->get_meta_query();
$tax_query   = WC()->query->get_tax_query();
$tax_query[] = array(
'taxonomy' => 'product_visibility',
'field'    => 'name',
'terms'    => 'featured',
'operator' => 'IN',
);

$args = array(
'post_type'           => 'product',
'post_status'         => 'publish',
'ignore_sticky_posts' => 1,
'posts_per_page'      => $atts['per_page'],
'orderby'             => $atts['orderby'],
'order'               => $atts['order'],
'meta_query'          => $meta_query,
'tax_query'           => $tax_query,
);

$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>


<div class="col-xs-12 col-sm-6 col-lg-3">
   <article class="tw-instruction">

      <?php 
	  if ( has_post_thumbnail( $loop->post->ID ) ) 
	      echo get_the_post_thumbnail( $loop->post->ID, 'shop_catalog' );
	  else  echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="100%" height="auto" />'; ?>
      <h3><?php the_title(); ?></h3>
      <p>Test</p>
      <span class="badge badge-warning hidden-xs hidden-sm m-r-1"><a style="color:#fff;text-decoration:none;" href="https://google.com">info</a></span><?php echo $product->get_price_html();  ?><br />
      <?php echo woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
   </article>
</div>


<?php 
endwhile;
wp_reset_query(); 
?>



<!-- #----------- -->
You have access to $product
<!-- #----------- -->

<!-- Code Reference: https://businessbloomer.com/woocommerce-easily-get-product-info-title-sku-desc-product-object/ -->

<?php 

// Get Product ID
 
$product->get_id(); (fixes the error: "Notice: id was called incorrectly. Product properties should not be accessed directly")
 
// Get Product General Info
 
$product->get_type();
$product->get_name();
$product->get_slug();
$product->get_date_created();
$product->get_date_modified();
$product->get_status();
$product->get_featured();
$product->get_catalog_visibility();
$product->get_description();
$product->get_short_description();
$product->get_sku();
$product->get_menu_order();
$product->get_virtual();
get_permalink( $product->get_id() );
 
// Get Product Prices
 
$product->get_price();
$product->get_regular_price();
$product->get_sale_price();
$product->get_date_on_sale_from();
$product->get_date_on_sale_to();
$product->get_total_sales();
 
// Get Product Tax, Shipping & Stock
 
$product->get_tax_status();
$product->get_tax_class();
$product->get_manage_stock();
$product->get_stock_quantity();
$product->get_stock_status();
$product->get_backorders();
$product->get_sold_individually();
$product->get_purchase_note();
$product->get_shipping_class_id();
 
// Get Product Dimensions
 
$product->get_weight();
$product->get_length();
$product->get_width();
$product->get_height();
$product->get_dimensions();
 
// Get Linked Products
 
$product->get_upsell_ids();
$product->get_cross_sell_ids();
$product->get_parent_id();
 
// Get Product Variations
 
$product->get_attributes();
$product->get_default_attributes();
 
// Get Product Taxonomies
 
$product->get_categories();
$product->get_category_ids();
$product->get_tag_ids();
 
// Get Product Downloads
 
$product->get_downloads();
$product->get_download_expiry();
$product->get_downloadable();
$product->get_download_limit();
 
// Get Product Images
 
$product->get_image_id();
$product->get_image();
$product->get_gallery_image_ids();
 
// Get Product Reviews
 
$product->get_reviews_allowed();
$product->get_rating_counts();
$product->get_average_rating();
$product->get_review_count();

?>

<!-- #----------- -->
Access through Product ID
<!-- #----------- -->

<?php 

// Get $product object from product ID
 
$product = wc_get_product( $product_id );
 
// Now you have access to (see above)...
 
$product->get_type();
$product->get_name();
// etc.
// etc.

?>


<!-- #----------- -->
You have access to the Cart object
<!-- #----------- -->

<?php
// Get $product object from Cart object
 
$cart = WC()->cart->get_cart();
 
foreach( $cart as $cart_item ){
 
    $product = wc_get_product( $cart_item['product_id'] );
 
    // Now you have access to (see above)...
 
    $product->get_type();
    $product->get_name();
    // etc.
    // etc.
 
}
?>

<!-- #----------- -->
Gets current cart $ amount total
<!-- #----------- -->

Example: $30.00
Reference: https://docs.woocommerce.com/wc-apidocs/class-WC_Cart.html#_get_totals

<?php $ordertotal = wp_kses_data( WC()->cart->get_total() ); ?>



<!-- #----------- -->
Single Post Snippets
<!-- #----------- -->

<?php echo get_avatar( get_the_author_email(), '80' ); ?>
<?php the_author_meta( "display_name" ); ?>
<?php the_author_meta( "user_description" ); ?>

<?php echo get_the_title(); ?>
<?php echo esc_html( get_the_title() ); ?>

<?php the_title_attribute(); ?>
<!-- If you are going to add alt titles to an element do this: -->
' . esc_attr( the_title_attribute() ) . '

<?php the_content(); ?>
<?php the_content( 'Read more ...' ); ?>

<?php the_excerpt(); ?>

<?php the_permalink(); ?>
<!-- If you are going to add permalink to a <a> element do this:  -->
' . esc_url( get_permalink() ) . '

<?php echo get_the_date(); ?>
<!-- To make the date appear as “Monday January 11, 2017”, for example, use -->
$post_date = get_the_date( 'l F j, Y' ); echo $post_date;

<!-- To make the date appear as “Wed Jan 9”, for example, use -->
$post_date = get_the_date( 'D M j' ); echo $post_date;

<!-- without parameter -> Post Thumbnail (as set by theme using set_post_thumbnail_size()) -->
<?php get_the_post_thumbnail( $post_id ); ?>
 
<?php get_the_post_thumbnail( $post_id, 'thumbnail' ); ?> <!-- Thumbnail (Note: different to Post Thumbnail) -->
<?php get_the_post_thumbnail( $post_id, 'medium' ); ?> <!-- Medium resolution -->
<?php get_the_post_thumbnail( $post_id, 'large' ); ?> <!-- Large resolution -->
<?php get_the_post_thumbnail( $post_id, 'full' ); ?> <!-- Original resolution -->
 
<?php get_the_post_thumbnail( $post_id, array( 100, 100) ); ?> <!-- Other resolutions -->

<!-- ACF Plugin -->
<?php get_field('field name'); ?>
<!-- Custom Field Post: -->
<?php echo the_meta(); ?>
<!-- Show the custom field value in custom post type plugin by using get_post_meta($post->ID, 'game_offer', true); function -->
<?php echo get_post_meta($post->ID, 'game_offer', true); ?>

<!-- Get woocommerce product price by id -->
$product = wc_get_product( $post_id );
global $post, $product;

$product->get_regular_price();
$product->get_sale_price();
$product->get_price();
$product->get_sku();

<!-- for use in the loop, list 5 post titles related to first tag on current post -->
<?php
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
	    echo 'Related Posts';
	    $first_tag = $tags[0]->term_id;
	    $args      = array(
	        'tag__in' => array(
	            $first_tag
	        ),
	        'post__not_in' => array(
	            $post->ID
	        ),
	        'posts_per_page' => 5,
	        'caller_get_posts' => 1
	    );
	    $my_query  = new WP_Query($args);
	    if ($my_query->have_posts()) {
	        while ($my_query->have_posts()):
	            $my_query->the_post();
	?>
	<a href="<?php
	            the_permalink();
	?>" rel="bookmark" title="Permanent Link to <?php
	            the_title_attribute();
	?>"><?php
	            the_title();
	?></a>
	 
	<?php
	        endwhile;
	    }
	    wp_reset_query();
	}
?>

<!-- ------------------------ -->
Apply Custom CSS to Admin Area
<!-- ------------------------ -->

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    body, td, textarea, input, select {
      font-family: "Lucida Grande";
      font-size: 12px;
    }
    body,
    #wpadminbar,
    #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
    	background: #1b1c1d !important;
    }
    .wp-filter {
	    border: 1px solid #262829;
	    background: #262829;
        border-radius: 5px;
    }
    h1 {
    	color:#fff;
    }
  </style>';
}

<!-- -------------------- -->
Customize Login Page
<!-- -------------------- -->

function custom_login_logo() {
	echo '<style type="text/css">h1 a { background: url('.get_bloginfo('template_directory').'/images/logo-login.gif) 50% 50% no-repeat !important; }</style>';
}
add_action('login_head', 'custom_login_logo');

<!-- -------------------------- -->
Paginate Custom Post Types
<!-- -------------------------- -->

<?php 
  $temp = $wp_query; 
  $wp_query = null; 
  $wp_query = new WP_Query(); 
  $wp_query->query('showposts=6&post_type=news'.'&paged='.$paged); 

  while ($wp_query->have_posts()) : $wp_query->the_post(); 
?>

  <!-- LOOP: Usual Post Template Stuff Here-->

<?php endwhile; ?>

<nav>
    <?php previous_posts_link('&laquo; Newer') ?>
    <?php next_posts_link('Older &raquo;') ?>
</nav>

<?php 
  $wp_query = null; 
  $wp_query = $temp;  // Reset
?>

<!-- -------------------------- -->
WooCommerce Page Shortcodes
<!-- -------------------------- -->

Snippets Reference: https://docs.woocommerce.com/document/woocommerce-shortcodes/

[woocommerce_cart] – shows the cart page
[woocommerce_checkout] – shows the checkout page
[woocommerce_my_account] – shows the user account page
[woocommerce_order_tracking] – shows the order tracking form
