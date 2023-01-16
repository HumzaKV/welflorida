<?php if (!defined('ABSPATH')) {
    die('You are not allowed to call this page directly.');
} ?>
<?php

// home page Edit profile

if (isset($_GET['action']) && $_GET['action'] == "home") {
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
                    <li class="evnets-tab"><a href="?action=events">
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
                <!--  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Setting</button>
                 <button class="tablinks" onclick="openCity(event, 'Paris')">Historical Timeline</button> -->
                <!-- <a href="<?php // echo MeprHooks::apply_filters('mepr-account-nav-subscriptions-link',$account_url.$delim.'action=subscriptions'); ?>" id="mepr-account-subscriptions" class="btn red"><?php // echo MeprHooks::apply_filters('mepr-account-nav-subscriptions-label',_x('Subscriptions', 'ui', 'memberpress')); ?></a> -->
            </div>
        </div>
    </div>
    <div class="portal_edit">
        <div class="container">
            <div class="mp_wrapper">
                <?php if (!empty($welcome_message)): ?>
                    <div id="mepr-account-welcome-message">
                        <?php echo MeprHooks::apply_filters('mepr-account-welcome-message', do_shortcode($welcome_message), $mepr_current_user); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($mepr_current_user->user_message)): ?>
                    <div id="mepr-account-user-message">
                        <?php echo MeprHooks::apply_filters('mepr-user-message', wpautop(do_shortcode($mepr_current_user->user_message)), $mepr_current_user); ?>
                    </div>
                <?php endif; ?>

                <?php MeprView::render('/shared/errors', get_defined_vars()); ?>

                <form class="mepr-account-form mepr-form" id="mepr_account_form" action="" method="post"
                      enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="mepr-process-account" value="Y"/>
                    <?php wp_nonce_field('update_account', 'mepr_account_nonce'); ?>

                    <?php MeprHooks::do_action('mepr-account-home-before-name', $mepr_current_user); ?>

                    <?php if ($mepr_options->show_fname_lname): ?>
                        <div class="mp-form-row mepr_first_name left-half-third">
                            <div class="mp-form-label">
                                <label for="user_first_name"><?php _ex('First Name:', 'ui', 'memberpress');
                                    echo ($mepr_options->require_fname_lname) ? '*' : ''; ?></label>
                                <span class="cc-error"><?php _ex('First Name Required', 'ui', 'memberpress'); ?></span>
                            </div>
                            <input type="text" name="user_first_name" id="user_first_name" class="mepr-form-input"
                                   value="<?php echo $mepr_current_user->first_name; ?>" <?php echo ($mepr_options->require_fname_lname) ? 'required' : ''; ?> />
                        </div>
                        <div class="mp-form-row mepr_last_name middle-half-third">
                            <div class="mp-form-label">
                                <label for="user_last_name"><?php _ex('Last Name:', 'ui', 'memberpress');
                                    echo ($mepr_options->require_fname_lname) ? '*' : ''; ?></label>
                                <span class="cc-error"><?php _ex('Last Name Required', 'ui', 'memberpress'); ?></span>
                            </div>
                            <input type="text" id="user_last_name" name="user_last_name" class="mepr-form-input"
                                   value="<?php echo $mepr_current_user->last_name; ?>" <?php echo ($mepr_options->require_fname_lname) ? 'required' : ''; ?> />
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="user_first_name"
                               value="<?php echo $mepr_current_user->first_name; ?>"/>
                        <input type="hidden" name="user_last_name"
                               value="<?php echo $mepr_current_user->last_name; ?>"/>
                    <?php endif; ?>
                    <div class="mp-form-row mepr_email right-half-third">
                        <div class="mp-form-label">
                            <label for="user_email"><?php _ex('Email:*', 'ui', 'memberpress'); ?></label>
                            <span class="cc-error"><?php _ex('Invalid Email', 'ui', 'memberpress'); ?></span>
                        </div>
                        <input type="email" id="user_email" name="user_email" class="mepr-form-input"
                               value="<?php echo $mepr_current_user->user_email; ?>" required/>
                    </div>


                    <?php

                    MeprUsersHelper::render_custom_fields(null, 'account');
                    MeprHooks::do_action('mepr-account-home-fields', $mepr_current_user);
                    ?>

                    <div class="mepr_spacer">&nbsp;</div>
                    <div class="account-submit-btns">
                        <div class="account-submit">
                            <input type="submit" name="mepr-account-form"
                                   value="<?php _ex('Save Profile', 'ui', 'memberpress'); ?>"
                                   class="mepr-submit mepr-share-button"/>
                        </div>

                        <span class="mepr-account-change-password">
      <a href="<?php echo $account_url . $delim . 'action=newpassword'; ?>"
         class="orange btn"><?php _ex('Change Password', 'ui', 'memberpress'); ?></a>
    </span>
                    </div>
                    <img src="<?php echo admin_url('images/loading.gif'); ?>" style="display: none;"
                         class="mepr-loading-gif"/>
                    <?php //Mepriew::render('/shared/has_errors', get_defined_vars()); ?>
                </form>


                <?php MeprHooks::do_action('mepr_account_home', $mepr_current_user); ?>
            </div>
        </div>
    </div>
    <?php
}

// Events History
if (isset($_GET['action']) && $_GET['action'] == "events") {

    if (class_exists('MeprUtils')) {
        $user = MeprUtils::get_currentuserinfo();
        $user = $user->ID;
        global $wpdb;
        $results = $wpdb->get_results("SELECT wp_acf_data.post_id,wp_acf_data.e_start,wp_acf_data.e_end FROM wp_acf_data LEFT JOIN wp_gf_custom ON wp_acf_data.post_id = wp_gf_custom.event_id WHERE wp_gf_custom.user_id='" . $user . "' AND wp_acf_data.available_for='member' ");
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
                        <li class="evnets-tab"><a href="?action=events">
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
                    <!--  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Setting</button>
                     <button class="tablinks" onclick="openCity(event, 'Paris')">Historical Timeline</button> -->
                    <!-- <a href="<?php // echo MeprHooks::apply_filters('mepr-account-nav-subscriptions-link',$account_url.$delim.'action=subscriptions'); ?>" id="mepr-account-subscriptions" class="btn red"><?php // echo MeprHooks::apply_filters('mepr-account-nav-subscriptions-label',_x('Subscriptions', 'ui', 'memberpress')); ?></a> -->
                </div>
            </div>
        </div>


        <div class="main-event">
            <div class="title red"><h2>UPCOMING <span>EVENTS</span></h2></div>
            <table>
                <tr>
                    <th>Event Name</th>
                    <th>Event Date</th>
                </tr>
                <?php
                $current_date_time = date('Y-m-d h:i:s a');
                if (!empty($results)) {
                    foreach ($results as $key => $value) {
                        if ($current_date_time <= date('Y-m-d h:i:s a', strtotime($value->e_start))) {
                            ?>
                            <tr>
                                <td><?php echo get_the_title($value->post_id); ?></td>
                                <td><?php echo date('m/d/Y h:i:s a', strtotime($value->e_start)) ?></td>
                            </tr>
                        <?php }

                    }
                } else {
                    echo "No Upcoming Events";

                }
                ?>
            </table>
            <?php

            // $post_id = get_the_ID();
            // $current_date_time= date('Y-m-d h:i:s a');
            // $startTimeDate=get_field('start_date',$post_id);
            // $startTimeDateComplete = date('Y-m-d h:i:s a', strtotime($startTimeDate));

            // $startDate = date('Y-m-d', strtotime($startTimeDate));
            // $startTime = date('g:i a', strtotime($startTimeDate));

            // $endTimeDate=get_field('end_date',$post_id);
            // $endDate = date('Y-m-d', strtotime($endTimeDate));
            // $endTime = date('g:i a', strtotime($endTimeDate));
            // die;


            ?>
        </div>
        <div class="main-event past-events">

            <div class="title orange"><h2>Past <span>EVENTS</span></h2></div>
            <table>
                <tr>
                    <th>Event Name</th>
                    <th>Event Date</th>
                </tr>
                <?php
                $current_date_time = date('Y-m-d h:i:s a');
                if (!empty($results)) {
                    foreach ($results as $key => $value) {
                        if ($current_date_time > date('Y-m-d h:i:s a', strtotime($value->e_start))) {

                            ?>
                            <tr>
                                <td><?php echo get_the_title($value->post_id); ?></td>
                                <td><?php echo date('m/d/Y h:i:s a', strtotime($value->e_start)) ?></td>

                            </tr>
                        <?php }
                    }
                } else {
                    echo "No Past Events";
                } ?>
            </table>
        </div>

        <?php
    }
}

if (isset($_GET['action']) && $_GET['action'] == "members") {
    $first_name = isset($_GET['first-name']) ? $_GET['first-name'] : null;
    $last_name = isset($_GET['last-name']) ? $_GET['last-name'] : null;
    $position = isset($_GET['position']) ? $_GET['position'] : null;
    $company = isset($_GET['company']) ? $_GET['company'] : null;
    $member_type = isset($_GET['member_type']) ? $_GET['member_type'] : null;
    $userArgs = array(
        'orderby' => 'name',
        'order' => 'ASC',
        'role' => 'subscriber',
        'fields' => 'all_with_meta',
        'number' => -1
    );
    $metaQuery = array();
    $name = '';
    if (!empty($first_name)) {
        $name = $first_name;
    }
    if (!empty($last_name)) {
        $name .= ' ' . $last_name;
    }
    if (!empty($name)) {
        $userArgs['search'] = '*' . esc_attr(trim($name)) . '*';
        $userArgs['search_columns'] = array('display_name', 'user_nicename');
    }

    if (!empty($position)) {
        $metaQuery[] = array(
            'key' => 'mepr_position_title',
            'value' => $position,
        );
    }
    if (!empty($company)) {
        $metaQuery[] = array(
            'key' => 'mepr_company',
            'value' => $company,
        );
    }
    if (!empty($member_type)) {

        if ($member_type === 'diamond-member') {
            // echo $member_type;
            $metaQuery[] = array(
                'key' => 'mepr_member_type',
                'value' => ['diamond-member', 'diamond-board-member'],
                // 'Orderby' => 'DESC',
            );
        } else if ($member_type === 'charter-member') {
            $metaQuery[] = array(
                'key' => 'mepr_member_type',
                'value' => ['charter-member', 'charter-board-member'],
                // 'Orderby' => 'DESC',
            );
        } else {
            $metaQuery[] = array(
                'key' => 'mepr_member_type',
                'value' => $member_type,

            );
        }
    }
    if (!empty($metaQuery)) {
        $userArgs['meta_query'] =
            array(
                'relation' => 'AND',
            );
        $userArgs['meta_query'] = array_merge($userArgs['meta_query'], $metaQuery);
    }
    // $user_query = new WP_User_Query($userArgs);
    $user_query = get_users($userArgs);
    // echo '<pre>';
    // print_r($userArgs);
    // // print_r($user_query);
    // echo '</pre>';
    // die;
    ?>
    <div class="membership-directory">
        <div class="main-title">
            <div class="container">
                <h1>MEMBERSHIP <span>DIRECTORY</span></h1>
            </div>
        </div>

        <div class="member-search-wrap">
            <div class="container">
                <div class="member-search">
                    <h3>SEARCH MEMBER</h3>
                    <form action="<?php echo home_url('/account') ?>">
                        <input type="hidden" name="action" value="members">
                        <input type="text" name="first-name" placeholder="First Name" value="<?php echo $first_name; ?>"
                               class="search_first_name">
                        <input type="text" name="last-name" placeholder="Last Name" value="<?php echo $last_name; ?>"
                               class="search_last_name">
                        <input type="text" name="position" placeholder="Position" value="<?php echo $position; ?>"
                               class="search_position">
                        <input type="text" name="company" placeholder="Company" value="<?php echo $company; ?>"
                               class="search_company">
                        <select name="member_type" placeholder="Member Type" value="<?php echo $member_type; ?>"
                                class="search_member_type">
                            <option <?= !isset($_GET['member_type']) ? 'selected' : '' ?> value="">Select Member Type
                            </option>
                            <option <?= @$_GET['member_type'] == 'diamond-member' ? 'selected' : '' ?>
                                    value="diamond-member">Diamond Member
                            </option>
                            <option <?= @$_GET['member_type'] == 'charter-member' ? 'selected' : '' ?>
                                    value="charter-member">Charter Member
                            </option>
                            <option <?= @$_GET['member_type'] == 'diamond-board-member' ? 'selected' : '' ?>
                                    value="diamond-board-member">Diamond - Board Member
                            </option>
                            <option <?= @$_GET['member_type'] == 'charter-board-member' ? 'selected' : '' ?>
                                    value="charter-board-member">Charter - Board Member
                            </option>
                        </select>
                        <button type="submit">SEARCH</button>
                        <?php if ($first_name || $last_name || $position || $company || $member_type): ?>
                            <div class="reset-button"><a class="reset-filter"
                                                         href="<?php echo home_url('/account/?action=members') ?>">Reset
                                    Filter</a></div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="back_button">
            <a href="<?php echo home_url('/account'); ?>" class="btn red"><i class="fa fa-chevron-left"></i> Back to
                Account</a>
        </div>
        <div class="container">
            <ul id="myUL">
                <?php
                // if (!empty($user_query->get_results())) {
                    // foreach ($user_query->get_results() as $user) {
                if (!empty($user_query)) {
                    foreach ($user_query as $user) {
                        $all_meta_for_user = array_map(function ($a) {
                            return $a[0];
                        }, get_user_meta($user->id));
    //                     echo '<pre>';
    // print_r($all_meta_for_user);
    // // print_r($user_query);
    // echo '</pre>';die;
                        global $wpdb;
                        $status_id = $wpdb->get_results("SELECT `active_txn_count` FROM `wp_mepr_members` WHERE `user_id` = $user->id");
                        if ($status_id[0]->active_txn_count == 0) {
                            continue;
                        }

                        // var_dump($status_id[0]->active_txn_count);

                        if (empty($all_meta_for_user['mepr_image'])) {
                            $all_meta_for_user['mepr_image'] = home_url('/wp-content/uploads/2021/04/iconfinder_user_female_172621.png');
                        } else {
                            $member_type = $all_meta_for_user['mepr_member_type'];
                        }
                        if ($member_type) {
                            $member_type = str_replace(array("-"), array(" "), $member_type);
                            $member_type = ucwords($member_type);
                        } else {
                            $member_type = 'None';
                        }
                        $well_committees_unserialize = @unserialize($all_meta_for_user['mepr_member_of_wel_committees']);
                        if ($well_committees_unserialize) {
                            $well_committees = implode(", ", array_map('ucfirst', array_keys($well_committees_unserialize)));
                        } else {
                            $well_committees = "None";
                        }

                        if ($all_meta_for_user['mepr_member_type']) {
                            $membertype = $all_meta_for_user['mepr_member_type'];
                            $membertype = str_replace(array("-"), array(" "), $membertype);
                            $membertype = ucwords($membertype);
                        } else {
                            $membertype = 'None';
                        }

                        ?>
                        <li class="search_all <?= strtolower($membertype); ?> ">
                            <div class="member-img"><img width="300" height="300"
                                                         src="<?php echo $all_meta_for_user['mepr_image']; ?>"></div>
                            <div class="member-content">
                                <div class="md-user-title">
                                    <h3><?php echo $all_meta_for_user['first_name'] . " " . $all_meta_for_user['last_name']; ?></h3>
                                    <span class="md-user-value"><?php echo $membertype == 'None' ? '' : $membertype; ?>
                                        <?php
                                        if (strpos(strtolower($membertype), 'diamond') !== false) {
                                            ?>
                                            <i class="fa fa-diamond" aria-hidden="true"></i>
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="md-title" id="company_name_id">Company Name: <span
                                            class="md-value"><?php echo $all_meta_for_user['mepr_company']; ?></span>
                                </div>
                                <div class="md-title">Employment Status: <span
                                            class="md-value"><?php echo $all_meta_for_user['mepr_employment_status']; ?></span>
                                </div>
                                <div class="md-title">Position/Title: <span
                                            class="md-value"><?php echo $all_meta_for_user['mepr_position_title']; ?></span>
                                </div>
                                <div class="md-title">Committees: <span
                                            class="md-value"><?php echo $well_committees; ?></span></div>

                                <div class="md-title">Linkedin Id: <span class="md-value"><a
                                                href="<?php echo $all_meta_for_user['mepr_linkedin_id']; ?>"><?php echo $all_meta_for_user['mepr_linkedin_id']; ?></a></span>
                                </div>
                                <div class="md-title">City: <span
                                            class="md-value"><?php echo $all_meta_for_user['mepr_city']; ?></span></div>
                                <a class="link-bio" href="<?php echo "?action=single_member&id=" . $user->ID ?>">View
                                    Full
                                    Profile</a>
                            </div>
                        </li>
                        <?php
                    }
                } else {
                    echo '<li style="width:100%;" id="search_all">No Data Found</li>';
                }
                ?>
            </ul>
        </div>
    </div>
    <?php
}

if (isset($_GET['action']) && $_GET['action'] == "single_member" && isset($_GET['id'])) {


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

    // $id=htmlspecialchars($_GET["id"]);
    $id = $_GET['id'];
    // $user_info = get_user_meta($id);
    $all_meta_for_user = array_map(function ($a) {
        return $a[0];
    }, get_user_meta($id));;
    $address_type = $all_meta_for_user['mepr_address'];
    $address_line_2 = $all_meta_for_user['mepr_address_line_2'];
    if ($address_line_2) {
        $address_line_2 = ",<br>" . $address_line_2 . ",<br>";
    } else {
        $address_line_2 = ",<br>";
    }
    $address_state = $all_meta_for_user['mepr_state_province_region'];
    if ($address_state) {
        $address_state = ", " . $address_state . ", ";
    } else {
        $address_state = ", ";
    }


    if ($address_type == "other-address") {
        $complete_address = $all_meta_for_user['mepr_address_line_1'] . "" . $address_line_2 . $all_meta_for_user['mepr_city'] . $address_state . $all_meta_for_user['mepr_zip_postal_code'];
    } else {
        $complete_address = $all_meta_for_user['mepr_address_line_1'] . "" . $address_line_2 . $all_meta_for_user['mepr_city'] . $address_state . $all_meta_for_user['mepr_zip_postal_code'];
    }

    $well_committees_unserialize = @unserialize($all_meta_for_user['mepr_member_of_wel_committees']);
    if ($well_committees_unserialize) {
        $well_committees = implode(", ", array_map('ucfirst', array_keys($well_committees_unserialize)));
    } else {
        $well_committees = "None";
    }

    $professional_goals = $all_meta_for_user['mepr_professional_goals'];
    if ($professional_goals) {
        $professional_goals = str_replace("-", " ", $professional_goals);
        $professional_goals = ucwords($professional_goals);
        $professional_goals = str_replace(' A ', ' a ', ucwords($professional_goals));

    } else {
        $professional_goals = 'None';
    }
    $member_type = $all_meta_for_user['mepr_member_type'];
    if ($member_type) {
        $member_type = str_replace("-", " ", $member_type);
        $member_type = ucwords($member_type);

    } else {
        $member_type = 'None';
    }
    if (!$all_meta_for_user['mepr_address_line_1'] && !$all_meta_for_user['mepr_address'] && !$all_meta_for_user['mepr_city'] && !$all_meta_for_user['mepr_state_province_region'] && !$all_meta_for_user['mepr_zip_postal_code'] && !$all_meta_for_user['mepr_business_county']) {
        $complete_address = "None";
    }
    ?>
    <div class="single-member-wrap">
        <div class="main-title">
            <div class="container">
                <h1>MEMBER <span>DETAILS</span></h1>
            </div>
        </div>
        <div class="back_button">
            <a href="<?php echo home_url('/account/?action=members'); ?>" class="btn red"><i
                        class="fa fa-chevron-left"></i> Back to Membership Directory</a>
        </div>

        <div class="single-member-detail-wrap">
            <div class="container">
                <div class="single-member-detail">
                    <div class="member-img">
                        <?php if (empty($all_meta_for_user['mepr_image'])) {
                            $all_meta_for_user['mepr_image'] = home_url('/wp-content/uploads/2021/04/iconfinder_user_female_172621.png');
                        } ?>
                        <div class="image"><img width="300" height="300"
                                                src="<?php echo $all_meta_for_user['mepr_image'] ?>"></div>
                        <?php if ($all_meta_for_user['mepr_linkedin_id']) { ?>
                            <div class="single_member_btn">
                                <a href="<?php echo esc_url($all_meta_for_user['mepr_linkedin_id']); ?>" class="btn">LINKEDIN
                                    PROFILE</a>
                            </div>
                        <?php } ?>
                        <?php if (!empty($all_meta_for_user['mepr_bio_resume'])) { ?>
                            <div class="single_member_btn">
                                <a href="<?php echo esc_url($all_meta_for_user['mepr_bio_resume']); ?>" class="btn">Bio/Resume</a>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                    // print_r($all_meta_for_user);
                    if ($all_meta_for_user['mepr_member_type'] == 'diamond-board-member' || $all_meta_for_user['mepr_member_type'] == 'charter-board-member') {
                        $board_member = 'Board Member';
                    }
                    ?>
                    <div class="member-content">

                        <div class="member-title">
                            <h3><?php echo $all_meta_for_user['first_name'] . " " . $all_meta_for_user['last_name'];
                                ?>
                                <span class="profile-designation"><?php echo $member_type ?: ''; ?></span>
                                <?php if ($board_member) { ?>
                                    <span class="profile-designation"><?php echo $board_member; ?></span>
                                <?php } ?>
                            </h3>
                        </div>

                        <ul class="member-info">
                            <li>
                                <span class="pi-title">Title:</span>
                                <span class="pi-value"><?php echo $all_meta_for_user['mepr_position_title'] ?: ""; ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Company Name:</span>
                                <span class="pi-value"><?php echo $all_meta_for_user['mepr_company'] ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Employment Status:</span>
                                <span class="pi-value"><?php echo $all_meta_for_user['mepr_employment_status'] ?></span>

                            </li>

                            <li>
                                <span class="pi-title">Primary Email:</span>
                                <span class="pi-value"><a
                                            href="mailto:<?php echo $all_meta_for_user['mepr_primary_email'] ?>"><?php echo $all_meta_for_user['mepr_primary_email'] ?></a></span>
                            </li>
                            <li>
                                <span class="pi-title">Secondary Email:</span>
                                <span class="pi-value"><a
                                            href="mailto:<?php echo $all_meta_for_user['mepr_alternate_email'] ?>"><?php echo $all_meta_for_user['mepr_alternate_email'] ?></a></span>
                            </li>
                            <li>
                                <span class="pi-title">Business Phone:</span>
                                <span class="pi-value"><?php echo formatPhoneNumber($all_meta_for_user['mepr_business_phone_number']) ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Mobile Phone:</span>
                                <span class="pi-value"><?php echo formatPhoneNumber($all_meta_for_user['mepr_mobile_phone_number']) ?></span>
                            </li>
                            <?php
                            if ($address_type == "other-address") { ?>
                                <li>
                                    <span class="pi-title">Address:</span>
                                    <span class="pi-value"><?php echo $complete_address ?></span>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <span class="pi-title">Address:</span>
                                    <span class="pi-value"><?php echo $complete_address ?></span>
                                </li>
                            <?php } ?>
                            <li>
                                <span class="pi-title">Professional Goals:</span>
                                <span class="pi-value"><?php echo $professional_goals ?></span>
                            </li>
                            <li>
                                <span class="pi-title">Member Type:</span>
                                <span class="pi-value"><?php echo $member_type; ?></span>

                            </li>
                            <li>
                                <span class="pi-title">Committee(s):</span>
                                <span class="pi-value"><?php echo $well_committees ?></span>

                            </li>
                        </ul>
                    </div>
                </div>
                    <?php echo 'in class MeprUtils'; ?>
                <div class="portal-members">qwerdsjkjgf
                            <div class="container">
                                <h2>Join Us in <strong>Welcoming New Members</strong></h2>
                                <ul class="member-listing">
                                    <?php
                                    global $wpdb;
                                    $membership_ids = $wpdb->get_results(" SELECT * FROM `wp_mepr_members` where memberships != '' ORDER BY created_at DESC Limit 4  ");
                                    $user_info = get_user_meta($value->id, 'mepr_first_name');

                                    $results = $wpdb->get_results(" SELECT wp_usermeta.meta_key,wp_usermeta.meta_value,wp_usermeta.user_id FROM wp_mepr_members LEFT JOIN wp_usermeta ON wp_mepr_members.user_id = wp_usermeta.user_id WHERE wp_mepr_members.memberships != '' AND (wp_usermeta.meta_key= 'mepr_image' OR wp_usermeta.meta_key='mepr_first_name')
 Limit 6 ");
                                    foreach ($membership_ids as $value) {
                                        $user_info = get_user_meta($value->user_id);

                                        if (!$user_info['mepr_image'][0]) {
                                            $user_info['mepr_image'][0] = home_url('/wp-content/uploads/2021/04/iconfinder_user_female_172621.png');
                                        }
                                        ?>
                                        <li>
                                            <a href="<?php echo "?action=single_member&id=" . $value->user_id; ?>"><img
                                                        style="max-height: 228px; max-width: 228px; width: 228px;height: 228px; object-fit: cover;object-position: top;"
                                                        src="<?php echo $user_info['mepr_image'][0]; ?>">
                                            </a>
                                            <a href="<?php echo "?action=single_member&id=" . $value->user_id; ?>"
                                               class="mem_name"><?php echo $user_info['first_name'][0] . " " . $user_info['last_name'][0]; ?></a>
                                        </li>
                                    <?php }
                                    ?>

                                    <a href="?action=members" class="btn red viewall-members">View All <i
                                                class="fa fa-angle-right"></i></a>
                            </div>
                </div>


            </div>
        </div>

    </div>
    <?php
}


if (isset($_GET['action']) && $_GET['action'] == "documents") {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $user_type = get_user_meta($user_id, 'mepr_member_type', true);
        $usermeta = get_usermeta($user_id);
        $member = $usermeta[57];
        global $wpdb;
        $result = $wpdb->get_results("SELECT DISTINCT file_path FROM `wp_upload_directory` WHERE allow_user = '$user_id' OR type = '$member' OR type = 'both'");
        $args = array(
            'taxonomy' => 'directory_category',
            'hide_empty' => true,
            'order' => 'asc'
        );
        $cats = get_terms($args);
    }
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
                <li class="evnets-tab"><a href="?action=events">
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
    <div class="document-list">
        <div class="container">
            <?php
            if (!empty($cats)) {
                foreach ($cats as $cat) {
                    $thumbnail = get_field('thumbnail', $cat->taxonomy . '_' . $cat->term_id);
                    ?>
                    <h2><?= $cat->name; ?></h2>
                    <?php
                    $useID = get_current_user_id();
                    $membertype = get_usermeta($useID, 'mepr_member_type');
                    $membertype = explode('-', $membertype);
                    $meta_values = $membertype[0];
                    $qArgs = array(
                        'post_type' => 'directory',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'directory_category',
                                'field' => 'term_id',
                                'terms' => array($cat->term_id),
                            )
                        ),
                        'meta_query' => array(
                            array(
                                'key' => 'membership',
                                'value' => $meta_values,
                                'compare' => 'LIKE'
                            )
                        )
                    );
                    $q = new WP_Query($qArgs);
                    $posts = $q->get_posts();
                    ?>
                    <ul class="document-list-group">
                        <?php
                        foreach ($posts as $post) {
                            $filePath = get_field('attachment', $post->ID);
                            $type = wp_check_filetype($filePath);
                            ?>
                            <li class="document-list-item">
                                <a <?= strpos($type["type"], 'video') !== false ? 'data-fancybox="video"' : ''; ?> <?= strpos($type["type"], 'image') !== false ? 'data-fancybox="gallery"' : ''; ?>
                                        target="_blank" href="<?= $filePath; ?>"
                                        class="btn red">
                                            <span><img src="<?= $thumbnail; ?>"
                                                       height="30px"
                                                       width="30px"></span>
                                    <strong><?= $post->post_title; ?></strong>
                                </a>
                                <?php
                                if (!empty($post->post_content)) {
                                    ?>
                                    <p><?= $post->post_content; ?></p>
                                    <?php
                                }
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php

                }
            }
            ?>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('a[data-fancybox="gallery"]').fancybox({
                buttons: [
                    "close"
                ],
                loop: true,
                protect: true
            });
            $('a[data-fancybox="video"]').fancybox({
                buttons: [
                    "close"
                ],
                loop: true,
                protect: true
            });
        })
    </script>
    <?php
}