<?php
/*
Plugin Name: Post Formats Widget
Version: 1.0
Plugin URI: https://github.com/site-59/wp-post-formats-widget
Description: Displays a panel of all the available post formats with counter and links to the post format archives.
Author: Lefteris Theodossiadis
Author URI: https://github.com/site-59
License: GPL v2

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


class s59_Post_Formats_Widget extends WP_Widget {
	
	public function __construct() {
		
		parent::__construct(
			'widget-name-id',
			__( 'Post Formats Widget', 's59' ),
			array(
				'classname'		=>	's59-post-formats-class',
				'description'	=>	__( 'Shows a panel of links to all the post formats archives', 's59' )
			)
		);

		add_action( 'init', array( $this, 'textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_css' ) );
	}
	
	public function register_plugin_css() {
		wp_enqueue_style( 's59css', plugins_url( 'wp-post-formats-widget/style.css' ) );
	} 
	
	public function textdomain() {
		load_plugin_textdomain( 's59', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	} 


	public function widget( $args, $instance ) {


		// Widget Values
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Post Formats Widget', 's59' ) : $instance['title'], $instance, $this->id_base );

		if ( ! isset( $instance['columns'] ) ) $instance['columns'] = '3';
		if ( ! $columns = absint( $instance['columns'] ) ) $number = 3;

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
			echo $after_title;
			echo '<div id="post-formats" class="clearfix">';

			$width = (100 / $columns) .'%';

			foreach ( $categories as $cat) {
				$pformat = str_replace( 'post-format-', '', $cat->category_nicename );
				echo '<a class="item-'.$pformat.'" style="width:'.$width.'" href="'.get_option('home').'/type/'.$pformat.'/"><span aria-hidden="true" class="icon icon-' . $pformat . '"></span><span class="count">'.$cat->category_count.'</span>  <p>'.$cat->cat_name.'</p></a>';

			} 

			echo '</div>';
		endif;
		
		echo $after_widget;

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
		$instance['columns'] = (int) $new_instance['columns'];

		return $instance;

	} // end widget


	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$columns = isset( $instance['columns'] ) ? absint( $instance['columns'] ) : 10;
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 's59' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php _e( 'Number of columns to show:', 's59' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>" type="text" value="<?php echo esc_attr( $columns ); ?>" size="3" />
		</p>

	<?php

	} // end form


} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("s59_Post_Formats_Widget");' ) );
