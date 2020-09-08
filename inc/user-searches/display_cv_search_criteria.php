<div class="cja_search_criteria">

    <?php // print_r($cja_usersearch); ?>

    <?php if ($cja_usersearch->max_distance) { ?>
        <p>Maximum Distance: <strong><?php echo $cja_usersearch->max_distance; ?> miles</strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->age_category) { ?>
        <p>Age Category: <strong><?php echo $cja_usersearch->age_category; ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->gcse_maths) { ?>
        <p>GCSE Maths Grade: <strong><?php echo $cja_usersearch->return_human('gcse_maths'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->weekends_availability) { ?>
        <p>Weekends Availability: <strong><?php echo $cja_usersearch->return_human('weekends_availability'); ?></strong></p>
    <?php } ?>
    <!--<p>Order results by: <strong><?php 
        if ($cja_usersearch->order_by == 'alphabet') {
            echo 'Alphabetical';
        } else if ($cja_usersearch->order_by == 'distance') {
            echo 'Closest Users First';
        } ?></strong></p>-->
</div>