<?php if (!defined('ABSPATH')) {
    die('You are not allowed to call this page directly.');
}
if (!isset($_GET['action'])):
    $address_type = do_shortcode('[mepr-account-info field="mepr_address"]');
    $professional_goal = do_shortcode('[mepr-account-info field="mepr_professional_goals"]');
    $business_phone = do_shortcode('[mepr-account-info field="mepr_business_phone_number"]');
    $mobile_phone = do_shortcode('[mepr-account-info field="mepr_mobile_phone_number"]');
// $committee_interest=do_shortcode('[mepr-account-info field="mepr_committee_interest"]');
// echo implode(" ",$committee_interest);
// $committee_interest=str_replace(array( '[', ']','"' ), '', $committee_interest);
    $committee_interest = do_shortcode('[mepr-account-info field="mepr_member_of_wel_committees"]');
    function format_phone_us($phone)
    {

        // note: making sure we have something
        if (!isset($phone{3})) {
            return '';
        }
        // note: strip out everything but numbers
        $phone = preg_replace("/[^0-9]/", "", $phone);

        $length = strlen($phone);
        switch ($length) {
            case 7:
                return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
                break;
            case 10:
                return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
                break;
            case 11:
                return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1 $2-$3-$4", $phone);
                break;
            case 12:
                return preg_replace("/([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})/", "$2 $3-$3-$4", $phone);
                break;
            default:
                return $phone;
                break;
        }
    }

    function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (strlen($phoneNumber) > 10) {
            $countryCode = substr($phoneNumber, 0, strlen($phoneNumber) - 10);
            $areaCode = substr($phoneNumber, -10, 3);
            $nextThree = substr($phoneNumber, -7, 3);
            $lastFour = substr($phoneNumber, -4, 4);

            $phoneNumber = '+' . $countryCode . ' (' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
        } else if (strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
        } else if (strlen($phoneNumber) == 7) {
            $nextThree = substr($phoneNumber, 0, 3);
            $lastFour = substr($phoneNumber, 3, 4);

            $phoneNumber = $nextThree . '-' . $lastFour;
        }

        return $phoneNumber;
    }

    if (strlen($professional_goal) > 30) {
        $professional_goal_sub = strlen($professional_goal) - 30;
        $professional_goal_remain = substr($professional_goal, 0, -($professional_goal_sub));
        $professional_goal = $professional_goal_remain . "...";
    };

    if ($address_type == "other-address") {
        $mepr_street_address = do_shortcode('[mepr-account-info field="mepr_address_line_1"]');
        $mepr_street_address_line = do_shortcode('[mepr-account-info field="mepr_address_line_2"]');
        $mepr_city = do_shortcode('[mepr-account-info field="mepr_city"]');
        $mepr_state_province = do_shortcode('[mepr-account-info field="mepr_state_province_region"]');
        $mepr_zip_postal = do_shortcode('[mepr-account-info field="mepr_zip_postal_code"]');
        $mepr_country = do_shortcode('[mepr-account-info field="mepr_business_county"]');

        $mepr_street_address_line = $mepr_street_address_line ? ',' . $mepr_street_address_line : '';
        $mepr_city = $mepr_city ? '<br>'. $mepr_city : '';
        $mepr_state_province = $mepr_state_province ? ',' . $mepr_state_province : '';

        $complete_address = $mepr_street_address . $mepr_street_address_line . $mepr_city . $mepr_state_province;
    } else {
        $mepr_street_address = do_shortcode('[mepr-account-info field="mepr_address_line_1"]');
        $mepr_street_address_line = do_shortcode('[mepr-account-info field="mepr_address_line_2"]');
        $mepr_city = do_shortcode('[mepr-account-info field="mepr_city"]');
        $mepr_state_province = do_shortcode('[mepr-account-info field="mepr_state_province_region"]');
        $mepr_zip_postal = do_shortcode('[mepr-account-info field="mepr_zip_postal_code"]');
        $mepr_country = do_shortcode('[mepr-account-info field="mepr_business_county"]');

        $mepr_street_address_line = $mepr_street_address_line ? ',' . $mepr_street_address_line : '';
        $mepr_city = $mepr_city ? '<br>' . $mepr_city : '';
        $mepr_state_province = $mepr_state_province ? ',' . $mepr_state_province : '';

        $complete_address = $mepr_street_address . $mepr_street_address_line . $mepr_city . $mepr_state_province;
    }
    $mepr_first_name = do_shortcode('[mepr-account-info field="mepr_first_name"]');
    $mepr_middle_name = do_shortcode('[mepr-account-info field="mepr_middle_name"]');
    $mepr_last_name = do_shortcode('[mepr-account-info field="mepr_last_name"]');
    ?>
    <div class="portal-wrap">
        <div class="mp_wrapper">
            <div id="mepr-account-nav" class="main-title">
                <div class="container">
                    <?php
                    $current_user = wp_get_current_user();

                    printf(__('<h1>Welcome <span>%s</span></h1>', 'textdomain'), esc_html($current_user->user_firstname)) . '<br />';
                    ?>
                </div>
            </div>
        </div>

        <div class="portal-tabs">
            <div class="container">
                <ul>
                    <li class="account-tab">
                        <a href="<?php echo home_url('/account'); ?>">
                            <i class="fa fa-user"></i>
                            <span>My Member Portal</span>
                        </a>
                    </li>
                    <li class="evnets-tab">
                        <a href="?action=events">
                            <i class="fa fa-shield"></i>
                            <span>My Events</span>
                        </a>
                    </li>
                    <li class="home-tab">
                        <a href="?action=home">
                            <i class="fa fa-tasks"></i>
                            <span>My Profile</span>
                        </a>
                    </li>

                    <li class="subscriptions-tab">
                        <a href="?action=subscriptions">
                            <i class="fa fa-user-plus"></i>
                            <span>Membership</span>
                        </a>
                    </li>
                    <li class="members-tab">
                        <a href="?action=members">
                            <i class="fa fa-address-book-o"></i>
                            <span>Membership Directory</span>
                        </a>
                    </li>
                    <li class="documents-tab">
                        <a href="?action=documents">
                            <i class="fa fa-address-book"></i>
                            <span>Member Resource</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="portal-profile">
            <div class="container">
                <div class="portal-profile-content">
                    <div class="profile-img">
                        <div class="image">
                            <?php $img = do_shortcode('[mepr-account-info field="mepr_image"]');

                            if (!$img) {
                                $img = home_url('/wp-content/uploads/2021/04/iconfinder_user_female_172621.png');
                            }
                            ?>
                            <img width="300" height="300" src="<?php echo $img; ?>">
                        </div>
                        <a href="?action=home" class="btn red">EDIT PROFILE</a>
                    </div>
                    <div class="profile-content">
                        <div class="profile-title">
                            <h3><?php echo $mepr_first_name . " " . $mepr_middle_name . " " . $mepr_last_name;
                                $user = MeprUtils::get_currentuserinfo();
                                ?>
                                <span class="profile-designation"><?php echo str_replace(array('Welflorida', 'Membership'), array('', 'Member'), $user->get_active_subscription_titles()); ?></span>
                                <span class="profile-designation"><?php echo do_shortcode('[mepr-account-info field="mepr_position_title"]'); ?></span>
                            </h3>
                            <div class="profile-location"><i
                                        class="fa fa-map-marker"></i><?php echo str_replace(',', '', $mepr_city) . $mepr_state_province; ?>
                            </div>
                        </div>

                        <ul class="profile-info">
                            <li>
                                <span class="pi-title">Company Name:</span>
                                <span class="pi-value"><?php echo do_shortcode('[mepr-account-info field="mepr_company"]'); ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Employment Status:</span>
                                <span class="pi-value"><?php echo do_shortcode('[mepr-account-info field="mepr_employment_status"]'); ?></span>
                            </li>

                            <li>
                                <span class="pi-title">Primary Email:</span>
                                <span class="pi-value"><?php echo do_shortcode('[mepr-account-info field="mepr_primary_email"]'); ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Secondary Email:</span>
                                <span class="pi-value"><?php echo do_shortcode('[mepr-account-info field="mepr_alternate_email"]'); ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Business Phone:</span>
                                <span class="pi-value"><?php echo formatPhoneNumber($business_phone); ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Mobile Phone:</span>
                                <span class="pi-value"><?php echo formatPhoneNumber($mobile_phone); ?></span>
                            </li>


                            <?php

                            if ($address_type == "other-address") { ?>
                                <li>
                                    <span class="pi-title">Address:</span>
                                    <span class="pi-value"><?php echo $complete_address; ?></span>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <span class="pi-title">Address:</span>
                                    <span class="pi-value"><?php echo $complete_address; ?></span>
                                </li>
                            <?php } ?>
                            <li>
                                <span class="pi-title">Professional Goals:</span>
                                <span class="pi-value"><?php echo $professional_goal ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Member Type:</span>
                                <span style="text-transform: capitalize;"
                                      class="pi-value"><?php echo str_replace(array('-'), array(' '), get_user_meta(get_current_user_id(), 'mepr_member_type', 1)) ?: str_replace(array('Welflorida', 'Membership'), array('', 'Member'), $user->get_active_subscription_titles()); ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Committee(s):</span>
                                <span class="pi-value"><?php echo $committee_interest ?: 'None'; ?></span>
                            </li>
                        </ul>

                        <!--                        <div class="upgrade-container" style="text-align:left;width:100%;">-->
                        <!--                            <a href="/plans/welflorida-memberships/"-->
                        <!--                               class="btn red">Upgrade Membership</a>-->
                        <!--                        </div>-->

                    </div>
                    <?php
                    if (class_exists('MeprUtils')) {
                        $subscriptions = $user->active_product_subscriptions('transactions');
                        if (!empty($subscriptions)) {
                            foreach ($subscriptions as $s):
                                $expire = $s->expires_at;
                                if ($expire == '0000-00-00 00:00:00') {
                                    @$expires_at = 'Lifetime';
                                } else {
                                    @$expires_at = date('m-d-Y', strtotime($expire));
                                }
                                // $user_membershi_data[$s->product_id]['expires_at'] = $expires_at;
                                break;
                            endforeach;
                        }
                    }
                    ?>
                    <div class="athena-portal-wrapper">
                        <?php if (get_single_active_product_subscription_custom(get_current_user_id())) { ?>
                            <a style="background: #002060;" class="btn blue"
                               href=" https://login.athenaalliance.com/login?state=g6Fo2SBuRUk4ZHVjSlJJSmJpbUdhVThoX2xBVk5BX0lkYTlmWaN0aWTZIEhYMnZsdEVQRzl4ZllXVkdEcmdlNENGOHczS2l0RVlHo2NpZNkgcWx0ZnNaS1M3Z2lmMTJhWVlnMmZoWkkyV0hLY0Y5amk&client=qltfsZKS7gif12aYYg2fhZI2WHKcF9ji&protocol=oauth2&connection=DB-Athena-Alliance&scope=openid%20email%20profile&nonce=70b218c60b672a8035b4096feadd72908c6e1342014179e405e5248e3497eb1d&response_type=code&response_mode=query&redirect_uri=https%3A%2F%2Fportal.athenaalliance.com%2Findex.php%3Fauth0%3D1">
                                Access Athena Portal
                            </a>
                        <?php } ?>
                    </div>
                    <div class="member-renewal">Membership Renewal: <?php echo @$expires_at ?></div>
                </div>
            </div>

        </div>


        <div class="portal-members">
            <?php if (class_exists('MeprUtils')) {
                $user = MeprUtils::get_currentuserinfo();
                $subscriptions = $user->active_product_subscriptions('transactions');
                if ($subscriptions) {
                    ?>
                    <div class="container">
                        <h2>Join Us in <strong>Welcoming New Members</strong></h2>
                        <ul class="member-listing">
                            <?php
                            global $wpdb;
                            $membership_ids = $wpdb->get_results(" SELECT * FROM `wp_mepr_members` where memberships != '' ");
                            // $user_info = get_user_meta($value->id,'mepr_first_name');

                            $results = $wpdb->get_results(" SELECT wp_usermeta.meta_key,wp_usermeta.meta_value,wp_usermeta.user_id FROM wp_mepr_members LEFT JOIN wp_usermeta ON wp_mepr_members.user_id = wp_usermeta.user_id WHERE wp_mepr_members.memberships != '' AND (wp_usermeta.meta_key= 'mepr_image' OR wp_usermeta.meta_key='mepr_first_name')
 Limit 6 ");
                            $member_ids_array = wp_list_pluck($membership_ids, "user_id");
                            $args = array(
                                'include' => $member_ids_array,
                                'number' => 4,
                                'orderby' => 'user_registered',
                                'order' => 'DESC',
                                'meta_query' => array(
                                    array(
                                        'relation' => 'OR',
                                        array(
                                            'key' => 'mepr_hide_from_member_directory',
                                            // 'value' => 'on',
                                            'compare' => 'NOT EXISTS',
                                        ),
                                        array(
                                            'key' => 'mepr_hide_from_member_directory',
                                            'value' => 'on',
                                            'compare' => '!=',
                                        )
                                    )
                                )
                            );
                            $users = get_users($args);
                            foreach ($users as $value) {
                                $user_info = get_user_meta($value->ID);
                                // echo "<pre>";
                                // print_r($user_info);
                                // die;


                                if (!$user_info['mepr_image'][0]) {
                                    $user_info['mepr_image'][0] = home_url('/wp-content/uploads/2021/04/iconfinder_user_female_172621.png');
                                }
                                ?>
                                <li>
                                    <a href="<?php echo "?action=single_member&id=" . $value->ID; ?>"><img
                                                style="max-height: 228px; max-width: 228px; width: 228px;height: 228px; object-fit: cover;object-position: top;"
                                                src="<?php echo $user_info['mepr_image'][0]; ?>">
                                    </a>
                                    <a href="<?php echo "?action=single_member&id=" . $value->ID; ?>"
                                       class="mem_name"><?php echo $user_info['first_name'][0] . " " . $user_info['last_name'][0]; ?></a>
                                </li>
                            <?php }

                            ?>
                            <!-- <a href="?action=members" class="btn red viewall-members">View All <i class="fa fa-angle-right"></i></a> -->
                        </ul>
                        <a href="/account/?action=members" class="btn red viewall-members">View All</a>
                    </div>
                <?php }
            } ?>
        </div>

    </div>
<?php endif; ?>
