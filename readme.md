# Description 

This library provides a simplified way to interacte with the [overly verbose](http://codex.wordpress.org/images/7/7e/editing-settings-api-example.png) [WordPress settings API](http://codex.wordpress.org/Settings_API) via an array. 

Once you've created a settings array the class will handle form submission, admin notices, dynamically generate actions and filters, display settings as a page or tab interface, and determine to display settings as "theme options" or a site "settings" while interanlly using the WordPress settings API.

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
* us_state_select – A select box prepopulate with US states
* upload – An upload field, which uses the WP Media Library
* thickbox_url – A url (internal or external), which displays content using WordPress' "thickbox"
* touchtime – tbd
* html – An arbitrary field which displays any HTML you've added

*Note: All fields are sanitized accordingly.*

# Usage 

This library has the [ZM Form Fields](http://labs.zanematthew.com/zm/zm-form-fields) as a dependency. The dependency is designed to have the path and URL passed in via a parameter using one of the following WordPress functions: `plugin_dir_url( __FILE__ )`, `get_stylesheet_dir_uri()`, etc. 

This allows for the library to be bundled in with a theme as "theme options".

1. Instantiate the object
2. Assign the following:
   1. namespace: This is the value stored in the *_options table in the 'option_name'
   1. settings: An array of settings to derive the tabs, and form fields
   1. type: The type will determine if the submenu is added
 to the Settigns menu (plugin) or to the Appearance menu (theme)
 plugin or theme
   1. labels: Specifiy the menu title and page title
   1. paths: The `dir_url_form_fields` are needed to derive
 the URLs for the form fields dependcy


## Usage – Plugin settings

```
function my_function_setup(){   
    
    $namespace = 'my-namespace';
        
    $settings = array(
        'foo' => array(
            'title' => 'Foo',
            'fields' => array(
                array(
                    'id' => 'foo_header',
                    'title' => 'Constant Contact',
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
    
    $labels = array(
        'menu_title' => 'My Plugin Settings',
        'page_title' => 'My Plugin – An awesome plugin'
    );
    
    $type = 'plugin'; 
        
    $paths = array(
        'dir_url_form_fields' => plugin_dir_url( __FILE__ ) . 'lib/zm-form-fields/'
    );
    
    global $my_settings_obj;
    $my_settings_obj = new ZM_Settings( 
    	$namespace, 
    	$settings, 
    	$labels, 
    	$type, 
    	$paths 
    );
    
    global $my_plugin_settings;
    $my_plugin_settings = $my_settings->get_options();
}
add_action( 'init', 'my_function_setup' );
```

## Usage – Theme Options

All thats needed is to assign the `type` to be 'theme' and assign the `dir_url_form_fields` to `get_stylesheet_dir_uri()`.

## Usage – Retrieveing the Settings

You can retrieve your settings via the `get_options()` method, and assign this to a global variable.

```
$my_settigns_obj = ZM_Settings();

global $my_settings;
$my_settings = $my_settigns_obj->get_options();

echo $my_settings['some_value'];
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

        // Notifications
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










