<?php
/**
 * Post Formats Widget.
 * Displays a panel of links to post format archives
 * https://github.com/site-59/wp-post-formats-widget
 *
 *
 * @package og2013
 * @since og2013 1.0
 */


class s59_Post_Formats_Widget extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	function og2013_Post_Formats_Widget() {
		$widget_ops = array( 'classname' => 'og2013-post-formats-class', 'description' => __( 'Shows a list of links to the different post formats archives.', 'og2013' ) );
		$this->WP_Widget( 'widget_og2013_post_formats', __( 'Post Formats Widget', 'og2013' ), $widget_ops );
		$this->alt_option_name = 'widget_og2013_post_formats';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @args   The array of form elements
	 * @instance  The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		$cache = wp_cache_get( 'widget_og2013_post_formats', 'widget' );

		if ( !is_array( $cache ) ) 
			$cache = array();

		if ( ! isset( $args['widget_id'] ) ) 
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		// Widget Values
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Post Formats Widget', 'og2013' ) : $instance['title'], $instance, $this->id_base );

		if ( ! isset( $instance['number'] ) ) $instance['number'] = '110';
		if ( ! $number = absint( $instance['number'] ) ) $number = 110;

		$args = array(
			'show_count'     => 1,
			'orderby'        => 'count',
			'order'          => 'DESC',
			'hierarchical'   => 0,
			'number'         => '',
			'taxonomy'       => 'post_format'
		);

		$categories = get_categories( $args );
		$css = '
		<style>
			#post-formats {width:100%;}
			#post-formats a {display:block;width:33.33%;float:left;position:relative;font-size:0.875em;text-align:center;}
			#post-formats .icon {display:block;font-size:3em;}
			span.count {position:absolute;right:25px;top:5px;font-size:10px;line-height:1em;font-weight:600;background-color:#999a9f;color:#fff;padding:4px 6px;border-radius:12px;border:2px solid #fff;}
			@font-face {
				font-family:"iconfont";
				src:url("'.get_template_directory_uri() .'/wp-post-formats-widget/fonts/iconfont.eot");
				src:
					url("'.get_template_directory_uri() .'/wp-post-formats-widget/fonts/iconfont.eot?#iefix") format("embedded-opentype"),
					url("'.get_template_directory_uri() .'/wp-post-formats-widget/fonts/iconfont.svg#iconfont") format("svg"),
					url("'.get_template_directory_uri() .'/wp-post-formats-widget/fonts/iconfont.woff") format("woff"),
					url("'.get_template_directory_uri() .'/wp-post-formats-widget/fonts/iconfont.ttf") format("truetype";font-weight:normal;font-style:normal;
			}
			[data-icon]:before {font-family:"iconfont";content:attr(data-icon);speak:none;font-weight:normal;-webkit-font-smoothing:antialiased;}
			[class^="icon-"]:before, [class*=" icon-"]:before {font-family:"iconfont";font-style:normal;speak:none;font-weight:normal;-webkit-font-smoothing:antialiased;}
			.icon-video:before {content:"\e003";}
			.icon-audio:before {content:"\e001";}
			.icon-gallery:before {content:"\e002";}
			.icon-image:before {content:"\e004";}
			.icon-aside:before {content:"\e005";}
			.icon-quote:before {content:"\e006";}
			.icon-link:before {content:"\e007";}
			.icon-status:before {content:"\e008";}
			.icon-chat:before {content:"\e000";}
		</style>';
		
		if( $categories ):
			// Printing the result
			echo $before_widget;
			echo $css;
			echo $before_title;
			//echo __( 'Featuring:', 'og2013' ); //$title; // Can set this with a widget option, or omit altogether
			echo $after_title;
			echo '<div id="post-formats" class="clearfix">';

			foreach ( $categories as $cat) {
				$pformat = str_replace( 'post-format-', '', $cat->category_nicename );
				echo '<a class="item-'.$pformat.'" href="'.get_option('home').'/type/'.$pformat.'/"><span aria-hidden="true" class="icon icon-' . $pformat . '"></span><span class="count">'.$cat->category_count.'</span>  <p>'.$cat->cat_name.'</p></a>';

			} 

			echo '</div>';
		endif;
		
		echo $after_widget;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_og2013_post_formats', $cache, 'widget' );
	} // end widget

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @new_instance The previous instance of values before the update.
	 * @old_instance The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_og2013_post_formats'] ) ) 
			delete_option( 'widget_og2013_post_formats' );

		return $instance;

	} // end widget

	function flush_widget_cache() {
		wp_cache_delete( 'widget_og2013_post_formats', 'widget' );
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'og2013' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

	<?php

	} // end form


} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("s59_Post_Formats_Widget");' ) );
