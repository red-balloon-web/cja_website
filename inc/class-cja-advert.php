<?php

class CJA_Advert {

    /**
     * PROPERTIES
     */

    public $id; // ID of advert post
    public $ad_type; // job_ad or course_ad
    public $title; // ad title
    public $content; // ad content
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
    public $salary;
    public $contact_person;
    public $phone;
    public $deadline; // YYYY-MM-DD
    public $job_type;
    public $sectors;
    

    /**
     * CONSTRUCTOR
     */

    function __construct($id = 0) {
        if($id) {
            $this->id = $id;
            $this->ad_type = get_post_type($id);
            $this->title = get_the_title($id);
            $this->content = get_the_content(null, false, $id);
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
            $this->salary = get_post_meta($id, 'cja_salary', true);
            $this->contact_person = get_post_meta($id, 'cja_contact_person', true);
            $this->phone = get_post_meta($id, 'cja_phone', true);
            $this->deadline = get_post_meta($id, 'cja_deadline', true);
            $this->job_type = get_post_meta($id, 'cja_job_type', true);
            $this->sectors = get_post_meta($id, 'cja_sectors', true);
        }
    }

    /**
     * PUBLIC FUNCTIONS
     */

    // Create a new WP Post
    public function create() {
        $postarray = array(
            'post_type' => 'job_ad',
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
        if ($_POST['ad-content']) {
            $this->content = $_POST['ad-content'];
        }
        if ($_POST['salary']) {
            $this->salary = $_POST['salary'];
        }
        if ($_POST['contact_person']) {
            $this->contact_person = $_POST['contact_person'];
        }
        if ($_POST['phone']) {
            $this->phone = $_POST['phone'];
        }
        if ($_POST['deadline']) {
            $this->deadline = $_POST['deadline'];
        }
        if ($_POST['job_type']) {
            $this->job_type = $_POST['job_type'];
        }
        if ($_POST['sectors']) {
            $this->sectors = $_POST['sectors'];
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
        update_post_meta($this->id, 'cja_salary', $this->salary);
        update_post_meta($this->id, 'cja_contact_person', $this->contact_person);
        update_post_meta($this->id, 'cja_phone', $this->phone);
        update_post_meta($this->id, 'cja_deadline', $this->deadline);
        update_post_meta($this->id, 'cja_job_type', $this->job_type);
        update_post_meta($this->id, 'cja_sectors', $this->sectors);
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

    public function return_human($field) {
        if ($field == 'job_type') {
            if ($this->job_type == 'full_time') { return 'Full Time'; }
            if ($this->job_type == 'part_time') { return 'Part Time'; }
            if ($this->job_type == 'freelance') { return 'Freelance'; }
            if ($this->job_type == 'intern') { return 'Internship'; }
            if ($this->job_type == 'temporary') { return 'Temporary'; }
        }

        if ($field == 'sectors') {
            if ($this->sectors == 'accountancy') { return 'Accountancy'; }
            if ($this->sectors == 'construction') { return 'Construction'; }
            if ($this->sectors == 'nursing') { return 'Nursing'; }
        }
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