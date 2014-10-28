<?php

// This should be agnostic of meta vs. option
// post_type is actually our "key"

if ( ! class_exists( 'ZM_Form_Fields' ) ) :
Class ZM_Form_Fields {

    public function do_text( $field=null, $current_form=null, $value=null ){

        extract( $this->get_attributes( $field, $current_form ) );

        $value = empty( $current_value ) ? $value : $current_value;

        $required = ( $req == true ) ? ' required ' : null;
        $required_html = ( $req == true ) ? '<sup class="req">&#42;</sup>' : null;

        $row  = '<p class="' . $row_class . '" id="' . $row_id . '">';
        $row .= '<label for="' . $for . '">' . $title . '</label>';
        $row .= $required_html;
        $row .= '<input type="text" id="' . $input_id . '" name="' . $name . '" value="' . esc_attr( $value ) . '" placeholder="' . $placeholder . '" size="25" ' . $required . '/>';
        $row .= '</p>';

        if ( $echo )
            echo $row;
        else
            return $row;
    }


    public function do_hidden( $field=null, $current_form=null, $value=null ){

        extract( $this->get_attributes( $field, $current_form ) );

        $value = empty( $current_value ) ? $value : $current_value;

        $required = ( $req == true ) ? ' required ' : null;
        $required_html = ( $req == true ) ? '<sup class="req">&#42;</sup>' : null;

        $row  = '<p class="' . $row_class . '" id="' . $row_id . '">';
        $row .= '<label for="' . $for . '">' . $title . '</label>';
        $row .= $required_html;
        $row .= '<input type="text" id="' . $input_id . '" name="' . $name . '" value="' . esc_attr( $value ) . '" placeholder="' . $placeholder . '" size="25" ' . $required . ' ' . $style . '/>';
        $row .= '</p>';

        if ( $echo )
            echo $row;
        else
            return $row;
    }


    public function do_url( $field=null, $current_form=null, $value=null ){

        extract( $this->get_attributes( $field, $current_form ) );

        $value = empty( $current_value ) ? $value : $current_value;

        $required = ( $req == true ) ? ' required ' : null;
        $required_html = ( $req == true ) ? '<sup class="req">&#42;</sup>' : null;

        $row  = '<p class="' . $row_class . '" id="' . $row_id . '">';
        $row .= '<label for="' . $for . '">' . $title . '</label>';
        $row .= $required_html;
        $row .= '<input type="url" id="' . $input_id . '" name="' . $name . '" value="' . esc_url( $value ) . '" placeholder="' . $placeholder . '" size="25" ' . $required . '/>';
        $row .= '</p>';

        if ( $echo )
            echo $row;
        else
            return $row;
    }


    public function do_open_fieldset( $field=array() ){

        extract( $this->get_attributes( $field ) );

        $html = '<div class="' . $row_class . ' zm-form-open-fieldset">';
        $html .= '<fieldset id="zm_form_' . $field['id'] . '_fieldset"><legend>' . $field['title'] . '</legend>';
        return $html;
    }


    public function do_end_fieldset(){
        return '</fieldset></div>';
    }


    public function do_open_section( $field=array() ){

        extract( $this->get_attributes( $field ) );

        $html = '<div class="' . $row_class . ' open-section" id="zm_form_' . $field['id'] . '_section">';
        return $html;
    }


    public function do_end_section(){
        return '</div>';
    }


    /**
     * @todo move to DI
     */
    public function do_select( $field=array(), $current_form=null, $value=null ){

        extract( $this->get_attributes( $field, $current_form ) );

        if ( empty( $field['options'] ) )
            return;

        $value = empty( $current_value ) ? $value : $current_value;

        $options = null;
        foreach( $field['options'] as $k => $v ) {
            $options .= '<option value="' . $k . '" ' . selected( $k, $value, false ) . '>' . $v . '</option>';
        }

        $required = ( $req == true ) ? ' required ' : null;
        $required_html = ( $req == true ) ? '<sup class="req">&#42;</sup>' : null;

        $html  = '<p class="' . $row_class . '" id="' . $row_id . '"><label for="' . $for . '">' . $title . '</label> ';
        $html .= $required_html;
        $html .= '<select name="' . $name . '" ' . $required . '>';
        $html .= $options;
        $html .= '</select>';
        $html .= $desc;

        if ( $echo )
            echo $html;
        else
            return $html;
    }


    public function do_multiselect( $field=array(), $current_form=null, $value=null ){
        extract( $this->get_attributes( $field, $current_form ) );

        if ( empty( $field['options'] ) ){
            $html = 'No options';
        } else {

            $value = empty( $current_value ) ? $value : $current_value;

            $options = null;
            foreach( $field['options'] as $k => $v ) {
                if ( in_array( $k, $value ) ){
                    $selected = 'selected=selected';
                } else {
                    $selected = selected( $k, $value, false );
                }
                $options .= '<option value="' . $k . '" ' . $selected . '>' . $v . '</option>';
            }

            $html  = '<p class="' . $row_class . '" id="' . $row_id . '"><label for="' . $for . '">' . $title . '</label> ';
            $html .= '<select name="' . $name . '[]" multiple>';
            $html .= $options;
            $html .= '</select>';
            $html .= $desc;
        }

        if ( $echo )
            echo $html;
        else
            return $html;
    }


    public function do_us_state_select( $field=array(), $current_form=null, $value=null ){
        $states = array(
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'District Of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming'
            );

        extract( $this->get_attributes( $field, $current_form ) );
        $value = empty( $current_value ) ? $value : $current_value;

        $options = '<option value=""></option>';
        foreach( $states as $k => $v ) {
            $options .= '<option value="' . $k . '" ' . selected( $k, $value, false ) . '>' . $v . '</option>';
        }

        $required = ( $req == true ) ? ' required ' : null;
        $required_html = ( $req == true ) ? '<sup class="req">&#42;</sup>' : null;

        $html  = '<p class="' . $row_class . '" id="' . $row_id . '"><label for="' . $for . '">' . $title . '</label>';
        $html .= $required_html;
        $html .= '<select name="' . $name . '" ' . $required . '>';
        $html .= $options;
        $html .= '</select></p>';
        $html .= $desc;

        if ( $echo )
            echo $html;
        else
            return $html;
    }


    public function do_textarea( $field=array(), $current_form=null, $value=null ){

        extract( $this->get_attributes( $field, $current_form ) );

        $description = empty( $field['desc'] ) ? null : '<span class="description">' . $field['desc'] . '</span>';
        $value = empty( $current_value ) ? $value : $current_value;

        $html  = '<p class="' . $row_class . '" id="' . $row_id . '"><label for="' . $for . '">' . $title . '</label>';
        $html .= '<textarea name="' . $name . '" rows="'.$rows.'" cols="" class="'.$field_class.'" placeholder="' . $placeholder . '">' . esc_textarea( $value ) . '</textarea>';
        $html .= '<p class="description">'.$desc.'</p>';
        $html .= '</p>';

        if ( $echo )
            echo $html;
        else
            return $html;
    }


    public function do_css_textarea( $field=array(), $current_form=null, $value=null ){

        extract( $this->get_attributes( $field, $current_form ) );

        $description = empty( $field['desc'] ) ? null : '<span class="description">' . $field['desc'] . '</span>';
        $value = empty( $current_value ) ? $value : $current_value;

        $html  = '<p class="' . $row_class . '" id="' . $row_id . '"><label for="' . $for . '">' . $title . '</label>';
        $html .= '<textarea class="large-text" name="' . $name . '" placeholder="' . $placeholder . '">' . wp_kses( $value, '' ) . '</textarea>';
        $html .= $desc;
        $html .= '</p>';

        if ( $echo )
            echo $html;
        else
            return $html;
    }


    public function do_textarea_emails( $field=array(), $current_form=null, $value=null ){
        return $this->do_textarea( $field, $current_form, $value );
    }

    public function do_checkbox( $field=array(), $current_form=null, $value=null ){

        extract( $this->get_attributes( $field, $current_form ) );

        $value = empty( $current_value ) ? $value : $current_value;

        $html = '<p class="'.$row_class.'"><input type="checkbox" name="'.$name.'" id="' . $input_id .'" value="1" ' . checked( 1, $value, false ) . '/>';
        $html .= '<label for="' . $for . '_checkbox">' . $title . '</label></p>';

        if ( $echo )
            echo $html;
        else
            return $html;
    }


    public function do_upload( $field=array(), $current_form=null, $value=null ){

        wp_enqueue_media();
        wp_enqueue_script( 'custom-header' );
        wp_enqueue_script( 'zm-form-fields-upload', get_stylesheet_directory_uri() .'/lib/zm-forms/assets/javascripts/admin-upload.js', array('jquery', 'custom-header') );

        extract( $this->get_attributes( $field, $current_form ) );

        $value = empty( $current_value ) ? intval( $value ) : intval( $current_value );

        if ( $value ){
            $style = null;
            $image = '<img src="' . wp_get_attachment_thumb_url( $value ) . '" style="border: 1px solid #ddd;" />';
        } else {
            $style = 'style="display:none;"';
            $image = null;
        }

        $row  = '<p class="' . $row_class . '" id="' . $row_id . '">';
        $row .= '<label for="' . $for . '">' . $title . '</label>';


        $row .= '<span class="zm-form-fields-upload-container" style="margin: -10px 0 0 200px; display: block; width: 50%;">';
        $row .= '<a href="#" class="button zm-form-fields-media-upload-handle" style="margin-bottom: 10px;">' . __('Upload', 'zm_alr_pro') . '</a><br />';
        $row .= '<span class="zm-form-fields-upload-image-container" ' . $style . '>';
        $row .= $image;
        $row .= '</span>';
        $row .= '<br /><a href="#" class="zm-form-fields-upload-remove-handle" ' . $style . '>' . __('Remove', 'zm_alr_pro_settings') . '</a>';
        $row .= '<input type="hidden" class="zm-form-fields-upload-attachment-id" id="'.$input_id.'" name="' . $name . '" value="' . $value . '"/>';
        $row .= '</span>';

        $row .= '</p>';



        if ( $echo )
            echo $row;
        else
            return $row;
    }


    public function do_radio( $field, $current_form, $value ){

        extract( $this->get_attributes( $field, $current_form ) );

        if ( empty( $field['options'] ) )
            return;

        $value = empty( $current_value ) ? $value : $current_value;
        $options = null;

        foreach( $field['options'] as $k => $v ) {

            $key = sanitize_title( $k );
            $id = $input_id . '_' . $key;

            $options .= '<input type="radio" class="" name="'.$name.'" id="' . $id . '" value="' . $key . '" ' . checked( $key, $value, false ) . ' /><label for="' . $id . '">' . $v . '</label><br />';
        }

        $required = ( $req == true ) ? ' required ' : null;
        $required_html = ( $req == true ) ? '<sup class="req">&#42;</sup>' : null;

        $html  = '<p class="' . $row_class . '" id="' . $row_id . '">';
        $html .= $required_html;
        // $html .= '<select name="' . $name . '" ' . $required . '>';
        $html .= $options;
        // $html .= '</select>';
        $html .= $desc;

        if ( $echo )
            echo $html;
        else
            return $html;
    }


    public function do_html( $field=null, $current_form=null ){

        extract( $this->get_attributes( $field, $current_form ) );

        $row  = '<p class="' . $row_class . '" id="' . $row_id . '">';
        $row .= '<label for="' . $for . '">' . $title . '</label>';
        $row .= $std;
        $row .= '</p>';

        if ( $echo )
            echo $row;
        else
            return $row;
    }


    public function do_thickbox_url( $field=null, $current_form=null, $value=null ){

        extract( $this->get_attributes( $field, $current_form ) );

        // var_dump($placeholder); // for title of hidden content
        // var_dump($std); // for URL

        add_thickbox();

        $row  = '<p class="' . $row_class . '" id="' . $row_id . '">';
        $row .= '<label for="' . $for . '">' . $title . '</label>';
        $row .= '<a href="' . esc_url( $std ) . '&TB_iframe=true&width=600&height=550" class="thickbox">' . $placeholder . '</a>';
        $row .= '</p>';

        if ( $echo )
            echo $row;
        else
            return $row;
    }


    public function get_attributes( $field=null, $current_form=null ){

        // Other people can override the name, by passing it in with the field
        $name = '_' . $current_form . '_form[meta]['.$field['id'].']';

        $attr = array(
            'for' => empty( $field['id'] ) ? null : $field['id'],
            'title' => empty( $field['title'] ) ? null : $field['title'],
            'name' => empty( $field['name'] ) ? $name : $field['name'],
            'placeholder' => empty( $field['placeholder'] ) ? null : $field['placeholder'],
            'row_class' => ( empty( $field['extra_class'] ) ) ? 'zm-form-default-row' : 'zm-form-default-row ' . $field['extra_class'],
            'field_class' => ( empty( $field['field_class'] ) ) ? '' : $field['field_class'],
            'row_id' => 'zm_form_' . $current_form . '_' . $field['id'] . '_row',
            'input_id' => $current_form . '_' . $field['id'],
            'req' => empty( $field['req'] ) ? null : $field['req'],
            'desc' => empty( $field['desc'] ) ? null : $field['desc'],
            'echo' => empty( $field['echo'] ) ? false : true,
            'current_value' => empty( $field['value'][ $field['id'] ] ) ? null : $field['value'][ $field['id'] ],
            'style' => empty( $field['style'] ) ? null : $field['style'],
            'std' => empty( $field['std'] ) ? null : $field['std'],
            'rows' => empty( $field['rows'] ) ? null : $field['rows'],
            );
        return $attr;
    }


    public function get_fields(){
        // Our default fields
        $default_fields = array(
            array(
                'id' => 'email',
                'type' => 'text',
                'title' => 'Email Address',
                'value' => null
                ),
            array(
                'id' => 'cell',
                'type' => 'text',
                'title' => 'Cell Phone',
                'value' => null
                ),
            array(
                'id' => 'info_about',
                'type' => 'text',
                'title' => 'Send info about',
                'value' => null
                )
        );

        $forms = $this->get_forms();

        foreach( $forms as $form ){
            $fields[ $form['post_type'] ] = apply_filters( 'zm_form_fields_' . $form['post_type'], $default_fields );
        }
        return apply_filters( 'zm_form_fields_additional_fields', $fields );
    }


    // i.e., form or post types
    // as of now these are passed in as post types
    public function get_forms(){
        // $forms = array(
        //     array(
        //         'post_type' => null,
        //         'name' => null,
        //         'label' => null
        //     )
        // );

        $forms = array();

        return apply_filters( 'zm_form_add_new', $forms );
    }

    // get our meta values for a given post_type
    public function get_values( $post_id=null, $key=null ){
        $post_meta = get_post_meta( $post_id, '_zm_form_meta', true );
        if ( empty( $key ) ){
            $meta = apply_filters( 'zm_forms_meta_values', $post_meta, $post_id );
        } else {
            $meta = empty( $post_meta[ $key ] ) ? null : $post_meta[ $key ];
        }

        return $meta;
    }


    public function get_meta_fields_html( $post_id=null, $current_form=null ){

        $meta = $this->get_values( $post_id );
        $my_fields = $this->get_fields();
        $html = null;

        foreach( $my_fields as $form => $fields ){
            if ( $current_form == $form ){
                if ( empty( $fields ) ){
                    $html .= 'Using defaults';
                } else {
                    foreach( $fields as $field ) :

                        $value = empty( $meta[ $field['id'] ] ) ? null : $meta[ $field['id'] ];

                        switch( $field['type'] ) {

                            case 'select' :
                                $html .= $this->do_select( $field, $current_form, $value );
                                break;

                            case 'multiselect' :
                                $html .= $this->do_multiselect( $field, $current_form, $value );
                                break;

                            case 'us_state' :
                                $html .= $this->do_us_state_select( $field, $current_form, $value );
                                break;

                            case 'textarea' :
                            case 'textarea_email_template' :
                                $html .= $this->do_textarea( $field, $current_form, $value );
                                break;

                            case 'textarea_emails' :
                                $html .= $this->do_textarea_emails( $field, $current_form, $value );
                                break;

                            case 'open_fieldset' :
                                $html .= $this->do_open_fieldset( $field, $current_form, $value );
                                break;

                            case 'end_fieldset' :
                                $html .= $this->do_end_fieldset();
                                break;

                            case 'open_section' :
                                $html .= $this->do_open_section( $field, $current_form, $value );
                                break;

                            case 'end_section' :
                                $html .= $this->do_end_section();
                                break;

                            case 'checkbox' :
                                $html .= $this->do_checkbox( $field, $current_form, $value );
                                break;

                            case 'radio' :
                                $html .= $this->do_radio( $field, $current_form, $value );
                                break;

                            case 'hidden' :
                                $html .= $this->do_hidden( $field, $current_form, $value );
                                break;

                            case 'upload' :
                                $html .= $this->do_upload( $field, $current_form, $value );
                                break;

                            case 'html' :
                                $html .= $this->do_html( $field, $current_form );
                                break;

                            case 'thickbox_url' :
                                $html .= $this->do_thickbox_url( $field, $current_form, $value );
                                break;

                            default:
                                $html .= $this->do_text( $field, $current_form, $value );
                                break;
                        }

                    endforeach;
                }
            }
        }
        return $html;
    }


    // merge the meta fields with that of the current form,
    // this allows us to get add additional data to the fields.
    // Essentially we are going from this:
    // array( 'first_name' ); to
    // array( 'first_name' => array( 'type' => 'text', 'id' => etc. ) )
    public function get_formatted_meta( $meta=null, $current_form=null ){
        $fields = $this->get_fields();
        $current_form_fields = $fields[ $current_form ];
        foreach( $current_form_fields as $field ){
            foreach( $meta as $k => $v ){
                if ( $field['id'] == $k ){
                    $formatted[ $k ] = $field;
                    $formatted[ $k ]['value'] = $v;
                }
            }
        }
        return $formatted;
    }


    // saves form meta
    public function save_meta( $post_id=null, $meta=null, $current_form=null ){
        $formatted_meta = $this->get_formatted_meta( $meta, $current_form );
        $multi_value = null;

        foreach( $formatted_meta as $k => $v ){

            if ( is_array( $v['value'] ) ){
                // for multiselect
                // we sanitize them individually then implode them on a , comma
                foreach( $v['value'] as $vv ){
                    $multi_value[] = $this->sanitize( $type, $vv );
                }
                $sanitized[ $k ] = implode( ',', $multi_value );
            } else {
                $value = trim( $v['value'] );
                if ( ! empty( $value ) ){
                    $type = empty( $v['type'] ) ? 'default' : $v['type'];

                    // sanitize by type
                    $value = $this->sanitize( $type, $v['value'] );

                    // sanitize by id
                    $value = apply_filters( 'zm_form_sanitize_' . $current_form . '_' . $v['id'], $value );

                    // Build our array of values
                    $sanitized[ $k ] = $value;

                }
            }
        }

        do_action( 'zm_form_' . $current_form . '_before_save_meta', $post_id, $meta );
        return update_post_meta( $post_id, '_zm_form_meta', $sanitized );
    }


    // default
    // to override this just create a method called 'sanitize' in the child class
    public function sanitize( $type=null, $value=null ){
        switch ( $type ) {
            case 'textarea':
                $value = esc_textarea( $value );
                break;

            case 'checkbox' :
                $value = intval( $value );
                break;

            case 'email' :
                $value = sanitize_email( $value );
                break;

            case 'float' :
                $value = floatval( $value );
                break;

            case 'multiselect' :
                print_r( $value );
                break;

            case 'text' :
            case 'us_state' :
            case 'select' :
            case 'phone' :
            default:
                $value = esc_attr( $value );
                break;
        }

        return $value;
    }


    public function meta_fields( $post ){ ?>
        <?php wp_nonce_field( 'zm_form_meta_box', 'zm_form_meta_box_nonce' ); ?>
        <style type="text/css">
            label { display: inline-block; width: 200px; }
        </style>
        <?php echo $this->get_meta_fields_html( $post->ID, $post->post_type ); ?>
    <?php }


    public function get_meta( $post_id=null, $key=null ){
        $meta = maybe_unserialize( get_post_meta( $post_id,  $this->meta_key , true ) );
        return empty( $meta[ $key ]['value'] ) ? false : $meta[ $key ]['value'];
    }

}
endif;