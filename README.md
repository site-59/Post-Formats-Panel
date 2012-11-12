![Widget on the sidebar](https://photos-2.dropbox.com/t/0/AABHufD8BAe-8_Id21Z4NpYJ-_mjoMV37zPQpbpZugEu7Q/10/3074147/png/1024x768/2/1352646000/0/2/grab2.png/Bp3IDsL0plY2fY2emFPPI83vcpPSQRkINYq1zlHfgkk)

wp-post-formats-widget
======================

**Wordpress Post Formats Widget** by **site-59** offers a beautiful and practical way to display the links with counters to any of your post format archives available on your site.
 
##Installation
This is not a plugin, it requires a few steps to install it on your site. First create a widget folder into the active theme folder and then add the following lines of code into your functions.php file:

<pre><code>
	
	function load_wp_post_formats_widget(){
		require_once ( get_template_directory() . '/widgets/post-formats.php' );			// Post Formats widget
	}

	add_action( 'after_setup_theme', 'load_wp_post_formats_widget' );
	
</code></pre>



## License
The **Wordpress Post Formats Widget** is licensed the under the GPL license as is Wordpress itself. You can find a copy of the license text at the [Codex](http://codex.wordpress.org/GPL).

Icon Set:	Brankic1979 -- http://brankic1979.com/icons/
License:	Custom -- http://brankic1979.com/icons/
Icon Set:	Entypo -- http://www.entypo.com/
License:	CC BY-SA 3.0 -- http://creativecommons.org/licenses/by-sa/3.0/
Icon Set:	IcoMoon - Free -- http://keyamoon.com/icomoon/
License:	CC BY-SA 3.0 -- http://creativecommons.org/licenses/by-sa/3.0/

