<?php
class PrsoFoundation5Gallery {
	
	protected static $class_config 				= array();
	protected $current_screen					= NULL;
	protected $plugin_ajax_nonce				= 'prso_foundation_5_gallery-ajax-nonce';
	protected $plugin_path						= PRSOFOUNDATION5GALLERY__PLUGIN_DIR;
	protected $plugin_url						= PRSOFOUNDATION5GALLERY__PLUGIN_URL;
	protected $plugin_textdomain				= PRSOFOUNDATION5GALLERY__DOMAIN;
	
	function __construct( $config = array() ) {
		
		//Cache plugin congif options
		self::$class_config = $config;
		
		//Set textdomain
		add_action( 'after_setup_theme', array($this, 'plugin_textdomain') );
		
		//Init plugin
		//add_action( 'init', array($this, 'init_plugin') );
		//add_action( 'admin_init', array($this, 'admin_init_plugin') );
		//add_action( 'current_screen', array($this, 'current_screen_init_plugin') );
		add_action( 'after_setup_theme', array($this, 'setup_gallery_shortcode') );
		
	}
	
	/**
	 * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
	 * @static
	 */
	public static function plugin_activation( $network_wide ) {
		
	}

	/**
	 * Attached to deactivate_{ plugin_basename( __FILES__ ) } by register_deactivation_hook()
	 * @static
	 */
	public static function plugin_deactivation( ) {
		
	}
	
	/**
	 * Setup plugin textdomain folder
	 * @public
	 */
	public function plugin_textdomain() {
		
		load_plugin_textdomain( $this->plugin_textdomain, FALSE, $this->plugin_path . '/languages/' );
		
	}
	
	/**
	* init_plugin
	* 
	* Used By Action: 'init'
	* 
	*
	* @access 	public
	* @author	Ben Moody
	*/
	public function init_plugin() {
		
		//Init vars
		$options 		= self::$class_config;
		
		if( is_admin() ) {
		
			//PLUGIN OPTIONS FRAMEWORK -- comment out if you dont need options
			//$this->load_redux_options_framework();
			
		}
		
	}
	
	/**
	* admin_init_plugin
	* 
	* Used By Action: 'admin_init'
	* 
	*
	* @access 	public
	* @author	Ben Moody
	*/
	public function admin_init_plugin() {
		
		//Init vars
		$options 		= self::$class_config;
		
		if( is_admin() ) {
			
			//Enqueue admin scripts
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts') );
			
		}
		
	}
	
	/**
	* current_screen_init_plugin
	* 
	* Used By Action: 'current_screen'
	* 
	* Detects current view and decides if plugin should be activated
	*
	* @access 	public
	* @author	Ben Moody
	*/
	public function current_screen_init_plugin() {
		
		//Init vars
		$options 		= self::$class_config;
		
		if( is_admin() ) {
		
			//Confirm we are on an active admin view
			if( $this->is_active_view() ) {
		
				//Carry out view specific actions here
				
			}
			
		}
		
	}
	
	/**
	* load_redux_options_framework
	* 
	* Loads Redux options framework as well as the unique config file for this plugin
	*
	* NOTE!!!!
	*			You WILL need to make sure some unique constants as well as the class
	*			name in the plugin config file 'inc/ReduxConfig/ReduxConfig.php'
	*
	* @access 	public
	* @author	Ben Moody
	*/
	protected function load_redux_options_framework() {
		
		//Init vars
		$framework_inc 		= $this->plugin_path . 'inc/ReduxFramework/ReduxCore/framework.php';
		$framework_config	= $this->plugin_path . 'inc/ReduxConfig/ReduxConfig.php';
		
		//Try and load redux framework
		if ( !class_exists('ReduxFramework') && file_exists($framework_inc) ) {
			require_once( $framework_inc );
		}
		
		//Try and load redux config for this plugin
		if ( file_exists($framework_config) ) {
			require_once( $framework_config );
		}
		
	}
	
	/**
	* is_active_view
	* 
	* Detects if current admin view has been set as 'active_post_type' in
	* plugin config options array.
	* 
	* @var		array	self::$class_config
	* @var		array	$active_views
	* @var		obj		$screen
	* @var		string	$current_screen
	* @return	bool	
	* @access 	protected
	* @author	Ben Moody
	*/
	protected function is_active_view() {
		
		//Init vars
		$options 		= self::$class_config;
		$active_views	= array();
		$screen			= get_current_screen();
		$current_screen	= NULL;
		
		//Cache all views plugin will be active on
		$active_views = $this->get_active_views( $options );
		
		//Cache the current view
		if( isset($screen) ) {
		
			//Is this an attachment screen (base:upload or post_type:attachment)
			if( ($screen->id === 'attachment') || ($screen->id === 'upload') ) {
				$current_screen = 'attachment';
			} else {
				
				//Cache post type for all others
				$current_screen = $screen->post_type;
				
			}
			
			//Cache current screen in class protected var
			$this->current_screen = $current_screen;
		}
		
		//Finaly lets check if current view is an active view for plugin
		if( in_array($current_screen, $active_views) ) {
			return TRUE;
		} else {
			return FALSE;
		}
		
	}
	
	/**
	* get_active_views
	* 
	* Interates over plugin config options array merging all
	* 'active_post_type' values into single array
	* 
	* @param	array	$options
	* @var		array	$active_views
	* @return	array	$active_views
	* @access 	private
	* @author	Ben Moody
	*/
	protected function get_active_views( $options = array() ) {
		
		//Init vars
		$active_views = array();
		
		//Loop options and cache each active post view
		foreach( $options as $option ) {
			if( isset($option['active_post_types']) ) {
				$active_views = array_merge($active_views, $option['active_post_types']);
			}
		}
		
		return $active_views;
	}
	
	/**
	 * Helper to set all actions for plugin
	 */
	protected function set_admin_actions() {
		
		
		
	}
	
	/**
	 * Helper to enqueue all scripts/styles for admin views
	 */
	public function enqueue_admin_scripts() {
		
		//Init vars
		$js_inc_path 	= $this->plugin_url . 'inc/js/';
		$css_inc_path 	= $this->plugin_url . 'inc/css/';
		
		
		
		//Localize vars
		$this->localize_script();
		
	}
	
	/**
	* localize_script
	* 
	* Helper to localize all vars required for plugin JS.
	* 
	* @var		string	$object
	* @var		array	$js_vars
	* @access 	private
	* @author	Ben Moody
	*/
	protected function localize_script() {
		
		//Init vars
		$object 	= 'PrsoPluginFrameworkVars';
		$js_vars	= array();
		
		//Localize vars for ajax requests
		
		
		//wp_localize_script( '', $object, $js_vars );
	}
	
	public function setup_gallery_shortcode() {
		
		//First remove the standard wordpress gallery shortcode action
		remove_shortcode('gallery', array($this, 'gallery_shortcode') );
		
		//Add our foundation clearing gallery shortcode action here
		add_shortcode('gallery', array($this, 'foundation_gallery_shortcode') );
		
	}
	
	/**
	* Gallery Shortcodes
	*
	* Called by add_shortcode( 'gallery' )
	*
	* Replaced Wordpress default gallery action with Zurb Foundation Clearing Feature.
	* This is essentially a copy of the wordpress gallery function with some adjustments to 
	* add in the foundation clearing feature.
	*
	* You can add a gallery just as you normally would including setting up the number of columns.
	* The function supports up to 6 columns for any gallery, it will fall back to 4 column grid for
	* invalid values.
	*
	* MOBILE: Note that the foundation mobile classes have already been added for each gallery size.
	*			That said you can use the filters below to alter any foundation classes applied to the
	*			block grid.
	* 
	* FILTERS:
	*			prso_found_gallery_large_class 		->	Foundation large class for grid block
	*			prso_found_gallery_small_class 		->	Foundation small class for grid block
	*			prso_found_gallery_image_caption 	->	Filter caption for each image in gallery
	*			prso_found_gallery_li_class 		->	Filter class applied to each <li> item in block grid
	*			prso_found_gallery_output 			->	Filter overall html output for gallery
	* 
	*/
	public function foundation_gallery_shortcode($attr) {
	
		$post = get_post();

		static $instance = 0;
		$instance++;
	
		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}
	
		// Allow plugins/themes to override the default gallery template.
		$output = apply_filters('post_gallery', '', $attr);
		if ( $output != '' )
			return $output;
	
		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}
		
		$gallery_defaults = array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 4,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => ''
		);
		
		//Filter gallery deafults
		$gallery_defaults = apply_filters( 'prso_gallery_shortcode_args', $gallery_defaults );
		
		extract(shortcode_atts($gallery_defaults, $attr, 'gallery'));
		
		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';
	
		if ( !empty($include) ) {
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	
			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}
	
		if ( empty($attachments) )
			return '';
	
		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}
	
		$itemtag = tag_escape($itemtag);
		$captiontag = tag_escape($captiontag);
		$icontag = tag_escape($icontag);
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) )
			$itemtag = 'dl';
		if ( ! isset( $valid_tags[ $captiontag ] ) )
			$captiontag = 'dd';
		if ( ! isset( $valid_tags[ $icontag ] ) )
			$icontag = 'dt';
	
		$columns = intval($columns);
		
		//Set bloch grid class based on columns
		switch( $columns ) {
			case 1:
				$block_class = apply_filters( 'prso_found_gallery_large_class', 'large-block-grid-1', $columns ) . ' ' . apply_filters( 'prso_found_gallery_small_class', 'small-block-grid-3', $columns );
				break;
			case 2:
				$block_class = apply_filters( 'prso_found_gallery_large_class', 'large-block-grid-2', $columns ) . ' ' . apply_filters( 'prso_found_gallery_small_class', 'small-block-grid-3', $columns );
				break;
			case 3:
				$block_class = apply_filters( 'prso_found_gallery_large_class', 'large-block-grid-3', $columns ) . ' ' . apply_filters( 'prso_found_gallery_small_class', 'small-block-grid-3', $columns );
				break;
			case 4:
				$block_class = apply_filters( 'prso_found_gallery_large_class', 'large-block-grid-4', $columns ) . ' ' . apply_filters( 'prso_found_gallery_small_class', 'small-block-grid-3', $columns );
				break;
			case 5:
				$block_class = apply_filters( 'prso_found_gallery_large_class', 'large-block-grid-5', $columns ) . ' ' . apply_filters( 'prso_found_gallery_small_class', 'small-block-grid-3', $columns );
				break;
			case 6:
				$block_class = apply_filters( 'prso_found_gallery_large_class', 'large-block-grid-6', $columns ) . ' ' . apply_filters( 'prso_found_gallery_small_class', 'small-block-grid-3', $columns );
				break;
			default:
				$block_class = apply_filters( 'prso_found_gallery_large_class', 'large-block-grid-4', 'default' ) . ' ' . apply_filters( 'prso_found_gallery_small_class', 'small-block-grid-3', 'default' );
				break;
		}
		
		$gallery_container = "<div class='row'><div class='large-12 columns'><ul class='clearing-thumbs gallery galleryid-{$id} {$block_class}' data-clearing>";
		
		$output = apply_filters( 'gallery_style', $gallery_container );
	
		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
				$image_output = wp_get_attachment_link( $id, $size, false, false );
			elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
				$image_output = wp_get_attachment_image( $id, $size, false );
			else
				$image_output = wp_get_attachment_link( $id, $size, true, false );
				
			$image_output = wp_get_attachment_link( $id, $size, false, false );	
			
			$image_meta  = wp_get_attachment_metadata( $id );
			
			//Cache image caption
			$caption_text = NULL;
			if ( trim($attachment->post_excerpt) ) {
				$caption_text = wptexturize($attachment->post_excerpt);
				$caption_text = apply_filters( 'prso_found_gallery_image_caption', $caption_text, $attachment );
			}
			
			//Add caption to img tag
			$image_output = str_replace('<img', "<img data-caption='{$caption_text}'", $image_output);
			
			ob_start();
			?>
			<li class="<?php echo apply_filters( 'prso_found_gallery_li_class', $columns, $attachment ); ?>">
				<?php echo $image_output; ?>
			</li>
			<?php
			$output.= ob_get_contents();
			ob_end_clean();
			
		}
	
		$output .= "</ul></div></div>";
		
		return apply_filters( 'prso_found_gallery_output',$output, $columns, $attachment );
	}
	
}



