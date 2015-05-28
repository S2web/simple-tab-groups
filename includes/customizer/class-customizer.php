<?php
/**
 * Simple Tab Groups.
 *
 * @package   S2_Tab_Customizer
 * @author    Steven Slack <steven@s2webpress.com>
 * @license   GPL-2.0+
 * @link      http://s2webpress.com
 * @copyright 2013 S2 Web LLC
 */


/**
 * S2_Tab_Customizer. This class handles the style of the tabs using the theme customizer.
 *
 * @package S2_Tab_Customizer
 * @author  Steven Slack <steven@s2webpress.com>
 */


class S2_Tab_Customizer {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Register the theme customizer and theme customizer preview scripts and styles
	 *
	 * @since     1.0.0
	 */
	private function __construct() {


		$plugin = S2_Tab_Groups::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		
		// register the customizer function
	    add_action( 'customize_register', array( $this, 's2_tab_color_custom' ), 50 );

		add_action( 'customize_preview_init', array( $this, 's2_tab_customizer_preview_js' ) );

		add_action( 'wp_head', array( $this, 's2_tab_customizer_styles') );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	/**
	 * Custom Tab Colors and styles using the Wordpress Customizer
	 */
	public function s2_tab_color_custom( $wp_customize ) {
		
	    $wp_customize->add_section(
	        's2_tab_styles',
	        array(
	            'title' 			=> __( 'Tab Styles', $this->plugin_slug ),
	            'description' 		=> __( 'Change the color and settings of your tabs to match your theme.', $this->plugin_slug ),
	            'priority' 			=> 300,
	        )
	    );
		
		// Tab Background Color
	    $wp_customize->add_setting(
	        's2_tab_styles[tab_bg]',
	        array(
				'default'              => '#f1f1f1',
				'type'                 => 'option',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
	        )
	    );
 
	    $wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            's2_tab_styles[tab_bg]',
	            array(
	                'label'      => __( 'Tab Background', $this->plugin_slug ),
	                'section'    => 's2_tab_styles',
	                'priority' 	 => 0,
	            )
	        )
	    );
		
		// Tab text color																														
	    $wp_customize->add_setting(
	        's2_tab_styles[tab_color]',
	        array(
				'default'              => '#A5A5A5',
				'type'                 => 'option',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
	        )
	    );
 
	    $wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            's2_tab_styles[tab_color]',
	            array(
	                'label'      => __( 'Tab text color', $this->plugin_slug ),
	                'section'    => 's2_tab_styles',
	                'priority' 	 => 1,
	            )
	        )
	    );
		
		// Tab active state background color
	    $wp_customize->add_setting(
	        's2_tab_styles[tab_active]',
	        array(
				'default'              => '#DBDBDB',
				'type'                 => 'option',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
	        )
	    );
 
	    $wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            's2_tab_styles[tab_active]',
	            array(
	                'label'      => __( 'Active tab background', $this->plugin_slug ),
	                'section'    => 's2_tab_styles',
	                'priority' 	 => 2,
	            )
	        )
	    );
		
		// Tab active state text color
	    $wp_customize->add_setting(
	        's2_tab_styles[tab_active_color]',
	        array(
				'default'              => '#6D6D6D',
				'type'                 => 'option',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
	        )
	    );
 
	    $wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            's2_tab_styles[tab_active_color]',
	            array(
	                'label'      => __( 'Active tab text color', $this->plugin_slug ),
	                'section'    => 's2_tab_styles',
	                'priority' 	 => 3,
	            )
	        )
	    );
		
		// Tab hover state background color
	    $wp_customize->add_setting(
	        's2_tab_styles[tab_hover_bg]',
	        array(
				'default'              => '#CFCFCF',
				'type'                 => 'option',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
	        )
	    );
 
	    $wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            's2_tab_styles[tab_hover_bg]',
	            array(
	                'label'      => __( 'Tab hover background', $this->plugin_slug ),
	                'section'    => 's2_tab_styles',
	                'priority' 	 => 4,
	            )
	        )
	    );
		
		// Tab hover state text color
	    $wp_customize->add_setting(
	        's2_tab_styles[tab_hover_color]',
	        array(
				'default'              => '#4D4D4D',
				'type'                 => 'option',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
	        )
	    );
 
	    $wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            's2_tab_styles[tab_hover_color]',
	            array(
	                'label'      => __( 'Tab hover text color', $this->plugin_slug ),
	                'section'    => 's2_tab_styles',
	                'priority' 	 => 5,
	            )
	        )
	    );
		
		// Tab content background color
	    $wp_customize->add_setting(
	        's2_tab_styles[tab_content_bg]',
	        array(
				'default'              => '',
				'type'                 => 'option',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
	        )
	    );
 
	    $wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            's2_tab_styles[tab_content_bg]',
	            array(
	                'label'      => __( 'Tab content background color', $this->plugin_slug ),
	                'section'    => 's2_tab_styles',
	                'priority' 	 => 6,
	            )
	        )
	    );
		
		// Tab Content text color
	    $wp_customize->add_setting(
	        's2_tab_styles[tab_content_color]',
	        array(
				'default'              => '',
				'type'                 => 'option',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
	        )
	    );
 
	    $wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            's2_tab_styles[tab_content_color]',
	            array(
	                'label'      => __( 'Tab content text color', $this->plugin_slug ),
	                'section'    => 's2_tab_styles',
	                'priority' 	 => 7,
	            )
	        )
	    );

	    // Tab Content border color
	    $wp_customize->add_setting(
	        's2_tab_styles[tab_content_border_color]',
	        array(
				'default'              => '#f1f1f1',
				'type'                 => 'option',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage'
	        )
	    );
 
 		
	    $wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            's2_tab_styles[tab_content_border_color]',
	            array(
	                'label'      => __( 'Tab content area border color', $this->plugin_slug ),
	                'section'    => 's2_tab_styles',
	                'priority' 	 => 8,
	            )
	        )
	    );

	} // end s2_tab_color_custom


	/**
	 * [s2_tab_customizer_styles description]
	 * @return styles in the header using wp_head
	 */
	public function s2_tab_customizer_styles() {

		global $post;

		// get the options for the tab styles. This method is used instead of the theme_mod because we are 
		// using this in a plugin.
		$tab_styles = get_option( 's2_tab_styles' );

	    ?>
	    <style type="text/css" id="custom-tab-styles">
	        .s2-tab-groups .s2-tab-nav li a { 
	        	<?php if ( ! empty ( $tab_styles['tab_bg'] ) ) {
	        		echo 'background-color: #' . $tab_styles['tab_bg'] . ';'; 
	        	}
	        	if ( ! empty ( $tab_styles['tab_color'] ) ) {
	        		echo 'color: #' . $tab_styles['tab_color'] . ';';
	        	}
			    
	        	?>
	        }
	        .s2-tab-groups .s2-tab-nav li.active a {
	        	<?php if ( ! empty ( $tab_styles['tab_active'] ) ) {
	        		echo 'background-color: #' . $tab_styles['tab_active'] . ';'; 
	        	}
	        	if ( ! empty ( $tab_styles['tab_active_color'] ) ) {
	        		echo 'color: #' . $tab_styles['tab_active_color'] . ';';
	        	} ?>
	        }
	        .s2-tab-groups .s2-tab-nav li a:hover {
	        	<?php if ( ! empty ( $tab_styles['tab_hover_bg'] ) ) {
	        		echo 'background-color: #' . $tab_styles['tab_hover_bg'] . ';';
	        	}
	        	if ( ! empty ( $tab_styles['tab_hover_color'] ) ) {
	        		echo 'color: #' . $tab_styles['tab_hover_color'] . ';';
	        	} ?>
	        }
	        .s2-tab-groups .tab-content {
	        	<?php if ( ! empty ( $tab_styles['tab_content_bg'] ) ) {
	        		echo 'background-color: #' . $tab_styles['tab_content_bg'] . ';'; 
	        	}
	        	if ( ! empty ( $tab_styles['tab_content_color'] ) ) {
	        		echo 'color: #' . $tab_styles['tab_content_color'] . ';';
	        	}
	        	if ( ! empty ( $tab_styles['tab_content_border_color'] ) ) {
	        		echo 'border-color: #' . $tab_styles['tab_content_border_color'] . ';';
	        	}
				?>
	        }
	    </style>
	    <?php
	}

	/**
	 * [s2_tab_customizer_preview_js description]
	 * @return [type] [description]
	 */
	public function s2_tab_customizer_preview_js() {

		wp_enqueue_script( $this->plugin_slug . '-customizer-script', plugins_url( 'js/customizer.js', __FILE__ ), array( 'jquery', 'customize-preview' ), S2_Tab_Groups::VERSION, true );

	} // s2_tab_customizer_preview

}





    
