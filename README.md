# Quilt

Yet another WordPress Settings API wrapper. [Why](http://zanematthew.com/a-wordpress-settings-api-wrapper/)?

# Description

This library provides a simplified way to interact with the [overly verbose](http://codex.wordpress.org/images/7/7e/editing-settings-api-example.png) WordPress [settings API](http://codex.wordpress.org/Settings_API) via an array.

This will handle;

1. Form submission.
1. Admin notices.
1. Display settings as a single page or tab interface.
1. Sanitizing.
1. Tabbed based settings, or single page based settings.


# Supported Fields

Quilt allows you to easily create the following WordPress admin settings field types.

* button
* canadaStateSelect
* checkbox
* checkboxes
* email
* fancyText
* fancySelect
* fieldset
* hidden
* html
* license
* multiselect
* mexicoStateSelect
* number
* radio
* roleToPage
* section
* select
* text
* textDisabled
* textarea
* css
* emails
* ips
* thickbox
* touchtime
* url
* upload
* usStateSelect

*Each field is sanitized accordingly using the WordPress settings API with custom sanitize callbacks.*

# Usage

**Full working example**

1. Download the [zip](https://github.com/zanematthew/quilt-sample-plugin/archive/master.zip) file from the [Quilt Sample Plugin](https://github.com/zanematthew/quilt-sample-plugin) repository.
2. Install the plugin.
4. Under "Settings" see the sub-menu link named "Quilt Plugin", click that.

## Usage -- A single form field

A single form field entry can consists of:

```
$field = array(
    'id'          => HTML ID
    'title'       => HTML Label
    'type'        => HTML field type
    'value'       => Value to set
    'std'         => The default value
    'placeholder' => HTML Placeholder
    'options'     => An array of options
    )
```

At minimum an entry only needs type, and title.

```
array(
    'title' => HTML Label
    'type'  => HTML field type
    )
```


## Usage -- A full example

1. Require the two classes
2. Call the class
3. Assign your settings

This is a full working example.

1. Create a folder in your `wp-content/plugins/` directory
2. Create a PHP file.
3. Copy/paste the below code into that file
4. Verify that you have the correct path for the additional files
5. Activate the plugin
6. Under "Settings" see the sub-menu link named "Quilt Plugin", click that.

```
/**
 * You can obtain the classes here:
 *      https://github.com/zanematthew/lumber
 *      https://github.com/zanematthew/quilt
 */
require plugin_dir_path( __FILE__ ) . 'lib/lumber/lumber.php';
require plugin_dir_path( __FILE__ ) . 'lib/quilt/quilt.php';


/**
 * This is best set as a constant. We will use it later.
 * Filters are derived from this.
 */
define( 'MY_SAMPLE_NAMESPACE', 'quilt_plugin' );


/**
 * This function shows an example of settings as a single page (not tabbed).
 * The settings are defined in the $settings array.
 */
function quilt_plugin_init(){


    // You define settings here. Refer to above for each field "type".
    $settings = array(
        'default_field_types' => array(
            'title' => 'Default Fields Types',
            'fields' => array(
                array(
                    'title' => 'Sample Text',
                    'type' => 'text'
                    ),
                array(
                    'title' => 'Sample FancyText',
                    'type' => 'fancyText',
                    'desc' => 'Any "fancy" field type has a description with it.'
                    ),
                array(
                    'title' => 'Sample Email',
                    'type' => 'email',
                    'desc' => 'Only allow a single email.',
                    'std' => get_option( 'admin_email' )
                    ),
                array(
                    'title' => 'Sample Number',
                    'type' => 'number',
                    'desc' => 'Only allow a single number, also shows usage of placeholder.',
                    'placeholder' => 'Enter a number'
                    ),
                array(
                    'title' => 'Sample Hidden',
                    'type' => 'hidden',
                    'desc' => 'Yes, its hidden, sometimes this is good for passing values between JS.'
                    ),
                array(
                    'title' => 'Sample URL',
                    'type' => 'url',
                    'desc' => 'Only a valid URL.'
                    ),
                array(
                    'title' => 'Sample Button',
                    'type' => 'button',
                    'desc' => 'A button.',
                    'std' => 'Button'
                    ),
                array(
                    'title' => 'Sample TextDisabled',
                    'type' => 'textDisabled',
                    'desc' => 'This text is disabled.',
                    'std' => 'You cannot edit this.'
                    ),
                array(
                    'title' => 'Sample Checkbox',
                    'type' => 'checkbox',
                    'desc' => ''
                    ),
                array(
                    'title' => 'Sample Group of Checkboxes',
                    'type' => 'checkboxes',
                    'desc' => 'Choose a transportation type.',
                    'options' => array(
                        'car' => 'Car',
                        'bike' => 'Bike'
                        )
                    ),
                array(
                    'title' => 'Sample Radio',
                    'type' => 'radio',
                    'desc' => 'Yes, or no.',
                    'options' => array(
                        'yes' => 'Yes',
                        'no' => 'No'
                        )
                    ),
                array(
                    'title' => 'Sample Select',
                    'type' => 'select',
                    'options' => array(
                        'maybe' => 'Maybe',
                        'yes' => 'Yes',
                        'no' => 'No'
                        )
                    ),
                array(
                    'title' => 'Sample FancySelect',
                    'type' => 'fancySelect',
                    'desc' => 'Which one?',
                    'options' => array(
                        'maybe' => 'Maybe',
                        'yes' => 'Yes',
                        'no' => 'No'
                        )
                    ),
                array(
                    'title' => 'Sample Multiselect',
                    'type' => 'multiselect',
                    'desc' => 'A multi-select',
                    'options' => array(
                        'maybe' => 'Maybe',
                        'yes' => 'Yes',
                        'no' => 'No'
                        )
                    ),
                array(
                    'title' => 'Sample UsStateSelect',
                    'type' => 'usStateSelect',
                    'desc' => 'No options are needed.'
                    ),
                array(
                    'title' => 'Sample MexicoStateSelect',
                    'type' => 'mexicoStateSelect',
                    'desc' => 'No options are needed.'
                    ),
                array(
                    'title' => 'Sample CanadaStateSelect',
                    'type' => 'canadaStateSelect',
                    'desc' => 'No options are needed.'
                    ),
                array(
                    'title' => 'Sample Textarea',
                    'type' => 'textarea'
                    ),
                array(
                    'title' => 'Sample CSS',
                    'type' => 'css',
                    'desc' => 'Allow for only CSS (sanitized with wp_kses).'
                    ),
                array(
                    'title' => 'Sample Emails',
                    'type' => 'emails',
                    'desc' => 'Allow for only emails. Enter each email on a new line.',
                    'placeholder' => 'Enter each email on a new line.'
                    ),
                array(
                    'title' => 'Sample Ips',
                    'type' => 'ips',
                    'desc' => 'Allow for only emails. Enter each email on a new line.',
                    'placeholder' => 'Enter each email on a new line.'
                    ),
                array(
                    'title' => 'Sample Upload',
                    'type' => 'upload',
                    'desc' => 'A WordPress upload field'
                    ),
                array(
                    'title' => 'Sample HTML',
                    'type' => 'html',
                    'desc' => 'Any HTML you want',
                    'std' => '<div>This is my <strong>custom</strong> HTML.</div>'
                    ),
                array(
                    'title' => 'Sample Thickbox',
                    'type' => 'thickbox',
                    'desc' => 'Yes, a thickbox. Via WordPress native Thickbox. Currently ONLY supports iFrame.',
                    'std' => 'http://zanematthew.com/',
                    'placeholder' => 'View Entries'
                    ),
                array(
                    'title' => 'Sample Touchtime',
                    'type' => 'touchtime',
                    'desc' => 'Another built in WordPress type.'
                    ),
                array(
                    'title' => 'Sample RoleToPage',
                    'type' => 'roleToPage',
                    'desc' => '',
                    'options' => array(
                        'administrator' => 'Administrator',
                        'editor' => 'Editor',
                        'author' => 'Author',
                        'contributor' => 'Contributor',
                        'subscriber' => 'Subscriber'
                        )
                    )
                )
        )
    );


    // Instantiate the class
    $quilt_plugin = new Quilt(
        MY_SAMPLE_NAMESPACE,
        $settings,
        'plugin'
    );

    // Set our global used to retrieve settings
    global $quilt_plugin_settings;

    // Assign the option. This allows us to use the standard option
    // values WITHOUT having to set any options in the database.
    $quilt_plugin_settings = $quilt_plugin->getSaneOptions();

}
add_action( 'init', 'quilt_plugin_init' );
```

## Usage – Retrieving the Settings

You can retrieve your settings via the `get_options()` method, and assign this to a global variable.

```
$my_settigns_obj = Quilt();

global $my_settings;
echo $my_settings_obj->get_options( 'some_text_field' );
```

# Uninstall Settings

Do it the [WordPress way](http://codex.wordpress.org/Function_Reference/register_uninstall_hook#uninstall.php).

# Hooks

All **filters** and **actions** are dynamically create via your namespace using the following format. Filters are listed below.

```
apply_filters( 'quilt_{$my_namespace}_settings' );
apply_filters( 'quilt_{$my_namespace}_admin_menu' );
apply_filters( 'quilt_{$my_namespace}_below_tabs' );
apply_filters( 'quilt_{$my_namespace}_below_title' );
apply_filters( 'quilt_{$my_namespace}_footer' );
apply_filters( 'quilt_{$my_namespace}_all_default_options' );
apply_filters( 'quilt_{$my_namespace}_get_option' );
apply_filters( 'quilt_{$my_namespace}_get_setting_{$key}' );
apply_filters( 'quilt_{$my_namespace}_sanitize_{$type}' );
apply_filters( 'quilt_{$my_namespace}_sanitize_{$key}' );
apply_filters( 'quilt_{$my_namespace}_sanitize_{$field_id}' );
apply_filters( 'quilt_{$my_namespace}_admin_styles' );
apply_filters( 'quilt_{$my_namespace}_admin_style' );
apply_filters( 'quilt_{$my_namespace}_admin_script' );
apply_filters( 'quilt_{$my_namespace}_default_tab' );
apply_filters( 'quilt_{$my_namespace}_page_title' );
apply_filters( 'quilt_{$my_namespace}_menu_title' );

do_action( 'quilt_{$my_namespace}_above_form' );
do_action( 'quilt_{$my_namespace}_after_left_buttons' );
```

**Sample Filter usage**

```
// Note 'my_plugin' matches the namespace passed into the Quilt class.
function my_plugin_change_footer( $text ){

    return 'My custom footer';

}
add_filter( 'quilt_my_plugin_footer', 'my_plugin_change_footer' );
```

---

*At its core Quilt handles interacting with the WordPress settings API; assigning the sections, registering settings, setting [sane options](https://make.wordpress.org/themes/2014/07/09/using-sane-defaults-in-themes/), and sanitizing. It actually does not create form fields. Lumber does that.*
