<?php

class CJA_Classified_Advert {

    /**
     * PROPERTIES
     */

    public $id; // ID of advert post
    public $ad_type; // job_ad or course_ad 
    public $status; // active, expired, etc.
    public $expiry_date; // expiry date as timestamp
    public $activation_date; // activation date as timestamp
    public $human_activation_date; // human readable
    public $days_old;
    public $days_left;
    public $author; // ID of user placing ad
    public $author_human_name; // Humain readable author (company) name
    
    // Form fields
    public $title;
    public $content;
    public $category;
    public $subcategory;
    public $postcode;
    public $email;
    public $phone;
    public $class_photo_filename;
    public $class_photo_url;

    public $files_array = array();

    // For search
    public $order_by = 'date';
    public $max_distance;

    /**
     * CONSTRUCTOR
     */

    function __construct($id = 0) {
        if($id) {
            $this->id = $id;
            $this->ad_type = get_post_type($id);
            $this->status = get_post_meta($id, 'cja_ad_status', true);
            $this->expiry_date = get_post_meta($id, 'cja_ad_expiry_date', true);
            $this->activation_date = get_post_meta($id, 'cja_ad_activation_date', true);
            $this->human_activation_date = $this->get_human_activation_date();
            $this->days_left = $this->days_left();
            $this->days_old = $this->get_days_old();
            $this->author = get_post_field( 'post_author', $id );
            $this->author_human_name = $this->get_human_name();
            $this->created_by_current_user = $this->is_current_user_ad();
            
            // Form Fields
            $this->title = get_the_title($id);
            $this->content = get_the_content(null, false, $id);
            $this->category = get_post_meta($id, 'cja_category', true);
            $this->subcategory = get_post_meta($id, 'cja_subcategory', true);
            $this->postcode = get_post_meta($id, 'cja_postcode', true);
            $this->email = get_post_meta($id, 'cja_email', true);
            $this->phone = get_post_meta($id, 'cja_phone', true);
            $this->class_photo_filename = get_post_meta($id, 'cja_class_photo_filename', true);
            $this->class_photo_url = get_post_meta($id, 'cja_class_photo_url', true);

            $this->files_array = unserialize(get_post_meta($id, 'files_array', true));
        }
    }

    /**
     * PUBLIC FUNCTIONS
     */

    // Create a new WP Post
    public function create() {
        $postarray = array(
            'post_type' => 'classified_ad',
            'post_status' => 'publish'
        );
        $this->id = wp_insert_post( $postarray, true );
        $this->status = 'inactive';
        $this->expiry_date = 100;
        return $this->id;
    }

    // Update object from $_POST data
    public function update_from_form() {
        if ($_POST['ad-title']) {
            $this->title = $_POST['ad-title'];
        }
        if ($_POST['category']) {
            $this->category = $_POST['category'];
        }
        if ($_POST['subcategory']) {
            $this->subcategory = $_POST['subcategory'];
        }
        if ($_POST['postcode']) {
            $this->postcode = $_POST['postcode'];
        }
        if ($_POST['email']) {
            $this->email = $_POST['email'];
        }
        if ($_POST['phone']) {
            $this->phone = $_POST['phone'];
        }
        if ($_POST['content']) {
            $this->content = $_POST['content'];
        }
        
        if ($_POST['max_distance']) {
            $this->max_distance = $_POST['max_distance'];
        }
        if ($_POST['order_by']) {
            $this->order_by = $_POST['order_by'];
        }

        if ($_POST['delete_photo']) {
            $this->class_photo_filename = '';
            $this->class_photo_url = '';
        }

        if ( $_FILES['class_photo']['size'] != 0 ) {
            
            $info = getimagesize($_FILES['class_photo']['tmp_name']);
            if ($info === FALSE) {
                return 'filetype_error';
            }
            
            if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
                return 'filetype_error';
            }
    
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }
            $uploadedfile = $_FILES['class_photo'];
    
            $upload_overrides = array(
                'test_form' => false
            );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            $this->class_photo_filename = $uploadedfile['name'];
            $this->class_photo_url = $movefile['url'];
        }

        //files
        if ( $_POST['delete_files'] ) {
            foreach ($_POST['delete_files'] as $delete_file) {
                foreach ($this->files_array as $key => $value) {
                    if ($delete_file == $value['url']) {
                        unset($this->files_array[$key]);
                    }
                }
            }
        }

        if ( $_FILES['files']['size'][0] != 0 ) {
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }
            $files = $_FILES['files'];
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                    'name'     => $files['name'][$key],
                    'type'     => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error'    => $files['error'][$key],
                    'size'     => $files['size'][$key]
                    );
                    $upload_overrides = array(
                        'test_form' => false
                    );
                    $movefile = wp_handle_upload($file, $upload_overrides);
                    $new_file_data = array(
                        'name' => $files['name'][$key],
                        'url' => $movefile['url']
                    );
                    $this->files_array[] = $new_file_data;
                }
            }
        }
    }
    
    // Update all properties in the WP database
    public function save() {
        $values = array(
            'ID'           => $this->id,
            'post_title'   => $this->title,
            'post_content' => $this->content,
        );
        wp_update_post( $values );

        update_post_meta($this->id, 'cja_ad_status', $this->status);
        update_post_meta($this->id, 'cja_ad_expiry_date', $this->expiry_date);
        update_post_meta($this->id, 'cja_ad_activation_date', $this->activation_date);

        update_post_meta($this->id, 'cja_category', $this->category);
        update_post_meta($this->id, 'cja_subcategory', $this->subcategory);
        update_post_meta($this->id, 'cja_postcode', $this->postcode);
        update_post_meta($this->id, 'cja_email', $this->email);
        update_post_meta($this->id, 'cja_phone', $this->phone);
        update_post_meta($this->id, 'cja_class_photo_url', $this->class_photo_url);
        update_post_meta($this->id, 'cja_class_photo_filename', $this->class_photo_filename);

        update_post_meta($this->id, 'files_array', serialize($this->files_array));
    }

    // Activate the advert
    public function activate() {
        $this->status = 'active';
        $this->activation_date = strtotime(date('j F Y'));
        $this->expiry_date = strtotime(date("j F Y", strtotime("+1 month", strtotime(date('j F Y')))));
        $this->send_approval_email();
    }

    private function send_approval_email() {
        $advertiser = new CJA_User($this->author);
        $to = $advertiser->email;
        $subject = 'Your advert has been approved';
        $message = 'Your advert for ' . $this->title . ' has been approved and is now live.';
        wp_mail($to, $subject, $message);
    }

    // Extend the advert
    public function extend() {
        $this->expiry_date = strtotime(date("j F Y", strtotime("+1 month", $this->expiry_date)));
    }

    // Delete ad (not delete post but set status to deleted)
    public function delete() {
        $this->status = 'deleted';
    }

    // Update search object from cookies
    public function update_from_cookies() {
        $this->salary_numeric = $_COOKIE[ get_current_user_id() . '_salary_numeric'];
        $this->max_distance = $_COOKIE[ get_current_user_id() . '_classified_max_distance'];
        $this->category = $_COOKIE[ get_current_user_id() . '_classified_category'];
        $this->subcategory = $_COOKIE[ get_current_user_id() . '_classified_subcategory'];
        $this->order_by = $_COOKIE[ get_current_user_id() . '_classified_order_by'];
    }

    // Build WP Query from search values
    public function build_wp_query() {

        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $wp_query_args = array(
            'post_type' => 'classified_ad',
            'orderby' => 'order_clause',
            'order' => 'DSC',
            'posts_per_page' => -1
        );

        $meta_query = array();
        $meta_query['order-clause'] = array(
            'key' => 'cja_ad_activation_date',
            'type' => 'NUMERIC'
        );

        $meta_item = array(
            'key' => 'cja_ad_status',
            'value' => 'active'
        );
        $meta_query[] = $meta_item;

        $fields = array( 'category', 'subcategory' );

        foreach($fields as $field) {
            if ($this->$field) {
                $meta_item = array();
                $meta_item['key'] = 'cja_' . $field;
                $meta_item['value'] = $this->$field;
                $meta_query[] = $meta_item;
            }
        }

        $wp_query_args['meta_query'] = $meta_query;

        return $wp_query_args;
    }

    // Return human values
    public function return_human($field) {
        
        if ($field == 'category') {
            if ($this->category == 'for_sale') { return 'For Sale'; }
            if ($this->category == 'for_hire') { return 'For Hire'; }
            if ($this->category == 'motors') { return 'Motors'; }
            if ($this->category == 'pets') { return 'Pets'; }
            if ($this->category == 'properties') { return 'Properties'; }
            if ($this->category == 'services') { return 'Services'; }
            if ($this->category == 'exchange') { return 'Exchange'; }
            if ($this->category == 'freebies') { return 'Freebies'; }
            if ($this->category == 'lost_found') { return 'Lost and Found'; }
            if ($this->category == 'make_offer') { return 'Make an Offer'; }
            if ($this->category == 'notices') { return 'Notices'; }
            if ($this->category == 'events') { return 'Events'; }
            if ($this->category == 'urgent_jobs') { return 'Urgent Jobs'; }
        }

        /*
        if ($field == 'subcategory') {
            if ($this->subcategory == 'motors') { return 'Motors'; }
            if ($this->subcategory == 'properties') { return 'Properties'; }
            if ($this->subcategory == 'restaurants') { return 'Restaurants'; }
            if ($this->subcategory == 'pets') { return 'Pets'; }
            if ($this->subcategory == 'plumbers') { return 'Plumbers'; }
            if ($this->subcategory == 'news_events') { return 'News and Events'; }
        }
        */
    }

    /**
     * PRIVATE FUNCTIONS
     */

    // Calculate number of days left for ad to run as integer
    private function days_left() {
        if ($this->status == 'active') {
            return abs(round($this->expiry_date - strtotime(date('j F Y'))) / 86400);
        } else {
            return 0;
        }
    }

    // Return human friendly activation date
    private function get_human_activation_date() {
        if (is_numeric($this->activation_date)) {
            return date("j F Y", $this->activation_date);
        } else {
            return "Not activated";
        }
    }

    // Return number of days since the ad was activated
    private function get_days_old() {
        $diff = strtotime(date("j F Y")) - $this->activation_date;
        return abs(round($diff / 86400));
    }

    // Return human friendly author (company) name 
    private function get_human_name() {
        return get_user_meta($this->author, 'company_name', true);
    }

    // Is the ad by the current user
    private function is_current_user_ad() {
        if ($this->author == get_current_user_id()) {
            return 1;
        } else {
            return 0;
        }
    }
}

?>