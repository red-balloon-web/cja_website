<?php

class CJA_Course_Advert {

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
    public $created_by_current_user; // Boolean
    public $applied_to_by_current_user; // Boolean
    public $hourly_equivalent_rate;
    
    // Form fields
    public $title;
    public $description;
    public $offer_type;
    public $category;
    public $organisation_name;
    public $address;
    public $postcode;
    public $price;
    public $contact_person;
    public $phone;
    public $sector;
    public $deposit_required;
    public $experience_required;
    public $provider_type;
    public $previous_qualification;
    public $course_pathway;
    public $funding_options;
    public $payment_plan;
    public $qualification_level;
    public $qualification_type;
    public $contact_for_enquiry;
    public $total_units;
    public $dbs_required;
    public $availability_period;
    public $allowance_available;
    public $awarding_body;
    public $duration;
    public $suitable_benefits;
    public $social_services;
    public $delivery_route;
    public $available_start;
    public $deadline;
    public $course_file_filename;
    public $course_file_url;

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
            $this->applied_to_by_current_user = $this->is_applied_to_by_current_user();
            
            // Form Fields
            $this->title = get_the_title($id);
            $this->description = get_the_content($id);
            $this->offer_type = get_post_meta($id, 'cja_offer_type', true);
            $this->category = get_post_meta($id, 'cja_category', true);
            $this->organisation_name = get_post_meta($id, 'cja_organisation_name', true);
            $this->address = get_post_meta($id, 'cja_address', true);
            $this->postcode = get_post_meta($id, 'cja_postcode', true);
            $this->price = get_post_meta($id, 'cja_price', true);
            $this->contact_person = get_post_meta($id, 'cja_contact_person', true);
            $this->phone = get_post_meta($id, 'cja_phone', true);
            $this->sector = get_post_meta($id, 'cja_sector', true);
            $this->deposit_required = get_post_meta($id, 'cja_deposit_required', true);
            $this->career_level = get_post_meta($id, 'cja_career_level', true);
            $this->experience_required = get_post_meta($id, 'cja_experience_required', true);
            $this->provider_type = get_post_meta($id, 'cja_provider_type', true);
            $this->previous_qualification = get_post_meta($id, 'cja_previous_qualification', true);
            $this->course_pathway = get_post_meta($id, 'cja_course_pathway', true);
            $this->funding_options = get_post_meta($id, 'cja_funding_options', true);
            $this->payment_plan = get_post_meta($id, 'cja_payment_plan', true);
            $this->qualification_level = get_post_meta($id, 'cja_qualification_level', true);
            $this->qualification_type = get_post_meta($id, 'cja_qualification_type', true);
            $this->contact_for_enquiry = get_post_meta($id, 'cja_contact_for_enquiry', true);
            $this->total_units = get_post_meta($id, 'cja_total_units', true);
            $this->dbs_required = get_post_meta($id, 'cja_dbs_required', true);
            $this->availability_period = get_post_meta($id, 'cja_availability_period', true);
            $this->allowance_available = get_post_meta($id, 'cja_allowance_available', true);
            $this->awarding_body = get_post_meta($id, 'cja_awarding_body', true);
            $this->duration = get_post_meta($id, 'cja_duration', true);
            $this->suitable_benefits = get_post_meta($id, 'cja_suitable_benefits', true);
            $this->social_services = get_post_meta($id, 'cja_social_services', true);
            $this->delivery_route = get_post_meta($id, 'cja_delivery_route', true);
            $this->available_start = get_post_meta($id, 'cja_available_start', true);
            $this->deadline = get_post_meta($id, 'cja_deadline', true);
            $this->course_file_filename = get_post_meta($id, 'cja_course_file_filename', true);
            $this->course_file_url = get_post_meta($id, 'cja_course_file_url', true);
        }
    }

    /**
     * PUBLIC FUNCTIONS
     */

    // Create a new WP Post
    public function create() {
        $postarray = array(
            'post_type' => 'course_ad',
            'post_status' => 'publish'
        );
        $this->id = wp_insert_post( $postarray, true );
        $this->status = 'inactive';
        $this->expiry_date = 100;
        return $this->id;
    }

    // Update object from $_POST data
    public function update_from_form() {
        if (array_key_exists('ad-title', $_POST)) {
            $this->title = $_POST['ad-title'];
        }
        if (array_key_exists('ad-content', $_POST)) {
            $this->description = $_POST['ad-content'];
        }
        if (array_key_exists('offer_type', $_POST)) {
            $this->offer_type = $_POST['offer_type'];
        }
        if (array_key_exists('category', $_POST)) {
            $this->category = $_POST['category'];
        }
        if (array_key_exists('organisation_name', $_POST)) {
            $this->organisation_name = $_POST['organisation_name'];
        }
        if (array_key_exists('address', $_POST)) {
            $this->address = $_POST['address'];
        }
        if (array_key_exists('postcode', $_POST)) {
            $this->postcode = $_POST['postcode'];
        }
        if (array_key_exists('price', $_POST)) {
            $this->price = $_POST['price'];
        }
        if (array_key_exists('contact_person', $_POST)) {
            $this->contact_person = $_POST['contact_person'];
        }
        if (array_key_exists('phone', $_POST)) {
            $this->phone = $_POST['phone'];
        }
        if (array_key_exists('sector', $_POST)) {
            $this->sector = $_POST['sector'];
        }
        if (array_key_exists('deposit_required', $_POST)) {
            $this->deposit_required = $_POST['deposit_required'];
        }
        if (array_key_exists('career_level', $_POST)) {
            $this->career_level = $_POST['career_level'];
        }
        if (array_key_exists('experience_required', $_POST)) {
            $this->experience_required = $_POST['experience_required'];
        }
        if (array_key_exists('provider_type', $_POST)) {
            $this->provider_type = $_POST['provider_type'];
        }
        if (array_key_exists('previous_qualification', $_POST)) {
            $this->previous_qualification = $_POST['previous_qualification'];
        }
        if (array_key_exists('course_pathway', $_POST)) {
            $this->course_pathway = $_POST['course_pathway'];
        }
        if (array_key_exists('funding_options', $_POST)) {
            $this->funding_options = $_POST['funding_options'];
        }
        if (array_key_exists('payment_plan', $_POST)) {
            $this->payment_plan = $_POST['payment_plan'];
        }
        if (array_key_exists('qualification_level', $_POST)) {
            $this->qualification_level = $_POST['qualification_level'];
        }
        if (array_key_exists('qualification_type', $_POST)) {
            $this->qualification_type = $_POST['qualification_type'];
        }
        if (array_key_exists('contact_for_enquiry', $_POST)) {
            $this->contact_for_enquiry = $_POST['contact_for_enquiry'];
        }
        if (array_key_exists('total_units', $_POST)) {
            $this->total_units = $_POST['total_units'];
        }
        if (array_key_exists('dbs_required', $_POST)) {
            $this->dbs_required = $_POST['dbs_required'];
        }
        if (array_key_exists('availability_period', $_POST)) {
            $this->availability_period = $_POST['availability_period'];
        }
        if (array_key_exists('allowance_available', $_POST)) {
            $this->allowance_available = $_POST['allowance_available'];
        }
        if (array_key_exists('awarding_body', $_POST)) {
            $this->awarding_body = $_POST['awarding_body'];
        }
        if (array_key_exists('duration', $_POST)) {
            $this->duration = $_POST['duration'];
        }
        if (array_key_exists('suitable_benefits', $_POST)) {
            $this->suitable_benefits = $_POST['suitable_benefits'];
        }
        if (array_key_exists('social_services', $_POST)) {
            $this->social_services = $_POST['social_services'];
        }
        if (array_key_exists('delivery_route', $_POST)) {
            $this->delivery_route = $_POST['delivery_route'];
        }
        if (array_key_exists('available_start', $_POST)) {
            $this->available_start = $_POST['available_start'];
        }
        if (array_key_exists('deadline', $_POST)) {
            $this->deadline = $_POST['deadline'];
        }
        if ( $_FILES['course_file']['size'] != 0 ) {
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }
            $uploadedfile = $_FILES['course_file'];

            $upload_overrides = array(
                'test_form' => false
            );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            $this->course_file_filename = $uploadedfile['name'];
            $this->course_file_url = $movefile['url'];
        }
    }

    // Update all properties in the WP database
    public function save() {
        $values = array(
            'ID'           => $this->id,
            'post_title'   => $this->title,
            'post_content' => $this->description,
        );
        wp_update_post( $values );

        update_post_meta($this->id, 'cja_ad_status', $this->status);
        update_post_meta($this->id, 'cja_ad_expiry_date', $this->expiry_date);
        update_post_meta($this->id, 'cja_ad_activation_date', $this->activation_date);

        // Form fields
        update_post_meta($this->id, 'cja_offer_type', $this->offer_type);
        update_post_meta($this->id, 'cja_category', $this->category);
        update_post_meta($this->id, 'cja_organisation_name', $this->organisation_name);
        update_post_meta($this->id, 'cja_address', $this->address);
        update_post_meta($this->id, 'cja_postcode', $this->postcode);
        update_post_meta($this->id, 'cja_price', $this->price);
        update_post_meta($this->id, 'cja_contact_person', $this->contact_person);
        update_post_meta($this->id, 'cja_phone', $this->phone);
        update_post_meta($this->id, 'cja_sector', $this->sector);
        update_post_meta($this->id, 'cja_deposit_required', $this->deposit_required);
        update_post_meta($this->id, 'cja_career_level', $this->career_level);
        update_post_meta($this->id, 'cja_experience_required', $this->experience_required);
        update_post_meta($this->id, 'cja_provider_type', $this->provider_type);
        update_post_meta($this->id, 'cja_previous_qualification', $this->previous_qualification);
        update_post_meta($this->id, 'cja_course_pathway', $this->course_pathway);
        update_post_meta($this->id, 'cja_funding_options', $this->funding_options);
        update_post_meta($this->id, 'cja_payment_plan', $this->payment_plan);
        update_post_meta($this->id, 'cja_qualification_level', $this->qualification_level);
        update_post_meta($this->id, 'cja_qualification_type', $this->qualification_type);
        update_post_meta($this->id, 'cja_contact_for_enquiry', $this->contact_for_enquiry);
        update_post_meta($this->id, 'cja_total_units', $this->total_units);
        update_post_meta($this->id, 'cja_dbs_required', $this->dbs_required);
        update_post_meta($this->id, 'cja_availability_period', $this->availability_period);
        update_post_meta($this->id, 'cja_allowance_available', $this->allowance_available);
        update_post_meta($this->id, 'cja_awarding_body', $this->awarding_body);
        update_post_meta($this->id, 'cja_duration', $this->duration);
        update_post_meta($this->id, 'cja_suitable_benefits', $this->suitable_benefits);
        update_post_meta($this->id, 'cja_social_services', $this->social_services);
        update_post_meta($this->id, 'cja_delivery_route', $this->delivery_route);
        update_post_meta($this->id, 'cja_available_start', $this->available_start);
        update_post_meta($this->id, 'cja_deadline', $this->deadline);
        update_post_meta($this->id, 'cja_course_file_filename', $this->course_file_filename);
        update_post_meta($this->id, 'cja_course_file_url', $this->course_file_url);
    }

    // Activate the advert
    public function activate() {
        $this->status = 'active';
        $this->activation_date = strtotime(date('j F Y'));
        $this->expiry_date = strtotime(date("j F Y", strtotime("+1 month", strtotime(date('j F Y')))));
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
        $this->max_distance = $_COOKIE[ get_current_user_id() . '_course_max_distance'];
        $this->order_by = $_COOKIE[ get_current_user_id() . '_course_order_by'];
        if (!$this->order_by) { $this->order_by = 'date'; }
    }

    // Build WP Query from search values
    public function build_wp_query() {

        $wp_query_args = array(
            'post_type' => 'course_ad',
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

        $wp_query_args['meta_query'] = $meta_query;

        return $wp_query_args;
    }

    // Return human values
    public function return_human($field) {
        
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
    
    // Has the ad been applied to by the current user?
    private function is_applied_to_by_current_user() {

        $newargs = array(
            'post_type' => 'application',
            'meta_query' => array(
                array(
                    'key' => 'advertID',
                    'value' => $this->id
                )
            )
        );

        $the_new_query = new WP_Query( $newargs );

        if ( $the_new_query->have_posts() ) {
            while ( $the_new_query->have_posts() ) : $the_new_query->the_post();

                $check_application = new CJA_Application(get_the_ID());
                if ($check_application->applicant_ID == get_current_user_id()) {
                    wp_reset_postdata();
                    return $check_application->id;
                }

            endwhile;
        }

        wp_reset_postdata();
        return 0;
    }
}

?>