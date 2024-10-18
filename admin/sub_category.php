<?php

include "database.php"; ?>
    <?php
    $obj = new Database();
    $main_cate = isset($_POST['category_name']) ? $_POST['category_name'] : '';

    $html = '';
    $obj->select('sub_categories', '*', null, "category_id='$main_cate' AND status='1'", null, null);
    $category = $obj->getResult();
    if (!empty($category)) {
        foreach ($category as $cate_row) {
            if ($sub_cate_id == $cate_row['subcate_id']) {
                $html .= "<option value=" . $cate_row['subcate_id'] . " selected>" . $cate_row['subcate_name'] . "</option>";
            } else {
                $html .= "<option value=" . $cate_row['subcate_id'] . ">" . $cate_row['subcate_name'] . "</option>";
            }
        }
    } else {
        echo "<option value=''>No Sub Category Found</option>";
    }
    echo $html;
    ?>

