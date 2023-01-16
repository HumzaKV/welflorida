<?php

//	ini_set( 'display_errors', 1 );
//	ini_set( 'display_startup_errors', 1 );
//	error_reporting( E_ALL );
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

define('THEME_PATH', get_template_directory());
define('THEME_URL', get_template_directory_uri());

require_once THEME_PATH . '/functions/gf_column.php';
require_once THEME_PATH . '/functions/post-type.php';
require_once THEME_PATH . '/functions/shortcodes.php';
require_once THEME_PATH . '/functions/ACF_Field_Unique_ID.php';
if (is_plugin_active('advanced-custom-fields-pro/acf.php')) {
    PhilipNewcomer\ACF_Unique_ID_Field\ACF_Field_Unique_ID::init();
}

function theme_files()
{
    // Theme Files
    wp_register_style('theme-style', get_stylesheet_uri(), false, null);
    wp_enqueue_style('theme-style');
    wp_register_style('theme-styler', get_stylesheet_directory_uri() . '/css/responsive.css', false, null);
    wp_enqueue_style('theme-styler');
    wp_register_style('font-css', get_stylesheet_directory_uri() . '/css/fonts.css', false, null);
    wp_enqueue_style('font-css');

    // Owl Carousel Files
    wp_register_style('owl-carousel', get_stylesheet_directory_uri() . '/owl-carousel/owl.carousel.css', false, '2.2.1');
    wp_enqueue_style('owl-carousel');
    wp_register_script('owl-carousel', get_stylesheet_directory_uri() . '/owl-carousel/owl.carousel.js', array('jquery'), '2.2.1', true);
    wp_enqueue_script('owl-carousel');

    // PrettyPhoto
    wp_register_style('prettyphoto', get_stylesheet_directory_uri() . '/prettyphoto/css/prettyPhoto.css', false);
    wp_enqueue_style('prettyphoto');
    wp_register_script('prettyphoto', get_stylesheet_directory_uri() . '/prettyphoto/jquery.prettyPhoto.js', array('jquery'), '3.1.6', true);
    wp_enqueue_script('prettyphoto');

    wp_register_script('kv-script', get_stylesheet_directory_uri() . '/kv-script.js', array('jquery'), true);
    wp_enqueue_script('kv-script');

    // Font Awesome
    wp_register_script('fontawesome', '//use.fontawesome.com/96bc47e5c3.js', true);
    wp_enqueue_script('fontawesome');

    if (isset($_GET['action']) && $_GET['action'] == "documents") {
        //Fancy Box
        wp_register_script('fancybox-js', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', true);
        wp_enqueue_script('fancybox-js');
        wp_register_style('fancybox-css', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css', false);
        wp_enqueue_style('fancybox-css');
    }
}

add_action('wp_enqueue_scripts', 'theme_files');

function kv_fix_gform_chosen_mobile()
{

    wp_deregister_script('gform_chosen');
    wp_register_script('gform_chosen', 'https://cdn.jsdelivr.net/npm/chosen.jquery-fixes@0.1.0/chosen.jquery-fixes.js', array(
        'jquery'
    ), '1.10.0-fix', true);
}

add_action('init', 'kv_fix_gform_chosen_mobile', 11);

// Enable Classic Editor
add_filter('use_block_editor_for_post', '__return_false', 10);

// Theme Options
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme Options',
        'menu_title' => 'Theme Options',
        'menu_slug' => 'theme-pptions',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}
add_action('admin_head', 'custom_css');
function custom_css()
{
    ?>
    <style type="text/css">
        li#toplevel_page_upload-directory ul.wp-submenu.wp-submenu-wrap li:nth-child(4) {
            display: none;
        }

        li#toplevel_page_upload-directory ul.wp-submenu.wp-submenu-wrap li:nth-child(5) {
            display: none;
        }

        div#gform_confirmation_wrapper_13 div#gform_confirmation_message_13 {
            font-size: 22px;
            margin: 200px 0 0 25px;
            color: #8ecc2f;
        }

        ul.pagination.backend-event {
            float: right;
            display: flex;
        }

        ul.pagination.backend-event li {
            padding: 0px 3px;
            margin: 0px;
        }

        ul.pagination.backend-event li:last-child {
            padding-right: 0px;
        }

        ul.pagination.backend-event li a {
            text-decoration: none;
            margin: 0px;
            background-color: #064b91;
            color: #fff;
            padding: 2px 8px;
        }

        ul.pagination.backend-event li a:hover {
            background-color: #000;
            transition: 0.2s;
        }

        form#events-form {
            overflow: scroll;
        }

        form#events-form table.wp-list-table.widefat.fixed.striped.pages {
            table-layout: auto;
        }
    </style>
    <script type="text/javascript">
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };

        jQuery(function ($) {
            $(document).on('change', 'select[name=input_69]', function () {
                // console.log( $(this).find(":selected").val() );
                if ($(this).find(":selected").val() == 21284 || $(this).find(":selected").val() == 21351) {
                    $("li#field_12_72 label").append('<span class="gfield_required">*</span>');
                    $("input[name=input_72]").prop('required', true);

                    $("li#field_12_73 label").append('<span class="gfield_required">*</span>');
                    $("input[name=input_73]").prop('required', true);

                    $("li#field_12_74 label").append('<span class="gfield_required">*</span>');
                    $("input[name=input_74]").prop('required', true);
                } else {
                    $("li#field_12_72 label span").remove();
                    $("input[name=input_72]").prop('required', false);

                    $("li#field_12_73 label span").remove();
                    $("input[name=input_73]").prop('required', false);

                    $("li#field_12_74 label span").remove();
                    $("input[name=input_74]").prop('required', false);
                }
            });
        });//<span class="gfield_required">*</span>

        // if (getUrlParameter('checkout') == 1) {
        //       jQuery('html,body').animate({
        //           scrollTop: jQuery("#scroll_attendees").offset().top
        //       }, 'slow');
        //   }
        // jQuery("#scroll_to_details").click(function(e){
        // e.preventDefault();
        // jQuery('html, body').animate({
        //         scrollTop: jQuery("#scroll_attendees").offset().top
        //     }, 1000);
        // });
    </script>
    <?php
}

// Register Sidebar
add_action('widgets_init', 'kv_widgets_init');
function kv_widgets_init()
{
    $sidebar_attr = array(
        'name' => '',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    );
    $sidebar_id = 0;
    $gdl_sidebar = array("Blog", "Footer 1", "Footer 2", "Footer 3", "Footer 4", "Search");
    foreach ($gdl_sidebar as $sidebar_name) {
        $sidebar_attr['name'] = $sidebar_name;
        $sidebar_attr['id'] = 'custom-sidebar' . $sidebar_id++;
        register_sidebar($sidebar_attr);
    }
}

// Register Navigation
function register_menu()
{
    register_nav_menu('main-menu', __('Main Menu'));
}

add_action('init', 'register_menu');

// Image Crop
function codex_post_size_crop()
{
    add_image_size("packages_image", 300, 200, true);
    add_image_size("event_images", 397, 729, true);
    add_image_size("member_list", 228, 228, true);
    add_image_size("event_listing_img", 150, 150, true);


}

add_action("init", "codex_post_size_crop");

// Featured Image Function
add_theme_support('post-thumbnails');

// raza code 01-09-2020
add_action('admin_menu', 'admin_register_menu');
function admin_register_menu()
{
    add_submenu_page('edit.php?post_type=events', __('User Enroll'), __('Event Listings'), 'manage_options', 'enroll-listings', 'wp_admin_enroll_listing_page');
    add_submenu_page('edit.php?post_type=events', __('Register Event'), __('Register Event'), 'manage_options', 'register-event', function () {
        require(locate_template('admin/register-event.php'));
    });

}

// Muzammil code 7 April 2022
add_action('admin_menu', 'admin_upload_directory_page');
function admin_upload_directory_page()
{
    add_submenu_page(
        'edit.php?post_type=directory', //$parent_slug
        'Upload Multiple Directory',  //$page_title
        'Upload Files',        //$menu_title
        'manage_options',           //$capability
        'upload-directory',
        function () {
            require(locate_template('admin/upload-directory.php'));
        }
    );
}


function wp_admin_enroll_listing_page()
{
    require(locate_template('enroll-listings.php'));
}


if (function_exists('acf_add_options_page')) {
    acf_add_options_sub_page(array(
        'page_title' => 'Mail Setting',
        'menu_title' => 'Mail Setting',
        'parent_slug' => 'edit.php?post_type=events',
    ));
}

add_action("wp_footer", "custom_script");

function custom_script()
{
    ?>
    <script type="text/javascript">
        jQuery(function ($) {
            $(".gfield_list_19_cell1").find('[aria-label="First Name"]').attr("placeholder", "First Name");
            $(".gfield_list_19_cell2").find('[aria-label="Middle Name"]').attr("placeholder", "Middle Name");
            $(".gfield_list_19_cell3").find('[aria-label="Last Name"]').attr("placeholder", "Last Name");
            $(".gfield_list_19_cell4").find('[aria-label="Company Name"]').attr("placeholder", "Company Name");
            $(".gfield_list_19_cell7").find('[aria-label="Phone"]').attr("placeholder", "Phone");
            $(".gfield_list_19_cell8").find('[aria-label="Email"]').attr("placeholder", "Email");
            $(".gfield_list_19_cell5").find('select[name="input_19[]"]').attr("placeholder", "Email");

            $('.gfield_list_cell').each(function () {
                let $this = $(this),
                    $tr = $('tr', $this.parent().parent().prev()),
                    i = $this.index();
                $('input', $this).attr('placeholder', $('th:eq(' + i + ')', $tr).text());
                $('select', $this).prepend('<option value="" selected>' + $('th:eq(' + i + ')', $tr).text() + '</option>');
            });

            $('.ginput_quantity_1_5').val("1");
            let ginput_quantity_1_30 = $('#input_1_30_1');

            let value = ginput_quantity_1_30.val();

            // Yes
            $(document).on("change", "#choice_1_42_0", function () {
                if (value == "1") {
                    ginput_quantity_1_30.val("2");
                }
                // Member
                else if (value == "0" || value == '') {
                    ginput_quantity_1_30.val("1");
                }

                ginput_quantity_1_30.change();
            })

            $(document).on("change", "#choice_1_42_1", function () {
                if (value == "1") {
                    ginput_quantity_1_30.val("1");
                }
                // Member
                else if (value == "0" || value == '') {
                    ginput_quantity_1_30.val("0");
                }
                
                ginput_quantity_1_30.change();
            })

            // var inc=1;
            let inc = <?= isset($_GET['id1'], $_GET['id2']) ? 1 : 2; ?>;
            $(document).on("click", ".add_list_item", function () {
                let quantity = ginput_quantity_1_30;


                // var a = quantity.val();
                console.log(inc);
                inc += 1;
                console.log(inc);
                quantity.val(parseInt(inc));
                ginput_quantity_1_30.change();

            });
            let isdelete = false;


            $(document).on("click", ".delete_list_item", function () {
                // if(!isdelete){
                // 	isdelete=true;
                // }
                // else{
                // 	isdelete=true;
                // 	return false;
                // }
                let rooms = ginput_quantity_1_30;

                // inc--;
                // var a = rooms.val();
                if (inc >= 1) {
                    inc--;
                    rooms.val(parseInt(inc));
                    ginput_quantity_1_30.change();

                } else {
                    $(".delete_list_item").prop("disabled", true);
                }
            });

            // gf ticket purchase quantity read only
            ginput_quantity_1_30.prop("readonly", true);

        });
    </script>
    <?php
}

add_action('gform_after_submission_1', 'endo_add_entry_to_db', 10, 2);
function dateToCal($time)
{
    return date('Ymd\This', $time) . 'Z';
}

function endo_add_entry_to_db($entry, $form)
{
    global $wpdb;
    $post_id = $entry['53'];
    $results = $wpdb->get_row(" SELECT * from wp_acf_data WHERE post_id='" . $post_id . "' AND available_for ='member' AND status=1");
    $location = $results->location;
    $dynamic_text_area = $results->description;
    $start_date = get_field("start_date", $entry["post_id"]);
    $date = date('m-d-Y', strtotime($start_date));
    $time = date('h:i:s a', strtotime($start_date));
    $end_date = get_field("end_date", $entry["post_id"]);
    $post_title_name = get_the_title($post_id);
    $calendar_start_date = date_i18n(('Ymd\THis\Z'), strtotime($start_date), true);
    $calendar_end_date = date_i18n(('Ymd\THis\Z'), strtotime($end_date), true);
    $isguest = rgar($entry, '42');
    $total_price = $entry['16'];
    $payment_gateway = $form['fields']['16']->type;
    // if($total_price==0 ){
    // 	$total_price=0;
    // 	$payment_gateway="-";
    // 	if ($isguest=='Yes') {
    // 	$total_price=$entry['16'];
    // 	$payment_gateway=$form['fields']['16']->type;
    // 	}

    // }
    if (!$entry['transaction_id']) {
        $entry['transaction_id'] = '-';
    }
    $member_guest = 'Guest';
    if (isset($_GET['id1']) && isset($_GET['id2'])) {
        $member_guest = 'Member';
        if ($total_price == 0) {
            $total_price = 0;
            $payment_gateway = "-";
            if ($isguest == 'Yes') {
                $total_price = $entry['16'];
                $payment_gateway = $form['fields']['16']->type;
            }

        }
    }


    $parent_table = array(
        'id' => $entry['id'],
        'user_id' => $entry['52'],
        'event_id' => $entry['53'],
        'ticket_id' => 0,
        'guest_ticket_id' => 0,
        'member_guest' => $member_guest,
        'b_name' => $entry['2.3'] . " " . $entry['2.4'] . " " . $entry['2.6'],
        'company' => $entry['12'],
        'position' => $entry['59'],
        'role' => $entry['56'],
        'phone' => $entry['3'],
        'price' => $total_price,
        'transaction_id' => $entry['transaction_id'],
        'payment_gateway' => $payment_gateway,
        'address' => $entry['4.1'] . " " . $entry['4.2'] . " " . $entry['4.3'] . " " . $entry['4.4'] . " " . $entry['4.5'],
        'option_in_out' => $entry['41.1'],
        'email' => $entry['8'],
        'created_at' => $entry['date_created'],
    );

    $wpdb->insert('wp_gf_custom', $parent_table);

    // $price=$entry['5.2'];
    // $address=$entry['4.1']." ".$entry['4.2']." ".$entry['4.3']." ".$entry['4.4']." ".$entry['4.5'];
    // $email=$entry['8'];
    // $created_at=$entry['date_created'];
    // $company=$entry['12'];
    // $position=$entry['40'];
    // $role=$entry['14'];
    // $phone=$entry['3'];
    // $option_in_out=$entry['41.1'];
    // $id=$entry['287'];
    // $user_id=$entry['52'];
    // $b_name=$entry['2.3']." ".$entry['2.4']." ".$entry['2.6'];
    // $event_id=$entry['53'];
    $data = array();
    $list_values = is_serialized(rgar($entry, '19')) ? unserialize(rgar($entry, '19')) : array();

    $isguest = rgar($entry, '42');


    if (isset($_GET['id1']) && isset($_GET['id2'])) {
        if ($isguest == "Yes") {
            $isguestprice = rgar($entry, '30.2');
            $ticket_id_guest = $_GET['id2'];
            $array = array(

                'ticket_id' => $ticket_id_guest,
                'price' => $isguestprice

            );
            foreach ($list_values as $key => $value) {

                $data[$key] = array_merge($list_values[$key], $array);


            }

            foreach ($data as $key => $value) {
                $dataa = array(
                    'entry_id' => $entry['id'],
                    'ticket_id' => $value['ticket_id'],
                    'price' => $value['price'],
                    'memberOrguest' => "guest",
                    'f_name' => $value['First Name'],
                    'm_name' => $value['Middle Name'],
                    'l_name' => $value['Last Name'],
                    'company_name' => $value['Company Name'],
                    'position_title' => $value['Position/Title'],
                    'role' => $value['Role'],
                    'phone' => $value['Phone'],
                    'email' => $value['Email'],
                );

                if (get_current_user_id()) {
                    $uid = get_current_user_id();
                } else {
                    $uid = 0;
                }
                $wpdb->insert('wp_gf_custom_child', $dataa);
                $price = $entry['5.2'];
                $username = $value['First Name'] . " " . $value['Last Name'];
                // $message_url="https://www.google.com/calendar/render?action=TEMPLATE&text=".$post_title_name."&dates=".$calendar_start_date."/".$calendar_end_date."&details=".$dynamic_text_area."&location=".$location."&sf=true&output=xml";
                // $message_outlook="https://outlook.live.com/owa/?path=/calendar/action/compose&rru=addevent&subject=".$post_title_name."&startdt=".$calendar_start_date."&enddt=".$calendar_end_date."&body=".$dynamic_text_area.", time: ".$post_title_name."&location=".$location."";


                $title_name = sanitize_title($post_title_name);
                // $uid = $post_id;
                $filename = $title_name . "-" . $uid . ".ics";
                $message_url = get_stylesheet_directory_uri() . '/eventicsfiles/' . $filename;
                $message_outlook = $message_url;

                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "From: WeLFlorida <info@welflorida.org>\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $subject = "You are registered";
                $message .= "";
                $message .= "<p style='text-align: center; padding: 10px 0; margin: 0;'><img class='size-full wp-image-11558 aligncenter' src='" . home_url('/wp-content/uploads/2021/01/wel-logo.png') . "' alt='' width='250' height='80' /></p>";

                $message .= "<div style='width:550px; margin:0 auto;  padding: 10px;' class='main_row container-full'><div class='body'>
						<h3>Dear $username</h3>
						<p><strong>Thank you for registering for $post_title_name</strong></p>
						<p>Date: $date </p>
						<p>Time: $time</p>
						<p>Location: $location</p>
						<p>Add to Google:  <a href='$message_url'>Click Follow Link To Add Google Calendar.</a></p>
						<p>Add to Outlook:  <a href='$message_outlook'>Click Follow Link To Add Outlook Calendar.</a></p>
						";

                $additional_note = get_field('event_additional_note', $entry['5.3']);
                if ($additional_note) {
                    $message .= "<br><h5>Additional Notes</h5><p>" . $additional_note . "</p><br>";
                }

                $message .= "<p>You has been paid $price amount as a guest member.</p>";

                $message .= "		
                <p>Please contact WEL’s Administrator, Meredith Williams at:  <a href='mailto:info@welflorida.org' target='_blank'>info@welflorida.org</a> if you need any assistance.</p>
						<p>Thank you.</p>
						</div>
						<div  style='text-align: center; color: #fff; background: #000; padding: 5px 0;'>
							<p>Copyright ©2020 All right Reserved</p>
						</div>
						</div>";
                $user_email = $value['Email'];

                wp_mail($user_email, $subject, $message, $headers);
            }


        }

        $ismemberprice = rgar($entry, '5.2');

        $ticket_id_member = $_GET['id1'];
        $onlymember = array(
            'entry_id' => $entry['id'],
            'ticket_id' => $ticket_id_member,
            'price' => $ismemberprice,
            'memberOrguest' => "member",
            'f_name' => rgar($entry, '2.3'),
            'm_name' => rgar($entry, '2.4'),
            'l_name' => rgar($entry, '2.6'),
            'company_name' => rgar($entry, '12'),
            'position_title' => rgar($entry, '59'),
            'role' => rgar($entry, '14'),
            'phone' => rgar($entry, '3'),
            'email' => rgar($entry, '8'),

        );

        $wpdb->insert('wp_gf_custom_child', $onlymember);

    } else {
        if ($isguest == "Yes") {
            $isguestprice = rgar($entry, '30.2');
            $ticket_id_guest = $_GET['id2'];
            $array = array(

                'ticket_id' => $ticket_id_guest,
                'price' => $isguestprice

            );
            foreach ($list_values as $key => $value) {

                $data[$key] = array_merge($list_values[$key], $array);


            }

            foreach ($data as $key => $value) {
                $dataa = array(
                    'entry_id' => $entry['id'],
                    'ticket_id' => $value['ticket_id'],
                    'price' => $value['price'],
                    'memberOrguest' => "guest",
                    'f_name' => $value['First Name'],
                    'm_name' => $value['Middle Name'],
                    'l_name' => $value['Last Name'],
                    'company_name' => $value['Company Name'],
                    'position_title' => $value['Position/Title'],
                    'role' => $value['Role'],
                    'phone' => $value['Phone'],
                    'email' => $value['Email'],
                );
                $wpdb->insert('wp_gf_custom_child', $dataa);
                $price = $entry['5.2'];
                $username = $value['First Name'] . " " . $value['Last Name'];
                // $message_url="https://www.google.com/calendar/render?action=TEMPLATE&text=".$post_title_name."&dates=".$calendar_start_date."/".$calendar_end_date."&details=".$dynamic_text_area."&location=".$location."&sf=true&output=xml";
                // $message_outlook="https://outlook.live.com/owa/?path=/calendar/action/compose&rru=addevent&subject=".$post_title_name."&startdt=".$calendar_start_date."&enddt=".$calendar_end_date."&body=".$dynamic_text_area.", time: ".$post_title_name."&location=".$location."";
                if (get_current_user_id()) {
                    $uid = get_current_user_id();
                } else {
                    $uid = 0;
                }
                $title_name = sanitize_title($post_title_name);
                // $uid = $post_id;
                $filename = $title_name . "-" . $uid . ".ics";
                $message_url = get_stylesheet_directory_uri() . '/eventicsfiles/' . $filename;
                $message_outlook = $message_url;

                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "From: WeLFlorida <info@welflorida.org>\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $subject = "You are registered";
                $message .= "";
                $message .= "<p style='text-align: center; padding: 10px 0; margin: 0;'><img class='size-full wp-image-11558 aligncenter' src='" . home_url('/wp-content/uploads/2021/01/wel-logo.png') . "' alt='' width='250' height='80' /></p>";

                $message .= "<div style='width:550px; margin:0 auto;  padding: 10px;' class='main_row container-full'><div class='body'>
						<h3>Dear $username</h3>
						<p><strong>Thank you for registering for $post_title_name</strong></p>
						<p>Date: $date </p>
						<p>Time: $time </p>
						<p>Location: $location</p>
						<p>Add to Google:  <a href='$message_url'>Click Follow Link To Add Google Calendar.</a></p>
						<p>Add to Outlook:  <a href='$message_outlook'>Click Follow Link To Add Outlook Calendar.</a></p>
						";
                $additional_note = get_field('event_additional_note', $entry['5.3']);
                if ($additional_note) {
                    $message .= "<br><h5>Additional Notes</h5><p>" . $additional_note . "</p><br>";
                }

                $message .= "<p>You has been paid $price amount as a guest member.</p>";

                $message .= "	
						<p>Please contact WEL’s Administrator, Meredith Williams at:  <a href='mailto:info@welflorida.org' target='_blank'>info@welflorida.org</a> if you need any assistance.</p>
						<p>Thank you.</p>
						</div>
						<div  style='text-align: center; color: #fff; background: #000; padding: 5px 0;'>
							<p>Copyright ©2020 All right Reserved</p>
						</div>
						</div>";
                $user_email = $value['Email'];

                wp_mail($user_email, $subject, $message, $headers);
            }
        }
        $isguestprice = rgar($entry, '30.2');
        $ticket_id_guest = $_GET['id2'];
        $onlyguest = array(
            'entry_id' => $entry['id'],
            'ticket_id' => $ticket_id_guest,
            'price' => $isguestprice,
            'memberOrguest' => "guest",
            'f_name' => rgar($entry, '2.3'),
            'm_name' => rgar($entry, '2.4'),
            'l_name' => rgar($entry, '2.6'),
            'company_name' => rgar($entry, '12'),
            'position_title' => rgar($entry, '59'),
            'role' => rgar($entry, '14'),
            'phone' => rgar($entry, '3'),
            'email' => rgar($entry, '8'),

        );
        // print_r($onlyguest);
        // die;
        $wpdb->insert('wp_gf_custom_child', $onlyguest);

    }


    // 	// add calender send mail to user
    $post_id = $entry['53'];
    $results = $wpdb->get_row(" SELECT * from wp_acf_data WHERE post_id='" . $post_id . "' AND available_for ='member' AND status=1");
    $location = $results->location;
    $dynamic_text_area = $results->description;

    $user_name = $entry['2.3'] . " " . $entry['2.6'];
    $post_title_name = get_the_title($post_id);
    $total_price = "$" . $entry['16'];
    $user_email = rgar($entry, '8');
    $start_date = get_field("start_date", $entry["post_id"]);
    $end_date = get_field("end_date", $entry["post_id"]);
    $title = get_field("sub_title", $entry["post_id"]);
    $calendar_start_date = date_i18n(('Ymd\THis\Z'), strtotime($start_date), true);
    $calendar_end_date = date_i18n(('Ymd\THis\Z'), strtotime($end_date), true);

    // $calendar_start_date = gmDate("Ymd\THis\Z",strtotime($start_date));
    // $calendar_end_date = gmDate("Ymd\THis\Z",strtotime($end_date));

    // $calendar_start_date = gmDate("Ymd\THis\Z",strtotime($start_date));
    // $calendar_end_date = gmDate("Ymd\THis\Z",strtotime($end_date));
    // $message_url="https://www.google.com/calendar/render?action=TEMPLATE&text=".$title."&dates=".$calendar_start_date."/".$calendar_end_date."&details=".$dynamic_text_area."&location=".$location."&sf=true&output=xml";
    // $message_outlook="https://outlook.live.com/owa/?path=/calendar/action/compose&rru=addevent&subject=".$title."&startdt=".$calendar_start_date."&enddt=".$calendar_end_date."&body=".$dynamic_text_area.", time: ".$title."&location=".$location."";
    if (get_current_user_id()) {
        $uid = get_current_user_id();
    } else {
        $uid = 0;
    }
    $title_name = sanitize_title($post_title_name);
    // $uid = $post_id;
    $filename = $title_name . "-" . $uid . ".ics";
    $message_url = get_stylesheet_directory_uri() . '/eventicsfiles/' . $filename;
    $message_outlook = $message_url;

    // $user_email = $user_email;
    $headers = "";
    $message = "";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "From: WeLFlorida <info@welflorida.org>\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message .= "";
    $message .= "<p style='text-align: center; padding: 10px 0; margin: 0;'><img class='size-full wp-image-11558 aligncenter' src='" . home_url('/wp-content/uploads/2021/01/wel-logo.png') . "' alt='' width='250' height='80' /></p>";

    $message .= "<div style='width:550px; margin:0 auto;  padding: 10px;' class='main_row container-full'><div class='body'>
						<h3>Dear $user_name</h3>
						<p><strong>Thank you for registering for $post_title_name</strong></p>
						<p>Date: $date </p>
						<p>Time: $time</p>
						<p>Location: $location</p>
						<p>Add to Google:  <a href='$message_url'>Click Follow Link To Add Google Calendar.</a></p>
						<p>Add to Outlook:  <a href='$message_outlook'>Click Follow Link To Add Outlook Calendar.</a></p>
						";
    $additional_note = get_field('event_additional_note', $entry['5.3']);
    if ($additional_note) {
        $message .= "<br><h5>Additional Notes</h5><p>" . $additional_note . "</p><br>";
    }
    $message .= "<p>You has been paid $total_price amount as a guest member.</p>";

    $message .= "	
						<p>Please contact WEL’s Administrator, Meredith Williams at:  <a href='mailto:info@welflorida.org' target='_blank'>info@welflorida.org</a> if you need any assistance.</p>
						<p>Thank you.</p>
						</div>
						<div  style='text-align: center; color: #fff; background: #000; padding: 5px 0;'>
							<p>Copyright ©2020 All right Reserved</p>
						</div>
						</div>";


    $subject = "You are registered";
    wp_mail($user_email, $subject, $message, $headers);
    // end add calender send mail to user

}


add_action('admin_enqueue_scripts', 'admin_register_script_style');
function admin_register_script_style()
{
    wp_enqueue_script('jquery-ui-datepicker');
    wp_register_style('jquery-ui', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('jquery-ui');

}


add_action('save_post', 'save_acf_data', 10, 3);
function save_acf_data($post_id, $post, $update)
{

    if (wp_is_post_revision($post_id) || empty($_POST) || $post->post_type != 'events') {
        return;
    }
    global $wpdb;
    $tablename = $wpdb->prefix . 'acf_data';
    $fields = get_field('ticket', $post_id);
    $eventStart = get_field('start_date', $post_id);
    $eventEnd = get_field('end_date', $post_id);
    $eventCoupon = get_field('coupon', $post_id);

    if ($_POST['original_publish'] == "Publish") {
        // Save Query
        foreach ($fields as $key => $value) {
            $lastid = $wpdb->insert_id;
            $group = $value['public'];
            if ($group['availabilty'] == 'yes') {
                $group['availabilty'] = 1;
            } else {
                $group['availabilty'] = 0;
            }
            $data = array(
                'post_id' => $post_id,
                'name' => $group['name'],
                'description' => $group['description'],
                'available_for' => $group['available_for'],
                'available_from_time' => $group['available_from_time'],
                'available_from_date' => date("m-d-Y", strtotime($group['available_from_date'])),
                'available_until_time' => $group['available_until_time'],
                'available_until_date' => date("m-d-Y", strtotime($group['available_until_date'])),
                'price' => $group['price'],
                'spaces' => $group['spaces'],
                'location' => $group['location'],
                'uniq_id' => $group['uniq-id'],
                'status' => $group['availabilty'],
                'e_start' => $eventStart,
                'e_end' => $eventEnd,
                'coupon' => $eventCoupon
            );
            $wpdb->insert($tablename, $data);
            update_post_meta($post_id, 'ticket_' . $key . '_public_uniq-id', $group['uniq-id']);
        }
    } else {
        foreach ($fields as $key => $value) {
            $group = $value['public'];
            // $ticket_id = get_post_meta($post_id, 'ticket_' . $key . '_public_uniq-id',true);
            if ($group['availabilty'] == 'yes') {
                $group['availabilty'] = 1;
            } else {
                $group['availabilty'] = 0;
            }
            $data = array(
                'name' => $group['name'],
                'description' => $group['description'],
                'available_for' => $group['available_for'],
                'available_from_time' => $group['available_from_time'],
                'available_from_date' => date("m-d-Y", strtotime($group['available_from_date'])),
                'available_until_time' => $group['available_until_time'],
                'available_until_date' => date("m-d-Y", strtotime($group['available_until_date'])),
                'price' => $group['price'],
                'spaces' => $group['spaces'],
                'location' => $group['location'],
                'status' => $group['availabilty'],
                'e_start' => $eventStart,
                'e_end' => $eventEnd,
                'coupon' => $eventCoupon
            );

            $update_result = $wpdb->update('wp_acf_data', $data, array(
                'uniq_id' => $group['uniq-id'],
                'post_id' => $post_id
            ));
            $uniqueid = $group["uniq-id"];
            $result = $wpdb->get_var("SELECT COUNT(*) FROM wp_acf_data WHERE post_id = $post_id AND uniq_id = '$uniqueid'");

            if (!empty($result) || $update_result == 1) {
                continue;
            }

            $group = $value['public'];
            if ($group['availabilty'] == 'yes') {
                $group['availabilty'] = 1;
            } else {
                $group['availabilty'] = 0;
            }

            $data['post_id'] = $post_id;
            $data['uniq_id'] = $group['uniq-id'];
            $wpdb->insert($tablename, $data);
            update_post_meta($post_id, 'ticket_' . $key . '_public_uniq-id', $group['uniq-id']);
        }

        $enroll_query = $wpdb->get_results(" SELECT wp_acf_data.uniq_id FROM wp_acf_data where uniq_id NOT IN(SELECT meta_value from wp_postmeta)");
        if (@$enroll_query[0]->uniq_id) {
            foreach ($enroll_query as $value) {
                $wpdb->update('wp_acf_data', array('status' => 0), array('uniq_id' => $value->uniq_id));
            }
        }
    }
}

// for location of event
function my_acf_init()
{
    acf_update_setting('google_api_key', '');
}

add_action('acf/init', 'my_acf_init');

// add_action( 'wp_footer', 'field_delete_for_member' );
function field_delete_for_member()
{
    ?>
    <script type="text/javascript">
        jQuery('#ginput_quantity_1_5').val("1");
        jQuery('#ginput_quantity_1_30').val("0");

        jQuery("#input_1_29").change(function () {
            var val, tbody, row, additionalRows;
            val = jQuery(this).val();
            jQuery(".gfield_list_container").find("tbody tr:gt(0)").remove();
            jQuery('#ginput_quantity_1_30').val(parseInt(val));
            jQuery('#ginput_quantity_1_30').change();
            // jQuery(document).on("click","#input_1_29",function() {
            // 	jQuery('#ginput_quantity_1_5').val(val);
            // })
            tbody = jQuery('#field_1_19 table tbody');
            console.log(tbody);

            row = tbody.find('tr:last');
            additionalRows = new Array(parseInt(val)).join(row[0].outerHTML);
            tbody.append(additionalRows);
        })

    </script>

    <?php
}

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

$main_sql_create = "CREATE TABLE `wp_acf_data` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `post_id` int(11) NOT NULL,
 `name` varchar(255) NOT NULL,
 `description` varchar(255) NOT NULL,
 `available_for` varchar(255) NOT NULL,
 `available_from_time` varchar(255) NOT NULL,
 `available_from_date` varchar(255) NOT NULL,
 `available_until_time` varchar(255) NOT NULL,
 `available_until_date` varchar(255) NOT NULL,
 `price` varchar(255) NOT NULL,
 `spaces` varchar(255) NOT NULL,
 `location` varchar(255) NOT NULL,
 `uniq_id` int(11) DEFAULT NULL,
 `status` tinyint(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4";
maybe_create_table('wp_acf_data', $main_sql_create);

$main_sql_create = "CREATE TABLE `wp_gf_custom` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `ticket_id` int(11) NOT NULL,
 `company` varchar(255) NOT NULL,
 `position` varchar(255) NOT NULL,
 `role` varchar(255) NOT NULL,
 `phone` varchar(255) NOT NULL,
 `b_name` varchar(255) NOT NULL,
 `price` varchar(255) NOT NULL,
 `address` varchar(255) NOT NULL,
 `option_in_out` tinyint(1) NOT NULL,
 `email` varchar(255) NOT NULL,
 `created_at` date DEFAULT NULL,
 `status` tinyint(1) DEFAULT NULL,
 `withdraw_date` date DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4";
maybe_create_table('wp_gf_custom', $main_sql_create);

$main_sql_create = "CREATE TABLE `wp_gf_custom2` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `subject` varchar(255) NOT NULL,
 `message` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4";
maybe_create_table('wp_gf_custom2', $main_sql_create);

$main_sql_create = "CREATE TABLE `wp_gf_custom_child` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `transaction_id` int(11) NOT NULL,
 `name` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `phone` varchar(255) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4";
maybe_create_table('wp_gf_custom_child', $main_sql_create);

$main_sql_create = "CREATE TABLE `wp_upload_directory` 
( `id` int(11) NOT NULL AUTO_INCREMENT,
 `file_path` varchar(255) NOT NULL,
 `allow_user` varchar(255) DEFAULT NULL,
 `type` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
maybe_create_table('wp_upload_directory', $main_sql_create);

function mepr_add_some_tabs($user)
{
    ?>


    <span>
      <!-- REDIRECTS THE USER TO A DIFFERENT PAGE ON THE SITE -->
      <a href="#">Profile</a>
    </span>
    <?php
}

// add_action('mepr_account_nav', 'mepr_add_some_tabs');

add_filter('gform_validation_1', 'custom_validation');
function custom_validation($validation_result)
{
    global $post, $wpdb;
    $registered_emails = array();
    $email = $_POST['input_8'];
    $post_id = get_the_ID();
    $coupon_used = $_POST['input_60'];
    $wp_gf_custom = $wpdb->get_results(" SELECT * from wp_gf_custom WHERE event_id='" . $post_id . "' AND status=0");

    if ($wp_gf_custom) {
        foreach ($wp_gf_custom as $key => $value) {
            $registered_emails[] = $value->email;
        }
    }
    $check_email = in_array($email, $registered_emails);

    if ($check_email) {
        $form = $validation_result["form"];

        $validation_result["is_valid"] = false;
        $validation_result["form"]["fields"][8]["failed_validation"] = true;
        $validation_result["form"]["fields"][8]["validation_message"] = "You already purchased this event";

        $validation_result["form"] = $form;

        return $validation_result;
    }

    $results = $wpdb->get_results(" SELECT * from wp_acf_data WHERE post_id='" . $post->ID . "' AND available_for='guest' AND status=1 ");
    $results_count = $wpdb->get_results("SELECT COUNT(wp_gf_custom.ticket_id) AS NumberOfTicketId FROM wp_gf_custom LEFT JOIN wp_gf_custom_child ON wp_gf_custom.id = wp_gf_custom_child.entry_id WHERE wp_gf_custom.event_id = '" . $post->ID . "' AND wp_gf_custom_child.memberOrguest='guest' AND wp_gf_custom.status = 0");
    $total_spaces = $results[0]->spaces;
    $total_booking = $results_count[0]->NumberOfTicketId;
    if (isset($_GET['id1']) && isset($_GET['id2'])) {
        $remaining = $total_spaces - $total_booking;
        $message = "only" . $remaining;
    } else {
        $remaining = $total_spaces - $total_booking;
        if ($remaining == 1) {
            $message = "Sorry " . $remaining;
        }
    }

    $form = $validation_result['form'];
    $count = is_array(rgpost('input_19')) ? rgpost('input_19') : array();

    // if( sizeof($count) > 0 ){
    $count = sizeof($count);
    // }
    $count = ($count / 8);
    // print_r($remaining);
    // print_r(ceil($count));
    if ($count > $remaining) {
        $validation_result['is_valid'] = false;

        //finding Field with ID of 1 and marking it as failed validation
        foreach ($form['fields'] as $field) {
            //NOTE: replace 1 with the field you would like to validate
            if ($field->id == '42') {
                $field->failed_validation = true;
                $field->validation_message = $message . " seats available for guest";
                break;
            }
        }
    }
    $coupon_name = $results[0]->coupon;
    // echo $coupon_name;
    // echo $coupon_used;
    // die;
    if ($coupon_used != $coupon_name) {

        foreach ($form['fields'] as $field) {
            //NOTE: replace 1 with the field you would like to validate
            if ($field->id == '60') {
                $field->failed_validation = true;
                $field->validation_message = "Invalid Coupon";
                break;
            }
        }


    }

    // print_r($validation_result );
    // echo "<pre>";
    // die;
    $validation_result['form'] = $form;

    return $validation_result;
}

//add_filter( 'template_include', 'portfolio_page_template', 99 );
function portfolio_page_template($template)
{
    echo $template;
    if (is_page('portfolio')) {
        $new_template = locate_template(array('portfolio-page-template.php'));
        if ('' != $new_template) {
            return $new_template;
        }
    }

    return $template;
}

// add_action( 'wcs_daily_clean_database', 'three_day_before_email' );

// wp_schedule_event( time(), 'daily', 'wcs_daily_clean_database' );

function three_day_before_email()
{
    global $wpdb;
    $data = $wpdb->get_results("SELECT wp_acf_data.e_start,wp_gf_custom.email FROM `wp_gf_custom` LEFT JOIN wp_acf_data ON wp_gf_custom.guest_ticket_id=wp_acf_data.id WHERE DATE_ADD(date(wp_acf_data.e_start) , INTERVAL -3 DAY) = CURRENT_DATE()");
    foreach ($data as $key => $value) {
        $headers = "";
        $message = "";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "From: WeLFlorida <info@welflorida.org>\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message .= "<p style='text-align: center; padding: 10px 0; margin: 0;'><img class='size-full wp-image-11558 aligncenter' src='" . home_url('/wp-content/uploads/2020/08/logo.png') . "' alt='' width='189' height='65' /></p>";
        $message .= get_option('options_message_three_day');
        $message .= "<p style='text-align: center;  padding: 10px 0;'>© 2020 WeLFlorida | All rights reserved</p>";
        $subject = get_option('options_subject_three_day');
        $user_email = $value->email;
        wp_mail($user_email, $subject, $message, $headers);

    }

}

//add_action('gform_pre_render_3', 'gf_scroll_to_first_error_focus', 10, 1);
function gf_scroll_to_first_error_focus($form)
{
    ?>
    <script type="text/javascript">
        if (window['jQuery']) {
            (function ($) {
                $(document).bind('gform_post_render', function () {
                    var firstError = $('li.gfield.gfield_error:first');
                    if (firstError.length > 0) {

                        firstError.find('input, select, textarea').eq(0).focus();
                        document.body.scrollTop = firstError.offset().top;

                    }
                });
            })(jQuery);
        }
    </script>
    <?php
    return $form;
}

// Allow PDF uploads
add_filter('mepr_upload_mimes', 'alter_mepr_upload_mimes', 1);
function alter_mepr_upload_mimes($mimes)
{
    $mimes['pdf'] = 'application/pdf';

    return $mimes;
}

add_filter('gform_multiselect_placeholder_3_66', 'set_multiselect_placeholder_66', 10, 2);
function set_multiselect_placeholder_66($placeholder, $form_id)
{
    return 'Committee Interest';
}

add_filter('gform_address_display_format', 'address_format', 10, 2);
function address_format($format, $field)
{
    return 'zip_before_city';
}

add_action('gform_activate_user', 'after_user_activate', 10, 3);
function after_user_activate($user_id, $user_data, $signup_meta)
{

    $get_data = get_user_meta($user_id, 'mepr_committee_interest', true);
    if (is_string($get_data)) {
        eval("\$get_data = $get_data;");
    }
    if (is_array($get_data)) {
        $get_data = serialize($get_data);
    }
    global $wpdb;
    $wpdb->query("UPDATE $wpdb->usermeta SET meta_value = '$get_data' WHERE user_id = '$user_id' AND meta_key = 'mepr_committee_interest' ");
}

add_action('wp_ajax_enroll_list_summary', 'export_enroll_list_summary_csv');
function export_enroll_list_summary_csv()
{
    global $wpdb;
    $status = 0;
    $checked = $_POST['checked'];
    $name = 'Event_Enroll_List';
    $event_id = $_POST['event_id'];
    $dt_to = $_POST['dt_to'];
    $dt_from = $_POST['dt_from'];
    $ticket = $_POST['ticket'];
    $guest_member = $_POST['guest_member'];

    $data = array();
    $heading = array(
        'Entry ID',
        'Event Name',
        'Buyer Name',
        'Email',
        'Phone',
        'Company',
        'Position',
        'User Type',
        'Price',
        'Transaction Id',
        'Payment Gateway',
        'Address',
        'Date',
        'Total Tickets Count',
        'Employed Company',
        'Board of Director Company',
        'Private or Public Company',
    );
    // $post_id = $_POST['post_id'];

    $_where = " WHERE 1=1 ";
    if ($event_id) {
        $_where .= " AND event_id = '$event_id' ";
    }

    if ($dt_from) {

        $dt_from = date('Y-m-d', strtotime($dt_from));
        if ($dt_to == '') {
            $_where .= " AND `created_at` >= '$dt_from' ";
        } else {
            $dt_to = date('Y-m-d', strtotime($dt_to));
            $_where .= " AND `created_at` BETWEEN '$dt_from' AND '$dt_to' ";
        }

    }

    if ($guest_member) {
        $_where .= " AND member_guest = '$guest_member' ";
    }

    if ($ticket) {
        $enroll_query = $wpdb->get_results(" SELECT * FROM wp_gf_custom_child INNER JOIN wp_gf_custom ON wp_gf_custom_child.entry_id = wp_gf_custom.id   WHERE wp_gf_custom_child.ticket_id = '$ticket'   ");
    }
    $enroll_query = $wpdb->get_results(" SELECT * FROM `wp_gf_custom` $_where  ");

    foreach ($enroll_query as $key => $course) {


        $resultstwo = $wpdb->get_results("SELECT COUNT(entry_id) as totalticket FROM wp_gf_custom_child WHERE entry_id='" . $course->id . "'");
        $post_name = get_the_title($course->event_id);
        $data[$key]['Entry ID'] = $course->id;
        $data[$key]['Event Name'] = $post_name;
        $data[$key]['Buyer Name'] = $course->b_name;
        $data[$key]['Email'] = $course->email;
        $data[$key]['Phone'] = $course->phone ?: '-';
        $data[$key]['Company'] = $course->company ?: '-';
        $data[$key]['Position'] = $course->position ?: '-';
        $data[$key]['User Type'] = $course->member_guest;
        $data[$key]['Price'] = $course->price;
        $data[$key]['Transaction Id'] = $course->transaction_id;
        $data[$key]['Payment Gateway'] = $course->payment_gateway;
        $data[$key]['Address'] = $course->address;
        $data[$key]['Date'] = $course->created_at;
        $data[$key]['Total Tickets Count'] = $resultstwo[0]->totalticket;

        //Gravity Form 12 entry
        $gform_id = 12;
        $result_csv = GFAPI::get_entries($gform_id);
        foreach ($result_csv as $form_entries => $gdata) {
            if ($gdata[8] == $course->email) {
                $data[$key]['Employed Company'] = $gdata[72];
            }
        }
        foreach ($result_csv as $form_entries => $gdata) {
            if ($gdata[8] == $course->email) {
                $data[$key]['Board of Director Company'] = $gdata[73];
            }
        }
        foreach ($result_csv as $form_entries => $gdata) {
            if ($gdata[8] == $course->email) {
                $data[$key]['Private or Public Company'] = $gdata[74];
            }
        }
    }
    $path = generate_csv($name, $heading, $data);
    die($path);

}

function generate_csv($name, $heading, $data)
{

    $filename = ($name . '_' . date_i18n('d_M_Y') . '.csv');

    $wp_upload_dir = wp_upload_dir();
    $upload_dir = $wp_upload_dir['basedir'] . '/eventlisting/';
    $upload_url = $wp_upload_dir['baseurl'] . '/eventlisting/';
    $file_path = $upload_dir . $filename;
    $file_url = $upload_url . $filename;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir);
    }

    $fp = @fopen($file_path, 'w');

    fputcsv($fp, $heading);

    foreach ($data as $res) {
        fputcsv($fp, $res);
    }


    fclose($fp);

    return ($file_url);
}

add_action('wp_logout', 'remove_login_popup_message');


function remove_login_popup_message()
{
    if (isset($_COOKIE['name'])) {
        unset($_COOKIE['name']);
        setcookie('name', null, -1, '/');

        return true;
    } else {
        return false;
    }
}

add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy');
function tsm_filter_post_type_by_taxonomy()
{
    global $typenow;
    $post_type = 'events'; // change to your post type
    $taxonomy = 'events-cat'; // change to your taxonomy
    if ($typenow == $post_type) {
        $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
        $info_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' => sprintf(__('Show all %s', 'textdomain'), $info_taxonomy->label),
            'taxonomy' => $taxonomy,
            'name' => $taxonomy,
            'orderby' => 'name',
            'selected' => $selected,
            'show_count' => true,
            'hide_empty' => true,
        ));
    };
}

add_filter('parse_query', 'tsm_convert_id_to_term_in_query');
function tsm_convert_id_to_term_in_query($query)
{
    global $pagenow;
    $post_type = 'events'; // change to your post type
    $taxonomy = 'events-cat'; // change to your taxonomy
    $q_vars = &$query->query_vars;
    if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
        $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
        $q_vars[$taxonomy] = $term->slug;
    }
}


add_action('mepr_subscription_transition_status', 'mepr_subscription_transition_status_fn', 10, 3);
function mepr_subscription_transition_status_fn($old_status, $new_status, $sub)
{
    $user_id = $sub->user_id;
    $user_data = get_userdata($user_id);
    $membership_id = $sub->product_id;
    $new_subscription_status = $new_status;
    $subject = "CONGRATULATIONS ON YOUR WEL DIAMOND MEMBERSHIP.";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: WeLFlorida <info@welflorida.org>\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message = '
<table style="width: 100%; background-color: #cfcfcf;" width="100" cellspacing="0" cellpadding="0" bgcolor="#cfcfcf">
	<tbody>
	<tr>
		<td>
			<table style="width: 640px; background-color: #fff; margin: 0 auto; padding: 0 15px; font-family: Sans-serif;" width="640px" cellspacing="0" cellpadding="0" bgcolor="#cfcfcf">
				<tbody>
				<tr style="height: 10px; line-height: 10px;">
					<td></td>
				</tr>
				<tr>
					<td><img style="display: block; margin: 0 auto;" src="https://welflorida.org/wp-content/uploads/2021/01/wel-logo.png" width="250" height="80" /></td>
				</tr>
				<tr>
					<td style="height: 50px; line-height: 50px;" height="50px;"></td>
				</tr>
				<tr>
					<td>Dear ,' . $user_data->display_name . '</td>
				</tr>
				<tr>
					<td style="height: 20px; line-height: 20px;" height="20px;"></td>
				</tr>
				<tr>
					<td>
						<h3>CONGRATULATIONS ON YOUR WEL DIAMOND MEMBERSHIP!</h3>
					</td>
				</tr>
				<tr>
					<td>
							You are part of an elite group of successful women executives who want to further their career & expand their network. Your WEL Diamond Membership provides you extra benefits including extra discounts that save you money, as well as valuable services to accelerate your career. Below are all the benefits of your Diamond Membership.

						Plus, you received our special offerings for the launch which includes:
							
						<ul>
							<li>$250 Discount off Diamond Membership</li>
							<li>Credit for proration of unused Charter Membership Dues</li>
							<li>Forever Renewal of $950</li>
							<li>Private Diamond Member Salon with Coco Brown, CEO and Founder of Athena Alliance</li>
						</ul>

					</td>
				</tr>
				<tr>
					<td style="height: 2px; line-height: 2px;" height="2px;"></td>
				</tr>
				<tr>
					<td>In the next 72 hours, you will receive a Welcome Email from Athena Alliance with instructions on how to access their Membership Portal and the resources provided by Athena.</td>
				</tr>
				<tr>
					<td style="height: 20px; line-height: 20px;" height="20px;"></td>
				</tr>
				<tr>
					<td>You also will receive a separate email from WEL’s Administrator, Meredith Williams with the invoice for your Diamond Membership.  Please reach out to Meredith, <a href="mailto:Admin@WELFlorida.org">Admin@WELFlorida.org</a> , or me with any questions. We’re here for you to get the most from you Diamond Membership.</td>
				</tr>
				<tr style="height: 10px; line-height: 10px;">
					<td></td>
				</tr>
				<tr>
					<td>Thank you!</td>
				</tr>
				<tr style="height: 10px; line-height: 10px;">
					<td></td>
				</tr>
				<tr>
					<td><strong>Best,</strong></td>
				</tr>
				<tr style="height: 10px; line-height: 10px;">
					<td></td>
				</tr>
				<tr>
					<td style="color: #12b5e2;"><strong><i>Shari</i></strong></td>
				</tr>
				<tr style="height: 10px; line-height: 10px;">
					<td></td>
				</tr>
				<tr>
					<td><strong>Shari B. Roth</strong></td>
				</tr>
				<tr>
					<td><a href="mailto:shari@sharibroth.com">shari@sharibroth.com</a></td>
				</tr>
				<tr>
					<td><a href="tel:9546660258">(954) 666-0258 (Office)</a></td>
				</tr>
				<tr>
					<td><a href="tel:9545624631">(954) 562-4631 (Call)</a></td>
				</tr>
				<tr style="height: 20px; line-height: 20px;">
					<td></td>
				</tr>
				<tr>
					<td>
						<h3 style="margin-bottom: 0;">YOUR WEL DIAMOND MEMBERSHIP INCLUDES:</h3>
					</td>
				</tr>
				<tr style="height: 10px; line-height: 10px;">
					<td></td>
				</tr>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" border="1" style="font-family: “Helvetica Neue”,Helvetica,Arial,sans-serif;">
							<tbody>
								<tr bgcolor="#00b0f0" style="background: #00b0f0; color: #fff;">
									<td style="padding: 5px;">
									WOMEN EXECUTIVE LEADERSHIP
									</td>
									<td style="padding: 5px;">
										WELFlorida.org
									</td>
								</tr>
							<tr>
								<td style="padding: 5px;">
								Virtual Programs &amp; Educational Workshops (4 to 5 per year)
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								In Person Programs &amp; Educational Workshops
								(1 to 2 per year)
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Member Only Edutainment Events (3 to 4 per year)
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Member Only Breakfast/Dinners (1 – 2 per year)
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Member Directory
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Executive &amp; Board Candidate Searches
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Annual Signature Event
								</td>
								<td style="padding: 5px;">
								Enhanced Preferred Pricing &amp; Seating
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Board Boot Camp
								</td>
								<td style="padding: 5px;">
								Enhanced Preferred Pricing
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Event Recordings
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Resources for Members Only
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								BoardEx: Profile listed on BoardEx website a “Go To” resource for Board Recruiters
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Bio &amp; LinkedIn Review<strong>*</strong>
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Featured in WEL’s Equilar Listing
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								One-On-One with WEL Advisory Board Member<strong>**</strong>
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr bgcolor="#ed7d31" style="background: #ed7d31; color : #fff;">
								<td colspan="2" style="padding: 5px;">
								<strong>Athena Alliance: Self-Service Membership Includes:</strong>
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Virtual Educational Workshops
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Online Learning Library
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Executive &amp; Board Candidate Searches
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							<tr>
								<td style="padding: 5px;">
								Member Directory with Concierge Support introductions &amp; connections to Athena Members
								</td>
								<td style="padding: 5px;">
								Complimentary
								</td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr >
					<td style="height: 20px; line-height: 20px;" > </td>
				</tr>
				<tr>
					<td><strong>* Resume & LinkedIn Review</strong> provided by Scott Singer, <a href="mailto:scott.singer@insidercs.com">scott.singer@insidercs.com</a>
Scott’s services include: One 30-minute phone or virtual discussion, followed by his written recommendations to enhance your Bio & LinkedIn Profile.</td>
				</tr>
				<tr style="height: 20px; line-height: 20px;">
					<td></td>
				</tr>
				<tr>
					<td><strong>** One-On-One Hour with an Advisory Board Member:</strong> Contact Meredith Williams, Meredith Williams, Admin@WELFlorida.org when you are ready to schedule your one-on-one.</td>
				</tr>
				<tr style="height: 20px; line-height: 20px;">
					<td></td>
				</tr>
				<tr style="background-color: #000; color: #fff;" bgcolor="#000">
					<td style="padding: 15px; text-align: center;">Copyright ©2021. All Rights Reserved | Designed &amp; Developed by <a style="color: #00b0f0;" href="https://kingdom-vision.com/" target="_blank" rel="noopener">Kingdom Vision</a></td>
				</tr>
				<tr style="height: 10px; line-height: 10px;">
					<td></td>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>
	</tbody>
</table>';
    if ($membership_id == 20138 && $new_subscription_status == 'active') {
        wp_mail($user_data->user_email, $subject, $message, $headers);
    }
}

function get_active_product_subscription_custom($user_id)
{
    global $wpdb;
    $total_ids = array(263, 20138);
    $found = false;
    $result = $wpdb->get_results("SELECT COUNT(id) AS total FROM `wp_mepr_subscriptions` WHERE user_id = $user_id AND status = 'active' AND  product_id IN (20138,263)");
    // print_r($result);
    // die;
    if ($result[0]->total == 2) {
        $found = true;
    }

    return $found;
}

function is_active_charter_subscription($user_id)
{
    $user = MeprUtils::get_currentuserinfo();
    if ($user) {
        return in_array(263, $user->active_product_subscriptions('ids'));

    }

    return false;
}

function get_single_active_product_subscription_custom($user_id)
{
    $user = MeprUtils::get_currentuserinfo();
    if ($user) {
        return in_array(20138, $user->active_product_subscriptions('ids'));
    }

    return false;
}


// This adds display names for all users to a drop down box on a gravity form.
add_filter("gform_pre_render", "populate_userdrop");
add_filter("gform_admin_pre_render", "populate_userdrop");

function populate_userdrop($form)
{

//    var_dump($form["id"] == 11 && isset($_GET['membership']) && isset($_GET['level']));
//    die;

    //only populating drop down for form id 1 - if editing this change to your own form ID
    if ($form["id"] == 12) {

        //Creating item array.
        $items = array();
        // Get the custom field values stored in the array
        // If editing this lookup where you would like to get your data from
        // this example loads through all users of the website
        $metas = get_users();

        if (is_array($metas)) {
// in this example we just load the display_name for each user into our drop-down field
            foreach ($metas as $meta) {
                $items[] = array("value" => $meta->id, "text" => $meta->display_name);
            }
        }

        $events = array();

        $args = array(
            'post_status' => 'publish',
            'post_type' => 'events',
            'posts_per_page' => -1,
            'meta_key' => 'latest_announcement',
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'events-cat',
                    'field' => 'slug',
                    'terms' => array('private-events'),
                    'operator' => 'NOT IN'
                )
            )
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                $events[] = array("value" => get_the_id(), "text" => get_the_title());
            endwhile;
            wp_reset_postdata();
        endif;


        //Adding items to field id 1. Replace 1 with your actual field id. You can get the field id by looking at the input name in the markup.
        foreach ($form["fields"] as &$field) {
            if ($field["id"] == 68) {
                $field["choices"] = $items;
            }
            if ($field["id"] == 69) {
                $field["choices"] = $events;
            }
        }

    }

    //only populating drop down for form id 1 - if editing this change to your own form ID
    if ($form["id"] == 11 && isset($_GET['membership'])) {
        //Adding items to field id 1. Replace 1 with your actual field id. You can get the field id by looking at the input name in the markup.
        foreach ($form["fields"] as &$field) {
            if ($field["id"] == 92) {
                $choices = array();
                foreach ($field['choices'] as $choice) {
                    if (@$_GET['membership'] == 'charter' && $choice['value'] == 'gold') {
                        $choice['isSelected'] = true;
                    }
                    if (@$_GET['membership'] == 'diamond' && $choice['value'] == 'welflorida-diamond-membership') {
                        $choice['isSelected'] = true;
                    }

                    $choices [] = $choice;
                }
                $field['choices'] = $choices;
//                pre($choices, 1);
//                die;
            }
        }
    }

    return $form;
}

add_action('gform_after_submission_12', 'register_event_add_entry_to_db', 10, 2);

function register_event_add_entry_to_db($entry, $form)
{
    global $wpdb;
    $data_to_insert = array(
        'user_id' => $entry['68'],
        'event_id' => $entry['69'],
        'ticket_id' => 0,
        'guest_ticket_id' => 0,
        'member_guest' => $entry['71'],
        'b_name' => $entry['2.3'] . " " . $entry['2.4'] . " " . $entry['2.6'],
        'company' => $entry['12'],
        'position' => $entry['59'],
        'role' => $entry['56'],
        'phone' => $entry['3'],
        'price' => $entry['65'],
        'transaction_id' => $entry['66'],
        'payment_gateway' => 'Manual',
        'address' => $entry['4.1'] . " " . $entry['4.2'] . " " . $entry['4.3'] . " " . $entry['4.4'] . " " . $entry['4.5'],
        'option_in_out' => 0,
        'email' => $entry['8'],
        'created_at' => $entry['date_created'],
    );
    $wpdb->insert('wp_gf_custom', $data_to_insert);

    $post_id = $entry['69'];
    $post_title_name = get_the_title($post_id);
    $uid = $entry['68'];
    $user_name = $entry['2.3'] . " " . $entry['2.6'];
    $start_date = get_field("start_date", $entry["post_id"]);
    $date = date('m-d-Y', strtotime($start_date));
    $time = date('h:i:s a', strtotime($start_date));
    $results = $wpdb->get_results(" SELECT * from wp_acf_data WHERE post_id='" . $post_id . "' AND available_for ='member' AND status=1");
    $location = $results[0]->location;
    $user_email = rgar($entry, '8');

    $title_name = sanitize_title($post_title_name);
    // $uid = $post_id;
    $filename = $title_name . "-" . $uid . ".ics";
    $message_url = get_stylesheet_directory_uri() . '/eventicsfiles/' . $filename;
    $message_outlook = $message_url;

//    $additional_note = get_field('event_additional_note', $entry["53"]);

//    var_dump($additional_note);
//    die;

    // $user_email = $user_email;
    $headers = "";
    $message = "";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "From: WeLFlorida <info@welflorida.org>\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message .= "";
    $message .= "<p style='text-align: center; padding: 10px 0; margin: 0;'><img class='size-full wp-image-11558 aligncenter' src='" . home_url('/wp-content/uploads/2021/01/wel-logo.png') . "' alt='' width='250' height='80' /></p>";

    $message .= "<div style='width:550px; margin:0 auto;  padding: 10px;' class='main_row container-full'><div class='body'>
						<h3>Dear $user_name</h3>
						<p><strong>Thank you for registering for $post_title_name</strong></p>
						<p>Date: $date </p>
						<p>Time: $time</p>
						<p>Location: $location</p>
						<p>Add to Google:  <a href='$message_url'>Click Follow Link To Add Google Calendar.</a></p>
						<p>Add to Outlook:  <a href='$message_outlook'>Click Follow Link To Add Outlook Calendar.</a></p>
						";
    $message .= "
						<p>Please contact WEL’s Administrator, Meredith Williams at:  <a href='mailto:info@welflorida.org' target='_blank'>info@welflorida.org</a> if you need any assistance.</p>
						<p>Thank you.</p>
						</div>
						<div  style='text-align: center; color: #fff; background: #000; padding: 5px 0;''>
							<p>Copyright ©2020 All right Reserved</p>
						</div>
						</div>";


    $subject = "You are registered";
    wp_mail($user_email, $subject, $message, $headers);
    // end add calender send mail to user
}

function pre($d = array(), $t = 0)
{
    echo '<pre>';
    print_r($d);
    echo '</pre>';
    if ($t) {
        die;
    }
}

function mepr_account_subscriptions_actions($user, $sub, $txn, $is_sub)
{
    if ($is_sub && $sub->status === 'active') {
        $sub = new MeprSubscription($sub->id);
//        pre(get_class_methods($sub), 1);
//        pre($sub->transactions(),1);
//        pre($sub->user()->subscriptions()[0]->id, 1);
//        $sub->destroy();
        if ($sub->product()->ID === 263) {
            echo '<a href="' . get_permalink(20138) . '" class="mepr-account-row-action mepr-account-change">Upgrade To Diamond</a>';
        } elseif ($sub->product()->ID === 20138) {
            echo '<a href="' . get_permalink(263) . '" class="mepr-account-row-action mepr-account-change">Downgrade To Charter</a>';
        }
    }
}

add_action('mepr-account-subscriptions-actions', 'mepr_account_subscriptions_actions', 10, 4);

add_filter('mepr_create_subscription', 'mepr_capture_new_recurring_sub', 99, 1);
function mepr_capture_new_recurring_sub($sub_id)
{
    $sub = new MeprSubscription($sub_id);
    MeprEvent::record('subsc ription-created', $sub);
    foreach ($sub->user()->subscriptions() as $subscription) {
        if ($subscription->id === $sub_id) {
            continue;
        }
        $subscription = new MeprSubscription($subscription->id);
        $subscription->delete();
    }
    $user_id = $sub->user_id;
    $user_type = get_user_meta($user_id, 'mepr_member_type', true);
    if (empty($user_type)) {
        return $sub_id;
    }
    if ($sub_id == 263) {
        $user_type = str_replace('diamond', 'charter', $user_type);
        update_user_meta($user_id, 'mepr_member_type', $user_type);
    }
    if ($sub_id == 20138) {
        $user_type = str_replace('charter', 'diamond', $user_type);
        update_user_meta($user_id, 'mepr_member_type', $user_type);
    }

    return $sub_id;

}

add_action('gform_user_registered', 'add_custom_user_meta', 10, 4);
function add_custom_user_meta($user_id, $feed, $entry, $user_pass)
{
    if ($entry['92'] == 'gold|375') {
        update_user_meta($user_id, 'mepr_member_type', 'charter-member');
    }
    if ($entry['92'] == 'welflorida-diamond-membership|1200') {
        update_user_meta($user_id, 'mepr_member_type', 'diamond-member');
    }
}

//add_filter( 'gform_pre_render_13', 'dynamic_add_user_in_gform' );
function dynamic_add_user_in_gform($form)
{
    $users = get_users();
    // print_r($users);
    foreach ($form['fields'] as &$field) {
        // var_dump($field->type);
        if ($field->type != 'multiselect') {
            continue;
        }
        foreach ($users as $user) {
            // echo $user->data->ID;
            // echo $user->data->display_name;

            $choices[] = array('text' => $user->data->display_name, 'value' => $user->data->ID);
        }
        $field->choices = $choices;
    }

    return $form;
}

//add_action( 'gform_after_submission_13', 'dynamic_gform_upload', 10, 2 );
function dynamic_gform_upload($entry, $form)
{
    global $wpdb;
    // echo '<pre>';
    // print_r($entry);
    // print_r($form);
    // echo '</pre>';

    // print_r($entry[1]);
    $file_url = $entry[1];
    $user_ids = str_replace("[", "", $entry[2]);
    $user_ids = str_replace("]", "", $user_ids);
    $user_ids = str_replace("\"", "", $user_ids);
    // echo $file_url. ' '.$user_ids;
    // $filename = explode("/", $file_url);
    // print_r(end($filename));
    $user_ids = explode(",", $user_ids);
    // print_r($user_ids);

    // $subscription_member = $entry[5.1];
    // $subscription_user = $entry[5.2];
    $subscription = $entry[6];
    // echo $file_url. ' '. $user_ids . ' ' . $subscription . ' ' . $member;
    // print_r($entry[5]);
    // print_r($entry[5.1]);
    // print_r($entry[5.2]);
    $field_id = 7;
    $field = GFFormsModel::get_field($form, $field_id);
    $field_value = is_object($field) ? $field->get_value_export($entry) : '';

    // print_r($field_value);
    // echo $field_value;
    $field_value = explode(",", $field_value);
    $chartermember = $field_value[0];
    $diamondmember = $field_value[1];
    $advisorymember = $field_value[2];

    // $checkTwoFieldSelected = 0;
    // elseif( !empty($chartermember) && !empty($diamondmember) && empty($advisorymember) ){
    //     $checkTwoFieldSelected = 1;
    //     $type = $chartermember.','.$diamondmember;
    // } elseif( !empty($chartermember) && empty($diamondmember) && !empty($advisorymember) ){
    //     $checkTwoFieldSelected = 1;
    //     $type = $chartermember.','.$advisorymember;  
    // } elseif( empty($chartermember) && empty($diamondmember) && !empty($advisorymember) ){
    //     $checkTwoFieldSelected = 1;
    //     $type = $diamondmember.','.$advisorymember;  
    // }

    // echo $subscription . ' ' . $chartermember . ' ' .$diamondmember . ' ' . $charterboardmember . ' ' . $diamondboardmember ;
    // echo 'subscription_member: ' . $subscription_member. '   subscription_user: '. $subscription_user;
    // die('test');

    //For Charter Board & Diamond Board Member

    // $charterboardmember = $field_value[2];
    // $diamondboardmember = $field_value[3];

    // if( !empty($file_url) ){
    //     if( $subscription == 1  ){
    //         foreach($user_ids as $user_id){
    //             $wpdb->insert('wp_upload_directory', array(
    //                 'file_path'     => $file_url,
    //                 'allow_user'    => $user_id,
    //                 'type'          => null,
    //             ));
    //         }
    //     } else if($subscription ==  2 && ( !empty($chartermember) || !empty($charterboardmember) ) && ( empty($diamondmember) || empty($diamondboardmember) ) ){
    //         foreach($user_ids as $user_id) {
    //             $wpdb->insert('wp_upload_directory', array(
    //                 'file_path'     => $file_url,
    //                 'allow_user'    => null,
    //                 'type'          => $chartermember,
    //             ));
    //         }
    //     } else if($subscription ==  2 && ( empty($chartermember) || empty($charterboardmember) ) && ( !empty($diamondmember) || !empty($diamondboardmember) ) ){
    //         foreach($user_ids as $user_id) {
    //             $wpdb->insert('wp_upload_directory', array(
    //                 'file_path'     => $file_url,
    //                 'allow_user'    => null,
    //                 'type'          => $diamondmember,
    //             ));
    //         }
    //     } else {
    //         $wpdb->insert('wp_upload_directory', array(
    //             'file_path'     => $file_url,
    //             'type'          => 'both',
    //             'allow_user'    => null,
    //         ));
    //     }
    // }

    if (!empty($file_url)) {
        if ($subscription == 1) {
            foreach ($user_ids as $user_id) {
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => $user_id,
                    'type' => null,
                ));
            }
        } elseif (!empty($chartermember) && !empty($diamondmember) && empty($advisorymember)) {
            foreach ($user_ids as $user_id) {
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => null,
                    'type' => trim($chartermember),
                    'check_file' => 'two',
                ));
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => null,
                    'type' => trim($diamondmember),
                    'check_file' => 'two',
                ));
            }
            // foreach($user_ids as $user_id) {
            // }
        } elseif (!empty($chartermember) && empty($diamondmember) && !empty($advisorymember)) {
            foreach ($user_ids as $user_id) {
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => null,
                    'type' => trim($chartermember),
                    'check_file' => 'two',
                ));
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => null,
                    'type' => trim($advisorymember),
                    'check_file' => 'two',
                ));
            }
            // foreach($user_ids as $user_id) {
            // }
        } elseif (empty($chartermember) && !empty($diamondmember) && !empty($advisorymember)) {
            foreach ($user_ids as $user_id) {
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => null,
                    'type' => trim($diamondmember),
                    'check_file' => 'two',
                ));
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => null,
                    'type' => trim($advisorymember),
                    'check_file' => 'two',
                ));
            }
            // foreach($user_ids as $user_id) {
            // }
        } else if ($subscription == 2 && !empty($chartermember) && (empty($diamondmember) || empty($advisorymember))) {
            foreach ($user_ids as $user_id) {
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => null,
                    'type' => $chartermember,
                ));
            }
        } else if ($subscription == 2 && (empty($chartermember) || empty($advisorymember)) && !empty($diamondmember)) {
            foreach ($user_ids as $user_id) {
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => null,
                    'type' => $diamondmember,
                ));
            }
        } else if ($subscription == 2 && (empty($diamondmember) || empty($chartermember)) && !empty($advisorymember)) {
            foreach ($user_ids as $user_id) {
                $wpdb->insert('wp_upload_directory', array(
                    'file_path' => $file_url,
                    'allow_user' => null,
                    'type' => $advisorymember,
                ));
            }
        } else {
            $wpdb->insert('wp_upload_directory', array(
                'file_path' => $file_url,
                'type' => 'both',
                'allow_user' => null,
            ));
        }
    }
}

add_action('init', 'directory_custom_post_type', 0);
function directory_custom_post_type()
{

// Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Directories', 'Post Type General Name', 'welflorida'),
        'singular_name' => _x('Directory', 'Post Type Singular Name', 'welflorida'),
        'menu_name' => __('Member Directory', 'welflorida'),
        'all_items' => __('All Directories', 'welflorida'),
        'view_item' => __('View Directory', 'welflorida'),
        'add_new_item' => __('Add New Directory', 'welflorida'),
        'add_new' => __('Add New', 'welflorida'),
        'edit_item' => __('Edit Directory', 'welflorida'),
        'update_item' => __('Update Directory', 'welflorida'),
        'search_items' => __('Search Directory', 'welflorida'),
        'not_found' => __('Not Found', 'welflorida'),
        'not_found_in_trash' => __('Not found in Trash', 'welflorida'),
    );

// Set other options for Custom Post Type

    $args = array(
        'label' => __('Membership Directories', 'welflorida'),
        'description' => __('Membership Directories', 'welflorida'),
        'labels' => $labels,
        'supports' => array('title', 'editor'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-open-folder',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'show_in_rest' => true,
    );
    // Registering your Custom Post Type
    register_post_type('directory', $args);

    //labels array
    $labels = array(
        'name' => _x('Directory Folders', 'taxonomy general name'),
        'singular_name' => _x('Directory Folders', 'taxonomy singular name'),
        'search_items' => __('Search Directory Folders'),
        'all_items' => __('All Directory Folders'),
        'parent_item' => __('Parent Directory Category'),
        'edit_item' => __('Edit Directory Folder'),
        'update_item' => __('Update Directory Folder'),
        'add_new_item' => __('Add New Directory Folder'),
        'new_item_name' => __('New Directory Folder'),
        'menu_name' => __(' Directory Folders'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
    );

    register_taxonomy('directory_category', 'directory', $args);

}

function mime_type($filename)
{
    $mime_types = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'css' => 'text/css',
        'json' => array('application/json', 'text/json'),
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',
        'hqx' => 'application/mac-binhex40',
        'cpt' => 'application/mac-compactpro',
        'csv' => array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel'),
        'bin' => 'application/macbinary',
        'dms' => 'application/octet-stream',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'exe' => array('application/octet-stream', 'application/x-msdownload'),
        'class' => 'application/octet-stream',
        'so' => 'application/octet-stream',
        'sea' => 'application/octet-stream',
        'dll' => 'application/octet-stream',
        'oda' => 'application/oda',
        'ps' => 'application/postscript',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'mif' => 'application/vnd.mif',
        'wbxml' => 'application/wbxml',
        'wmlc' => 'application/wmlc',
        'dcr' => 'application/x-director',
        'dir' => 'application/x-director',
        'dxr' => 'application/x-director',
        'dvi' => 'application/x-dvi',
        'gtar' => 'application/x-gtar',
        'gz' => 'application/x-gzip',
        'php' => 'application/x-httpd-php',
        'php4' => 'application/x-httpd-php',
        'php3' => 'application/x-httpd-php',
        'phtml' => 'application/x-httpd-php',
        'phps' => 'application/x-httpd-php-source',
        'js' => array('application/javascript', 'application/x-javascript'),
        'sit' => 'application/x-stuffit',
        'tar' => 'application/x-tar',
        'tgz' => array('application/x-tar', 'application/x-gzip-compressed'),
        'xhtml' => 'application/xhtml+xml',
        'xht' => 'application/xhtml+xml',
        'bmp' => array('image/bmp', 'image/x-windows-bmp'),
        'gif' => 'image/gif',
        'jpeg' => array('image/jpeg', 'image/pjpeg'),
        'jpg' => array('image/jpeg', 'image/pjpeg'),
        'jpe' => array('image/jpeg', 'image/pjpeg'),
        'png' => array('image/png', 'image/x-png'),
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'shtml' => 'text/html',
        'text' => 'text/plain',
        'log' => array('text/plain', 'text/x-log'),
        'rtx' => 'text/richtext',
        'rtf' => 'text/rtf',
        'xsl' => 'text/xml',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'word' => array('application/msword', 'application/octet-stream'),
        'xl' => 'application/excel',
        'eml' => 'message/rfc822',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => array('application/x-zip', 'application/zip', 'application/x-zip-compressed'),
        'rar' => 'application/x-rar-compressed',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'mpga' => 'audio/mpeg',
        'mp2' => 'audio/mpeg',
        'mp3' => array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
        'aif' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'ram' => 'audio/x-pn-realaudio',
        'rm' => 'audio/x-pn-realaudio',
        'rpm' => 'audio/x-pn-realaudio-plugin',
        'ra' => 'audio/x-realaudio',
        'rv' => 'video/vnd.rn-realvideo',
        'wav' => array('audio/x-wav', 'audio/wave', 'audio/wav'),
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'avi' => 'video/x-msvideo',
        'movie' => 'video/x-sgi-movie',

        // adobe
        'pdf' => 'document/pdf',
        'psd' => array('image/vnd.adobe.photoshop', 'application/x-photoshop'),
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'document/msword',
        'rtf' => 'document/rtf',
        'xls' => array('document/excel', 'application/vnd.ms-excel', 'application/msexcel'),
        'ppt' => array('document/powerpoint', 'application/vnd.ms-powerpoint'),

        // open office
        'odt' => 'document/vnd.oasis.opendocument.text',
        'ods' => 'document/vnd.oasis.opendocument.spreadsheet',
    );
    $ext = explode('.', $filename);
    $ext = strtolower(end($ext));

    if (array_key_exists($ext, $mime_types)) {
        return (is_array($mime_types[$ext])) ? $mime_types[$ext][0] : $mime_types[$ext];
    } else if (function_exists('finfo_open')) {
        if (file_exists($filename)) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
    }

    return 'application/octet-stream';
}

add_action('init', 'create_post_type');
function create_post_type()
{
    register_post_type('podcast',
        array(
            'labels' => array(
                'name' => __('Podcast'),
                'singular_name' => __('Podcast')
            ),
            'supports' => array(
                'title',
                'editor',
                'thumbnail'
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-microphone',
            'rewrite' => array('slug' => 'podcast')
        )
    );
}

//Podcast Shortcode
add_shortcode('our_podcast', 'codex_our_podcast');
function codex_our_podcast()
{
    ob_start();
    wp_reset_postdata();
    ?>
    <div class="podcast-wrapper">
        <?php $query = new WP_Query(array('post_status' => 'publish', 'post_type' => 'podcast', 'posts_per_page' => -1, 'order' => 'DESC')); ?>
        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
            <div class="podcast-container">
                <div class="thumbnail"><a
                            href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), ''); ?></a>
                </div>
                <div class="content">
                    <div class="title"><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></div>
                    <div class="except"><?php echo wp_trim_words(get_the_content(), 25); ?></div>
                    <div class="podcast-icon"><a href="<?php the_permalink(); ?>"></a></div>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
    <?php
    wp_reset_postdata();
    return '' . ob_get_clean();
}


function ajax_podcast_viewer_action_fn()
{
    $key = '';
    if ($_POST['_action'] == 'played') {
        $key = 'played';
    } elseif ($_POST['_action'] == 'downloaded') {
        $key = 'downloaded';
    }

    $post_id = !empty($_POST['post']) ? (int)$_POST['post'] : -1;

    $count = 1;
    $postCount = get_post_meta($post_id, $key, 1);
    if ($postCount)
        $count = $postCount + 1;
    if (update_post_meta($post_id, $key, $count))
        wp_send_json_success();

    wp_send_json_error();
}

add_action('wp_ajax_podcast_viewer_action', 'ajax_podcast_viewer_action_fn');
add_action('wp_ajax_nopriv_podcast_viewer_action', 'ajax_podcast_viewer_action_fn');


//Register Meta box
add_action('add_meta_boxes', function () {
    add_meta_box('podcast-details', 'Podcast Data', 'podcast_meta_data_box_fn', 'podcast', 'side');
});

//Meta callback function
function podcast_meta_data_box_fn($post)
{
    $played = get_post_meta($post->ID, 'played', 1) ?: 0;
    $downloaded = get_post_meta($post->ID, 'downloaded', 1) ?: 0;

    ?>
    <div class="field-wrapper">
        <label for="played">No of played</label>
        <input value="<?php echo $played; ?>" id="played" type="text" readonly>
    </div>
    <div class="field-wrapper">
        <label for="download">No of downloads</label>
        <input value="<?php echo $downloaded; ?>" id="download" type="text" readonly>
    </div
    <?php
}

add_filter( 'template_include', 'cf_custom_template_include', 99 );
function cf_custom_template_include($template) {
    if( @$_GET['_dev'] != 'custom' )
        return $template;

    if( is_singular( 'events' ) ) {
        $new_template = locate_template(array('single-eventsdev.php'));
        if ('' != $new_template) {
            return $new_template;
        }
    }

    return $template;
}
//active user
function mepr_upme_activate($txn) {
  update_user_meta($txn->user_id, 'upme_activation_status', 'ACTIVE');
  update_user_meta($txn->user_id, 'upme_approval_status', 'ACTIVE');
  update_user_meta($txn->user_id, 'upme_user_profile_status', 'ACTIVE');
  upme_update_user_cache($txn->user_id);
}
add_action('mepr-signup', 'mepr_upme_activate');