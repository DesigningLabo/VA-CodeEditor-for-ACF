<?php
defined('ABSPATH') or die();

if ( class_exists( 'acf_field' ) AND ! class_exists( 'acf_field_cm_htmlmode' ) ) :
class acf_field_cm_htmlmode extends acf_field {
	private $version     = '';
	private $vacmacf_url = '';

	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/

	function __construct() {
		// set data
		$this->version = VACMACF_VARSION;
		$this->vacmacf_url = VACMACF_URL;
		// vars
		$this->name     = 'va_cm_htmleditor';
		$this->label    = __("Html Editor",'acf');
		$this->category = __("VisuAlive",'acf');
		$this->defaults = array(
			'default_value' => '',
			'formatting'    => 'br',
			'maxlength'     => '',
			'placeholder'   => '',
		);

		// do not delete!
		parent::__construct();

		// JS and CSS load
		add_action( 'acf/input/admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );
	}

	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	function create_field( $field ) {

		// vars
		$o = array( 'id', 'class', 'name', 'placeholder' );
		$e = '';


		// maxlength
		if( $field['maxlength'] !== "" )
		{
			$o[] = 'maxlength';
		}


		$e .= '<textarea rows="4"';

		foreach( $o as $k )
		{
			$e .= ' ' . $k . '="' . esc_attr( $field[ $k ] ) . '"';
		}

		$e .= '>';
		$e .= esc_textarea($field['value']);
		$e .= '</textarea>';
		$e .= '<script>';
		$e .= 'var cssEditor = CodeMirror.fromTextArea(document.getElementById("' . esc_attr( $field['id'] ) . '"), {';
		$e .= 'lineNumbers: true,';
		$e .= 'tabSize: 4,';
		$e .= 'indentUnit: 4,';
		$e .= 'indentWithTabs: true,';
		$e .= 'styleActiveLine: true,';
		$e .= 'matchBrackets: true,';
		$e .= 'autoCloseBrackets: true,';
		$e .= 'foldGutter: true,';
		$e .= 'gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],';
		$e .= 'profile: "xhtml",';
		$e .= 'theme: "' . VACMACF_THEME . '",';
		$e .= 'mode: "text/html"';
		$e .= '});';
		$e .= '</script>';

		// return
		echo $e;
	}

	/**
	 * admin_enqueue_scripts()
	 */
	function admin_enqueue_scripts() {
		wp_enqueue_style( 'admin-va-codemirror-acf-core', $this->vacmacf_url . '/assets/js/lib/codemirror/codemirror.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'admin-va-codemirror-acf-theme', $this->vacmacf_url . '/assets/js/lib/codemirror/theme/' . VACMACF_THEME . '.css', array('admin-va-codemirror-acf-core'), $this->version, 'all' );
		wp_enqueue_style( 'admin-va-codemirror-acf-addon-foldgutter', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/fold/foldgutter.css', array('admin-va-codemirror-acf-theme'), $this->version, 'all' );
		wp_enqueue_style( 'admin-va-codemirror-acf-addon-hint', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/hint/show-hint.css', array('admin-va-codemirror-acf-theme'), $this->version, 'all' );

		wp_enqueue_script( 'admin-va-codemirror-acf-core', $this->vacmacf_url . '/assets/js/lib/codemirror/codemirror.min.js', array('jquery'), $this->version, false );

		wp_enqueue_script( 'admin-va-codemirror-acf-addon-activeline', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/selection/active-line.min.js', array('admin-va-codemirror-acf-core'), $this->version, false );
		wp_enqueue_script( 'admin-va-codemirror-acf-addon-matchbrackets', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/edit/matchbrackets.min.js', array('admin-va-codemirror-acf-core'), $this->version, false );
		wp_enqueue_script( 'admin-va-codemirror-acf-addon-closebrackets', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/edit/closebrackets.min.js', array('admin-va-codemirror-acf-core'), $this->version, false );
		wp_enqueue_script( 'admin-va-codemirror-acf-addon-emmet', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/edit/emmet.min.js', array('admin-va-codemirror-acf-core'), $this->version, false );

		wp_enqueue_script( 'admin-va-codemirror-acf-addon-foldcode', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/fold/foldcode.min.js', array('admin-va-codemirror-acf-core'), $this->version, false );
		wp_enqueue_script( 'admin-va-codemirror-acf-addon-foldgutter', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/fold/foldgutter.min.js', array('admin-va-codemirror-acf-addon-foldcode'), $this->version, false );
		wp_enqueue_script( 'admin-va-codemirror-acf-addon-brace-fold', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/fold/brace-fold.min.js', array('admin-va-codemirror-acf-addon-foldcode'), $this->version, false );
		wp_enqueue_script( 'admin-va-codemirror-acf-addon-xml-fold', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/fold/xml-fold.min.js', array('admin-va-codemirror-acf-addon-foldcode'), $this->version, false );
		wp_enqueue_script( 'admin-va-codemirror-acf-addon-comment-fold', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/fold/comment-fold.min.js', array('admin-va-codemirror-acf-addon-foldcode'), $this->version, false );

		wp_enqueue_script( 'admin-va-codemirror-acf-addon-hint', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/hint/show-hint.min.js', array('admin-va-codemirror-acf-core'), $this->version, false );
		wp_enqueue_script( 'admin-va-codemirror-acf-addon-htmlhint', $this->vacmacf_url . '/assets/js/lib/codemirror/addon/hint/html-hint.min.js', array('admin-va-codemirror-acf-addon-hint'), $this->version, false );
		wp_enqueue_script( 'admin-va-codemirror-acf-mode-xml', $this->vacmacf_url . '/assets/js/lib/codemirror/mode/xml.min.js', array('admin-va-codemirror-acf-addon-jshint'), $this->version, false );
	}

	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @param	$field	- an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	function create_options( $field ) {
		// vars
		$key = $field['name'];

?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Default Value",'acf'); ?></label>
		<p><?php _e("Appears when creating a new post",'acf') ?></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'textarea',
			'name'	=>	'fields['.$key.'][default_value]',
			'value'	=>	$field['default_value'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Placeholder Text",'acf'); ?></label>
		<p><?php _e("Appears within the input",'acf') ?></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields[' .$key.'][placeholder]',
			'value'	=>	$field['placeholder'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Character Limit",'acf'); ?></label>
		<p><?php _e("Leave blank for no limit",'acf') ?></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'number',
			'name'	=>	'fields[' .$key.'][maxlength]',
			'value'	=>	$field['maxlength'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Formatting",'acf'); ?></label>
		<p><?php _e("Effects value on front end",'acf') ?></p>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'select',
			'name'	=>	'fields['.$key.'][formatting]',
			'value'	=>	$field['formatting'],
			'choices' => array(
				'none'	=>	__("No formatting",'acf'),
				'br'	=>	__("Convert new lines into &lt;br /&gt; tags",'acf'),
				'html'	=>	__("Convert HTML into tags",'acf')
			)
		));
		?>
	</td>
</tr>
		<?php
	}

	/*
	*  format_value_for_api()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	function format_value_for_api( $value, $post_id, $field ) {
		// validate type
		if( !is_string($value) )
		{
			return $value;
		}

		if( $field['formatting'] == 'none' )
		{
			$value = htmlspecialchars($value, ENT_QUOTES);
		}
		elseif( $field['formatting'] == 'html' )
		{
			//$value = html_entity_decode($value);
			//$value = nl2br($value);
		}
		elseif( $field['formatting'] == 'br' )
		{
			$value = htmlspecialchars($value, ENT_QUOTES);
			$value = nl2br($value);
		}

		return $value;
	}
}

new acf_field_cm_htmlmode();
endif;
