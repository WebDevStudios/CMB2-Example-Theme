<?php
/**
 * Silence is golden; exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Example theme options page powered by CMB2
 */
class CMB2_Example_Theme_Options {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'cmb2_example_theme_options';

	/**
	 * Array of metaboxes/fields
	 * @var array
	 */
	protected $option_metabox = array();

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Example Options', 'cmb2-example-theme' );

		// Set our CMB2 fields, wrap them in a filter so others can easily tap in and add their own as well.
		$this->fields = apply_filters( 'cmb2_example_theme_options', array(
			array(
				'name'    => __( 'Logo', 'cmb2-example-theme' ),
				'id'      => 'logo',
				'type'    => 'file'
			),
			array(
				'name'    => __( 'Site Width', 'cmb2-example-theme' ),
				'id'      => 'width',
				'type'    => 'text_small',
				'default' => '960'
			),
			array(
				'name'    => __( 'Background Color', 'cmb2-example-theme' ),
				'id'      => 'bg_color',
				'type'    => 'colorpicker',
				'default' => '#404040'
			),
			array(
				'name'    => __( 'Content Background Color', 'cmb2-example-theme' ),
				'id'      => 'content_bg_color',
				'type'    => 'colorpicker',
				'default' => '#ffffff'
			),
			array(
				'name'    => __( 'Sidebar Position', 'cmb2-example-theme' ),
				'id'      => 'sidebar_position',
				'type'    => 'radio',
				'default' => 'right',
				'options' => array(
					'left'  => __( 'Left', 'cmb2-example-theme' ),
					'right' => __( 'Right', 'cmb2-example-theme' ),
				)
			),
			array(
				'name'    => __( 'Footer Widget Areas', 'cmb2-example-theme' ),
				'id'      => 'footer_widget_areas',
				'type'    => 'radio',
				'default' => 'two',
				'options' => array(
					0 => __( 'None', 'cmb2-example-theme' ),
					1 => __( 'One', 'cmb2-example-theme' ),
					2 => __( 'Two', 'cmb2-example-theme' ),
					3 => __( 'Three', 'cmb2-example-theme' ),
					4 => __( 'Four', 'cmb2-example-theme' ),
				)
			),
		) );
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
	}

	/**
	 * Register our setting to WP
	 * @since  1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_theme_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2_example_theme_options_page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->option_metabox(), $this->key ); ?>
		</div>
		<?php
	}

	/**
	 * Defines the theme option metabox and field configuration
	 * @since  1.0
	 * @return array
	 */
	public function option_metabox() {
		return array(
			'id'         => 'option_metabox',
			'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
			'show_names' => true,
			'fields'     => $this->fields,
		);
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'fields', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		if ( 'option_metabox' === $field ) {
			return $this->option_metabox();
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

$cmb2_example_theme_options = new CMB2_Example_Theme_Options();
$cmb2_example_theme_options->hooks();

/**
 * Wrapper function around cmb2_get_option
 * @since  1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function cmb2_example_theme_get_option( $key = '' ) {
	global $cmb2_example_theme_options;

	if( function_exists( 'cmb2_get_option' ) ) {
		return cmb2_get_option( $cmb2_example_theme_options->key, $key );
	} else {
		$options = get_option( $cmb2_example_theme_options->key );
		return isset( $options[ $key ] ) ? $options[ $key ] : false;
	}

}