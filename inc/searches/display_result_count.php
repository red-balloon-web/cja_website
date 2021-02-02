<?php

// Display count of results within area
$cja_total_results = count($cja_results_array); ?>
<p><?php echo $cja_total_results; ?> result<?php if ($cja_total_results != 1) { echo 's'; } ?> found<?php
    if ($cja_search->max_distance) {
        echo ' within a ' . $cja_search->max_distance . ' mile radius';
    }
?></p>