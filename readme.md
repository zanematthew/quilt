function my_init(){
    // $namespace, $type, $settings, $paths, $labels
    $foo = new ZM_Settings( 'my_namespace', 'theme', $settings, array(
            'dir_url' => get_stylesheet_directory_uri() . '/lib/zm-settings',
            'dir_path' => get_stylesheet_directory() . '/lib/zm-settings',
            'dir_url_form_fields' => get_stylesheet_directory_uri() . '/lib/zm-form-fields',
        ), array(
        'menu_title' => 'Theme Options',
        'page_title' => 'Bull Run Mountain Theme Options'
    ) );
}
add_action( 'init', 'my_init' );