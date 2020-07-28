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
    
    // Form Fields
    public $form_fields = array(
        0 => array(
            'name' => 'Salary',
            'database_name' => 'salary',
            'formname' => 'salary',
            'input_type' => 'text',
        ),
        1 => array(
            'name' => 'Job Type',
            'database_name' => 'job_type',
            'formname' => 'job_type',
            'input_type' => 'select',
            'select_options' => array(
                0 => array(
                    'name' => 'Freelance',
                    'formname' => 'freelance'
                ),
                1 => array(
                    'name' => 'Full time',
                    'formname' => 'fulltime'
                ),
                2 => array(
                    'name' => 'Part time',
                    'formname' => 'parttime'
                ),
                3 => array(
                    'name' => 'Intern',
                    'formname'=> 'intern'
                ),
                4 => array(
                    'name' => 'Temporary',
                    'formname' => 'temporary'
                ),
                5 => array(
                    'name' => 'Volunteer',
                    'formname' => 'volunteer'
                ),
                6 => array(
                    'name' => 'Work Based Learning',
                    'formname' => 'work_based_learning'
                )
            )
        ),
        2 => array(
            'name' => 'Contact Person',
            'database_name' => 'contact_person',
            'formname' => 'contact_person',
            'input_type' => 'text',
        ),
        3 => array(
            'name' => 'Phone Number',
            'database_name' => 'phone_number',
            'formname' => 'phone_number',
            'input_type' => 'text'
        ),
        4 => array(
            'name' => 'Deadline',
            'database_name' => 'deadline',
            'formname' => 'deadline',
            'input_type' => 'date'
        ),
        5 => array(
            'name' => 'Sector(s)',
            'database_name' => 'sectors',
            'formname' => 'sectors',
            'input_type' => 'select',
            'select_options' => array(
                0 => array(
                    'name' => 'Accounting',
                    'formname' => 'accounting'
                ),
                1 => array(
                    'name' => 'Construction',
                    'formname' => 'construction'
                ),
                2 => array(
                    'name' => 'Nursing',
                    'formname' => 'nursing'
                )
            )
        )
    );

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
        }
    }

    /**
     * PUBLIC FUNCTIONS
     */

    // Display form fields
    public function display_form_fields() {
        foreach ($this->form_fields as $field) {
            if ($field['input_type'] == 'text') {
                ?><p><?php echo $field['name']; ?></p>
                <input type="text" name="<?php echo $field['formname']; ?>"><?php
            }
        }
    }

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