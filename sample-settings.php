<?php

$namespace = 'my-namespace';
$settings = array(

    // General
    'usage' => array(
        'title' => 'Usage',
        'fields' => array(
            array(
                'id' => 'usage_header',
                'title' => 'Usage',
                'type' => 'header'
            ),
            array(
                'id' => 'usage_description',
                'title' => 'Description',
                'desc' => 'Thank you for using ZM Settings API. Each tab shows in detail how to use this API. All of the functionality this API provides is designed to be filtered using; hooks and filters. Click through each tab to see the default field types, and how to sanitize settings.',
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
                'desc' => 'This is a default URL field, type: url, sanitize: esc_url.'
            ),
            array(
                'id' => 'my_id_email',
                'title' => 'Email Field',
                'type' => 'email',
                'desc' => 'This is a default email field, type: email, sanitize: sanitize_email.'
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
                'desc' => "Default textarea, sanitize: wp_kses( '' )."
            ),
            array(
                'id' => 'my_textarea_id_email',
                'title' => 'Email Textarea',
                'type' => 'textarea_emails',
                'desc' => "Custom textarea, supports only valid emails, and forward slashed comments, i.e., '//'."
            ),
            array(
                'id' => 'my_textarea_id_ips',
                'title' => 'IP Textarea',
                'type' => 'textarea_ip',
                'desc' => "Custom textarea, supports only valid IP address, sanitize: sanitize_ip)."
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