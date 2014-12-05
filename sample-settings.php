<?php

$namespace = 'my-namespace';
$settings = array(

    // General
    'usage' => array(
        'title' => __( 'Usage', $namespace ),
        'fields' => array(
            array(
                'id' => 'usage_header',
                'title' => __('Usage', $namespace ),
                'type' => 'header'
            ),
            array(
                'id' => 'usage_description',
                'title' => __( 'Description', $namespace ),
                'desc' => __( 'Thank you for using ZM Settings API. Each tab shows in detail how to use this API. All of the functionality this API provides is designed to be filtered using; hooks and filters. Click through each tab to see the default field types, and how to sanitize settings.', $namespace ),
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
        'title' => __( 'Default Fields Types', $namespace ),
        'fields' => array(
            array(
                'id' => 'my_checkbox_id',
                'title' => __( 'Checkbox', $namespace ),
                'type' => 'checkbox',
                'desc' => 'This is my description.'
            ),
            array(
                'id' => 'my_checkboxes_id',
                'title' => __( 'Checkboxes', $namespace ),
                'type' => 'checkboxes',
                'options' => array(
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                    )
            ),
            array(
                'id' => 'my_radio_id',
                'title' => __( 'Radio', $namespace ),
                'type' => 'radio',
                'options' => array(
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                    )
            ),
            array(
                'id' => 'my_id',
                'title' => __( 'Text Field', $namespace ),
                'type' => 'text',
                'desc' => 'This is a default text field, it supports any type of value.'
            ),
            array(
                'id' => 'my_id_url',
                'title' => __( 'URL Field', $namespace ),
                'type' => 'url',
                'desc' => 'This is a default URL field, type: url, sanitize: esc_url.'
            ),
            array(
                'id' => 'my_id_email',
                'title' => __( 'Email Field', $namespace ),
                'type' => 'email',
                'desc' => 'This is a default email field, type: email, sanitize: sanitize_email.'
            ),
            array(
                'id' => 'my_id_hidden',
                'title' => __( 'Hidden Field', $namespace ),
                'type' => 'hidden',
                'desc' => 'This is hidden, you can\'t see it unless you view the html source.'
            ),
            array(
                'id' => 'my_textarea_id',
                'title' => __( 'Textarea', $namespace ),
                'type' => 'textarea',
                'desc' => 'Default textarea, sanitize: esc_textarea.'
            ),
            array(
                'id' => 'my_textarea_id_css',
                'title' => __( 'CSS Textarea', $namespace ),
                'type' => 'css_textarea',
                'desc' => "Default textarea, sanitize: wp_kses( '' )."
            ),
            array(
                'id' => 'my_textarea_id_email',
                'title' => __( 'Email Textarea', $namespace ),
                'type' => 'textarea_emails',
                'desc' => "Custom textarea, supports only valid emails, and forward slashed comments, i.e., '//'."
            ),
            array(
                'id' => 'my_textarea_id_ips',
                'title' => __( 'IP Textarea', $namespace ),
                'type' => 'textarea_ip',
                'desc' => "Custom textarea, supports only valid IP address, sanitize: sanitize_ip)."
            ),
            array(
                'id' => 'any_id',
                'title' => __( 'Select', $namespace ),
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