<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
get_header();

require __DIR__ . '/class-sq-event-tickets.php';

// $user = MeprUtils::get_currentuserinfo();
// pre( ($user->active_product_subscriptions('ids')), 1);
$SQEvent = new SQEventTickets();

// pre( $SQEvent->getMemberUser(), 0);
// pre( $SQEvent->getTickets(), 0);
// pre( $SQEvent->getCoupon(), 0);
// pre( $SQEvent->getCategories(), 0);
// pre( $SQEvent->getCategoryById(27), 0);
// pre( $SQEvent->getDiamondTicket(), 0);
// pre( $SQEvent->getDiamondTicket()->getName(), 0);
// pre( $SQEvent->getCharterTicket(), 0);
// pre( $SQEvent->getRegisterEvent(), 0);
// pre( $SQEvent->getUserSubscriptions(), 0);
// pre( $SQEvent->getMemberTicket(), 0);
// pre( $SQEvent->getMemberTicket()->getName(), 0);
// pre( $SQEvent->getGFShortcode(), 1);

global $post, $wpdb;
$id_hidden = '';
$quantity = '';
$checkout = '';
$check_id1 = 0;
$types = array();
$id1 = isset($_GET['id1']) && $_GET['id1'] ? $_GET['id1'] : false;
$id2 = isset($_GET['id2']) && $_GET['id2'] ? $_GET['id2'] : false;


$user = $SQEvent->getMemberUser();
$current_user = $SQEvent->getCurrentUser();
$post_id = get_the_ID();
$is_coupon = $SQEvent->isCoupon();
$getEvent = $SQEvent->getEvent();
$isEventRegistered = $SQEvent->isEventRegistered();
$subscription = $SQEvent->getUserSubscriptions();

$isDiamondMember = $SQEvent->isDiamondMember() ? 1 : 0;
$getGuestMember = $SQEvent->getGuestTicket();
$getCharterMember = $SQEvent->getCharterTicket();
$getDiamondMember = $SQEvent->getDiamondTicket();
$getAnyMember = $SQEvent->getAnyMemberTicket();

// Get Member
$isMemberTicket = ( $getAnyMember ? 1 : 0 );
$checkMember = $getGuestMember->getAvailableFor();
$category_ids = array(
    'announcement' => 25, 'athena' => 26,
    'welevent' => 27, 'private_event' => 28
);
$cat_announcement = $SQEvent->getCategoryById( $category_ids['announcement'] );
$cat_athena = $SQEvent->getCategoryById( $category_ids['athena'] );
$cat_welevent = $SQEvent->getCategoryById( $category_ids['welevent'] );
$cat_private_event = $SQEvent->getCategoryById( $category_ids['private_event'] );

?>

<section class="full-section single_event <?= ($cat_announcement || $cat_athena ) ? 'diamond-announcement' : ''; ?>">
    <div class="main-title">
        <div class="container">
            <?php 
            $term = array();
            // Announcements
            if( $term = $cat_announcement ) {
                // printf('<h1>%s</h1>', $term->name);
                printf('<h1>WEL <span>ANNOUNCEMENT</span></h1>');
            }
            // Athena Event
            else if( $term = $cat_athena ) {
                printf('<h1>Athena <span>Events</span></h1>');
            }
            else {
                printf('<h1>WEL <span>EVENTS</span></h1>');
            }
            ?>
        </div>
    </div>
    <!-- / .main-title -->

    <div class="container">
        <div class="main-event-single">
            <div class="event-name">
                <?php 
                if( !empty($term) ) :
                    printf( '<h2>%s</h2>', get_the_title() );
                else :
                    $sty_bold = get_field('bold_title');
                    $sty_title = get_field('title');

                    if ($sty_bold && $sty_title) {
                        printf('<h2><span class="color-bold">%s</span> %s</h2>', $sty_bold, $sty_title);
                    } else {
                        printf( '<h2>%s</h2>', get_the_title() );
                    }
                endif;
                ?>
                <h3 class="registration-timing"><?php the_field('sub_title'); ?></h3>
            </div>
            <!-- / .event-name -->

            <?php 
                $featuredImage = '';
                if( has_post_thumbnail() )
                    $featuredImage = get_the_post_thumbnail($post_id, 'event_images');
                else
                    $featuredImage = sprintf('<img src="%s"/>', home_url('/wp-content/themes/welflorida/images/placeholder+image.png') );
            ?>
            <!-- / featuredImage -->

            <?php if( $term && $term->term_id == $category_ids['announcement'] ) { ?>
                <div class="event-single-in">
                    <div class="left">
                        <?php echo $featuredImage; ?>
                    </div>
                    <div class="right">
                        <?php the_field('content_area', false, false); ?>
                    </div>
                </div>

            <?php } else if( $term && $term->term_id == $category_ids['athena'] ) { ?>

                <div class="event-single-in">
                    <?php echo $featuredImage; ?>
                    <?php if( $isDiamondMember ) { ?>
                        <?php the_field('content_area', false, false); ?>
                        <div class="event-btns">
                            <?php
                            $event_event_link = get_field('athena_event_link');
                            if ($event_event_link) {
                            ?>
                                <a class="red membership btn t1" 
                                    href="<?= $event_event_link; ?>">
                                    View Event
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            <?php
                            }
                            ?>
                        </div>
                    <?php } else { ?>

                        <h2>This Event is Only for the Diamond Members</h2>

                    <?php } // EndIf isDiamondMember ?>
                </div>

            <?php } else { ?>

                <div class="event-single-in">
                    <div class="left">
                        <?php echo $featuredImage; ?>

                        <?php 
                        $pro_link = get_field('social_links');
                        if ($pro_link) {
                            echo '<ul class="soc-profile">';
                            if ($pro_link) :
                                foreach ($pro_link as $key => $pl) {
                                    $label = $pl['label'];
                                    $links = $pl['links'];

                                    printf('<li><span class="label">%s</span>
                                        <span class="link">
                                        <a href="%s" target="_blank">%s</a>
                                        </span></li>', $label, $links, $links);

                                }
                            endif;
                            echo '</ul>';
                        }
                        ?>

                    </div>
                    <div class="right">
                        <?php the_field('content_area', false, false); ?>

                        <div class="registration-details">
                            <?php 
                            $types = array();
                            $types_guest = array();
                            $query_params = array();

                            $results_count = $SQEvent->dbGetTicketCounts('member');

                            $total_spaces = $getAnyMember->getSpaces();
                            $total_booking = $results_count ? $results_count->NumberOfTicketId : 0;
                            $available_until_date = $getAnyMember->getUntilDate();

                            $startTimeDate = $SQEvent->getStartDate();
                            $startDate = date('Y-m-d', strtotime($startTimeDate));
                            $startTime = date('g:i a', strtotime($startTimeDate));

                            $endTimeDate = $SQEvent->getEndDate();
                            $endDate = date('Y-m-d', strtotime($endTimeDate));
                            $endTime = date('g:i a', strtotime($endTimeDate));
                            $endTimeDateConvert = date('Y-m-d H:i:s', strtotime($endTimeDate));

                            $date_time = current_time('mysql');
                            $date = current_time('Y-m-d');

                            $available_until_date = DateTime::createFromFormat('m-d-Y', $available_until_date);

                            if ( $available_until_date ) {
                                $available_until_date = $available_until_date->format('Y-m-d');
                            }

                            $query_params['checkout'] = 1;

                            $memberRecord = $SQEvent->dbGetMemberGuest('member');
                            if( $memberRecord ) {
                                $types[$memberRecord->id] = $memberRecord;
                                $query_params['id1'] = $memberRecord->id;
                            }

                            $guestRecord = $SQEvent->dbGetMemberGuest('guest');
                            if( $guestRecord ) {
                                $types_guest[$guestRecord->id] = $guestRecord;
                                $query_params['id2'] = $guestRecord->id;
                            }

                            // pre( $subscription, 0);
                            // pre( $getGuestMember, 0);
                            if( $user ) {
                            if( $subscription ) {

                                $price = "Complimentary";
                                if( $getAnyMember->getPrice() > 0 ) {
                                    $price = $getAnyMember->getPriceFormat();
                                }
                            ?>
                                <div>
                                    <strong>Date:</strong><?= date("m-d-Y", strtotime($startTimeDate)); ?>
                                </div>

                                <div>
                                    <strong>Members1:</strong> 
                                    <?php 
                                    if( $isDiamondMember )
                                        echo 'Free for diamond members';
                                    else
                                        echo $price;
                                    ?>
                                </div>

                            <?php if( !empty($getGuestMember) ) { ?>
                                <div>
                                    <strong>Guest Price:</strong>
                                    <?= $getGuestMember->getPriceFormat(); ?>
                                </div>
                            <?php } ?>
                            
                            <?php
                                
                            } // EndIf $user && $subscription
                            } // EndIf $user && $subscription
                            else {
                                $results_count = $SQEvent->dbGetTicketCounts('guest');
                                $total_booking = $results_count->NumberOfTicketId;
                                $total_spaces = $getGuestMember->getSpaces();

                                $available_until_date = $getGuestMember->getUntilDate();
                                $available_until_date = DateTime::createFromFormat('m-d-Y', $available_until_date);
                                if ($available_until_date) {
                                    $available_until_date = $available_until_date->format('Y-m-d');
                                }

                                $price = "Complimentary";
                                if( $getAnyMember->getPrice() > 0 ) {
                                    $price = $getAnyMember->getPriceFormat();
                                }

                                $flagDate = true;
                                $types_guest[$guestRecord->id] = $guestRecord;
                                $id_hidden = 1;
                                if( !empty($startTimeDate) && $flagDate ) {
                            ?>
                                    <div><strong>Date:</strong><?= date("m-d-Y", strtotime($startTimeDate)) ?>
                                    </div>
                            <?php 
                                    $flagDate = false;
                                }
                                ?>
                                <div><strong>Members2:</strong><?= $price ?></div>
                            <?php 
                                $price = "Complimentary";
                                if( $getGuestMember->getPrice() > 0 ) {
                                    $price = $getGuestMember->getPriceFormat();
                                }
                            ?>
                                <div><strong>Guest Price:</strong><?= $price; ?></div>
                            <?php
                            }
                            ?>
                            <div class="email-us">
                                <?php the_field('content'); ?>
                            </div>
                        </div>

                    </div>
                </div>

                <?php 
                $multi = get_field('multi_image_text');
                if ($multi) {
                ?>
                    <div class="multi-img">
                        <ul>
                            <?php if ($multi):foreach ($multi as $key => $mi) {
                                $img = $mi['image'];
                                $title = $mi['title'];
                                $cont = $mi['content'];
                                ?>

                                <li>
                                    <img src="<?php echo $img; ?>" width="200px" height="200"/>
                                    <h3><?php echo $title; ?></h3>
                                    <?php echo $cont; ?>
                                </li>

                            <?php } endif; ?>
                        </ul>
                    </div> <!-- Multi-img -->

                <?php 
                }
                ?>


                <!-- Buttons -->
                <?php
                $closed_event = get_field('close_registeration_');
                if( $closed_event ) {

                    $closed_event_reason = get_field('reason_to_close');
                    echo "<h2 class='booking_close t1'>" . $closed_event_reason . "</h2>";

                } else {
                    $checkout = isset($_GET['checkout']) && $_GET['checkout'] ? true : false;
                    $guestRecord = $SQEvent->dbGetMemberGuest('guest');

                    if( $user ) {
                        if ($subscription) {

                            if ($date_time > $endTimeDateConvert || $date > $available_until_date) {

                                echo "<h2 class='booking_close t2'>Booking Close</h2>";

                            } elseif ($total_spaces <= $total_booking) {
                                echo "<h2 class='booking_close t3'>Booking Full For Members</h2>";
                            //Muzammil
                            } elseif( !$isMemberTicket ){

                                echo "<h2 class='booking_close t3'>Booking only for " . $checkMember . " Members</h2>";
                            } else {
                                
                                if (!$isEventRegistered) { ?>
                                    <div class="event-btns">
                                        <a class="red membership btn t2" href="<?php echo get_the_permalink() . '?' . http_build_query($query_params) ?>">REGISTER<i
                                                    class="fa fa-angle-right"></i></a>
                                    </div>

                                    <?php
                                } else {
                                    echo "<h2 class='booking_close t4'>Already Purchased</h2>";
                                }
                            }

                        } else {
                            if (!empty($guestRecord)) {
                                    $types_guest[$guestRecord->id] = $guestRecord;
                                    $id_hidden = 1;
                                    $quantity = 1;
                                    ?>

                                    <div class="event-btns">
                                        <a class="red membership btn t3"
                                           href="<?php echo get_the_permalink() . '?checkout=1&id2=' . $guestRecord->id ?>">WEL
                                            GUEST
                                            PURCHASE<i class="fa fa-angle-right"></i></a>
                                        <a class="orange partnership btn"
                                           href="<?php echo home_url('/account/?action=subscriptions'); ?>">Renew
                                            Membership</a>
                                    </div>
                                    <?php
                            } else {
                                echo "<h2 class='booking_close t5'>MEMBERS - ONLY EVENT</h2>";
                            }
                        }
                    } else {
                        $checkout = isset($_GET['checkout']) && $_GET['checkout'] ? true : false;

                        if (!empty($guestRecord)) {

                            if (new DateTime($date_time) > new DateTime($endTimeDateConvert) || new DateTime($date) > new DateTime($available_until_date)) {
                                echo "<h2 class='booking_close t6'>Event Closed</h2>";

                            } elseif ($total_spaces <= $total_booking) {

                                echo "<h2 class='booking_close t7'>Booking Full For Guest</h2>";

                            } else {
                                    $types_guest[$guestRecord->id] = $guestRecord;
                                    $id_hidden = 1;
                                    $quantity = 1;
                                    ?>
                                    <?php $actual_link = home_url(). $_SERVER['REQUEST_URI']; ?>
                                    <div class="event-btns">
                                        <a class="red membership btn t4"
                                           href="<?php echo home_url('/login?redirect_to=' . $actual_link); ?>">WEL MEMBER LOGIN HERE<i class="fa fa-angle-right"></i></a>

                                        <a class="orange partnership btn"
                                           href="<?php echo get_the_permalink() . '?checkout=1&id2=' . $guestRecord->id ?>">
                                           WEL GUEST PURCHASE<i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                    <?php
                            }
                        } else {
                            echo "<h2 class='booking_close t8'><a href='/login/'>MEMBERS -ONLY EVENT – Please log-in to register </a></h2>";
                        }
                    }
                }
            }
            ?>
        </div>
        <!-- / .main-event-single -->
    </div>
    <!-- / .container -->

</section>
<!-- / Section -->

<?php 
$gallery = get_field('gallery');
if ($gallery) {
?>
    <section class="full-section single_gallery__in">
        <div class="container">
            <ul class="gallery-pop">
                <?php
                foreach ($gallery as $key => $g) {
                    $image_id = wp_get_attachment_image($g['image'], $size);
                    $image_url = wp_get_attachment_image_src($g['image'], 'full')[0];
                    $size = '400x300';
                    echo '<li>';
                    echo sprintf('<a class="img_gallery" href="%s" rel="prettyPhoto[pp_gal]">%s</a>', $image_url, $image_id);
                    echo '</li>';
                } ?>
            </ul>
        </div>
    </section>
<?php } ?>

<?php

if( $checkout ) : ?>
    <!-- Gravity Form  -->
    <div class="enter_your_detail">
        <h2 id="scroll_page">Event Registration</h2>
    </div>
    <?php
    // if ($id1) {
    //     $event_price = $types[$id1]->price;
    //     if ($event_price == 0) {
    //         $check_id1 = 1;
    //     }
    // } else {
    //     $event_price = null;
    // }

    // if ($id2) {
    //     $event_price_guest = $types_guest[$id2]->price;
    // } else {
    //     $event_price_guest = null;
    // }
    
    $event_price = $getAnyMember->getPrice();
    $event_price_guest = $getGuestMember->getPrice();

    $welevent = 0;
    if( $cat_welevent && $isDiamondMember ) {
        $welevent = 1;
        $event_price = 0;
    }

    if ($event_price == 0 && $user) {
        $welevent = 1;
    }

    if ($event_price_guest == 0 && !$user) {
        $welevent = 1;
    }

    $private_event_custom = 0;
    if( $cat_private_event ) {
        $private_event_custom = 1;
    }

    if (!$isEventRegistered) {
        $args = array(
            'welevent'      => $welevent,
            'private_event_custom'      => $private_event_custom,
            'evnt_name'     => $getEvent->post_title,
            'price1'        => $event_price,
            'price2'        => $event_price_guest,
            'hidden_id_gf_invisible'    => $id_hidden,
            'quantity'      => $quantity,
            'is_coupon'     => $is_coupon,
            'check_id1'     => $check_id1,
            'diamond_member' => '0',
        );
        $field_values = http_build_query($args);

        // echo '[gravityform id="1" title="false" field_values="'. $field_values .'"]';

        echo do_shortcode('[gravityform id="1" title="false" field_values="'. $field_values .'"]');
    }

endif;
get_footer();
?>