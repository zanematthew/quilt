<?php

Class ZM_Settings Extends ZM_Form_Fields {

    public $namespace;

    /**
     * WordPress hooks to be ran during init
     *
     * @since 1.0.0
     */
    public function __construct( $namespace, $paths ){

        $this->namespace = $namespace;
        $this->dir_url = $paths['dir_url'];

        add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
        add_action( 'admin_init', array( &$this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts') );
    }


    public function settings(){

        $settings = array(

            // General
            'usage' => array(
                'title' => __( 'Usage', $this->namespace ),
                'fields' => array(
                    array(
                        'id' => 'usage_header',
                        'title' => __('Usage', $this->namespace ),
                        'type' => 'header'
                    ),
                    array(
                        'id' => 'usage_description',
                        'title' => __( 'Description', $this->namespace ),
                        'desc' => __( 'Thank you for using zM Settings API. Each tab shows in detail how to use this API. All of the functionality this API provides is designed to be filtered using; hooks and filters. Click through each tab to see the default field types, and how to sanitize settings.
                            ', $this->namespace ),
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
                'title' => __( 'Default Fields Types', $this->namespace ),
                'fields' => array(
                    array(
                        'id' => 'my_checkbox_id',
                        'title' => __( 'Checkbox', $this->namespace ),
                        'type' => 'checkbox',
                        'desc' => 'This is my description.'
                    ),
                    array(
                        'id' => 'my_checkboxes_id',
                        'title' => __( 'Checkboxes', $this->namespace ),
                        'type' => 'checkboxes',
                        'options' => array(
                            'foo' => 'Foo',
                            'bar' => 'Bar'
                            )
                    ),
                    array(
                        'id' => 'my_radio_id',
                        'title' => __( 'Radio', $this->namespace ),
                        'type' => 'radio',
                        'options' => array(
                            'foo' => 'Foo',
                            'bar' => 'Bar'
                            )
                    ),
                    array(
                        'id' => 'my_id',
                        'title' => __( 'Text Field', $this->namespace ),
                        'type' => 'text',
                        'desc' => 'This is a default text field, it supports any type of value.'
                    ),
                    array(
                        'id' => 'my_id_url',
                        'title' => __( 'URL Field', $this->namespace ),
                        'type' => 'url',
                        'desc' => 'This is a default URL field, type: url, sanitize: esc_url.'
                    ),
                    array(
                        'id' => 'my_id_email',
                        'title' => __( 'Email Field', $this->namespace ),
                        'type' => 'email',
                        'desc' => 'This is a default email field, type: email, sanitize: sanitize_email.'
                    ),
                    array(
                        'id' => 'my_id_hidden',
                        'title' => __( 'Hidden Field', $this->namespace ),
                        'type' => 'hidden',
                        'desc' => 'This is hidden, you can\'t see it unless you view the html source.'
                    ),
                    array(
                        'id' => 'my_textarea_id',
                        'title' => __( 'Textarea', $this->namespace ),
                        'type' => 'textarea',
                        'desc' => 'Default textarea, sanitize: esc_textarea.'
                    ),
                    array(
                        'id' => 'my_textarea_id_css',
                        'title' => __( 'CSS Textarea', $this->namespace ),
                        'type' => 'css_textarea',
                        'desc' => "Default textarea, sanitize: wp_kses( '' )."
                    ),
                    array(
                        'id' => 'my_textarea_id_email',
                        'title' => __( 'Email Textarea', $this->namespace ),
                        'type' => 'textarea_emails',
                        'desc' => "Custom textarea, supports only valid emails, sanitize: wp_kses( '' )."
                    ),
                    array(
                        'id' => 'my_textarea_id_ips',
                        'title' => __( 'IP Textarea', $this->namespace ),
                        'type' => 'textarea_ip',
                        'desc' => "Custom textarea, supports only valid IP address, sanitize: sanitize_ip)."
                    ),
                    array(
                        'id' => 'any_id',
                        'title' => __( 'Select', $this->namespace ),
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

        return apply_filters( "{$this->namespace}_settings", $settings );
    }


    /**
     * This function adds all our settings sections, settings fields, and registers
     * a single setting, which holds all of our settings.
     *
     * @since 1.0.0.
     */
    public function register_settings(){

        if ( false == get_option( $this->namespace ) ) {
            add_option( $this->namespace );
        }

        // Get our current options, these are passed into our field array
        $options = $this->get_options();

        foreach( $this->settings() as $id => $section ) {

            add_settings_section(
                $this->namespace . '_' . $id, // ID
                __return_null(),              // Title
                '__return_false',             // Callback
                $this->namespace . '_' . $id  // Page
            );

            foreach ( $section['fields'] as $field ) {

                $name = isset( $field['id'] ) ? $field['id'] : '';
                $title = isset( $field['title'] ) ? $field['title'] : '';

                if ( isset( $field['id'] ) && isset( $options[ $field['id'] ] ) ){
                    $value = $options[ $field['id'] ];
                } else {
                    $value = null;
                }

                $attr = $this->get_attributes( $field );

                $temp = array(
                    'echo'        => true,
                    'id'          => isset( $field['id'] ) ? $field['id'] : null,
                    'value'       => $value,
                    'options'     => isset( $field['options'] ) ? $field['options'] : '',
                    'name'        => $this->namespace . '[' . $field['id'] . ']', // ushyee_settings[my_checkbox_id
                    'title'       => '',
                    // 'section'     => $id,
                    // 'desc'        => ! empty( $field['desc'] ) ? $field['desc'] : '',
                    // Since we don't want the extended form class to derive names, we specify our names
                    // 'size'        => isset( $field['size'] ) ? $field['size'] : null,
                    // 'std'         => isset( $field['std'] ) ? $field['std'] : '',
                    // 'placeholder' => isset( $field['placeholder'] ) ? $field['placeholder'] : '',
                    // 'field_class' => isset( $field['field_class'] ) ? $field['field_class'] : '',
                    // 'rows'        => isset( $field['rows'] ) ? $field['rows'] : ''
                ); // These are extra params based into our function/method

                $final = array_merge( $attr, $temp );

                add_settings_field(
                    $this->namespace.'[' . $field['id'] . ']', // ID
                    $title,

                    method_exists( $this, 'do_' . $field['type'] )
                        ? array( $this, 'do_' . $field['type'] )
                        : array( $this, 'missing_callback' ),

                    $this->namespace . '_' . $id, // Page
                    $this->namespace . '_' . $id, // Section
                    $final
                );
            }

        }

        // Creates our settings in the options table
        // Note this uses zm_forms, but doesn't use the zm_forms sanitize method,
        // rather it uses its own
        register_setting( $this->namespace, $this->namespace, array( &$this, 'sanitize' ) );
    }


    /**
     * Build our admin menu
     *
     * @since 1.0.0
     */
    public function admin_menu(){

        $sub_menu_pages = apply_filters( $this->namespace . '_admin_submenu', array(
            array(
                'parent_slug' => 'options-general.php',
                'page_title' => __( 'ZM Settings', $this->namespace  ),
                'menu_title' => __( 'ZM Settings', $this->namespace  ),
                'capability' => 'manage_options',
                'menu_slug' => $this->namespace,
                'function' => 'load_template'
                )
            ) );

        foreach( $sub_menu_pages as $sub_menu ){
            add_submenu_page(
                $sub_menu['parent_slug'],
                $sub_menu['page_title'],
                $sub_menu['menu_title'],
                $sub_menu['capability'],
                $sub_menu['menu_slug'],
                array( &$this, $sub_menu['function'] )
            );
        }
    }


    /**
     * Call back function which is fired when the admin menu page is loaded.
     *
     * @since 1.0.0
     */
    public function load_template(){

        $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : null; // If we wanted to we can set a current tab
        $current_tab = false;
        $tab_ids = array();

        foreach( $this->settings() as $id => $section ){
            if ( isset( $tab ) && $tab == $id ){
                $current_tab = $id;
            }
            $tab_ids[] = $id;
        }

        // If we do not have a current tab set we assign the first ID in our array of IDs
        // to be the first/active tab
        $current_tab = empty( $current_tab ) ? $tab_ids[0] : $current_tab;


        $tabs = null;
        foreach( $this->settings() as $id => $section ){
            $tab_url = add_query_arg( array(
                'settings-updated' => false,
                'tab' => $id
            ) );

            $active = $current_tab == $id ? ' nav-tab-active' : '';

            $tabs .= '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $section['title'] ) . '" class="nav-tab' . $active . '">';
            $tabs .= esc_html( $section['title'] );
            $tabs .= '</a>';
        } ?>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"><br></div>
            <h2><?php echo apply_filters( "{$this->namespace}_page_title", 'ZM Settings API' ); ?></h2>
            <form action="options.php" method="post" class="form">

                <h2 class="nav-tab-wrapper">
                    <?php echo $tabs; ?>
                </h2>
                <table class="form-table">
                    <?php settings_fields( $this->namespace ); ?>
                    <?php do_settings_fields( $this->namespace . '_' . $current_tab, $this->namespace . '_' . $current_tab ); ?>
                </table>
                <hr >

                <p class="description"><?php echo apply_filters( "{$this->namespace}_settings_footer", 'Thank you for using the ZM Settings API.' ); ?></p>

                <?php submit_button(); ?>
            </form>

        </div>
    <?php }


    /**
     * Get all settings from the *_options table
     *
     * @since 1.0.0
     * @return Settings/options
     */
    public function get_options(){

        $settings = get_option( $this->namespace, array() );

        // Return false if we have the setting, but its empty
        if ( empty( $setting ) && isset( $setting ) ){
            $settings = false;
        }
        if ( empty( $settings ) ){
            $settings = array();
        //     // Update old settings to new single setting
        //     $settings = array(
        //         'keep_me_logged_in_enabled' => ( get_option( 'ajax_login_register_keep_me_logged_in' ) == "on" ? 1 : null ),
        //         'login_redirect_legacy' => get_option( 'ajax_login_register_redirect' ),
        //         'additional_styling' => get_option( 'ajax_login_register_additional_styling' ),
        //         'form_layout' => get_option( 'ajax_login_register_default_style' ),
        //         'login_handle' => get_option( 'ajax_login_register_advanced_usage_login' ),
        //         'register_handle' => get_option( 'ajax_login_register_advanced_usage_register' ),
        //         'facebook_url' => get_option( 'url' ),
        //         'facebook_app_id' => get_option( 'app_id' )
        //         );
        //     $r = update_option( 'zm_private_site_settings', $settings );
        }
        // return apply_filters( 'zm_private_site_settings', $settings );
        return $settings;
    }


    /**
     * Get a single option value from the settings array
     *
     * @since 1.0.0
     * @param $key The option key to get, $default, the default if any
     * @return Option from database
     */
    public function get_option( $key='', $default=false ) {
        $options = $this->get_options();

        $value = ! empty( $options[ $key ] ) ? $options[ $key ] : $default;
        $value = apply_filters( "{$this->namespace}_get_option", $value, $key, $default );

        return apply_filters( "{$this->namespace}_get_setting_" . $key, $value, $key, $default );
    }


    /**
     * This is the first stop when settings are being saved.
     * Each setting is then filtered through a "type" specific filter, and then
     * an "id" specific filter.
     *
     * i.e., {$this->namespace}_{$type}_sanitize( $input ), $type=text,select,checkbox,etc.
     * i.e., {$this->namespace}_{$id}_sanitize( $input ), $id=my_custom_field,etc.
     *
     * @since 1.0.0
     */
    public function sanitize( $input=array() ){

        if ( empty( $_POST['_wp_http_referer'] ) )
            return;

        parse_str( $_POST['_wp_http_referer'], $referrer );

        $settings = $this->settings();
        $tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : null;
        $input = $input ? $input : array();
        $tmp = array();

        foreach( $settings[ $tab ]['fields'] as $field ){

            if ( ! empty( $field['id'] ) && ! empty( $input[ $field['id'] ] ) ){

                $key = $field['id'];
                $value = $input[ $field['id'] ];
                $type = $field['type'];

                if ( array_key_exists( $key, $input ) ){

                    switch( $type ) {
                        case 'select' :
                        case 'us_state' :
                        case 'textarea' :
                        case 'textarea_email_template' :
                        case 'checkbox' :
                        case 'radio' :
                        case 'touchtime':
                            $input[ $key ] = $this->sanitize_default( $value );
                            break;

                        case 'checkboxes' :
                            $input[ $key ][] = $this->sanitize_default( $value );
                            break;

                        case 'multiselect' :
                            $input[ $key ] = $this->sanitize_multiselect( $value );
                            break;

                        case 'textarea_emails' :
                            $input[ $key ] = $this->sanitize_textarea_emails( $value );
                            break;

                        case 'textarea_ip' :
                            $input[ $key ] = $this->sanitize_textarea_ip( $value );
                            break;

                        default:
                            $input[ $key ] = $this->sanitize_default( $value );
                            break;
                    }
                    $input[ $key ] = apply_filters( $this->namespace . '_sanitize_' . $type, $input[ $key ] );
                }
            }

            // sanitize by key here via filter
            $input[ $key ] = apply_filters( $this->namespace . '_sanitize_' . $key, $input[ $key ] );
        }

        // Loop through the whitelist and unset any that are empty for the tab being saved
        $options = $this->get_options();
        if ( ! empty( $settings[ $tab ] ) ) {
            foreach ( $settings[ $tab ]['fields'] as $field ) {
                $key = $field['id'];
                if ( empty( $input[ $key ] ) ) {
                    unset( $options[ $key ] );
                }
            }
        }

        // Merge our new settings with the existing
        $output = array_merge( $options, $input );

        return $output;
    }


    /**
     * Just return the input being saved, no default sanitize.
     *
     * @since 1.0.0
     */
    public function general( $input ){
        return $input;
    }


    public function missing_callback(){
        echo 'No callback';
    }


    /**
     * Renders header
     *
     * @since 1.0.0
     * @param array $args Arguments passed by the setting
     * @return void
     */
    public function do_header(){
        echo '<hr />';
    }


    /**
     * Renders description fields.
     *
     * @since 1.0.0
     * @param array $args Arguments passed by the setting
     * @return void
     */
    public function do_desc( $args ) {
        echo '<p>' . $args['desc'] . '</p>';
    }


    public function admin_enqueue_scripts(){
        $screen = get_current_screen();
        if ( $screen->id == 'settings_page_' . $this->namespace ){
            wp_enqueue_style( 'zm-settings-admin-script', $this->dir_url . 'assets/stylesheets/admin.css', '', '1.0' );
        }
    }
}