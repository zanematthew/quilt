<?php

if ( ! class_exists( 'Quilt' ) ) :
Class Quilt Extends ZM_Form_Fields {


    /**
     * Current version number
     *
     * This is used in conjunction when scripts/css are loaded, the version number is appended to
     * the end of the URL.
     *
     * @since 1.0.0
     */
    public $version = '1.0.0';


    /**
     * The type of settings/options, i.e., Plugin or Theme (note use Theme Customizer as much
     * as possible!).
     *
     * @since 1.0.0
     */
    public $type;


    /**
     * The settings array
     *
     * @since 1.0.0
     */
    public $settings;


    public $app = 'quilt';

    /**
     * WordPress hooks to be ran during init
     *
     * @since 1.0.0
     *
     * @param $namespace    (string)    The unique name space to be saved in the options table
     * @param $settings     (array)     An array of settings
     * @param $type         (bool)      Plugin or Theme, this determines to add the menu link to
     *                                  the "Appearance" menu or "Settings"
     * @param $paths        (array)     Array of paths to where the settings are, relative to
     *                                  the plugin/theme, expects a trailing slash
     */
    public function __construct( $namespace=null, $settings=null, $type=null ){

        $this->namespace = $this->sanitizeNamespace( $namespace );
        $this->setting_type = $type;

        $paths = $this->getPaths();
        $this->dir_url = $paths['dir_url'];
        $this->dir_path = $paths['dir_path'];

        // @todo huh?
        if ( isset( $paths['dir_url_form_fields'] ) ){
            $this->dir_url_form_fields = trailingslashit( $paths['dir_url_form_fields'] );
            add_filter( 'zm_form_fields_dir_url', array( &$this, 'zmFormFieldsDirUrl' ) );
        }

        $this->settings = $settings;

        add_action( 'admin_menu', array( &$this, 'adminMenu' ) );
        add_action( 'admin_init', array( &$this, 'registerSettings' ) );
        add_action( 'admin_enqueue_scripts', array( &$this, 'adminEnqueueScripts') );
        add_action( 'admin_notices', array( &$this, 'adminNoticesAction' ) );
    }


    /**
     * Displays the setting error.
     *
     * @since 1.0.0
     * @return void
     */
    public function adminNoticesAction() {

        global $pagenow;

        if ( $pagenow == 'themes.php' ){

            $args = wp_parse_args( $_SERVER['REQUEST_URI'] );

            if ( isset( $args['settings-updated'] ) && $args['settings-updated'] == true ){
                add_settings_error(
                    $this->namespace,
                    'noon',
                    __( 'Options saved.', $this->namespace ),
                    'updated'
                );
            }
        }

    }



    /**
     * Sets the absolute and URL paths for either using this as a plugin setting or theme
     * settings
     *
     * @since 1.0.0
     * @return  $paths  (array)     An array of containing absolute and URLs paths
     */
    public function getPaths(){

        if ( $this->setting_type == 'plugin' ){
            $defaults = array(
                'dir_path' => plugin_dir_path( __FILE__ ),
                'dir_url' => plugin_dir_url( __FILE__ )
            );
        } else {
            $defaults = array(
                'dir_path' => trailingslashit( get_stylesheet_directory() ),
                'dir_url' => trailingslashit( get_stylesheet_directory_uri() )
            );
        }

        $paths = apply_filters( $this->namespace . '_paths', $defaults );

        return $paths;

    }


    // @todo huh?
    public function zmFormFieldsDirUrl(){
        return $this->dir_url_form_fields;
    }


    /**
     * Return our settings
     *
     * @since 1.0.0
     * @return $settings    (array)     The settings as a multi-dimensional array
     */
    public function settings(){

        return apply_filters( $this->namespace . '_settings', $this->settings );

    }


    /**
     * This function adds all our settings sections, settings form fields, and registers
     * a single setting, which holds all of our settings, i.e., get_option( 'my_product' ) will
     * contain the raw settings as seen in the *_options table.
     *
     * @since   1.0.0
     * @return  void
     */
    public function registerSettings(){

        $options = $this->getSaneOptions();

        foreach( $this->settings() as $id => $section ) {

            add_settings_section(
                $this->namespace . '_' . $id, // ID
                __return_null(),              // Title
                '__return_false',             // Callback
                $this->namespace . '_' . $id  // Page
            );

            foreach ( $section['fields'] as $field ) {

                if ( isset( $field['value'] ) ) {
                    $value = $options[ $field['id'] ];
                } else if ( isset( $field['id'] ) && isset( $options[ $field['id'] ] ) ){
                    $value = $options[ $field['id'] ];
                } elseif ( isset( $field['std'] ) ) {
                    $value = $field['std'];
                } else {
                    $value = null;
                }


                // Determine the callback
                // @todo document, this also allows for method overloading
                $method_name = 'do' . ucwords( $field['type'] );

                if ( method_exists( $this, $method_name ) ){
                    $callback = array( $this, $method_name );
                } else {
                    $callback = array( $this, 'missingCallback' );
                }

                // These are extra params passed into our function/method
                $params = array_merge( $this->getAttributes( $field ), array(
                    'echo'        => true,
                    'id'          => isset( $field['id'] ) ? $field['id'] : null,
                    'value'       => $value,
                    'options'     => isset( $field['options'] ) ? $field['options'] : '',
                    'name'        => $this->namespace . '[' . $field['id'] . ']',
                    'title'       => '',
                    'namespace'   => $this->namespace
                ) );

                $title = isset( $field['title'] ) ? $field['title'] : '';
                add_settings_field(
                    $this->namespace.'[' . $field['id'] . ']', // ID
                    $title,                                    // Title
                    $callback,                                 // Callback
                    $this->namespace . '_' . $id,              // Page
                    $this->namespace . '_' . $id,              // Section
                    $params                                    // Params
                );
            }
        }

        register_setting( $this->namespace, $this->namespace, array( &$this, 'sanitizeSingle' ) );

    }


    /**
     * Build our admin menu
     *
     * @since 1.0.0
     */
    public function adminMenu(){

        $params = apply_filters( $this->namespace . '_admin_menu', array(
            'title' => $this->namespaceToPageTitle(),
            'menu_title' => $this->namespaceToMenuTitle(),
            'permission' => 'manage_options',
            'namespace' => $this->namespace,
            'template' => array( &$this, 'loadTemplate' ),
            'submenu' => 'options-general.php'
            ) );

        if ( $this->setting_type == 'theme' ){

            add_theme_page(
                $params['title'],
                $params['menu_title'],
                $params['permission'],
                $params['namespace'] . '_options',
                $params['template']
            );

        } elseif ( $this->setting_type == 'plugin' ) {

            add_submenu_page(
                $params['submenu'],
                $params['title'],
                $params['menu_title'],
                $params['permission'],
                $params['namespace'] . '_settings',
                $params['template']
            );

        } else {

            wp_die('Invalid setting_type');

        }

    }


    /**
     * Call back function which is fired when the admin menu page is loaded.
     *
     * @since 1.0.0
     */
    public function loadTemplate(){

        // If we wanted to we can set a current tab
        $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : null;
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

        // We have a single tab instance, no need to use tabs
        if ( count( $tab_ids ) == 1 ) {
            $tabs = $this->settings();

            $title = '<h3>' . $tabs[ $current_tab ]['title'] . '</h3>';
            $desc = empty( $tabs[ $current_tab ]['desc'] ) ? null : '<p>' . $tabs[ $current_tab ]['desc'] . '</p>';

            $tabs = $title . $desc;

        }

        // We have multiple settings, lets build tabs
        else {
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
            }

            $tabs = '<h2 class="nav-tab-wrapper">' . $tabs . '</h2>';
        }

        global $pagenow;
        if ( $pagenow == 'themes.php' ){
            settings_errors( $this->namespace );
        }

        $below_tabs = apply_filters( $this->namespace . '_below_tabs', null );
        $below_title = apply_filters( $this->namespace . '_below_title', null );
        $description = apply_filters( $this->namespace . '_footer', __( 'Thank you for using Quilt.', $this->namespace ) );

        ?>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"><br></div>
            <h2><?php echo $this->namespaceToPageTitle(); ?></h2>
            <?php echo $below_title; ?>
            <form action="options.php" method="POST" id="<?php echo $this->namespace; ?>_settings_form" class="<?php echo $this->namespace; ?> <?php echo $current_tab; ?>-settings">
                <?php echo $tabs; ?>
                <?php echo $below_tabs; ?>
                <table class="form-table">
                    <?php settings_fields( $this->namespace ); ?>
                    <?php do_settings_fields( $this->namespace . '_' . $current_tab, $this->namespace . '_' . $current_tab ); ?>
                </table>
                <hr >
                <p class="description"><?php echo $description; ?></p>
                <?php submit_button( __( 'Save Changes', $this->namespace ), 'primary', 'submit_form', true ) ?>
            </form>
        </div>
    <?php }


    /**
     * Get all settings from the *_options table
     *
     * @since 1.0.0
     * @return Settings/options
     */
    public function getOptions(){

        $settings = get_option( $this->namespace );

        return $settings;
    }


    /**
     * Get the default options as set settings array
     * These options are formatted into an associative array. Since being
     * mapped as an associative array each key MUST be unique!
     *
     * @filter {namespace}_all_default_options $defaults
     * @return The formatted and filtered array
     *
     */
    public function getDefaultOptions(){

        $defaults = array();

        foreach( $this->settings as $k => $v ){
            foreach( $v['fields'] as $field ){
                if ( isset( $field['std'] ) ){
                    $defaults[ $field['id'] ] = $field['std'];
                }
            }
        }

        return apply_filters( $this->namespace . '_all_default_options', $defaults );

    }


    /**
     * Merge the default options with the options array
     * This allows us to use settings from the settings array, as apposed
     * to having the user visit the settings, press "save" and save the
     * defaults to the db. More info can be found on
     * [using sane defaults in themes](https://make.wordpress.org/themes/2014/07/09/using-sane-defaults-in-themes/).
     *
     * @return Associative array containing options from DB and defaults.
     */
    public function getSaneOptions(){

        $options = $this->getOptions();
        $defaults = $this->getDefaultOptions();

        if ( empty( $options ) ){
            $options = $this->getDefaultOptions();
        } else {
            $options = array_merge( $defaults, $options );
        }

        return $options;

    }


    /**
     * Get a single option value from the settings array
     *
     * @since 1.0.0
     * @param $key The option key to get, $default, the default if any
     * @return Option from database
     */
    public function getOption( $key='', $default=false ) {

        $options = $this->getSaneOptions();

        $value = ! empty( $options[ $key ] ) ? $options[ $key ] : $default;
        $value = apply_filters( $this->namespace . '_get_option', $value, $key, $default );

        return apply_filters( $this->namespace . '_get_setting_' . $key, $value, $key, $default );

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
    public function sanitizeSingle( $input=array() ){

        if ( empty( $_POST['_wp_http_referer'] ) )
            return;

        $settings = $this->settings();
        $tab = $this->getTab();
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
                            $input[ $key ] = $this->sanitizeDefault( $value );
                            break;

                        case 'checkboxes' :
                            $tmp = array();
                            foreach( $field['options'] as $k => $v ){
                                if ( is_array( $v ) ){
                                    if ( in_array($v['id'], $value) ){
                                        if ( ! empty( $v['title'] ) ){
                                            $tmp[ $v['id'] ] = array(
                                                'id' => $v['id'],
                                                'title' => $v['title']
                                            );
                                        }
                                    }
                                } elseif ( in_array( $k, $value ) ){
                                    $input[ $key ] = $value;
                                }
                            }
                            if ( ! empty( $tmp ) ){
                                $input[ $key ] = $tmp;
                            }
                            break;

                        case 'multiselect' :
                            $input[ $key ] = $this->sanitizeMultiselect( $value );
                            break;

                        case 'emails' :
                            $input[ $key ] = $this->sanitizeEmails( $value );
                            break;

                        // Yes, ips
                        case 'ips' :
                            $input[ $key ] = $this->sanitizeIps( $value );
                            break;

                        case 'touchtime' :
                            $input[ $key ] = $this->sanitizeTouchtime( $value );
                            break;

                        default:
                            $input[ $key ] = $this->sanitizeDefault( $value );
                            break;
                    }

                    // Sanitize by type
                    if ( ! empty( $input[ $key ] ) ){
                        $input[ $key ] = apply_filters( $this->namespace . '_sanitize_' . $type, $input[ $key ] );
                    }
                }

                // sanitize by key here via filter
                if ( ! empty( $input[ $key ] ) ){
                    $input[ $key ] = apply_filters( $this->namespace . '_sanitize_' . $key, $input[ $key ] );
                }
            }
        }

        // Loop through the whitelist and unset any that are empty for the tab being saved
        $options = $this->getSaneOptions();

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
     * Just return the input being saved.
     *
     * @since 1.0.0
     */
    public function sanitizeDefault( $input=null ){

        return esc_attr( $input );

    }


    /**
     * Missing callback
     *
     * @since 1.0.0
     */
    public function missingCallback(){

        echo 'No callback';

    }


    /**
     * Renders header
     *
     * @since 1.0.0
     * @param array $args Arguments passed by the setting
     * @return void
     */
    public function doHeader(){

        echo '<hr />';

    }


    /**
     * Renders description fields.
     *
     * @since 1.0.0
     * @param array $args Arguments passed by the setting
     * @return void
     */
    public function doDesc( $args ) {

        echo '<p>' . $args['desc'] . '</p>';

    }


    /**
     * Renders license fields.
     *
     * @since 1.0.0
     * @param array $args Arguments passed by the setting
     * @return void
     */
    public function doLicense( $args ) {

        // Use this to pass in the license data
        $args = apply_filters( $this->namespace . '_license_args', $args );

        $button_text = __('Activate', $this->namespace );
        $status_text = null;
        $action = 'license_activate';

        // Handle displaying of different license status' here,
        // currently we just handle "valid"
        if ( ! empty( $args['extra']['license_data'] ) ){
            if ( $args['extra']['license_data']['license'] == 'valid' ) {
                $status_text = '<span style="color:green;"> ' . __('Active', $this->namespace ) . '</span>';
                $button_text = __('Deactivate', $this->namespace );
                $action = 'license_deactivate';
            } else {
                $status_text = '<span style="color:red;"> ' . __('Inactive', $this->namespace ) . '</span>';
            }
        }

        /**
         * Display our input field
         */
        ?>
        <input type="text" placeholder="<?php esc_attr_e( $args['std'] ); ?>" class="regular-text" id="<?php echo $args['id']; ?>" name="<?php echo $args['name']; ?>" value="<?php echo $args['value']; ?>"/>
        <label for="<?php echo $args['id']; ?>"><?php echo $args['desc']; ?></label>

        <?php
        /**
         * If we have a license we show the Activate/Deactivate along with the status
         */
        if ( ! empty( $args['value'] ) ) : ?>
            <input type="hidden" name="<?php echo $this->namespace; ?>[license_action]" id="<?php echo $this->namespace; ?>_license_action" value="" />
            <input type="hidden" name="<?php echo $this->namespace; ?>[previous_license]" id="<?php echo $this->namespace; ?>_previous_license" value="<?php echo $args['value']; ?>" />

            <input type="button" name="<?php echo $this->namespace; ?>_license_activate_button" data-<?php echo $this->namespace; ?>_license_action="<?php echo $action; ?>" id="<?php echo $this->namespace; ?>_license_activate_button" class="button" value="<?php echo $button_text; ?>" />
            <?php echo $status_text; ?>
            <?php do_action( $this->namespace . '_below_license' ); ?>
        <?php endif; ?>
        <?php
    }


    /**
     * Load our JS, CSS files
     *
     * @since 1.0.0
     * @param array $args Arguments passed by the setting
     * @return void
     */
    public function adminEnqueueScripts(){
        $screen = get_current_screen();

        // use this filter to change the page_id to load css/js if the settings is
        // in a submenu
        // if ( $screen->id == apply_filters( $this->namespace . '_screen_id', 'settings_page_' . $this->namespace ) ){
        //     wp_enqueue_style( $this->namespace . 'admin-style', $this->dir_url . 'assets/stylesheets/admin.css', '', '1.0' );
        // }


        $styles = apply_filters( $this->namespace . '_styles', array(
            array(
                'handle' => $this->app . '-admin-style',
                'src' => $this->dir_url . 'assets/stylesheets/admin.css',
                'deps' => '',
                'ver' => $this->version,
                'media' => ''
            )
        ), $this->namespace );

        foreach( $styles as $style ){
            wp_enqueue_style( $style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media'] );
        }
    }


    /**
     * Determine which tab to use to save the settings/options
     *
     * @param
     * @return $tab (string) The default tab to use for saving settings/options
     */
    public function getTab(){

        // If we have a referrer tab
        parse_str( $_POST['_wp_http_referer'], $referrer );

        if ( isset( $referrer['tab'] ) ){
            $tab = $referrer['tab'];
        }

        else {
            $tab = key( $this->settings() );
        }

        return apply_filters( $this->namespace . '_default_tab', $tab );
    }


    /**
     * Should return a string that is safe to be used in function names, as a variable, etc.
     * free of illegal characters.
     *
     * @param $namespace (string)   The namespace to sanitize
     * @return $namespace (string)  The namespace free of illegal characters.
     */
    public function sanitizeNamespace( $namespace=null ){

        return str_replace( array('-', ' ' ), '_', $namespace );

    }


    /**
     * Converts a sanitized namespace to be used a page title.
     *
     * @param
     * @return $string A string to be used a the page title
     */
    public function namespaceToPageTitle(){

        $title = ucwords( $this->sanitizeNamespace( $this->namespace ) );

        return apply_filters( $this->namespace . '_page_title', $title, $this->namespace );

    }


    /**
     * Converts a sanitized namespace to be used a menu title.
     *
     * @param
     * @return $string A string to be used a the menu title
     */
    public function namespaceToMenuTitle(){

        $title = ucwords( $this->sanitizeNamespace( $this->namespace ) );

        return apply_filters( $this->namespace . '_menu_title', $title, $this->namespace );

    }
}
endif;