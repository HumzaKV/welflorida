<?php
/**
 * Author: Muhammad Saad
**/
class SQEventTickets {

    private $db;
    private $prefix;
    private $currentUser;
    private $memberUser;
    private $event;
    private $tickets = array();
    // private $ticket;
    private $coupon;
    private $categories = array();
    private $startDate = '';
    private $endDate = '';

    public $eid = 0;
    public $tid = 0;
    public $registered_emails = array();
    
    function __construct() {
        global $wpdb;

        $this->db = $wpdb;
        $this->prefix = $wpdb->prefix;
        // 
        $this->setCurrenctUser();
        $this->setMemberUser();
        $this->setEvent();
    }

    function setCurrenctUser() {
        $this->currentUser = wp_get_current_user();
    }

    function setMemberUser() {
        $this->memberUser = MeprUtils::get_currentuserinfo();
    }

    function setEvent() {
        $this->event = get_post( get_the_ID() );
        $this->eid = $this->event->ID;

        $this->setTickets();
        $this->setCoupon();
        $this->setCategories();
        $this->setStartDate();
        $this->setEndDate();
    }

    function setTickets() {
        $this->tickets = get_field('ticket', $this->eid);
    }

    function setCoupon() {
        $this->coupon = get_field('coupon', $this->eid);
    }

    function setCategories() {
        $this->categories = get_the_terms($this->eid, 'events-cat');
    }

    function setStartDate() {
        $this->startDate = get_field('start_date', $this->eid);
    }

    function setEndDate() {
        $this->endDate = get_field('end_date', $this->eid);
    }

    // Get Loggin User Details
    function getCurrentUser() {
        return $this->currentUser;
    }

    // Get Member User Details
    function getMemberUser() {
        return $this->memberUser;
    }

    // Get Single Event Details
    function getEvent() {
        // pre($this->event);
        return $this->event;
    }

    // Get All Tickets of Current Event
    function getTickets() {
        return $this->tickets;
    }

    // Get Ticket Details
    // function getTicket() {
    //     return $this->ticket;
    // }

    // Get Ticket By Id
    // function getTicketById() {
    //     return;
    // }

    function getCoupon() {
        return $this->coupon;
    }

    function getCategories() {
        return $this->categories;
    }

    function getCategoryById( $id ) {
        $_term = array();
        foreach ($this->getCategories() as $term) {
            if( $term->term_id == $id ) {
                $_term = $term;
                break;
            }
        }
        return $_term;
    }

    function getStartDate() {
        return $this->startDate;
    }

    function getEndDate() {
        return $this->endDate;
    }

    function getTicketByMemberType( $type, $key = 'available_member' ) {
        $_ticket = array();
        foreach ($this->getTickets() as $ticket) {
            $ticket = $ticket['public'];
            if( $ticket[$key] == $type ) {
                // $_ticket = $ticket;
                // pre($ticket,1);
                $_ticket = new SQTicket($ticket);
                // pre($_ticket,1);
                break;
            }
        }
        return $_ticket;
    }

    function getDiamondTicket() {
        $ticket = $this->getTicketByMemberType('Diamond');
        return $ticket;
    }

    function getCharterTicket() {
        $ticket = $this->getTicketByMemberType('Charted');
        return $ticket;
    }

    function getMemberTicket() {
        $ticket = $this->getTicketByMemberType('member', 'available_for');
        return $ticket;
    }

    function getAnyMemberTicket() {
        $ticket = $this->getCharterTicket();
        if( $ticket ) {
            return $ticket;
        }
        else {
            return $this->getDiamondTicket();
        }
    }

    function getGuestTicket() {
        $ticket = $this->getTicketByMemberType('guest', 'available_for');
        return $ticket;
    }

    function getRegisterEvent() {
        $results = $this->db->get_col( sprintf(" SELECT `email` FROM {$this->prefix}gf_custom 
                        WHERE event_id = '%s' AND status = 0 ", $this->eid) );

        $this->registered_emails = array();
        if( $results ) {
            $this->registered_emails = $results;
        }

        return $this->registered_emails;
    }

    function getUserSubscriptions($ids = '') {
        $user = $this->getMemberUser();
        if( $user ) {
            if( $ids )
            return $user->active_product_subscriptions($ids);
            else
                return $user->active_product_subscriptions();
        }
        else {
            return array();
        }
    }

    function isCoupon() {
        return $this->getCoupon() ? true : false;
    }

    function isEventRegistered() {
        if( $this->getCurrentUser() )
            return in_array($this->getCurrentUser()->user_email, $this->registered_emails);
        else
            return false;
    }

    function isCharterMember() {
        $subcription_id = 263;
        return in_array( $subcription_id, $this->getUserSubscriptions('ids') );
    }

    function isDiamondMember() {
        $subcription_id = 20138;
        return in_array( $subcription_id, $this->getUserSubscriptions('ids') );
    }

    function isTicketByMemberType( $type ) {
        $ticket = $this->getTicketByMemberType($type);
        return $ticket ? true : false;
    }

    function getGFShortcode() {
        $args = array(
            'welevent'      => 'welevent',
            'private_event_custom'      => 'private_event_custom',
            'evnt_name'     => $this->getEvent()->post_title,
            'price1'        => 'price1',
            'price2'        => 'price2',
            'hidden_id_gf_invisible'    => 'hidden_id_gf_invisible',
            'quantity'      => 'quantity',
            'is_coupon'     => $this->isCoupon(),
            'check_id1'     => 'check_id1',
            'diamond_member' => '0',
        );
        $field_values = http_build_query($args);
        printf('[gravityform id="1" title="false" field_values="%s"]', $field_values);
    }

    function dbGetMemberGuest( $type ) {
        $results = $this->db->get_row(" SELECT * from {$this->prefix}acf_data 
                    WHERE post_id = '{$this->eid}' AND available_for = '{$type}' 
                        AND `status` = '1' ");
        return $results;
    }

    function dbGetTicketCounts( $type ) {
        $prefix = $this->prefix;
        $results = $this->db->get_row(" SELECT COUNT(gfc.ticket_id) AS NumberOfTicketId 
            FROM {$prefix}gf_custom AS gfc 
            LEFT JOIN {$prefix}gf_custom_child gfcc ON gfc.id = gfcc.entry_id 
            WHERE gfc.event_id = '{$this->eid}' AND gfcc.memberOrguest = '{$type}' 
                AND gfc.status = 0 ");

        return $results;
    }
}

class SQTicket {

    private $data = array();
    public $tid = 0;

    function __construct($x) {
        // 
        // if( is_array($x) ) {
        //     $this->data = $x;
        // }
        $this->data = $x;

        $this->setId();
    }

    function setId() {
        if( isset($this->data->tid) ) {
            $this->tid = $this->data->tid;
        }
    }

    function getTicketId() {
        return $this->tid;
    }

    function getName() {
        return $this->data['name'];
    }

    function getDescription() {
        return $this->data['description'];
    }

    function getAvailableFor() {
        return $this->data['available_for'];
    }

    function getMember() {
        return $this->data['available_member'];
    }

    function getFromTime() {
        return $this->data['available_from_time'];
    }

    function getFromDate() {
        return $this->data['available_from_date'];
    }

    function getUntilTime() {
        return $this->data['available_until_time'];
    }

    function getUntilDate() {
        return $this->data['available_until_date'];
    }

    function getUntilDateFormat() {
        return $this->data['available_until_date'];
    }

    function getPrice() {
        return (float) $this->data['price'];
    }

    function getPriceFormat() {
        return '$'. number_format_i18n( $this->data['price'], 2 );
    }

    function getSpaces() {
        return $this->data['spaces'];
    }

    function getLocation() {
        return $this->data['location'];
    }

    function getUniqId() {
        return $this->data['uniq-id'];
    }

    function getAvailabilty() {
        return $this->data['availabilty'];
    }

    function isAvailabilty() {
        return $this->getAvailabilty() == 'yes';
    }

}