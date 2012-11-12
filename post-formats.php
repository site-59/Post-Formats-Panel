<?php
/**
 * Post Formats Widget.
 * Displays links to post format archives
 *
 * @package og2013
 * @since og2013 1.0
 */


class og2013_Post_Formats_Widget extends WP_Widget {

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
		
		if( $categories ):
			// Printing the result
			echo $before_widget;
			echo $before_title;
			//echo __( 'Featuring:', 'og2013' ); //$title; // Can set this with a widget option, or omit altogether
			echo $after_title;
			echo '<div id="post-formats" class="clearfix">';

			foreach ( $categories as $cat) {
				$pformat = str_replace( 'post-format-', '', $cat->category_nicename );
				//echo '<li class="item-'.$pformat.'"><span class="count">'.$cat->category_count.' <span aria-hidden="true" class="icon-' . $pformat . '"></span></span>  <a href="'.get_option('home').'/type/'.$pformat.'/">'.$cat->cat_name.'</a></li>';
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

add_action( 'widgets_init', create_function( '', 'register_widget("og2013_Post_Formats_Widget");' ) );
