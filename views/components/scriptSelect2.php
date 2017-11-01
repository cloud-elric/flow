<?php
$resultsJs = <<< JS
function (data, params) {
    params.page = params.page || 1;
    return {
        results: data.results,
        pagination: {
            more: (params.page * 10) < data.total_count
        }
    };
}
JS;
?>