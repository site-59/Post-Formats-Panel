![Widget on the sidebar](https://photos-2.dropbox.com/t/0/AABHufD8BAe-8_Id21Z4NpYJ-_mjoMV37zPQpbpZugEu7Q/10/3074147/png/1024x768/2/1352646000/0/2/grab2.png/Bp3IDsL0plY2fY2emFPPI83vcpPSQRkINYq1zlHfgkk)

# [WP Post Formats widget](https://github.com/site-59/wp-post-formats-widget)
======================

The **Wordpress Post Formats Widget** by **[site-59](https://github.com/site-59)** creates a stylish, practical panel that displays links with attached counters to any of the [post formats](http://codex.wordpress.org/Post_Formats)' archives available on your site. Originally created for the **[oh-gee](https://github.com/site-59/oh-gee)** theme it can used on almost any sidebar, giving direct access to all of those special posts. If you use the post formats feature on your site, this widget will enhance their functionality. If not then it's time to start using them. 
 
##Installation
This is not a plugin, it requires a few steps to install it on your site. You need to have FTP access to upload the contents of the package on the active theme's folder. Here are the steps to follow:
1. Download and uzip the package from [here]()https://github.com/site-59/wp-post-formats-widget/archive/master.zip
2. Use an FTP application to access your active theme's folder.
3. Create a new folder here and name it **wp-post-formats-widget** (the name is **important**)
4. Upload all the contents of the package to the folder you created earlier.
5. Open the functions.php file in your active theme folder and the following lines exact of code:

<pre><code>
	function s59_wp_post_formats_widget(){
		require_once ( get_template_directory() . '/wp-post-formats-widget/post-formats.php' );			// Post Formats widget
	}

	add_action( 'after_setup_theme', 's59_wp_post_formats_widget' );
</code></pre>

6. Save the functions.php file and log on to the widgets panel in the Wordpress administration.
7. Activate the widget by adding it in one the available widgets' areas. 


## License
The __Wordpress Post Formats Widget__ is licensed the under the GPL license as is Wordpress itself. You can find a copy of the license text at the [Codex](http://codex.wordpress.org/GPL).
* Icon Set: [Brankic1979](http://brankic1979.com/icons/) / License: Custom http://brankic1979.com/icons/
* Icon Set: [Entypo](http://www.entypo.com/) / License:	CC BY-SA 3.0 -- http://creativecommons.org/licenses/by-sa/3.0/
* Icon Set: [IcoMoon - Free](http://keyamoon.com/icomoon/) / License: CC BY-SA 3.0 -- http://creativecommons.org/licenses/by-sa/3.0/

