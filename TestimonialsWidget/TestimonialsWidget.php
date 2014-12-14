<?php
/*
Plugin Name: Testimonials Widget by Arjun
Plugin URI: 
Description:
Author: Arjun Jain
Author URI: http://www.arjunjain.info
Version: 1.0
*/

add_action('init','add_testimonials_post_type');
function add_testimonials_post_type (){
	$labels=array(
			'name' => 'Testimonials',
			'singular_name'=>'Testimonials',
			'add_new'=>'Add New',
			'add_new_item'=>'Add New Testimonials',
			'edit_item'=>'Edit Testimonials',
			'new_item'=>'New Testimonials',
			'all_items'=>'All Testimonials',
			'view_item'=>'View Testimonials',
			'search_items'=>'Search Testimonials',
			'not_found' => 'No Testimonials found',
			'not_found_in_trash'=>'No Testimonials found in the trash',
			'parent_item_colon' =>'',
			'menu_name'	=>'Testimonials'
	);

	$args = array(
			'labels'        => $labels,
			'description'   => 'Testimonials',
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'   => true,
	);

	register_post_type( 'testimonials', $args );
}


/* Load the widget */
add_action( 'widgets_init', array( 'Custom_Inc_Widgets_TestimonialsbxSlider', 'bx_custom_core_register_widget' ) );

class Custom_Inc_Widgets_TestimonialsbxSlider extends WP_Widget {
	
	/* Widget defaults */
	public static $widget_defaults = array( 
		'title'         => '',
	);

	/* Widget setup  */
	function __construct() {  
		/* Widget settings. */
		$widget_ops = array( 'description' => 'Testimonials slider');

		/* Create the widget. */
		parent::__construct(
			'bx-custom-testimonials-slider',
			'Testimonials slider',
			$widget_ops
		);
	}

	/* Display the widget  */
	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( (array) $instance, self::$widget_defaults );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
		$post_count=apply_filters('widget_title', $instance['no_of_post']);

		$args = array(
			'no_found_rows'     => 1,
			'posts_per_page'    => $post_count,
			'post_type'         => 'testimonials',
			'post_status'       => 'publish',
			'orderby'           => 'date',
			'order'             => 'DESC',
		);

		$p_query = new WP_Query( $args ); 
		

		echo $before_widget . "\n";

		?>
		<script src="<?php echo path_join( WP_PLUGIN_URL, basename( dirname( __FILE__ )) );  ?>/jquery.bxslider.min.js"></script>
		<script type="text/javascript">
		jQuery(document).ready(function(){
  			jQuery('.bxslider').bxSlider({
  				adaptiveHeight: true,
  				mode: 'fade',
  				autoControls:'false'	
  	  		});
		});
		</script>
		<style>
		.bxslider .content{border:0px;margin:0px;padding:0px;clear:both;background: none !important;color:#fff !important;}
		.bx-controls.bx-has-pager.bx-has-controls-direction{text-align:center;}
		.bx-wrapper .bx-pager .bx-pager-item, .bx-wrapper .bx-controls-auto .bx-controls-auto-item { display: inline-block; *zoom: 1; *display: inline;}
		.bx-wrapper .bx-pager.bx-default-pager a { background: #a7a7a7;text-indent: -9999px; display: block;	width: 5px; height: 5px; margin:5px; outline: 0; -moz-border-radius: 5px;-webkit-border-radius: 5px;	border-radius: 5px;}
		.bx-wrapper .bx-pager.bx-default-pager a:hover,.bx-wrapper .bx-pager.bx-default-pager a.active { background: #fff;}
		.bx-controls-direction{display:none;}
		.bxslider li{border:0px !important}
		</style>
		<?php 
		// title
		if ( $title ) echo $before_title . $title . $after_title . "\n";

		if ( $p_query->have_posts() ) {

			echo '<ul class="bxslider">',"\n";

			while( $p_query->have_posts() ) { $p_query->the_post();
?>
				<li>
				<div class="content"><?php the_excerpt();?>
					<p style="text-align: right;"><strong>-- <?php the_title();?></strong></p>
				</div>
				</li>
<?php 
			} // while have posts
			wp_reset_postdata();

			echo '</ul>', "\n";

		} // if have posts

		echo $after_widget . "\n";
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']      = strip_tags($new_instance['title']);
		$instance['no_of_post'] = strip_tags($new_instance['no_of_post']);
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance, self::$widget_defaults );
	
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'no_of_post' ); ?>">Post count</label>
			<input type="text" id="<?php echo $this->get_field_id( 'no_of_post' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'no_of_post' ); ?>" value="<?php echo esc_attr($instance['no_of_post']); ?>" />
		</p>
		<div style="clear: both;"></div>
	<?php
	}

	public static function bx_custom_core_register_widget() {
		register_widget( get_class() );
	}
}