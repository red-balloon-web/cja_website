<div class="cja_search_criteria">

    <?php if ($cja_classifiedsearch->max_distance) { ?>
        <p>Maximum Distance: <strong><?php echo $cja_classifiedsearch->max_distance; ?> miles</strong></p>
    <?php } ?>
    <?php if ($cja_classifiedsearch->category) { ?>
        <p>Category: <strong><?php echo $cja_classifiedsearch->return_human('category'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_classifiedsearch->subcategory) { ?>
        <p>Subcategory: <strong><?php echo $cja_classifiedsearch->return_human('subcategory'); ?></strong></p>
    <?php } ?>
    <p>Order results by: <strong><?php 
        if ($cja_classifiedsearch->order_by == 'date') {
            echo 'Newest Adverts First';
        } else if ($cja_classifiedsearch->order_by == 'distance') {
            echo 'Closest Adverts First';
        } ?></strong></p>

</div>