<?php 

add_action( 'show_user_profile', 'custom_user_profile_fields' );
add_action( 'edit_user_profile', 'custom_user_profile_fields' );

function custom_user_profile_fields( $user ) {
    ?>
    <h3>Додаткова інформація (УАСД)</h3>
    <table class="form-table">
        <tr>
            <th><label for="organization">Організація</label></th>
            <td>
                <input type="text" name="organization" id="organization" value="<?php echo esc_attr( get_user_meta( $user->ID, 'organization', true ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="position">Посада</label></th>
            <td>
                <input type="text" name="position" id="position" value="<?php echo esc_attr( get_user_meta( $user->ID, 'position', true ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="phone_number">Номер телефону</label></th>
            <td>
                <input type="text" name="phone_number" id="phone_number" value="<?php echo esc_attr( get_user_meta( $user->ID, 'phone_number', true ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="account_status">Статус акаунта</label></th>
            <td>
                <select name="account_status" id="account_status">
                    <?php $status = get_user_meta( $user->ID, 'account_status', true ); ?>
                    <option value="pending" <?php selected( $status, 'pending' ); ?>>Очікує підтвердження (Pending)</option>
                    <option value="active" <?php selected( $status, 'active' ); ?>>Активний (Active)</option>
                </select>
                <p class="description">Якщо користувач не може підтвердити Email, ви можете активувати його вручну, обравши "Активний".</p>
            </td>
        </tr>
    </table>
    <?php
}

add_action( 'personal_options_update', 'save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_custom_user_profile_fields' );

function save_custom_user_profile_fields( $user_id ) {  
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
  
    if ( isset( $_POST['organization'] ) ) {
        update_user_meta( $user_id, 'organization', sanitize_text_field( $_POST['organization'] ) );
    }
  
    if ( isset( $_POST['position'] ) ) {
        update_user_meta( $user_id, 'position', sanitize_text_field( $_POST['position'] ) );
    }
  
    if ( isset( $_POST['phone_number'] ) ) {
        update_user_meta( $user_id, 'phone_number', sanitize_text_field( $_POST['phone_number'] ) );
    }
  
    if ( isset( $_POST['account_status'] ) ) {
        update_user_meta( $user_id, 'account_status', sanitize_text_field( $_POST['account_status'] ) );
    }
}
