# Description

This library provides a simplified way to interact with the [overly verbose](http://codex.wordpress.org/images/7/7e/editing-settings-api-example.png) [WordPress settings API](http://codex.wordpress.org/Settings_API) via an array.

This will handle;

1. Form submission
1. Admin notices
1. Dynamically generate actions and filters
1. Display settings as a single page or tab interface
1. Determine to display settings as "theme options" or as plugin "settings"
1. Visit your WordPress admin


# Usage

1. Download the following PHP files:
1. Place them in `lib/`
1. Require them in your code
1. Set the defines

get_template_directory_uri()

You can copy paste the following and place it in your `functions.php`, or in a plugin file. Note
you must require the needed php files.

A simplified version:

```
define( 'PRODUCT_URL', plugin_dir_url( __FILE__ ) );
define( 'PRODUCT_PATH', plugin_dir_path( __FILE__ ) );
define( 'PRODUCT_NAMESPACE', 'foo' );


require PRODUCT_PATH . '/lib/zm-form-fields/zm-form-fields.php';
require PRODUCT_PATH . '/lib/zm-settings/zm-settings.php';


function my_function_setup(){

    global $my_settings_obj;
    $my_settings_obj = new ZM_Settings(
        PRODUCT_NAMESPACE,
        array(
            'foo' => array(
                'title' => 'Foo',
                'fields' => array(
                    array(
                        'id' => 'foo_header',
                        'title' => 'My Header',
                        'type' => 'header'
                        ),
                    array(
                        'id' => 'foo_usage',
                        'title' => 'Usage',
                        'type' => 'desc',
                        'desc' => 'A description.'
                        ),
                    array(
                        'id' => 'some_text_field',
                        'title' => 'Text Field',
                        'type' => 'text'
                        )
                )
            )
        ),
        'theme',
        array(
            'dir_url_form_fields' => PRODUCT_URL . '/lib/zm-form-fields/'
        )
    );

    global $my_product_settings;
}
add_action( 'init', 'my_function_setup' );
```

A verbose version:
```
/**
 * You can use `get_template_directory()` if this is being used inside of a theme
 */
define( 'PRODUCT_URL', plugin_dir_url( __FILE__ ) );
define( 'PRODUCT_PATH', plugin_dir_path( __FILE__ ) );
define( 'PRODUCT_NAMESPACE', 'foo' );

require PRODUCT_PATH . '/lib/zm-form-fields/zm-form-fields.php';
require PRODUCT_PATH . '/lib/zm-settings/zm-settings.php';

function my_function_setup(){

    /**
     * All settings will be saved to the db in a single serialized record in
     * the *_options table.
     */
    $namespace = PRODUCT_NAMESPACE';


    /**
     * For a full list see "Supported Field Types"
     */
    $settings = array(
        'foo' => array(
            'title' => 'Foo',
            'fields' => array(
                array(
                    'id' => 'foo_header',
                    'title' => 'My Header',
                    'type' => 'header'
                    ),
                array(
                    'id' => 'foo_usage',
                    'title' => 'Usage',
                    'type' => 'desc',
                    'desc' => 'A description.'
                    ),
                array(
                    'id' => 'some_text_field',
                    'title' => 'Text Field',
                    'type' => 'text'
                    )
            )
        )
    );


    /**
     * Allowed: 'plugin', 'theme'.
     * 'plugin', will show the options as a sub-menu in
     * 'General Settings'.
     * 'theme', will show the options as a sub-menu in 'Appearances'
     */
    $type = 'theme';


    /**
     * Specify the URL for loading needed form field CSS and JS.
     */
    $paths = array(
        'dir_url_form_fields' => PRODUCT_URL . '/lib/zm-form-fields/'
    );


    global $my_settings_obj;
    $my_settings_obj = new ZM_Settings(
        $namespace,
        $settings,
        $type,
        $paths
    );


    /**
     * You can retrieve the setting via the method `get_options()`, note you can
     * also retrieve the unfiltered setting via `get_options( PRODUCT_NAMESPACE )`
     */
    global $my_product_settings;
}
add_action( 'init', 'my_function_setup' );
```


## Usage – Retrieving the Settings

You can retrieve your settings via the `get_options()` method, and assign this to a global variable.

```
$my_settigns_obj = ZM_Settings();

global $my_settings;
echo $my_settings_obj->get_options( 'some_text_field' );
```

# Sample Settings

Below is a detailed array of ALL available settings displayed as two tabs.

```
// This is an array of ALL available setting types
$settings = array(

    // General
    'usage' => array(
        'title' => 'Usage',
        'fields' => array(
            array(
                'id' => 'usage_header',
                'title' => __('Usage',
                'type' => 'header'
            ),
            array(
                'id' => 'usage_description',
                'title' => 'Description',
                'desc' => 'Thank you for using my plugin.',
                'type' => 'desc'
            ),
            array(
                'id' => 'namespace',
                'title' => 'Adding the plugin, namespace',
                'desc' => '',
                'type' => 'desc'
            ),
            array(
                'id' => 'tabs',
                'title' => 'Adding tabs',
                'desc' => '',
                'type' => 'desc'
            ),
            array(
                'id' => 'settings',
                'title' => 'Adding settings',
                'desc' => '',
                'type' => 'desc'
            ),
            array(
                'id' => 'sanitize',
                'title' => 'Sanitizing',
                'desc' => '',
                'type' => 'desc'
            ),
            array(
                'id' => '',
                'title' => 'Sanitizing per type',
                'desc' => 'sanitize per type',
                'type' => 'desc'
            ),
            array(
                'id' => 'sanitize per id',
                'title' => 'Sanitizing per id/key',
                'desc' => '',
                'type' => 'desc'
            ),
            array(
                'id' => 'hooks',
                'title' => 'Hooks',
                'desc' => '',
                'type' => 'desc'
            )
        )
    ),

    // Sample Settings
    'default_field_types' => array(
        'title' => 'Default Fields Types',
        'fields' => array(
            array(
                'id' => 'my_checkbox_id',
                'title' => 'Checkbox',
                'type' => 'checkbox',
                'desc' => 'This is my description.'
            ),
            array(
                'id' => 'my_checkboxes_id',
                'title' => 'Checkboxes',
                'type' => 'checkboxes',
                'options' => array(
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                    )
            ),
            array(
                'id' => 'my_radio_id',
                'title' => 'Radio',
                'type' => 'radio',
                'options' => array(
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                    )
            ),
            array(
                'id' => 'my_id',
                'title' => 'Text Field',
                'type' => 'text',
                'desc' => 'This is a default text field, it supports any type of value.'
            ),
            array(
                'id' => 'my_id_url',
                'title' => 'URL Field',
                'type' => 'url',
                'desc' => 'This is a URL field, type: url, sanitize: esc_url.'
            ),
            array(
                'id' => 'my_id_email',
                'title' => 'Email Field',
                'type' => 'email',
                'desc' => 'This is a email field, type: email, sanitize: sanitize_email.'
            ),
            array(
                'id' => 'my_id_hidden',
                'title' => 'Hidden Field',
                'type' => 'hidden',
                'desc' => 'This is hidden, you can\'t see it unless you view the html source.'
            ),
            array(
                'id' => 'my_textarea_id',
                'title' => 'Textarea',
                'type' => 'textarea',
                'desc' => 'Default textarea, sanitize: esc_textarea.'
            ),
            array(
                'id' => 'my_textarea_id_css',
                'title' => 'CSS Textarea',
                'type' => 'css_textarea',
                'desc' => "CSS textarea, sanitize: wp_kses( '' )."
            ),
            array(
                'id' => 'my_textarea_id_email',
                'title' => 'Email Textarea',
                'type' => 'textarea_emails',
                'desc' => "Email textarea, supports only valid emails, and forward slashed comments, i.e., '//'."
            ),
            array(
                'id' => 'my_textarea_id_ips',
                'title' => 'IP Textarea',
                'type' => 'textarea_ip',
                'desc' => "IP textarea, supports only valid IP address, sanitize: sanitize_ip)."
            ),
            array(
                'id' => 'any_id',
                'title' => 'Select',
                'type' => 'select',
                'desc' => '<p>This is a sample select, with options. The options are passed in using the <code>options</code> key, with an assigned array like the following; <code>array( [0] =>"", [2] => Sample Page )</code></p>',
                'options' => array(
                        1 => 'Option 1',
                        2 => 'Option 2'
                )
            ),
            array(
                'id' => 'sample_multiselect',
                'title' => 'Multi-select',
                'type' => 'multiselect',
                'options' => array(
                        1 => 'Option 1',
                        2 => 'Option 2'
                    )
            ),
            array(
                'id' => 'some_state',
                'title' => 'US State Select',
                'type' => 'us_state_select'
            ),
            array(
                'id' => 'my_image',
                'title' => 'Upload',
                'type' => 'upload'
            ),
            array(
                'id' => 'my_thinkbox_url',
                'title' => 'Thickbox',
                'type' => 'thickbox_url',
                'std' => 'http://zanematthew.com/',
                'placeholder' => 'View Entries',
                ),
            array(
                'id' => 'my_touch_time',
                'title' => 'Date Time',
                'type' => 'touchtime',
                )
        )
    )
);
```

# Sanitizing

```
function product_custom_sanitize( $input ){

    // Do something with $input

    // Display a message if needed
    if ( isset( $error['message'] ) && isset( $error['type'] ) ){
        add_settings_error(
            PRODUCT_NAMESPACE,
            'gitlab_enabled',
            $error['message'],
            $error['type']
        );
    }

    return $input;

}
add_filter( PRODUCT_NAMESPACE . '_sanitize_my_field', 'product_custom_sanitize' );
```

# Supported Field Types

The currently supported field types (settings types) are:

* header – An arbitrary header normally used to define a section
* desc – An arbitrary description normally used after a header
* checkbox – A single checkbox
* checkboxes – A collection of checkboxes
* radio – A single radio box
* radio boxes – A collection of radio boxes
* text – A simple text field
* url – An HTML5 URL field
* email – A text field which sanitizes emails
* hidden – A hidden text field
* textarea – A textarea
* css_textarea – An advanced textarea which only allows CSS
* textarea_emails – An advanced textarea which only saves emails on a new line and forward slashed comments
* textarea_ip – An advanced textarea which only saves IP address on a new line and forward slashed comments
* select – A single select box
* multiselect – A multiselect box
* us_state_select – A select box pre-populate with US states
* upload – An upload field, which uses the WP Media Library
* thickbox_url – A url (internal or external), which displays content using WordPress' "thickbox"
* touchtime – tbd
* html – An arbitrary field which displays any HTML you've added

*Note: All fields are sanitized accordingly.*

# Uninstall Settings

In order to have your plugin remove settings/options during plugin uninstall simply create an `uninstall.php` script, and follow the official [WordPress](http://codex.wordpress.org/Function_Reference/register_uninstall_hook#uninstall.php) `uninstall.php` way of removing settings/options.