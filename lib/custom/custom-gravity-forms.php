<?php
add_filter( 'gform_disable_form_theme_css', '__return_true' );

/*
 * Change the submit button to be an actual button element rather
 * than input submit. This is so we can style the inputs the exact
 * same as other buttons, which often have pseudo elements that aren't
 * allowed on inputs
 */
function custom_gform_submit( $submit_button, $form ) {
  if(!empty($form['cssClass'])) {
    if ( strpos( $form['cssClass'], 'form-skin' ) !== false || strpos( $form['cssClass'], 'inline-form' ) !== false ) {
      $submit_button = "<button class='button' id='gform_submit_button_{$form['id']}' type='submit'>{$form['button']['text']}</button>";
    }
  }
  return $submit_button;
}
add_filter( 'gform_submit_button', 'custom_gform_submit', 10, 2 );

function edit_choice_fields_markup( $field_content, $field ) {

  /*
   * Only continue if we're not on the form editor screen
   * and we're not on the entry screen. This is to ensure
   * we're only editing markup on the front end of the site
   */
  if ( $field->is_entry_detail() || $field->is_form_editor() )
    return $field_content;

  switch ( $field->type ) {
    case 'select':
      /*
       * Add a chevron icon right after select inputs
       */
      $field_content =  str_replace( '</select>', '</select><svg class="pointer-events-none fill-current icon icon-chevron-down select-dropdown-arrow"><use xlink:href="#icon-chevron-down"></use></svg>' , $field_content );
      break;

      case 'address':
        $field_content = str_replace( '<select', '<span class="relative block"><select', $field_content );
        $field_content = str_replace( '</select>', '</select><svg class="pointer-events-none fill-current icon icon-chevron-down select-dropdown-arrow"><use xlink:href="#icon-chevron-down"></use></svg></span>', $field_content);
        return $field_content;
      break;

    /*
     * Add selected / unselected icons for radios and checkboxes
     */
    // case 'checkbox':
    //   if ( $field->choices ) {
    //     foreach( $field->choices as $field_choice ) {
    //       $field_content =  str_replace( "{$field_choice['text']}</label>", "<svg class='fill-current icon icon-checkbox'><use xlink:href='#icon-checkbox'></use></svg><svg class='fill-current icon icon-checkbox-checked'><use xlink:href='#icon-checkbox-checked'></use></svg>{$field_choice['text']}</label>" , $field_content );
    //     }

    //     return $field_content;
    //   }
    //   break;
    // case 'radio':
    //   if ( $field->choices ) {
    //     foreach( $field->choices as $field_choice ) {
    //       $field_content =  str_replace( "{$field_choice['text']}</label>", "<svg class='fill-current icon icon-radio'><use xlink:href='#icon-radio'></use></svg><svg class='fill-current icon icon-radio-selected'><use xlink:href='#icon-radio-selected'></use></svg>{$field_choice['text']}</label>" , $field_content );
    //     }

    //     return $field_content;
    //   }
    //   break;

    /*
     * Add selected / unselected icon for consent field
     */
    // case 'consent' :
    //   $field_content =  str_replace( "{$field['checkboxLabel']}</label>", "<svg class='fill-current icon icon-checkbox'><use xlink:href='#icon-checkbox'></use></svg><svg class='fill-current icon icon-checkbox-checked'><use xlink:href='#icon-checkbox-checked'></use></svg>{$field['checkboxLabel']}</label>" , $field_content );
    //   return $field_content;
    //   break;

    default:
      break;
  }

  return $field_content;
}
add_filter( 'gform_field_content', 'edit_choice_fields_markup', 10, 2 );

/*
* Add class based on the field type to the fields parent wrapper
*/
add_filter( 'gform_field_css_class', 'add_gfield_type_class', 10, 3 );
function add_gfield_type_class( $classes, $field, $form ) {
  $classes .= ' gfield_type_' . $field->type;
  return $classes;
}

/* Prevent page from jumping to top of form on submit
 * Note: This will also effect multipage forms and exceptions may need to be handled for
 * them
 * TODO : check if a form is multipaged and return something other than false
 */
if ( function_exists( 'gravity_form' ) ) {
  add_filter( 'gform_confirmation_anchor', '__return_false' );
}

add_action( 'gform_field_appearance_settings', 'add_radio_style_setting', 10, 2 );
function add_radio_style_setting( $position, $form_id ) {
    if ( $position == 50 ) {
        ?>
        <li class="radio_style_setting field_setting">
            <label for="field_radio_style_value">
              <?php _e("Radio Style", "ll"); ?>
            </label>
            <select id="field_radio_style_value" onchange="SetFieldProperty('llRadioStyle', this.value);">
              <option value="radio-style--default">Default</option>
              <option value="radio-style--buttons">Buttons</option>
            </select>

        </li>
        <?php
    }
}

// Show the appearance setting on radio and checkbox fields
add_action( 'gform_editor_js', 'editor_script' );
function editor_script(){
    ?>
    <script type='text/javascript'>
        //adding setting to fields of type "text"
        fieldSettings.radio += ', .radio_style_setting';
        //binding to the load field settings event to initialize the checkbox
        jQuery(document).on('gform_load_field_settings', function(event, field, form){
            jQuery( '#field_radio_style_value' ).val( rgar( field, 'llRadioStyle' ) );
        });
    </script>
    <?php
}

// add class to field if setting is checked
add_filter( 'gform_field_css_class', 'radio_style_field', 10, 3 );
function radio_style_field( $classes, $field, $form ) {
    $classes .= ' ' . $field['llRadioStyle'];
    return $classes;
}
