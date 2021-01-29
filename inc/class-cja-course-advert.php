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
    public $can_apply_online;
    
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
    public $show_applied;
    
    public $files_array = array();

    public $photo_filename;
    public $photo_url;

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
            $this->can_apply_online = get_post_meta($id, 'cja_can_apply_online', true);
            
            // Form Fields
            $this->title = get_the_title($id);
            $this->description = get_the_content(null, false, $id);
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

            $this->files_array = unserialize(get_post_meta($id, 'files_array', true));

            $this->photo_filename = get_post_meta($id, 'photo_filename', true);
            $this->photo_url = get_post_meta($id, 'photo_url', true);

            $this->more_information = get_post_meta($id, 'more_information', true);
        }
    }

    /* FORM FIELDS */

    public $form_fields = array(
        "can_apply_online" => array(
            "meta_field" => true,
            "label" => "Allow applicants to apply online",
            "meta_label" => "cja_can_apply_online",
            "type" => "checkbox",
            "value" => "true"
        ),
        "offer_type" => array(
            "meta_field" => true,
            "label" => "Offer Type",
            "meta_label" => "cja_offer_type",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Classroom and Online Mode",
                    "value" => "classroom_online"
                ),
                array(
                    "label" => "Course Pathway: CPD Development",
                    "value" => "cp_cpd"
                ),
                array(
                    "label" => "Course Pathway: Employment",
                    "value" => "cp_employment"
                ),
                array(
                    "label" => "Course Pathway: University",
                    "value" => "cp_university"
                ),
                array(
                    "label" => "Course Pathway: Work or University",
                    "value" => "cp_work_or_university"
                ),
                array(
                    "label" => "Full Time",
                    "value" => "full_time"
                ),
                array(
                    "label" => "Fully-funded Course for 16-19s",
                    "value" => "fully_funded_16_19"
                ),
                array(
                    "label" => "Online - Study at your Own Pace",
                    "value" => "online_own_pace"
                ),
                array(
                    "label" => "Online and Distance Learning",
                    "value" => "online_distance"
                ),
                array(
                    "label" => "Part Time",
                    "value" => "part_time"
                ),
                array(
                    "label" => "Payment Plan Available",
                    "value" => "payment_plan_available"
                ),
                array(
                    "label" => "Payment Plan Available for 19s",
                    "value" => "payment_plan_19"
                ),
                array(
                    "label" => "Self-funded - No Payment Plan Available",
                    "value" => "self_fund_no_plan"
                ),
                array(
                    "label" => "Self-funded - Payment Plan Available",
                    "value" => "self_fun_plan"
                ),
                array(
                    "label" => "Student Loan Available",
                    "value" => "student_loan"
                ),
                array(
                    "label" => "Temporary",
                    "value" => "temporary"
                ),
                array(
                    "label" => "Volunteer",
                    "value" => "volunteer"
                ),
                array(
                    "label" => "Work Based Learning",
                    "value" => "work_based_learning"
                ),
                array(
                    "label" => "Other",
                    "value" => "other"
                )
            )
        ),
        "category" => array(
            "meta_field" => true,
            "label" => "Category",
            "meta_label" => "cja_category",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "A1, A2, B1 English Courses",
                    "value" => "ab_english"
                ),
                array(
                    "label" => "Assessor Course (CAVA)",
                    "value" => "assessor_cava"
                ),
                array(
                    "label" => "B1 English Course for Cab Drivers",
                    "value" => "b1_english_cab"
                ),
                array(
                    "label" => "Bespoke Training",
                    "value" => "bespoke_training"
                ),
                array(
                    "label" => "British Sign Language Course",
                    "value" => "bsl_course"
                ),
                array(
                    "label" => "Business Administration Courses",
                    "value" => "business_admin"
                ),
                array(
                    "label" => "Business Course for University",
                    "value" => "bus_course_university"
                ),
                array(
                    "label" => "Business Sector Courses",
                    "value" => "business_sector_courses"
                ),
                array(
                    "label" => "Childcare Sector",
                    "value" => "childcare_sector"
                ),
                array(
                    "label" => "CPD",
                    "value" => "cpd"
                ),
                array(
                    "label" => "CSCS",
                    "value" => "cscs"
                ),
                array(
                    "label" => "Customer Service Courses",
                    "value" => "customer_service"
                ),
                array(
                    "label" => "Driving Courses",
                    "value" => "driving_courses"
                ),
                array(
                    "label" => "Education Sector Courses",
                    "value" => "education_sector"
                ),
                array(
                    "label" => "Engineering & Construction Courses",
                    "value" => "engineering_construction"
                ),
                array(
                    "label" => "ESOL Courses",
                    "value" => "esol"
                ),
                array(
                    "label" => "First Aid Courses",
                    "value" => "first_aid"
                ),
                array(
                    "label" => "Fork Lift",
                    "value" => "fork_lift"
                ),
                array(
                    "label" => "Health and Safety",
                    "value" => "health_safety"
                ),
                array(
                    "label" => "Health and Social Care Course for University",
                    "value" => "health_social_university"
                ),
                array(
                    "label" => "Health and Social Care Courses for Work",
                    "value" => "health_social_work"
                ),
                array(
                    "label" => "Health Care Assistant Courses or Training",
                    "value" => "hca_courses"
                ),
                array(
                    "label" => "Health Care Industry Course",
                    "value" => "healthcare_industry"
                ),
                array(
                    "label" => "Hospitality and Catering Courses",
                    "value" => "hospitality_catering"
                ),
                array(
                    "label" => "Human Resources",
                    "value" => "human_resources"
                ),
                array(
                    "label" => "Information Technology Courses",
                    "value" => "it_courses"
                ),
                array(
                    "label" => "Internal Verifier Courses",
                    "value" => "internal_verifier"
                ),
                array(
                    "label" => "Legal Sector Courses",
                    "value" => "legal_sector"
                ),
                array(
                    "label" => "Marketing and PR Courses",
                    "value" => "marketing_pr"
                ),
                array(
                    "label" => "Private GCSE and A-level Exam Centres",
                    "value" => "private_gcse_alevel"
                ),
                array(
                    "label" => "Recruitment",
                    "value" => "recruitment"
                ),
                array(
                    "label" => "Retail Courses",
                    "value" => "retail_courses"
                ),
                array(
                    "label" => "S-Accountancy, Banking and Finance",
                    "value" => "s-accountancy"
                ),
                array(
                    "label" => "S-Business, Consulting and Management",
                    "value" => "s-business"
                ),
                array(
                    "label" => "S-Charity and Voluntary Work",
                    "value" => "s-charity"
                ),
                array(
                    "label" => "S-Creative Arts and Design",
                    "value" => "s-creative"
                ),
                array(
                    "label" => "S-Energy and Utilities",
                    "value" => "s-energy"
                ),
                array(
                    "label" => "S-Engineering and Manufacturing",
                    "value" => "s-engineering"
                ),
                array(
                    "label" => "S-Environment and Agriculture",
                    "value" => "s-environment"
                ),
                array(
                    "label" => "S-Healthcare",
                    "value" => "s-healthcare"
                ),
                array(
                    "label" => "S-Hospitality and Events Management",
                    "value" => "s-hospitality"
                ),
                array(
                    "label" => "S-Information Technology",
                    "value" => "s-it"
                ),
                array(
                    "label" => "S-Law",
                    "value" => "s-law"
                ),
                array(
                    "label" => "S-Law Enforcement and Security",
                    "value" => "s-law_enforcement"
                ),
                array(
                    "label" => "S-Leisure, Sports and Tourism",
                    "value" => "s-leisure"
                ),
                array(
                    "label" => "S-Marketing, Advertising and PR",
                    "value" => "s-marketing"
                ),
                array(
                    "label" => "S-Media and Internet",
                    "value" => "s-media"
                ),
                array(
                    "label" => "S-Property and Construction",
                    "value" => "s-property"
                ),
                array(
                    "label" => "S-Public Services and Administration",
                    "value" => "s-public_services"
                ),
                array(
                    "label" => "S-Recruitment",
                    "value" => "s-recruitment"
                ),
                array(
                    "label" => "S-Retail",
                    "value" => "s-retail"
                ),
                array(
                    "label" => "S-Sales",
                    "value" => "s-sales"
                ),
                array(
                    "label" => "S-Science and Pharmacuticals",
                    "value" => "s-science"
                ),
                array(
                    "label" => "S-Social Care",
                    "value" => "s-social"
                ),
                array(
                    "label" => "S-Teacher Training and Education",
                    "value" => "s-teacher"
                ),
                array(
                    "label" => "S-Transport and Logistics",
                    "value" => "s-transport"
                ),
                array(
                    "label" => "Sales and Marketing Courses",
                    "value" => "sales_marketing"
                ),
                array(
                    "label" => "SIA Course",
                    "value" => "sia"
                ),
                array(
                    "label" => "Software and Web Dev Courses",
                    "value" => "software"
                ),
                array(
                    "label" => "Teacher Training Courses",
                    "value" => "teacher_training"
                ),
                array(
                    "label" => "Teaching Assistant Courses",
                    "value" => "teaching_assistant"
                ),
                array(
                    "label" => "Team Leading",
                    "value" => "team_leading"
                ),
                array(
                    "label" => "Topographical Test Training for Cab Drivers",
                    "value" => "topographical"
                ),
                array(
                    "label" => "Traineeships",
                    "value" => "traineeships"
                ),
                array(
                    "label" => "Travel and Tourism Courses",
                    "value" => "travel_tourism"
                ),
                array(
                    "label" => "Tree Surgeon Course",
                    "value" => "tree_surgeon"
                )
            )
        ),
        "organisation_name" => array(
            "meta_field" => true,
            "label" => "Organisation Name",
            "meta_label" => "cja_organisation_name",
            "type" => "text"
        ),
        "address" => array(
            "meta_field" => true,
            "label" => "Address",
            "meta_label" => "cja_address",
            "type" => "textarea"
        ),
        "postcode" => array(
            "meta_field" => true,
            "label" => "Postcode",
            "meta_label" => "cja_postcode",
            "type" => "text"
        ),
        "price" => array(
            "meta_field" => true,
            "label" => "Price for students not eligible for funding (if applicable)",
            "meta_label" => "cja_price",
            "type" => "text"
        ),
        "contact_person" => array(
            "meta_field" => true,
            "label" => "Name of Key Contact Person",
            "meta_label" => "cja_contact_person",
            "type" => "text"
        ),
        "phone" => array(
            "meta_field" => true,
            "label" => "Contact Phone Number",
            "meta_label" => "cja_phone",
            "type" => "text"
        ),
        "sector" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_sector",
            "label" => "Sector",
            "options" => array(
                array(
                    "label" => "Accountancy, Business and Finance",
                    "value" => "accountancy_business_finance"
                ),
                array(
                    "label" => "Business, Consulting and Management",
                    "value" => "business_consulting_management"
                ),
                array(
                    "label" => "Charity and Voluntary Work",
                    "value" => "charity_voluntary"
                ),
                array(
                    "label" => "Creative Arts and Design",
                    "value" => "creative_design"
                ),
                array(
                    "label" => "Energy and Utilities",
                    "value" => "energy_utilities"
                ),
                array(
                    "label" => "Engineering and Manufacturing",
                    "value" => "engineering_manufacturing"
                ),
                array(
                    "label" => "Environment and Agriculture",
                    "value" => "environment_agriculture"
                ),
                array(
                    "label" => "Healthcare",
                    "value" => "healthcare"
                ),
                array(
                    "label" => "Hospitality and Events Management",
                    "value" => "hospitality_events"
                ),
                array(
                    "label" => "Information Technology",
                    "value" => "information_technology"
                ),
                array(
                    "label" => "Law",
                    "value" => "law"
                ),
                array(
                    "label" => "Law Enforcement and Security",
                    "value" => "law_enforcement_security"
                ),
                array(
                    "label" => "Leisure, Sport and Tourism",
                    "value" => "leisure_sport_tourism"
                ),
                array(
                    "label" => "Marketing, Advertising and PR",
                    "value" => "marketing_advertising_pr"
                ),
                array(
                    "label" => "Media and Internet",
                    "value" => "media_internet"
                ),
                array(
                    "label" => "Property and Construction",
                    "value" => "property_construction"
                ),
                array(
                    "label" => "Public Services and Administration",
                    "value" => "public_services_administration"
                ),
                array(
                    "label" => "Recruitment and HR",
                    "value" => "recruitment_hr"
                ),
                array(
                    "label" => "Retail",
                    "value" => "retail"
                ),
                array(
                    "label" => "Sales",
                    "value" => "sales"
                ),
                array(
                    "label" => "Science and Pharmaceuticals",
                    "value" => "science_pharmaceuticals"
                ),
                array(
                    "label" => "Social Care",
                    "value" => "social_care"
                ),
                array(
                    "label" => "Teacher Training and Education",
                    "value" => "teacher_education"
                ),
                array(
                    "label" => "Transport and Logistics",
                    "value" => "transport_logistics"
                ),
            )
        ),
        "deposit_required" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_deposit_required",
            "label" => "Deposit Required",
            "options" => array(
                array(
                    "label" => "£100-500",
                    "value" => "100-500"
                ),
                array(
                    "label" => "£600-1000",
                    "value" => "600-1000"
                ),
                array(
                    "label" => "£1000+",
                    "value" => "1000+"
                ),
                array(
                    "label" => "Half Price",
                    "value" => "half_price"
                ),
                array(
                    "label" => "Full Payment Required",
                    "value" => "full_payment"
                ),
                array(
                    "label" => "Can be negotiated based on your current circumstances",
                    "value" => "negotiated"
                ),
                array(
                    "label" => "Refer to Ad",
                    "value" => "refer_ad"
                ),
                array(
                    "label" => "Other",
                    "value" => "other"
                )
            )
        ),
        "career_level" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_career_level",
            "label" => "Career Level",
            "options" => array(
                array(
                    "label" => "Manager",
                    "value" => "manager"
                ),
                array(
                    "label" => "Officer",
                    "value" => "officer"
                ),
                array(
                    "label" => "Student",
                    "value" => "student"
                ),
                array(
                    "label" => "Executive",
                    "value" => "executive"
                ),
                array(
                    "label" => "Consultant",
                    "value" => "consultant"
                ),
                array(
                    "label" => "Entry Level",
                    "value" => "entry_level"
                ),
                array(
                    "label" => "Other",
                    "value" => "other"
                ),
                array(
                    "label" => "Any Level",
                    "value" => "any_level"
                )
            )
        ),
        "experience_required" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_experience_required",
            "label" => "Experience Required",
            "options" => array(
                array(
                    "label" => "None",
                    "value" => "none"
                ),
                array(
                    "label" => "Up to 3 Months",
                    "value" => "3months"
                ),
                array(
                    "label" => "Up to 6 Months",
                    "value" => "6months"
                ),
                array(
                    "label" => "Up to 1 Year",
                    "value" => "1year"
                ),
                array(
                    "label" => "2 Years Plus",
                    "value" => "2year"
                )
            )
        ),
        "provider_type" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_provider_type",
            "label" => "Provider Type",
            "options" => array(
                array(
                    "label" => "University",
                    "value" => "university"
                ),
                array(
                    "label" => "College",
                    "value" => "college"
                ),
                array(
                    "label" => "Private Training Provider",
                    "value" => "private_training"
                ),
                array(
                    "label" => "Private Freelancer",
                    "value" => "private_freelancer"
                ),
                array(
                    "label" => "Government Organisation",
                    "value" => "government_organisation"
                ),
                array(
                    "label" => "Recruitment Agency",
                    "value" => "recruitment_agency"
                ),
                array(
                    "label" => "Employer",
                    "value" => "employer"
                ),
                array(
                    "label" => "Online Programme",
                    "value" => "online_programme"
                ),
                array(
                    "label" => "Other",
                    "value" => "other"
                )
            )
        ),
        "previous_qualification" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_previous_qualification",
            "label" => "Previous Qualification Required",
            "options" => array(
                array(
                    "label" => "None Required",
                    "value" => "none"
                ),
                array(
                    "label" => "GCSE's",
                    "value" => "gcse"
                ),
                array(
                    "label" => "A Levels",
                    "value" => "alevels"
                ),
                array(
                    "label" => "Award",
                    "value" => "award"
                ),
                array(
                    "label" => "Certificate",
                    "value" => "certificate"
                ),
                array(
                    "label" => "Diploma",
                    "value" => "diploma"
                ),
                array(
                    "label" => "Studying towards a Degree",
                    "value" => "studying_degree"
                ),
                array(
                    "label" => "Degree",
                    "value" => "degree"
                ),
                array(
                    "label" => "Masters Degree",
                    "value" => "masters_degree"
                ),
                array(
                    "label" => "Doctorate Degree",
                    "value" => "doctorate_degree"
                )
            )
        ),
        "course_pathway" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_course_pathway",
            "label" => "Course Pathway",
            "options" => array(
                array(
                    "label" => "Courses for both Work & University Progression",
                    "value" => "work_university"
                ),
                array(
                    "label" => "Courses for University Progression",
                    "value" => "university"
                ),
                array(
                    "label" => "Courses to Enter Employment",
                    "value" => "employment"
                ),
                array(
                    "label" => "CPD Development Only",
                    "value" => "cpd_only"
                ),
                array(
                    "label" => "Courses for Career Development (CPD)",
                    "value" => "career_development"
                )
            )
        ),
        "funding_options" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_funding_options",
            "label" => "Course Funding Options",
            "options" => array(
                array(
                    "label" => "All Options",
                    "value" => "all_options"
                ),
                array(
                    "label" => "Self-funded - Full Payment Required",
                    "value" => "self_funded_full"
                ),
                array(
                    "label" => "Self-funded - Payment Plan Available",
                    "value" => "self_funded_plan"
                ),
                array(
                    "label" => "Student Loan",
                    "value" => "student_loan"
                ),
                array(
                    "label" => "Fully Funded",
                    "value" => "fully_funded"
                ),
                array(
                    "label" => "Funded (16-18s & Eligible 19s)",
                    "value" => "funded_16"
                ),
            )
        ),
        "payment_plan" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_payment_plan",
            "label" => "Payment Plan",
            "options" => array(
                array(
                    "label" => "Yes",
                    "value" => "yes"
                ),
                array(
                    "label" => "No",
                    "value" => "no"
                ),
                array(
                    "label" => "Can Be Discussed",
                    "value" => "discussed"
                )
            )
        ),
        "qualification_level" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_qualification_level",
            "label" => "Qualification Level",
            "options" => array(
                array(
                    "label" => "Entry Level, Level 1 or Level 2",
                    "value" => "entry12"
                ),
                array(
                    "label" => "All Levels",
                    "value" => "all"
                ),
                array(
                    "label" => "Entry Level",
                    "value" => "entry"
                ),
                array(
                    "label" => "Level 1",
                    "value" => "level1"
                ),
                array(
                    "label" => "Level 2",
                    "value" => "level2"
                ),
                array(
                    "label" => "Level 3",
                    "value" => "level3"
                ),
                array(
                    "label" => "Level 4-7",
                    "value" => "level47"
                ),
                array(
                    "label" => "Other",
                    "value" => "other"
                ),
            )
        ),
        "qualification_type" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_qualification_type",
            "label" => "Qualification Type",
            "options" => array(
                array(
                    "label" => "Award",
                    "value" => "award"
                ),
                array(
                    "label" => "Certificate",
                    "value" => "certificate"
                ),
                array(
                    "label" => "Diploma",
                    "value" => "diploma"
                ),
                array(
                    "label" => "Extended Diploma",
                    "value" => "extended_diploma"
                ),
                array(
                    "label" => "Subsidiary Diploma",
                    "value" => "subsidiary_diploma"
                ),
                array(
                    "label" => "90 Credit Diploma",
                    "value" => "90credit"
                ),
                array(
                    "label" => "Degree",
                    "value" => "degree"
                ),
                array(
                    "label" => "Associate Degree",
                    "value" => "associate_degree"
                ),
                array(
                    "label" => "HND",
                    "value" => "hnd"
                ),
                array(
                    "label" => "HNC",
                    "value" => "hnc"
                ),
                array(
                    "label" => "Masters Degree",
                    "value" => "masters_degree"
                ),
                array(
                    "label" => "Doctorate Degree",
                    "value" => "doctorate_degree"
                ),
                array(
                    "label" => "GCSE",
                    "value" => "gcse"
                ),
                array(
                    "label" => "A Levels",
                    "value" => "alevel"
                ),
            )
        ),
        "contact_for_enquiry" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_contact_for_enquiry",
            "label" => "Contact for Course Enquiry",
            "options" => array(
                array(
                    "label" => "Phone",
                    "value" => "phone"
                ),
                array(
                    "label" => "Email",
                    "value" => "email"
                ),
                array(
                    "label" => "Can Be Discussed",
                    "value" => "discussed"
                )
            )
        ),
        "total_units" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_total_units",
            "label" => "Total Units",
            "options" => array(
                array(
                    "label" => "1 Unit",
                    "value" => "1unit"
                ),
                array(
                    "label" => "2 Units",
                    "value" => "2unit"
                ),
                array(
                    "label" => "3 Units",
                    "value" => "3unit"
                ),
                array(
                    "label" => "4 Units",
                    "value" => "4unit"
                ),
                array(
                    "label" => "5 Units",
                    "value" => "5unit"
                ),
                array(
                    "label" => "6 Units",
                    "value" => "6unit"
                ),
                array(
                    "label" => "7 Units",
                    "value" => "7unit"
                ),
                array(
                    "label" => "8 Units",
                    "value" => "8unit"
                ),
                array(
                    "label" => "9 Units",
                    "value" => "9unit"
                ),
                array(
                    "label" => "10 Units",
                    "value" => "10unit"
                ),
                array(
                    "label" => "11 Units",
                    "value" => "11unit"
                ),
                array(
                    "label" => "12 Units",
                    "value" => "12unit"
                ),
                array(
                    "label" => "13 Units",
                    "value" => "13unit"
                ),
                array(
                    "label" => "14 Units",
                    "value" => "14unit"
                ),
                array(
                    "label" => "15 Units",
                    "value" => "15unit"
                ),
                array(
                    "label" => "16 Units",
                    "value" => "16unit"
                ),
                array(
                    "label" => "17 Units",
                    "value" => "17unit"
                ),
                array(
                    "label" => "18 Units",
                    "value" => "18unit"
                ),
                array(
                    "label" => "19 Units",
                    "value" => "19unit"
                ),
                array(
                    "label" => "20+ Units",
                    "value" => "20unit"
                )
            )
        ),
        "dbs_required" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_dbs_required",
            "label" => "DBS Required",
            "options" => array(
                array(
                    "label" => "Yes",
                    "value" => "yes"
                ),
                array(
                    "label" => "No",
                    "value" => "no"
                )
            )
        ),
        "allowance_available" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_allowance_available",
            "label" => "Allowance Available",
            "options" => array(
                array(
                    "label" => "Bursary",
                    "value" => "bursary"
                ),
                array(
                    "label" => "Care to Learn for Childcare",
                    "value" => "care_to_learn"
                ),
                array(
                    "label" => "DBS Check Allowance",
                    "value" => "dbs_check"
                ),
                array(
                    "label" => "Travel Expense",
                    "value" => "travel_expense"
                ),
                array(
                    "label" => "Meal e.g. Lunch",
                    "value" => "meal"
                ),
                array(
                    "label" => "Other - Can be Discussed",
                    "value" => "other"
                ),
            )
        ),
        "awarding_body" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_awarding_body",
            "label" => "Awarding Body",
            "options" => array(
                array(
                    "label" => "Edexcel",
                    "value" => "edexcel"
                ),
                array(
                    "label" => "NCFE",
                    "value" => "ncfe"
                ),
                array(
                    "label" => "High Fields",
                    "value" => "high_fields"
                ),
                array(
                    "label" => "CACHE",
                    "value" => "cache"
                ),
                array(
                    "label" => "OCR",
                    "value" => "orc"
                ),
                array(
                    "label" => "AQA",
                    "value" => "aqa"
                ),
                array(
                    "label" => "City & Guilds",
                    "value" => "city_guilds"
                ),
                array(
                    "label" => "Other",
                    "value" => "other"
                ),
            )
        ),
        "duration" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_duration",
            "label" => "Duration",
            "options" => array(
                array(
                    "label" => "It depends on assessment results",
                    "value" => "depends_assessment"
                ),
                array(
                    "label" => "At your own pace",
                    "value" => "own_pace"
                ),
                array(
                    "label" => "Less than 6 weeks",
                    "value" => "6weeks"
                ),
                array(
                    "label" => "Up to 3 months",
                    "value" => "3months"
                ),
                array(
                    "label" => "Up to 6 months",
                    "value" => "6months"
                ),
                array(
                    "label" => "Up to 1 year",
                    "value" => "1year"
                ),
                array(
                    "label" => "Up to 18 months",
                    "value" => "18month"
                ),
                array(
                    "label" => "Up to 2 years",
                    "value" => "2year"
                ),
                array(
                    "label" => "Up to 3 years",
                    "value" => "3year"
                ),
                array(
                    "label" => "Up to 4 years",
                    "value" => "4year"
                ),
                array(
                    "label" => "Will be discussed after IAG session",
                    "value" => "discussed_after_iag"
                )
            )
        ),
        "suitable_benefits" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_suitable_benefits",
            "label" => "Suitable for Those on Benefits",
            "options" => array(
                array(
                    "label" => "Yes - Universal Credit",
                    "value" => "universal_credit"
                ),
                array(
                    "label" => "Yes - ESA",
                    "value" => "esa"
                ),
                array(
                    "label" => "Yes - Housing Allowance",
                    "value" => "housing_allowance"
                ),
                array(
                    "label" => "Yes - Child Tax Credit",
                    "value" => "child_tax"
                ),
                array(
                    "label" => "Yes - Income Support",
                    "value" => "income_support"
                ),
                array(
                    "label" => "Yes - Other",
                    "value" => "other"
                ),
                array(
                    "label" => "Not Applicable",
                    "value" => "not_applicable"
                )
            )
        ),
        "social_services" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_social_services",
            "label" => "Social Services - Service Users",
            "options" => array(
                array(
                    "label" => "Course is suitable for those in care",
                    "value" => "care"
                ),
                array(
                    "label" => "Course is suitable for care leavers",
                    "value" => "care_leavers"
                ),
                array(
                    "label" => "Course is suitable for those who are preparing to leave care",
                    "value" => "prepare"
                ),
                array(
                    "label" => "Not Applicable",
                    "value" => "not_applicable"
                )
            )
        ),
        "delivery_route" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_delivery_route",
            "label" => "Delivery Route",
            "options" => array(
                array(
                    "label" => "Paid Work with a Course",
                    "value" => "paid_work"
                ),
                array(
                    "label" => "Classroom Delivery Only",
                    "value" => "classroom_only"
                ),
                array(
                    "label" => "Work-based Learning - No Classroom",
                    "value" => "work_based_learning"
                ),
                array(
                    "label" => "Classroom & Work-based",
                    "value" => "classroom_work"
                ),
                array(
                    "label" => "Work Experience with a Course",
                    "value" => "work_experience"
                ),
                array(
                    "label" => "Online Course Only",
                    "value" => "online_only"
                ),
                array(
                    "label" => "Online & Classroom",
                    "value" => "online_classroom"
                ),
                array(
                    "label" => "Distance Learning (paper-based only)",
                    "value" => "distance_learning"
                )
            )
        ),
        "available_start" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_available_start",
            "label" => "Available to Start",
            "options" => array(
                array(
                    "label" => "Immediately",
                    "value" => "immediately"
                ),
                array(
                    "label" => "Within a few days",
                    "value" => "few_days"
                ),
                array(
                    "label" => "Within the next 2 weeks",
                    "value" => "2weeks"
                ),
                array(
                    "label" => "Within a month",
                    "value" => "month"
                ),
                array(
                    "label" => "Within 6 to 8 weeks",
                    "value" => "68weeks"
                ),
                array(
                    "label" => "Flexible",
                    "value" => "flexible"
                )
            )
        ),
        "deadline" => array(
            "meta_field" => true,
            "type" => "date",
            "label" => "Deadline",
            "meta_label" => "cja_deadline"
        ),
        "more_information" => array(
            "meta_field" => true,
            "label" => "More Information",
            "meta_label" => "more_information",
            "type" => "textarea"
        )
    );

    /**
     * PUBLIC FUNCTIONS
     */

     // Display form field
    public function display_form_field($field, $do_label = true, $search_field = false) {
        include('display_form_field.php');
    }

    // Display field
    public function display_field($field) {
        include('display_field.php');
    }

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
        if ($_POST['cja_id']) {
            $this->cja_id = $_POST['cja_id'];
        }

        if (array_key_exists('max_distance', $_POST)) {
            $this->max_distance = $_POST['max_distance'];
        }
        if (array_key_exists('order_by', $_POST)) {
            $this->order_by = $_POST['order_by'];
        }
        if (array_key_exists('ad-title', $_POST)) {
            $this->title = $_POST['ad-title'];
        }
        if (array_key_exists('ad-content', $_POST)) {
            $this->description = $_POST['ad-content'];
        }

        // meta fields
        foreach($this->form_fields as $field => $value) {
            if ($this->form_fields[$field]['type'] == 'checkbox') {
                $this->$field = false; // blank checkbox value first
            }
            if (isset($_POST[$field])) {
                $this->$field = $_POST[$field];
                if ($field == 'salary_numeric') {
                    $sal_num = (float) filter_var( $_POST['salary_numeric'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                    $this->salary_numeric = $sal_num;
                }
            }
        }

        // photo

        if ($_POST['delete_photo']) {
            $this->photo_filename = '';
            $this->photo_url = '';
        }

        if ( $_FILES['photo']['size'] != 0 ) {
            
            $info = getimagesize($_FILES['photo']['tmp_name']);
            if ($info === FALSE) {
                return 'filetype_error';
            }
            
            if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
                return 'filetype_error';
            }
    
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }
            $uploadedfile = $_FILES['photo'];
    
            $upload_overrides = array(
                'test_form' => false
            );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            $this->photo_filename = $uploadedfile['name'];
            $this->photo_url = $movefile['url'];
        }

        // files
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
/*
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
        */
        if (array_key_exists('show_applied', $_POST)) {
            $this->show_applied = 'true';
        } else {
            $this->show_applied = NULL;
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

        // form fields
        foreach($this->form_fields as $field => $value) {
            if ($this->form_fields[$field]['is_array']) {
                update_post_meta($this->id, $this->form_fields[$field]['meta_label'], serialize($this->$field));
            } else {
                update_post_meta($this->id, $this->form_fields[$field]['meta_label'], $this->$field);
            }
        }

        update_post_meta($this->id, 'files_array', serialize($this->files_array));

        update_post_meta($this->id, 'photo_filename', $this->photo_filename);
        update_post_meta($this->id, 'photo_url', $this->photo_url);
        
        // Form fields
        /*
        update_post_meta($this->id, 'cja_can_apply_online', $this->can_apply_online);
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
        */

        update_post_meta($this->id, 'cja_course_file_filename', $this->course_file_filename);
        update_post_meta($this->id, 'cja_course_file_url', $this->course_file_url);
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

    // return total number of applications for this job
    public function application_count() {
        $args = array(
            'post_type' => 'course_application',
            'meta_key' => 'advertID',
            'meta_value' => $this->id
        );
        $query = new WP_Query($args);
        return $query->post_count;
    }

    // return display string with no.of applications
    public function display_application_count() {
        $applications = $this->application_count();
        if (!$applications) {
            return "No Applications";
        } else if ($applications == 1) {
            return "1 Application";
        } else {
            return $applications . " Applications";
        }
    }

    // return whether advert is "new"
    public function is_new() {
        if ($this->days_old <= get_option('cja_days_still_new')) {
            return true;
        } else {
            return false;
        }
    }

    // Update search object from cookies
    public function update_from_cookies() {
        $this->max_distance = $_COOKIE[ get_current_user_id() . '_course_max_distance'];
        $this->order_by = $_COOKIE[ get_current_user_id() . '_course_order_by'];
        if (!$this->order_by) { $this->order_by = 'date'; }
        $this->offer_type = $_COOKIE[ get_current_user_id() . '_course_offer_type'];
        $this->category = $_COOKIE[ get_current_user_id() . '_course_category'];
        $this->sector = $_COOKIE[ get_current_user_id() . '_course_sector'];
        $this->deposit_required = $_COOKIE[ get_current_user_id() . '_course_deposit_required'];
        $this->career_level = $_COOKIE[ get_current_user_id() . '_course_career_level'];
        $this->experience_required = $_COOKIE[ get_current_user_id() . '_course_experience_required'];
        $this->provider_type = $_COOKIE[ get_current_user_id() . '_course_provider_type'];
        $this->previous_qualification = $_COOKIE[ get_current_user_id() . '_course_previous_qualification'];
        $this->course_pathway = $_COOKIE[ get_current_user_id() . '_course_course_pathway'];
        $this->payment_plan = $_COOKIE[ get_current_user_id() . '_course_payment_plan'];
        $this->qualification_level = $_COOKIE[ get_current_user_id() . '_course_qualification_level'];
        $this->qualification_type = $_COOKIE[ get_current_user_id() . '_course_qualification_type'];
        $this->total_units = $_COOKIE[ get_current_user_id() . '_course_total_units'];
        $this->dbs_required = $_COOKIE[ get_current_user_id() . '_course_dbs_required'];
        $this->availability_period = $_COOKIE[ get_current_user_id() . '_course_availability_period'];
        $this->allowance_available = $_COOKIE[ get_current_user_id() . '_course_allowance_available'];
        $this->awarding_body = $_COOKIE[ get_current_user_id() . '_course_awarding_body'];
        $this->duration = $_COOKIE[ get_current_user_id() . '_course_duration'];
        $this->suitable_benefits = $_COOKIE[ get_current_user_id() . '_course_suitable_benefits'];
        $this->social_services = $_COOKIE[ get_current_user_id() . '_course_social_services'];
        $this->delivery_route = $_COOKIE[ get_current_user_id() . '_course_delivery_route'];
        $this->available_start = $_COOKIE[ get_current_user_id() . '_course_available_start'];
        $this->show_applied = $_COOKIE[ get_current_user_id() . '_course_show_applied'];
    }

    // Build WP Query from search values
    public function build_wp_query() {

        $wp_query_args = array(
            'post_type' => 'course_ad',
            'orderby' => 'order_clause',
            'order' => 'DSC',
            'posts_per_page' => -1
        );

        // If we are searching by ID return the query straight away
        if ($this->cja_id) {
            $wp_query_args['p'] = strip_cja_code($this->cja_id);
            $wp_query_args['meta_key'] = 'cja_ad_status';
            $wp_query_args['meta_value'] = 'active';
            return $wp_query_args;
        }

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

        $fields = array( 'offer_type', 'category', 'sector', 'deposit_required', 'career_level', 'experience_required', 'provider_type', 'previous_qualification', 'course_pathway', 'funding_options', 'payment_plan', 'qualification_level', 'qualfication_type', 'total_units', 'dbs_required', 'availability_period', 'allowance_available', 'awarding_body', 'duration', 'suitable_benefits', 'social_services', 'delivery_route', 'available_start' );

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
        if ($field == 'offer_type') {
            if ($this->offer_type == 'classroom_online') { return 'Classroom and Online Mode'; }
            if ($this->offer_type == 'cp_cpd') { return 'Course Pathway: CPD Development'; }
            if ($this->offer_type == 'cp_employment') { return 'Course Pathway: Employment'; }

            if ($this->offer_type == 'cp_university') { return 'Course Pathway: University'; }
            if ($this->offer_type == 'cp_work_or_university') { return 'Course Pathway: Work or University'; }
            if ($this->offer_type == 'full_time') { return 'Full Time'; }
            if ($this->offer_type == 'fully_funded_16_19') { return 'Fully-funded Course for 16-19s'; }
            if ($this->offer_type == 'online_own_pace') { return 'Online - Study at your Own Pace'; }
            if ($this->offer_type == 'online_distance') { return 'Online and Distance Learning'; }
            if ($this->offer_type == 'part_time') { return 'Part Time'; }
            if ($this->offer_type == 'payment_plan_available') { return 'Payment Plan Available'; }
            if ($this->offer_type == 'payment_plan_19') { return 'Payment Plan Available for 19s'; }
            if ($this->offer_type == 'self_fund_no_plan') { return 'Self-funded - No Payment Plan Available'; }
            if ($this->offer_type == 'self_fund_plan') { return 'Self-funded - Payment Plan Available'; }
            if ($this->offer_type == 'student_loan') { return 'Student Loan Available'; }
            if ($this->offer_type == 'temporary') { return 'Temporary'; }
            if ($this->offer_type == 'volunteer') { return 'Volunteer'; }
            if ($this->offer_type == 'work_based_learning') { return 'Work Based Learning'; }
            if ($this->offer_type == 'other') { return 'Other'; }
        }

        if ($field == 'category') {
            if ($this->category == 'ab_english') { return 'A1, A2, B1 English Courses'; }
            if ($this->category == 'assessor_cava') { return 'Assessor Course (CAVA)'; }
            if ($this->category == 'b1_english_cab') { return 'B1 English Course for Cab Drivers'; }
            if ($this->category == 'bespoke_training') { return 'Bespoke Training'; }
            if ($this->category == 'bsl_course') { return 'British Sign Language Course'; }
            if ($this->category == 'business_admin') { return 'Business Administration Courses'; }
            if ($this->category == 'bus_course_university') { return 'Business Course for University'; }
            if ($this->category == 'business_sector_courses') { return 'Business Sector Courses'; }
            if ($this->category == 'childcare_sector') { return 'Childcare Sector'; }
            if ($this->category == 'cpd') { return 'CPD'; }
            if ($this->category == 'cscs') { return 'CSCS'; }
            if ($this->category == 'customer_service') { return 'Customer Service Courses'; }
            if ($this->category == 'driving_courses') { return 'Driving Courses'; }
            if ($this->category == 'education_sector') { return 'Education Sector Courses'; }
            if ($this->category == 'engineering_construction') { return 'Engineering & Construction Courses'; }
            if ($this->category == 'esol') { return 'ESOL Courses'; }
            if ($this->category == 'first_aid') { return 'First Aid Courses'; }
            if ($this->category == 'fork_lift') { return 'Fork Lift'; }
            if ($this->category == 'health_safety') { return 'Health and Safety'; }
            if ($this->category == 'health_social_university') { return 'Health and Social Care Course for University'; }
            if ($this->category == 'health_social_work') { return 'Health and Social Care Courses for Work'; }
            if ($this->category == 'hca_courses') { return 'Health Care Assistant Courses or Training'; }
            if ($this->category == 'healthcare_industry') { return 'Health Care Industry Course'; }
            if ($this->category == 'hospitality_catering') { return 'Hospitality and Catering Courses'; }
            if ($this->category == 'human_resources') { return 'Human Resources'; }
            if ($this->category == 'it_courses') { return 'Information Technology Courses'; }
            if ($this->category == 'internal_verifier') { return 'Internal Verifier Courses'; }
            if ($this->category == 'legal_sector') { return 'Legal Sector Courses'; }
            if ($this->category == 'marketing_pr') { return 'Marketing and PR Courses'; }
            if ($this->category == 'private_gcse_alevel') { return 'Private GCSE and A-level Exam Centres'; }
            if ($this->category == 'recruitment') { return 'Recruitment'; }
            if ($this->category == 'retail_courses') { return 'Retail Courses'; }
            if ($this->category == 's-accountancy') { return 'S-Accountancy, Banking and Finance'; }
            if ($this->category == 's-business') { return 'S-Business, Consulting and Management'; }
            if ($this->category == 's-charity') { return 'S-Charity and Voluntary Work'; }
            if ($this->category == 's-creative') { return 'S-Creative Arts and Design'; }
            if ($this->category == 's-energy') { return 'S-Energy and Utilities'; }
            if ($this->category == 's-engineering') { return 'S-Engineering and Manufacturing'; }
            if ($this->category == 's-environment') { return 'S-Environment and Agriculture'; }
            if ($this->category == 's-healthcare') { return 'S-Healthcare'; }
            if ($this->category == 's-hospitality') { return 'S-Hospitality and Events Management'; }
            if ($this->category == 's-it') { return 'S-Information Technology'; }
            if ($this->category == 's-law') { return 'S-Law'; }
            if ($this->category == 's-law_enforcement') { return 'S-Law Enforcement and Security'; }
            if ($this->category == 's-leisure') { return 'S-Leisure, Sports and Tourism'; }
            if ($this->category == 's-marketing') { return 'S-Marketing, Advertising and PR'; }
            if ($this->category == 's-media') { return 'S-Media and Internet'; }
            if ($this->category == 's-property') { return 'S-Property and Construction'; }
            if ($this->category == 's-public_services') { return 'S-Public Services and Administration'; }
            if ($this->category == 's-recruitment') { return 'S-Retail'; }
            if ($this->category == 's-sales') { return 'S-Sales'; }
            if ($this->category == 's-science') { return 'S-Science and Pharmacuticals'; }
            if ($this->category == 's-social') { return 'S-Social Care'; }
            if ($this->category == 's-teacher') { return 'S-Teacher Training and Education'; }
            if ($this->category == 's-transport') { return 'S-Transport and Logistics'; }
            if ($this->category == 'sales_marketing') { return 'Sales and Marketing Courses'; }
            if ($this->category == 'sia') { return 'SIA Course'; }
            if ($this->category == 'software') { return 'Software and Web Dev Courses'; }
            if ($this->category == 'teacher_training') { return 'Teacher Training Courses'; }
            if ($this->category == 'teaching_assistant') { return 'Teaching Assistant Courses'; }
            if ($this->category == 'team_leading') { return 'Team Leading'; }
            if ($this->category == 'topographical') { return 'Topographical Test Training for Cab Drivers'; }
            if ($this->category == 'traineeships') { return 'Traineeships'; }
            if ($this->category == 'travel_tourism') { return 'Travel and Tourism Courses'; }
            if ($this->category == 'tree_surgeon') { return 'Tree Surgeon Course'; }
        }

        if ($field == 'sector') {
            if ($this->sector == 'accountancy_business_finance') { return 'Accountancy, Business and Finance'; }
            if ($this->sector == 'business_consulting_management') { return 'Business, Consulting and Management'; }
            if ($this->sector == 'charity_voluntary') { return 'Charity and Voluntary Work'; }
            if ($this->sector == 'creative_design') { return 'Creative Arts and Design'; }
            if ($this->sector == 'energy_utilities') { return 'Energy and Utilities'; }
            if ($this->sector == 'engineering_manufacturing') { return 'Engineering and Manufacturing'; }
            if ($this->sector == 'environment_agriculture') { return 'Environment and Agriculture'; }
            if ($this->sector == 'healthcare') { return 'Healthcare'; }
            if ($this->sector == 'hospitality_events') { return 'Hospitality and Events Management'; }
            if ($this->sector == 'information_technology') { return 'Information Technology'; }
            if ($this->sector == 'law') { return 'Law'; }
            if ($this->sector == 'law_enforcement_security') { return 'Law Enforcement and Security'; }
            if ($this->sector == 'leisure_sport_tourism') { return 'Leisure, Sport and Tourism'; }
            if ($this->sector == 'marketing_advertising_pr') { return 'Marketing, Advertising and PR'; }
            if ($this->sector == 'media_internet') { return 'Media and Internet'; }
            if ($this->sector == 'property_construction') { return 'Property and Construction'; }
            if ($this->sector == 'public_services_administration') { return 'Public Services and Administration'; }
            if ($this->sector == 'recruitment_hr') { return 'Recruitment and HR'; }
            if ($this->sector == 'retail') { return 'Retail'; }
            if ($this->sector == 'sales') { return 'Sales'; }
            if ($this->sector == 'science_pharmaceuticals') { return 'Science and Pharmaceuticals'; }
            if ($this->sector == 'social_care') { return 'Social Care'; }
            if ($this->sector == 'teacher_education') { return 'Teacher Training and Education'; }
            if ($this->sector == 'transport_logistics') { return 'Transport and Logistics'; }
        }

        if ($field == 'deposit_required') {
            if ($this->deposit_required == '100-500') { return '£100-500'; }
            if ($this->deposit_required == '600-1000') { return '£600-1000'; }
            if ($this->deposit_required == '1000+') { return '£1000+'; }
            if ($this->deposit_required == 'half_prie') { return 'Half Price'; }
            if ($this->deposit_required == 'full_payment') { return 'Full Payment Required'; }
            if ($this->deposit_required == 'negotiated') { return 'Can be negotiated based on your current circumstances'; }
            if ($this->deposit_required == 'refer_ad') { return 'Refer to Ad'; }
            if ($this->deposit_required == 'other') { return 'Other'; }
        }

        if ($field == 'career_level') {
            if ($this->career_level == 'manager') { return 'Manager'; }
            if ($this->career_level == 'officer') { return 'Officer'; }
            if ($this->career_level == 'student') { return 'Student'; }
            if ($this->career_level == 'executive') { return 'Executive'; }
            if ($this->career_level == 'consultant') { return 'Consultant'; }
            if ($this->career_level == 'entry_level') { return 'Entry Level'; }
            if ($this->career_level == 'other') { return 'Other'; }
            if ($this->career_level == 'any_level') { return 'Any Level'; }
        }

        if ($field == 'experience_required') {
            if ($this->experience_required == 'none') { return 'None'; }
            if ($this->experience_required == '3months') { return 'Up to 3 Months'; }
            if ($this->experience_required == '6months') { return 'Up to 6 Months'; }
            if ($this->experience_required == '1year') { return 'Up to 1 Year'; }
            if ($this->experience_required == '2year') { return '2 Years Plus'; }
        }

        if ($field == 'provider_type') {
            if ($this->provider_type == 'university') { return 'University'; }
            if ($this->provider_type == 'college') { return 'College'; }
            if ($this->provider_type == 'private_training') { return 'Private Training Provider'; }
            if ($this->provider_type == 'private_freelancer') { return 'Private Freelancer'; }
            if ($this->provider_type == 'government_organisation') { return 'Government Organisation'; }
            if ($this->provider_type == 'recruitment_agency') { return 'Recruitment Agency'; }
            if ($this->provider_type == 'employer') { return 'Employer'; }
            if ($this->provider_type == 'online_programme') { return 'Online Programme'; }
            if ($this->provider_type == 'other') { return 'Other'; }
        }

        if ($field == 'previous_qualification') {
            if ($this->previous_qualification == 'none') { return 'None Required'; }
            if ($this->previous_qualification == 'gcse') { return 'GCSE\'s'; }
            if ($this->previous_qualification == 'alevels') { return 'A Levels'; }
            if ($this->previous_qualification == 'award') { return 'Award'; }
            if ($this->previous_qualification == 'certificate') { return 'Certificate'; }
            if ($this->previous_qualification == 'diploma') { return 'Diploma'; }
            if ($this->previous_qualification == 'studying_degree') { return 'Studying towards a Degree'; }
            if ($this->previous_qualification == 'degree') { return 'Degree'; }
            if ($this->previous_qualification == 'masters_degree') { return 'Masters Degree'; }
            if ($this->previous_qualification == 'doctorate_degree') { return 'Doctorate Degree'; }
        }

        if ($field == 'course_pathway') {
            if ($this->course_pathway == 'work_university') { return 'Courses for both Work & University Progression'; }
            if ($this->course_pathway == 'university') { return 'Courses for University Progression'; }
            if ($this->course_pathway == 'employment') { return 'Courses to Enter Employment'; }
            if ($this->course_pathway == 'cpd_only') { return 'CPD Development Only'; }
            if ($this->course_pathway == 'career_development') { return 'Courses for Career Development (CPD)'; }
        }

        if ($field == 'funding_options') {
            if ($this->funding_options == 'all_options') { return 'All Options'; }
            if ($this->funding_options == 'self_funded_full') { return 'Self-funded - Full Payment Required'; }
            if ($this->funding_options == 'self_funded_plan') { return 'Self-funded - Payment Plan Available'; }
            if ($this->funding_options == 'student_loan') { return 'Student Loan'; }
            if ($this->funding_options == 'fully_funded') { return 'Fully Funded'; }
            if ($this->funding_options == 'funded_16') { return 'Funded (16-18s & Eligible 19s)'; }
        }

        if ($field == 'payment_plan') {
            if ($this->payment_plan == 'yes') { return 'Yes'; }
            if ($this->payment_plan == 'no') { return 'No'; }
            if ($this->payment_plan == 'discussed') { return 'Can Be Discussed'; }
        }

        if ($field == 'qualification_level') {
            if ($this->qualification_level == 'entry12') { return 'Entry Level, Level 1 or Level 2'; }
            if ($this->qualification_level == 'all') { return 'All Levels'; }
            if ($this->qualification_level == 'entry') { return 'Entry Level'; }
            if ($this->qualification_level == 'level1') { return 'Level 1'; }
            if ($this->qualification_level == 'level2') { return 'Level 2'; }
            if ($this->qualification_level == 'level3') { return 'Level 3'; }
            if ($this->qualification_level == 'level47') { return 'Level 4-7'; }
            if ($this->qualification_level == 'other') { return 'Other'; }           
        }

        if ($field == 'qualification_type') {
            if ($this->qualification_type == 'award') { return 'Award'; }
            if ($this->qualification_type == 'certificate') { return 'Certificate'; }
            if ($this->qualification_type == 'diploma') { return 'Diploma'; }
            if ($this->qualification_type == 'extended_diploma') { return 'Extended Diploma'; }
            if ($this->qualification_type == 'subsidiary_diploma') { return 'Subsidiary Diploma'; }
            if ($this->qualification_type == '90credit') { return '90 Credit Diploma'; }
            if ($this->qualification_type == 'degree') { return 'Degree'; }
            if ($this->qualification_type == 'associate_degree') { return 'Associate Degree'; }
            if ($this->qualification_type == 'hnd') { return 'HND'; }
            if ($this->qualification_type == 'hnc') { return 'HNC'; }
            if ($this->qualification_type == 'masters_degree') { return 'Masters Degree'; }
            if ($this->qualification_type == 'doctorate_degree') { return 'Doctorate Degree'; }
            if ($this->qualification_type == 'gcse') { return 'GCSE'; }
            if ($this->qualification_type == 'alevel') { return 'A Levels'; }          
        }

        if ($field == 'contact_for_enquiry') {
            if ($this->contact_for_enquiry == 'phone') { return 'Phone'; }
            if ($this->contact_for_enquiry == 'email') { return 'Email'; }
            if ($this->contact_for_enquiry == 'discuss') { return 'Can be discussed'; }
        }

        if ($field == 'total_units' && $this->total_units != '') {
            if ($this->total_units == '1unit') { return '1 Unit'; }
            if ($this->total_units == '20unit') { return '20+ Units'; }
            $int = (int) filter_var($this->total_units, FILTER_SANITIZE_NUMBER_INT);
            return ($int . ' Units');
        }

        if ($field == 'dbs_required') {
            if ($this->dbs_required == 'yes') { return 'Yes'; }
            if ($this->dbs_required == 'no') { return 'No'; }
        }

        if ($field == 'availability_period') {
            if ($this->availability_period == 'morning') { return 'Morning'; }
            if ($this->availability_period == 'afternoon') { return 'Afternoon'; }
            if ($this->availability_period == 'night') { return 'Night'; }
            if ($this->availability_period == 'weekend') { return 'Weekend'; }           
        }

        if ($field == 'allowance_available') {
            if ($this->allowance_available == 'bursary') { return 'Bursary'; }
            if ($this->allowance_available == 'care_to_learn') { return 'Care to Learn for Childcare'; }
            if ($this->allowance_available == 'dbs_check') { return 'DBS Check Allowance'; }
            if ($this->allowance_available == 'travel_expense') { return 'Travel Expense'; }
            if ($this->allowance_available == 'meal') { return 'Meal e.g. Lunch'; }
            if ($this->allowance_available == 'other') { return 'Other - Can be Discussed'; }
        }

        if ($field == 'awarding_body') {
            if ($this->awarding_body == 'edexcel') { return 'Edexcel'; }
            if ($this->awarding_body == 'ncfe') { return 'NCFE'; }
            if ($this->awarding_body == 'high_fields') { return 'High Fields'; }
            if ($this->awarding_body == 'cache') { return 'CACHE'; }
            if ($this->awarding_body == 'ocr') { return '>OCR'; }
            if ($this->awarding_body == 'aqa') { return 'AQA'; }
            if ($this->awarding_body == 'city_guilds') { return 'City & Guilds'; }
            if ($this->awarding_body == 'other') { return 'Other'; }          
        }

        if ($field == 'duration') {
            if ($this->duration == 'depends_assessment') { return 'It depends on assessment'; }
            if ($this->duration == 'own_pace') { return 'At your own pace'; }
            if ($this->duration == '6weeks') { return 'Less than 6 weeks'; }
            if ($this->duration == '3months') { return 'Up to 3 months'; }
            if ($this->duration == '6months') { return 'Up to 6 months'; }
            if ($this->duration == '1year') { return 'Up to 1 year'; }
            if ($this->duration == '18month') { return 'Up to 18 months'; }
            if ($this->duration == '2year') { return 'Up to 2 years'; }
            if ($this->duration == '3year') { return 'Up to 3 years'; }
            if ($this->duration == '4year') { return 'Up to 4 years'; }
            if ($this->duration == 'depends_agreed') { return 'It depends on what is agreed'; }          
        }

        if ($field == 'suitable_benefits') {
            if ($this->suitable_benefits == 'universal_credit') { return 'Yes - Universal Credit'; }
            if ($this->suitable_benefits == 'esa') { return 'Yes - ESA'; }
            if ($this->suitable_benefits == 'housing_allowance') { return 'Yes - Housing Allowance'; }
            if ($this->suitable_benefits == 'child_tax') { return 'Yes - Child Tax Credit'; }
            if ($this->suitable_benefits == 'income_support') { return 'Yes - Income Support'; }
            if ($this->suitable_benefits == 'other') { return 'Yes - Other'; }
            if ($this->suitable_benefits == 'not_applicable') { return 'Not Applicable'; }           
        }

        if ($field == 'social_services') {
            if ($this->social_services == 'care') { return 'Course is suitable for those in care'; }
            if ($this->social_services == 'care_leavers') { return 'Course is suitable for care leavers'; }
            if ($this->social_services == 'prepare') { return 'Course is suitable for those who are preparing to leave care'; }
            if ($this->social_services == 'not_applicable') { return 'Not Applicable'; }           
        }

        if ($field == 'delivery_route') {
            if ($this->delivery_route == 'paid_work') { return 'Paid Work with a Course'; }
            if ($this->delivery_route == 'classroom_only') { return 'Classroom Delivery Only'; }
            if ($this->delivery_route == 'work_based_learning') { return 'Work-based Learning - No Classroom'; }
            if ($this->delivery_route == 'classroom_work') { return 'Classroom & Work-based'; }
            if ($this->delivery_route == 'work_experience') { return 'Work Experience with a Course'; }
            if ($this->delivery_route == 'online_only') { return 'Online Course Only'; }
            if ($this->delivery_route == 'online_classroom') { return 'Online & Classroom'; }
            if ($this->delivery_route == 'distance_learning') { return 'Distance Learning (paper-based only)'; }            
        }

        if ($field == 'available_start') {
            if ($this->available_start == 'immediately') { return 'Immediately'; }
            if ($this->available_start == 'few_days') { return 'Within a few days'; }
            if ($this->available_start == '2weeks') { return 'Within the next 2 weeks'; }
            if ($this->available_start == 'month') { return 'Within a month'; }
            if ($this->available_start == '68weeks') { return 'Within 6 to 8 weeks'; }
            if ($this->available_start == 'flexible') { return 'Flexible'; }         
        }

        if ($field == 'deadline') {
            if ($this->deadline) {
                return date("j F Y", strtotime($this->deadline));
            } else {
                return false;
            }
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
        if ($this->activation_date) {
            $diff = strtotime(date("j F Y")) - $this->activation_date;
            return abs(round($diff / 86400));
        } else {
            return false;
        }
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
            'post_type' => 'course_application',
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