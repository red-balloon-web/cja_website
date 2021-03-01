<form action="<?php echo get_site_url(); ?>/search-classifieds?output_csv=true" method="post"> <?php
    foreach($_POST as $key => $value) { ?>
        <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>"><?php
    } ?>
    <input type="submit" class="cja_button" value="Export Results as CSV File">
</form>
<?php

// Initialise array
$csv_data_array = [];

// Set header row
$array_row = array(
'Advert Code', 
'Posted',
'Advert Title', 
'Advertiser Code',
'Advertiser',
'Category',
'Postcode',
'Phone Number',
'Email'
);
$csv_data_array[] = $array_row;

// Loop through and add records to CSV
foreach($cja_results_array as $cja_result) {
$current_advert = new CJA_Classified_Advert($cja_result['id']);
$array_row = [];
$array_row[] = get_cja_code($current_advert->id);
$array_row[] = $current_advert->human_activation_date;
$array_row[] = $current_advert->title;
$array_row[] = get_cja_user_code($current_advert->author);
$array_row[] = $current_advert->author_human_name;
$array_row[] = $current_advert->return_human('category');
$array_row[] = $current_advert->postcode;
$array_row[] = $current_advert->phone;
$array_row[] = $current_advert->email;
$csv_data_array[] = $array_row;
}