<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/admin/settings
 * @author     Gian MR <g14nblog@gmail.com>
 */
class Ktzagcplugin_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $ktzagcplugin    The ID of this plugin.
	 */
	private $ktzagcplugin;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The snake cased version of plugin ID for making hook tags.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $ktzagcplugin    The ID of this plugin.
	 */
	private $snake_cased_ktzagcplugin;

	/**
	 * The array of plugin settings.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array     $registered_settings    The array of plugin settings.
	 */
	private $registered_settings;

	/**
	 * The callback helper to render HTML elements for settings forms.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ktzagcplugin_Callback_Helper    $callback    Render HTML elements.
	 */
	protected $callback;

	/**
	 * The sanitization helper to sanitize and validate settings.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ktzagcplugin_Sanitization_Helper    $sanitization    Sanitize and validate settings.
	 */
	protected $sanitization;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 	1.0.0
	 * @param 	string    							$ktzagcplugin 			The name of this plugin.
	 * @param 	Ktzagcplugin_Callback_Helper 		$settings_callback 		The callback helper for rendering HTML markups
	 * @param 	Ktzagcplugin_Sanitization_Helper 	$settings_sanitization 	The sanitization helper for sanitizing settings
	 */
	public function __construct( $ktzagcplugin, $settings_callback, $settings_sanitization ) {

		$this->ktzagcplugin = $ktzagcplugin;
		$this->snake_cased_ktzagcplugin = $this->sanitize_snake_cased( $ktzagcplugin );

		$this->callback = $settings_callback;

		$this->sanitization = $settings_sanitization;

		$this->registered_settings = Ktzagcplugin_Settings_Definition::get_settings();
	}

	/**
	 * Sanitize a string key.
	 *
	 * Lowercase alphanumeric characters and underscores are allowed.
	 * Uppercase characters will be converted to lowercase.
	 * Dashes characters will be converted to underscores.
	 *
	 * @access   private
	 * @param  string 	$key 	String key
	 * @return string 	     	Sanitized snake cased key
	 */
	private function sanitize_snake_cased( $key ) {

		return str_replace( '-', '_', sanitize_key( $key ) );

	}

	/**
	 * Register all settings sections and fields.
	 *
	 * @since 	1.0.0
	 * @return 	void
	*/
	public function register_settings() {

		if ( false == get_option( $this->snake_cased_ktzagcplugin . '_settings' ) ) {
			add_option( $this->snake_cased_ktzagcplugin . '_settings', array(), '', 'yes' );
		}

		foreach( $this->registered_settings as $tab => $settings ) {

			// add_settings_section( $id, $title, $callback, $page )
			add_settings_section(
				$this->snake_cased_ktzagcplugin . '_settings_' . $tab,
				__return_null(),
				'__return_false',
				$this->snake_cased_ktzagcplugin . '_settings_' . $tab
				);

			foreach ( $settings as $key => $option ) {

				$_name = isset( $option['name'] ) ? $option['name'] : $key;

				// add_settings_field( $id, $title, $callback, $page, $section, $args )
				add_settings_field(
					$this->snake_cased_ktzagcplugin . '_settings[' . $key . ']',
					$_name,
					method_exists( $this->callback, $option['type'] . '_callback' ) ? array( $this->callback, $option['type'] . '_callback' ) : array( $this->callback, 'missing_callback' ),
					$this->snake_cased_ktzagcplugin . '_settings_' . $tab,
					$this->snake_cased_ktzagcplugin . '_settings_' . $tab,
					array(
						'id'      => $key,
						'desc'    => !empty( $option['desc'] ) ? $option['desc'] : '',
						'name'    => $_name,
						'section' => $tab,
						'size'    => isset( $option['size'] ) ? $option['size'] : 'regular',
						'options' => isset( $option['options'] ) ? $option['options'] : '',
						'std'     => isset( $option['std'] ) ? $option['std'] : '',
						'max'    => isset( $option['max'] ) ? $option['max'] : 999999,
						'min'    => isset( $option['min'] ) ? $option['min'] : 0,
						'step'   => isset( $option['step'] ) ? $option['step'] : 1,
						)
					);
			} // end foreach

		} // end foreach

		// Creates our settings in the options table
		register_setting( $this->snake_cased_ktzagcplugin . '_settings', $this->snake_cased_ktzagcplugin . '_settings', array( $this->sanitization, 'settings_sanitize' ) );

	}
}