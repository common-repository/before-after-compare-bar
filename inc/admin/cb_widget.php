<?php
class ComparebarWidget extends WP_Widget
{

/**
    * Register widget with WordPress.
    */
    function __construct() {
    $widget_ops = array('classname' => 'ComparebarWidget', 'description' => 'Displays selected comparebar' );
        parent::__construct(
            'ComparebarWidget', // Base ID
            __('Comparebar Widget',''), // Name
           $widget_ops ); // Args
    }

  function ComparebarWidget()
  {
    $widget_ops = array('classname' => 'ComparebarWidget', 'description' => 'Displays selected comparebar' );
    $this->WP_Widget('ComparebarWidget', 'Comparebar Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '','select_cbar' =>'' ) );
    $title = $instance['title'];
	$select_cbar = esc_attr($instance['select_cbar']);
	?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','cbar'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
	<p><label for="<?php echo $this->get_field_id('select_cbar'); ?>"><?php _e('Select Comparebar:','cbar'); ?> 
	<?php
		global $wpdb;
		$table_name = $wpdb->prefix . "comparebar"; 
		$cbar_data = $wpdb->get_results("SELECT * FROM $table_name WHERE active=1  ORDER BY id");
	?>
	<select id="<?php echo $this->get_field_id('select_cbar'); ?>" name="<?php echo $this->get_field_name('select_cbar'); ?>">
		<?php
			foreach($cbar_data as $cbar_item){ ?><option <?php selected($cbar_item->option_name,$select_cbar); ?> value="<?php echo $cbar_item->option_name; ?>"><?php echo $cbar_item->option_name; ?></option><?php }
		?>
	</select>
	</label>
	</p>
	
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
	$instance['select_cbar'] = strip_tags($new_instance['select_cbar']);
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
	$select_cbar = esc_attr($instance['select_cbar']);
    if (!empty($title))
    echo $before_title . $title . $after_title;;
    echo compareBar($select_cbar);
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("ComparebarWidget");') );
?>