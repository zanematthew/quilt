<?php


require dirname( __FILE__ ) . '/zm-form-fields.php';

Class ZM_Settings Extends ZM_Form_Fields {

    /**
     * WordPress hooks to be ran during init
     *
     * @since 1.0.0
     */
    public function __construct( $namespace ){

        $this->namespace = $namespace;

        add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
        add_action( 'admin_init', array( &$this, 'register_settings' ) );
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
                        'type' => 'checkbox'
                    ),
                    array(
                        'id' => 'my_id',
                        'title' => __( 'Text Field', $this->namespace ),
                        'type' => 'text'
                    ),
                    array(
                        'id' => 'my_id_url',
                        'title' => __( 'URL Field', $this->namespace ),
                        'type' => 'url'
                    ),
                    array(
                        'id' => 'my_textarea_id',
                        'title' => __( 'Textarea', $this->namespace ),
                        'type' => 'textarea'
                    ),
                    array(
                        'id' => 'my_textarea_id_css',
                        'title' => __( 'CSS Textarea', $this->namespace ),
                        'type' => 'css_textarea'
                    ),
                    array(
                        'id' => 'any_id',
                        'title' => __( 'Select', $this->namespace ),
                        'type' => 'select',
                        'desc' => '<p>This is a sample select, with options. The options are passed in using the <code>options</code> key, with an assigned array like the following; <code>array( [0] =>"", [2] => Sample Page )</code></p>',
                        'options' => array(
                                0 => '',
                                1 => 'Option 1',
                                2 => 'Option 2'
                        )
                    ),
                    array(
                        'id' => 'sample_multiselect',
                        'title' => 'Multi-select',
                        'type' => 'multiselect',
                        'options' => array(
                                0 => '',
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

                // echo "method: do_" . $field['type'] . '<br >';

                add_settings_field(
                    $this->namespace.'[' . $field['id'] . ']', // ID
                    $title,

                    method_exists( $this, 'do_' . $field['type'] )
                        ? array( $this, 'do_' . $field['type'] )
                        : array( $this, 'missing_callback' ),

                    $this->namespace . '_' . $id, // Page
                    $this->namespace . '_' . $id, // Section
                    array(
                        'echo'    => true,
                        'id'      => isset( $field['id'] ) ? $field['id'] : null,
                        'desc'    => ! empty( $field['desc'] ) ? $field['desc'] : '',
                        // Since we don't want the extended form class to derive names, we specify our names
                        'name'    => $this->namespace . '[' . $field['id'] . ']', // ushyee_settings[my_checkbox_id]
                        'value'   => $options,
                        'section' => $id,
                        'size'    => isset( $field['size'] ) ? $field['size'] : null,
                        'options' => isset( $field['options'] ) ? $field['options'] : '',
                        'std'     => isset( $field['std'] ) ? $field['std'] : ''
                    ) // These are extra params based into our function/method
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

        $sub_menu_pages = array(
            array(
                'parent_slug' => 'options-general.php',
                'page_title' => __( 'ZM Settings', $this->namespace  ),
                'menu_title' => __( 'ZM Settings', $this->namespace  ),
                'capability' => 'manage_options',
                'menu_slug' => $this->namespace,
                'function' => 'load_template'
                )
            );

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

                <p class="description"><?php echo apply_filters( "{$this->namespace}_page_footer", 'Thank you for using the ZM Settings API.' ); ?></p>

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

        $options = $this->get_options();

        if ( empty( $_POST['_wp_http_referer'] ) )
            return;

        parse_str( $_POST['_wp_http_referer'], $referrer );

        $settings = $this->settings();
        $tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : null;

        $input = $input ? $input : array();
        $input = apply_filters( $this->namespace . '_' . $tab . '_sanitize', $input );

        // Loop through each setting being saved and pass it through a sanitization filter
        foreach( $input as $key => $value ){
            if ( empty( $settings[ $tab ]['fields'] ) ){
            //     echo "missing: {$tab}<br />";
            } else {
                foreach( $settings[ $tab ]['fields'] as $field ){
                    $type = $field['type'];
                    // Type specific filter
                    $input[ $tab ] = apply_filters( $this->namespace . '_' . $type . '_sanitize', $value, $tab );
                }
            }

            // field specific filter
            $input[ $key ] = apply_filters( $this->namespace . '_' . $key . '_sanitize', $value );
        }


        // Loop through the whitelist and unset any that are empty for the tab being saved
        if ( ! empty( $settings[$tab] ) ) {
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

    // @todo finish this one
    public function touchtime_callback( $args ){

        global $wp_locale;
        $tab_index = 0;
        $multi = 0;
        $tab_index_attribute = '';

        if ( (int) $tab_index > 0 )
            $tab_index_attribute = " tabindex=\"$tab_index\"";


        $time_adj = current_time('timestamp');

        $jj = gmdate( 'd', $time_adj );
        $mm = gmdate( 'm', $time_adj );
        $aa = gmdate( 'Y', $time_adj );
        $hh = gmdate( 'H', $time_adj );
        $mn = gmdate( 'i', $time_adj );
        $ss = gmdate( 's', $time_adj );

        $cur_jj = gmdate( 'd', $time_adj );
        $cur_mm = gmdate( 'm', $time_adj );
        $cur_aa = gmdate( 'Y', $time_adj );
        $cur_hh = gmdate( 'H', $time_adj );
        $cur_mn = gmdate( 'i', $time_adj );

        $month = '<label for="mm" class="screen-reader-text">' . __( 'Month' ) . '</label><select ' . ( $multi ? '' : 'id="mm" ' ) . 'name="mm"' . $tab_index_attribute . ">\n";
        for ( $i = 1; $i < 13; $i = $i +1 ) {
            $monthnum = zeroise($i, 2);
            $month .= "\t\t\t" . '<option value="' . $monthnum . '" ' . selected( $monthnum, $mm, false ) . '>';
            /* translators: 1: month number (01, 02, etc.), 2: month abbreviation */
            $month .= sprintf( __( '%1$s-%2$s' ), $monthnum, $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) ) . "</option>\n";
        }
        $month .= '</select>';

        $day = '<label for="jj" class="screen-reader-text">' . __( 'Day' ) . '</label><input type="text" ' . ( $multi ? '' : 'id="jj" ' ) . 'name="jj" value="' . $jj . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';
        $year = '<label for="aa" class="screen-reader-text">' . __( 'Year' ) . '</label><input type="text" ' . ( $multi ? '' : 'id="aa" ' ) . 'name="aa" value="' . $aa . '" size="4" maxlength="4"' . $tab_index_attribute . ' autocomplete="off" />';
        $hour = '<label for="hh" class="screen-reader-text">' . __( 'Hour' ) . '</label><input type="text" ' . ( $multi ? '' : 'id="hh" ' ) . 'name="hh" value="' . $hh . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';
        $minute = '<label for="mn" class="screen-reader-text">' . __( 'Minute' ) . '</label><input type="text" ' . ( $multi ? '' : 'id="mn" ' ) . 'name="mn" value="' . $mn . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" />';

        $html = '<div class="timestamp-wrap">';
        /* translators: 1: month, 2: day, 3: year, 4: hour, 5: minute */
        printf( __( '%1$s %2$s, %3$s @ %4$s : %5$s' ), $month, $day, $year, $hour, $minute );

        $html .= '</div><input type="hidden" id="ss" name="ss" value="' . $ss . '" />';

        if ( $multi ) return;

        $html .= "\n\n";
        $map = array(
            'mm' => array( $mm, $cur_mm ),
            'jj' => array( $jj, $cur_jj ),
            'aa' => array( $aa, $cur_aa ),
            'hh' => array( $hh, $cur_hh ),
            'mn' => array( $mn, $cur_mn ),
        );
        foreach ( $map as $timeunit => $value ) {
            list( $unit, $curr ) = $value;

            $html .= '<input type="hidden" id="hidden_' . $timeunit . '" name="hidden_' . $timeunit . '" value="' . $unit . '" />' . "\n";
            $cur_timeunit = 'cur_' . $timeunit;
            $html .= '<input type="hidden" id="' . $cur_timeunit . '" name="' . $cur_timeunit . '" value="' . $curr . '" />' . "\n";
        }
        $html .= '<label for="' . $this->namespace . '[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';
        echo $html;
    }
}