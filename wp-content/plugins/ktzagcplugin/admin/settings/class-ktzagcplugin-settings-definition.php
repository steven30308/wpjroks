<?php
/**
 *
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/includes
 */

/**
 * The Settings definition of the plugin.
 *
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/includes
 * @author     Gian MR <g14nblog@gmail.com>
 */
class Ktzagcplugin_Settings_Definition {

	// @TODO: change ktzagcplugin
	public static $ktzagcplugin = 'ktzagcplugin';

	/**
	 * Sanitize ktzagcplugin.
	 *
	 * Lowercase alphanumeric characters and underscores are allowed.
	 * Uppercase characters will be converted to lowercase.
	 * Dashes characters will be converted to underscores.
	 *
	 * @access    private
	 * @return    string            Sanitized snake cased plugin name
	 */
	private static function get_snake_cased_ktzagcplugin() {

		return str_replace( '-', '_', sanitize_key( self::$ktzagcplugin ) );

	}

	/**
	 * [apply_tab_slug_filters description]
	 *
	 * @param  array $default_settings [description]
	 *
	 * @return array                   [description]
	 */
	static private function apply_tab_slug_filters( $default_settings ) {

		$extended_settings[] = array();
		$extended_tabs       = self::get_tabs();

		foreach ( $extended_tabs as $tab_slug => $tab_desc ) {

			$options = isset( $default_settings[ $tab_slug ] ) ? $default_settings[ $tab_slug ] : array();

			$extended_settings[ $tab_slug ] = apply_filters( self::get_snake_cased_ktzagcplugin() . '_settings_' . $tab_slug, $options );
		}

		return $extended_settings;
	}

	/**
	 * [get_default_tab_slug description]
	 * @return [type] [description]
	 */
	static public function get_default_tab_slug() {

		return key( self::get_tabs() );
	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since    1.0.0
	 * @return    array    $tabs    Settings tabs
	 */
	static public function get_tabs() {

		$tabs                = array();
		$tabs['default_tab'] = __( 'General Settings', self::$ktzagcplugin );
		$tabs['documentation_tab']  = __( 'Documentation', self::$ktzagcplugin );

		return apply_filters( self::get_snake_cased_ktzagcplugin() . '_settings_tabs', $tabs );
	}

	/**
	 * 'Whitelisted' Ktzagcplugin settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 *
	 *
	 * @since    1.0.0
	 * @return    mixed    $value    Value saved / $default if key if not exist
	 */
	static public function get_settings() {

		$settings[] = array();

		$settings = array(
			'default_tab' => array(
			
				/*
				sangat berat dan akan terposting otomatis tanpa ada filter termasuk ping, cape deh... 
				Ane nonaktifkan saja, tolong jangan diaktifkan fitur ini lagi gaes.
			
				'ktzplg_autopost_agccontent'                   => array(
					'name' => __( 'Active auto post', self::$ktzagcplugin ),
					'desc' => __( 'If you want auto post agc results, please check this option, leave blank if you want only AGC. If you check this option, every visitor visit your single AGC, title and content will automatic save in your database. Make sure you have a lot of space for this. :D', self::$ktzagcplugin ),
					'type' => 'checkbox'
				),
				'ktzplg_autopost_category'                => array(
					'name' => __( 'Auto post (Category)', self::$ktzagcplugin ),
					'desc' => __( 'If you activated auto post featured, please select this category, all auto post will place in this category.', self::$ktzagcplugin ),
					'std'  => __( '1', self::$ktzagcplugin ),
					'type' => 'category_select'
				),
				'ktzplg_autopost_status'                      => array(
					'name'    => __( 'Auto post (Status)', self::$ktzagcplugin ),
					'desc'    => __( 'If you activated auto post featured, please select this post status, all auto post will place in this status.', self::$ktzagcplugin ),
					'options' => array(
						'draft'   => __( "Draft", self::$ktzagcplugin ),
						'publish' => __( "Publish", self::$ktzagcplugin )
					),
					'std'  => __( 'publish', self::$ktzagcplugin ),
					'type'    => 'select'
				),
				*/
				
				'ktzplg_badword'              => array(
					'name' => __( 'Badword', self::$ktzagcplugin ),
					'desc' => __( 'Fill with badword, this word will delete from agc. Please use plugin redirection if you want redirect some URL. Please separate by comma for add other badword, example: keyword1, keyword2, keyword3, dll.', self::$ktzagcplugin ),
					'std'  => __( 'http:,cache:,site:,utm_source,sex,porn,gamble,xxx,nude,squirt,gay,abortion,attack,bomb,casino,cocaine,die,death,erection,gambling,heroin,marijuana,masturbation,pedophile,penis,poker,pussy,terrorist,anal,anus,anal,anus,group sex,guro,hand job,handjob,hard core,hardcore,motherfucker,nipples,orgasm,phone sex,rape,raping,xxx,zoophilia,memek,bugil,telanjang,porno,porns,pecun,pelacur,wts', self::$ktzagcplugin ),
					'type' => 'textarea'
				),
				'ktzplg_rand_keyword'              => array(
					'name' => __( 'Keyword', self::$ktzagcplugin ),
					'desc' => __( 'Fill with keyword, this keyword will display random in widget random keyword. This will display random in that widget, if our system detect search term from search engine just like stt2 this random keyword will add new keyword, so do not worry if have new keyword in that widget. Please add keyword per line for example:<br />Keyword 1<br />Keyword 2<br />Keyword 3', self::$ktzagcplugin ),
					'type' => 'textarea'
				),
				'ktzplg_agc_content'                => array(
					'name' => __( 'AGC content(Single)', self::$ktzagcplugin ),
					'desc' => __( 'This content support shortcode, you can add shortcode from AGC Plugin, please read documentation about AGC plugin shortcode. Form more information if you bought our premium plugin, this format post will same with auto post use that campaign.', self::$ktzagcplugin ),
					'std'  => __( '[ktzagcplugin_image]<br />[ktzagcplugin_text number="4"]<br />[ktzagcplugin_video]<br />[ktzagcplugin_text source="ask" number="4"]<br />[ktzagcplugin_text source="bing" number="4" related="true"]', self::$ktzagcplugin ),
					'type' => 'rich_editor'
				),
				'ktzplg_agc_searchresults'                      => array(
					'name'    => __( 'AGC in Search Results', self::$ktzagcplugin ),
					'desc'    => __( 'Please choice AGC search results, disable it, source from google, bing or ask. If you disable this option, search results in page search will only display from your content, if you enable choice google, bing or ask, search results will generate from that search engine. Better way if you enable it, so your website, will have a lot of keyword index in search engine. Default is from google.', self::$ktzagcplugin ),
					'options' => array(
						'disable'   => __( "Disable", self::$ktzagcplugin ),
						'google' => __( "Search Results Generate From <b>Google</b>", self::$ktzagcplugin ),
						'bing' => __( "Search Results Generate From <b>Bing</b>", self::$ktzagcplugin ),
						'ask'     => __( "Search Results Generate From <b>Ask</b>", self::$ktzagcplugin )
					),
					'std'    => 'google',
					'type'    => 'radio'
				),
				'ktzplg_curl_proxy'                => array(
					'name' => __( 'Proxy', self::$ktzagcplugin ),
					'desc' => __( 'With some reason maybe you need proxy for grab AGC, you can fill here with format: IPproxy:port for example: 127.0.0.0:80', self::$ktzagcplugin ),
					'type' => 'text'
				),
			),
			'documentation_tab'  => array(
				'ktzplg_doc_saja'              => array(
					'name'    => __( 'Documentation', self::$ktzagcplugin ),
					'desc' => 'Please setting your <a href="' . admin_url( 'options-permalink.php' ) . '">permalink</a> like this screenshot: <a href="http://prntscr.com/7soan2" target="_blank">http://prntscr.com/7soan2</a> done. :D All documentation for this plugin <a href="http://www.bostheme.com/tag/ktzagcplugin/" target="_blank">available here</a><br /><h1>Important</h1>
					This plugin not work if in search page use <strong>get_permalink()</strong> change with <strong>the_permalink()</strong> or change title link in search page with<br /> 
					<strong>&lt;h2 class="entry-title"&gt;&lt;a href="&lt;?php the_permalink() ?&gt;" rel="bookmark"&gt;&lt;?php the_title() ?&gt;&lt;/a&gt;&lt;/h2&gt;</strong><br />',
					'type' => 'doc'
				),
			)
		);

		return self::apply_tab_slug_filters( $settings );
	}
}
