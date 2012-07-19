<?php
/*
Plugin Name: DS Youtube Feeder
Plugin URI: https://github.com/wnrosenberg/ds_youtube_feeder
Description: Outputs a Youtuve Feed.
Version: 0.1b
Author: Will Rosenberg (Digital Surgeons) <will.rosenberg@gmail.com>
License: DBAD (http://philsturgeon.co.uk/code/dbad-license/)
*/

/* ACTIONS */
if ( is_admin() ){
	add_action( 'admin_menu', 'dsytf_my_plugin_menu' );       // creates a new menu item under 'Settings'
	add_action( 'admin_init', 'dsytf_register_mysettings' );  // register plugin settings
	add_option( 'ds-yt-user' );
}

/*** BEGIN ADMIN SECTION ***/

/* Creates a new menu item under 'Settings' for Options Page */
function dsytf_my_plugin_menu() {
	add_options_page( 'DS Youtube Feeder Options', 'DS Youtube Feeder', 'manage_options', 'ds-youtube-feeder', 'dsytf_my_plugin_options' );
}

/* Generate Options Page */
function dsytf_my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	//add_settings_field( $id, $title, $callback, $page, $section, $args );
	add_settings_section( 'ds-youtube-feeder-section', "General Settings", 'ds_youtube_feeder_section', 'ds-youtube-feeder' );

	/** start output **/
	?>

<div class="wrap">
<h2>DS Youtube Feeder Options</h2>
<p>This plugin accesses YouTube feeds using the following request:<br>
	<code>http://gdata.youtube.com/feeds/api/users/<b>USERNAME</b>/uploads?v=2&alt=json&format=5&max-results=<b>#</b></code><br>
	Where "USERNAME" is the <b>Youtube Username</b> supplied below, and "#" is the number of results to pull, set in the template tag.</p>
<form method="post" action="options.php">
	<?php settings_fields( 'ds-youtube-feeder-group' ); ?>
	<?php do_settings_fields( 'ds-youtube-feeder-group', 'ds-youtube-feeder-section'); ?>
	<table class="form-table">
	<tr valign="top">
		<th scope="row">Youtube Username</th> <td><input type="text" name="ds-yt-user" value="<?php echo get_option('ds-yt-user'); ?>" /></td>
	</tr>
	</table>
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
</form>
</div>

	<?
	/** end output **/
}

/* callback that outputs the form? */
function ds_youtube_feeder_section() {
	?>
	<table class="form-table">
	<tr valign="top">
		<th scope="row">Youtube Username</th> <td><input type="text" name="ds-yt-user" value="<?php echo get_option('ds-yt-user'); ?>" /></td>
	</tr>
	</table>
	<?
}

/* Register Settings used on Options Page */
function dsytf_register_mysettings() { // whitelist options
  register_setting( 'ds-youtube-feeder-group', 'ds-yt-user' );
}

/*** END ADMIN SECTION ***/


/* Output */
function ds_wordpress_feeder( $max_results = 0 ) {

	// sanitize $max_results
	$max_results = intval($max_results);
	if ($max_results <= 0) {
		$max_results = "";
	} else {
		$max_results = "&max-results=$max_results";
	}

	// grab youtube feed
	$feed_url = "http://gdata.youtube.com/feeds/api/users/" . get_option('ds-yt-user') . "/uploads?v=2&alt=json&format=5" . $max_results ;
	$feed = file_get_contents($feed_url);
	if ($feed) {
		print_r(json_decode($feed, 1));
	} else {
		echo "<b>Error parsing JSON feed data.</b>";
		return false;
	}

	/* parse that feed! 
	$entries = $feed['feed']['entry'];
	for (i=0;i<entries.length;i++) {
		//console.log(entries[i]);
		thumbnail = entries[i].media$group.media$thumbnail[1].url;
		title = entries[i].title.$t;
		url_title = slugify(title);
		description = entries[i].media$group.media$description.$t;
		summary = description.substring(0,100) + "...";
		videoid = entries[i].media$group.yt$videoid.$t;
		jQuery("#featured_videos ul").append('<li><figure class="post_img"><a class="thumb" href="/about/video-center/#' + videoid + '/' + url_title + '/"><img src="' + thumbnail + '" width="110" height="60"><i></i></a></figure><h4 class="title"><a href="/about/video-center/#' + videoid + '/' + url_title + '/">' + title + '</a></h4><p class="description">' + summary + ' <a href="/about/video-center/#' + videoid + '/' + url_title + '/">Read more</a></p></li>');
		//console.log("title: " + title + "\nthumbnail: " + thumbnail + "\ndescription: " + description);
	}
	*/



}

?>