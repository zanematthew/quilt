# Quilt

Yet another WordPress Settings API wrapper. Why?

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

* Button
* Canada State Select
* Checkbox
* Checkboxes
* Email
* Fancy Text
* Fancy Select
* Fieldset
* Hidden
* HTML
* License
* Multi-select
* Mexico State Select
* Number
* Radio
* Role To Page
* Section
* Select
* Text
* Text Disabled
* Textarea
* Textarea CSS
* Textarea Emails
* Textarea IP addresses
* Thickbox
* Touchtime
* URL
* Upload
* US State Select

*Each field is sanitized accordingly using the WordPress settings API with custom sanitize callbacks.*

# Usage

1. Require the two classes
2. Call the class
3. Assign your settings

**Full working example**

1. Download the `quilt-plugin.zip` file.
2. Install the plugin.
4. Under "Settings" see the sub-menu link named "Quilt Plugin", click that.

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
