<?php

class EM_Gateway_Converge extends EM_Gateway {

    //change these properties below if creating a new gateway, not advised to change this for Authorize_AIM
    var $gateway = 'converge';
    var $title = 'Converge';
    var $status = 4;
    var $status_txt = 'Processing (Converge)';
    var $button_enabled = false; //we can's use a button here
    var $supports_multiple_bookings = true;
    var $registered_timer = 0;

    /**
     * Sets up gateaway and adds relevant actions/filters
     */
    function __construct() {
        parent::__construct();
        if ($this->is_active()) {
            //Force SSL for booking submissions, since we have card info
            if (get_option('em_' . $this->gateway . '_mode') == 'live') { //no need if in sandbox mode
                add_filter('em_wp_localize_script', array(&$this, 'em_wp_localize_script'), 10, 1); //modify booking script, force SSL for all
                add_filter('em_booking_form_action_url', array(&$this, 'force_ssl'), 10, 1); //modify booking script, force SSL for all
            }
        }
    }

    /*
     * --------------------------------------------------
     * Booking Interception - functions that modify booking object behaviour
     * --------------------------------------------------
     */

    /**
     * This function intercepts the previous booking form url from the javascript localized array of EM variables and forces it to be an HTTPS url.
     * @param array $localized_array
     * @return array
     */
    function em_wp_localize_script($localized_array) {
        $localized_array['bookingajaxurl'] = $this->force_ssl($localized_array['bookingajaxurl']);
        return $localized_array;
    }

    /**
     * Turns any url into an HTTPS url.
     * @param string $url
     * @return string
     */
    function force_ssl($url) {
        return str_replace('http://', 'https://', $url);
    }

    /**
     * Triggered by the em_booking_add_yourgateway action, modifies the booking status if the event isn't free and also adds a filter to modify user feedback returned.
     * @param EM_Event $EM_Event
     * @param EM_Booking $EM_Booking
     * @param boolean $post_validation
     */
    function booking_add($EM_Event, $EM_Booking, $post_validation = false) {
        global $wpdb, $wp_rewrite, $EM_Notices;
        $this->registered_timer = current_time('timestamp', 1);
        parent::booking_add($EM_Event, $EM_Booking, $post_validation);
        if ($post_validation && empty($EM_Booking->booking_id)) {
            if (get_option('dbem_multiple_bookings') && get_class($EM_Booking) == 'EM_Multiple_Booking') {
                add_filter('em_multiple_booking_save', array(&$this, 'em_booking_save'), 2, 2);
            } else {
                add_filter('em_booking_save', array(&$this, 'em_booking_save'), 2, 2);
            }
        }
    }

    /**
     * Added to filters once a booking is added. Once booking is saved, we capture payment, and approve the booking (saving a second time). If payment isn't approved, just delete the booking and return false for save.
     * @param bool $result
     * @param EM_Booking $EM_Booking
     */
    function em_booking_save($result, $EM_Booking) {
        global $wpdb, $wp_rewrite, $EM_Notices;
        //make sure booking save was successful before we try anything
        if ($result) {
            if ($EM_Booking->get_price() > 0) {
                //handle results
                $capture = $this->authorize_and_capture($EM_Booking);
                if ($capture) {
                    //Set booking status, but no emails sent
                    if (!get_option('em_' . $this->gateway . '_manual_approval', false) || !get_option('dbem_bookings_approval')) {
                        $EM_Booking->set_status(1, false); //Approve
                    } else {
                        $EM_Booking->set_status(0, false); //Set back to normal "pending"
                    }
                } else {
                    //not good.... error inserted into booking in capture function. Delete this booking from db
                    if (!is_user_logged_in() && get_option('dbem_bookings_anonymous') && !get_option('dbem_bookings_registration_disable') && !empty($EM_Booking->person_id)) {
                        //delete the user we just created, only if created after em_booking_add filter is called (which is when a new user for this booking would be created)
                        $EM_Person = $EM_Booking->get_person();
                        if (strtotime($EM_Person->data->user_registered) >= $this->registered_timer) {
                            if (is_multisite()) {
                                include_once(ABSPATH . '/wp-admin/includes/ms.php');
                                wpmu_delete_user($EM_Person->ID);
                            } else {
                                include_once(ABSPATH . '/wp-admin/includes/user.php');
                                wp_delete_user($EM_Person->ID);
                            }
                            //remove email confirmation
                            global $EM_Notices;
                            $EM_Notices->notices['confirms'] = array();
                        }
                    }
                    $EM_Booking->manage_override = true;
                    $EM_Booking->delete();
                    $EM_Booking->manage_override = false;
                    return false;
                }
            }
        }
        return $result;
    }

    /**
     * Intercepts return data after a booking has been made and adds converge vars, modifies feedback message.
     * @param array $return
     * @param EM_Booking $EM_Booking
     * @return array
     */
    function booking_form_feedback($return, $EM_Booking = false) {
        //Double check $EM_Booking is an EM_Booking object and that we have a booking awaiting payment.
        if (!empty($return['result'])) {
            if (!empty($EM_Booking->booking_meta['gateway']) && $EM_Booking->booking_meta['gateway'] == $this->gateway && $EM_Booking->get_price() > 0) {
                $return['message'] = get_option('em_converge_booking_feedback');
            } else {
                //returning a free message
                $return['message'] = get_option('em_converge_booking_feedback_free');
            }
        } elseif (!empty($EM_Booking->booking_meta['gateway']) && $EM_Booking->booking_meta['gateway'] == $this->gateway && $EM_Booking->get_price() > 0) {
            //void this last authroization
            $this->void($EM_Booking);
        }
        return $return;
    }

    /*
     * --------------------------------------------------
     * Booking UI - modifications to booking pages and tables containing converge bookings
     * --------------------------------------------------
     */

    /**
     * Outputs custom content and credit card information.
     */
    function booking_form() {
        echo get_option('em_' . $this->gateway . '_form');
        ?>
        <p class="em-bookings-form-gateway-cardno">
            <label><?php _e('Credit Card Number', 'em-pro'); ?></label>
            <input type="text" size="15" name="x_card_num" value="" class="input" />
        </p>
        <p class="em-bookings-form-gateway-expiry">
            <label><?php _e('Expiry Date', 'em-pro'); ?></label>
            <select name="x_exp_date_month" >
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $m = $i > 9 ? $i : "0$i";
                    echo "<option>$m</option>";
                }
                ?>
            </select> /
            <select name="x_exp_date_year" >
                <?php
                $year = date('Y', current_time('timestamp'));
                for ($i = $year; $i <= $year + 10; $i++) {
                    $v = substr($i,-2);
                    echo "<option value='{$v}'>$i</option>";
                }
                ?>
            </select>
        </p>
        <p class="em-bookings-form-ccv">
            <label><?php _e('CCV', 'em-pro'); ?></label>
            <input type="text" size="4" name="x_card_code" value="" class="input" maxlength="4" />
        </p>
        <?php
    }

    /*
     * --------------------------------------------------
     * Converge Functions - functions specific to converge payments
     * --------------------------------------------------
     */

    /**
     * Get the AuthorizeNetAIM object and set up basic parameters
     * @return AuthorizeNetAIM
     */
    function get_api() {
        if (!class_exists('ConvergeApi')) {
            require_once('converge_php_sdk/ConvergeApi.php');
        }
        $mode = (get_option('em_' . $this->gateway . '_mode') == 'live');
        //Basic Credentials
        $sale = new ConvergeApi(
                get_option('em_' . $this->gateway . '_merchant_id'),
                get_option('em_' . $this->gateway . '_user_id'),
                get_option('em_' . $this->gateway . '_pin'),
                $mode
        );

        return $sale;
    }

    /**
     * Retreive the converge vars needed to send to the gateway to proceed with payment
     * @param EM_Booking $EM_Booking
     */
    function authorize_and_capture($EM_Booking) {
        global $EM_Notices;
        $sale = $this->get_api();
        //Address Info
        $cust_name = $EM_Booking->get_person()->get_name();

        //address slightly special address field
        $address = '';
        if (EM_Gateways::get_customer_field('address', $EM_Booking) != '')
            $address = EM_Gateways::get_customer_field('address', $EM_Booking);
        if (EM_Gateways::get_customer_field('address_2', $EM_Booking) != '')
            $address .= ', ' . EM_Gateways::get_customer_field('address_2', $EM_Booking);
        if (!empty($address))
            $address = substr($address, 0, 60); //cut off at 60 characters

        if (EM_Gateways::get_customer_field('zip', $EM_Booking) != '')
            $zipcode = EM_Gateways::get_customer_field('zip', $EM_Booking);

        $amount = $EM_Booking->get_price(false, false, true);

        $vars = array(
                    'ssl_amount' => $amount,
                    'ssl_card_number' => $_REQUEST['x_card_num'],
                    'ssl_cvv2cvc2' => $_REQUEST['x_card_code'],
                    'ssl_exp_date' => $_REQUEST['x_exp_date_month'] . $_REQUEST['x_exp_date_year'],
                    'ssl_avs_zip' => $zipcode,
                    'ssl_avs_address' => $address,
                    'ssl_last_name' => $cust_name,
                    'product_data' => preg_replace('/[^a-zA-Z0-9\s]/i', "", $EM_Booking->get_event()->event_name)
                );
        //Get Payment
        $sale = apply_filters('em_gateawy_converge_sale_var', $sale, $EM_Booking, $this);
        $response = $sale->ccsale($vars);
        $result = ($response['ssl_result'] == '0' && $response['ssl_txn_id']);
        //Handle result
        if ($result) {
            $EM_Booking->booking_meta[$this->gateway] = array('txn_id' => $response['ssl_txn_id'], 'amount' => $amount);
            $this->record_transaction($EM_Booking, $amount, 'USD', date('Y-m-d H:i:s', current_time('timestamp')), $response['ssl_txn_id'], 'Completed', '');
        } else {
            $EM_Booking->add_error($response['errorName']);
        }

        //Return transaction_id or false
        return apply_filters('em_gateway_converge_authorize', $result, $EM_Booking, $this);
    }

    function void($EM_Booking) {
        if (!empty($EM_Booking->booking_meta[$this->gateway])) {
            $capture = $this->get_api();
            $capture->amount = $EM_Booking->booking_meta[$this->gateway]['amount'];
            $capture->void();
        }
    }

    /*
     * --------------------------------------------------
     * Gateway Settings Functions
     * --------------------------------------------------
     */

    /**
     * Outputs custom PayPal setting fields in the settings page
     */
    function mysettings() {
        global $EM_options;
        ?>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><?php _e('Success Message', 'em-pro') ?></th>
                    <td>
                        <input type="text" name="booking_feedback" value="<?php esc_attr_e(get_option('em_' . $this->gateway . "_booking_feedback")); ?>" style='width: 40em;' /><br />
                        <em><?php _e('The message that is shown to a user when a booking is successful and payment has been taken.', 'em-pro'); ?></em>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Success Free Message', 'em-pro') ?></th>
                    <td>
                        <input type="text" name="booking_feedback_free" value="<?php esc_attr_e(get_option('em_' . $this->gateway . "_booking_feedback_free")); ?>" style='width: 40em;' /><br />
                        <em><?php _e('If some cases if you allow a free ticket (e.g. pay at gate) as well as paid tickets, this message will be shown and the user will not be charged.', 'em-pro'); ?></em>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3><?php echo sprintf(esc_html__emp('%s Options', 'dbem'), 'Converge') ?></h3>

        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><?php _e('Mode', 'em-pro'); ?></th>
                    <td>
                        <select name="mode">
        <?php $selected = get_option('em_' . $this->gateway . '_mode'); ?>
                            <option value="sandbox" <?php echo ($selected == 'sandbox') ? 'selected="selected"' : ''; ?>><?php _e('Sandbox', 'emp-pro'); ?></option>
                            <option value="live" <?php echo ($selected == 'live') ? 'selected="selected"' : ''; ?>><?php _e('Live', 'emp-pro'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('SSL MERCHANT ID', 'emp-pro') ?></th>
                    <td><input type="text" name="ssl_merchant_id" value="<?php esc_attr_e(get_option('em_' . $this->gateway . "_merchant_id", "")); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('SSL USER ID', 'emp-pro') ?></th>
                    <td><input type="text" name="ssl_user_id" value="<?php esc_attr_e(get_option('em_' . $this->gateway . "_user_id", "")); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('SSL PIN', 'emp-pro') ?></th>
                    <td><input type="text" name="ssl_pin" value="<?php esc_attr_e(get_option('em_' . $this->gateway . "_pin", "")); ?>" /></td>
                </tr>
            </tbody>
        </table>
        <?php
    }

    /*
     * Run when saving settings, saves the settings available in EM_Gateway_Authorize_AIM::mysettings()
     */

    function update() {
        parent::update();
        $gateway_options = array(
            $this->gateway . "_mode" => $_REQUEST['mode'],
            $this->gateway . "_merchant_id" => $_REQUEST['ssl_merchant_id'],
            $this->gateway . "_user_id" => $_REQUEST['ssl_user_id'],
            $this->gateway . "_pin" => $_REQUEST['ssl_pin'],
            $this->gateway . "_booking_feedback" => wp_kses_data($_REQUEST['booking_feedback']),
            $this->gateway . "_booking_feedback_free" => wp_kses_data($_REQUEST['booking_feedback_free'])
        );
        foreach ($gateway_options as $key => $option) {
            update_option('em_' . $key, stripslashes($option));
        }
        //default action is to return true
        return true;
    }

}

EM_Gateways::register_gateway('converge', 'EM_Gateway_Converge');
?>