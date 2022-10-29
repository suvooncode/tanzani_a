<?php
    include('../init.php');

    $fetch_type = $_POST['fetch_type'];
    if($fetch_type == 'fetch_subcat')
    {
        if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id']!='')
        {
            $cat_id = $_REQUEST['cat_id'];
            $sub_cat = find('all','category','*','where parent_id = '.$cat_id.'',array());
?>

            <option value="" >Select Your Sub Category</option>
            <?php if(isset($sub_cat)){
                foreach ($sub_cat as $key => $val) { ?>
            <option value="<?php echo $val["cat_id"]; ?>"><?php echo $val["cat_name"]; ?></option>


        <?php   } } ?>
<?php
        
        }
    }

    if($fetch_type == 'fetch_specification')
    {
        if(isset($_REQUEST['subcat_id']) && $_REQUEST['subcat_id']!='')
        {
            $subcat_id = $_REQUEST['subcat_id'];
            $sub_cat = find('all','specification','*','where subcat_id = '.$subcat_id.'',array());

?>
            <option value="" >Select Your Specification</option>
            <?php if(isset($sub_cat)){
                foreach ($sub_cat as $key => $val) { ?>
                <option value="<?php echo $val["spec_id"]; ?>"><?php echo $val["spec_name"]; ?></option>
            <?php } } ?>
<?php
      
        }
    }
    
    
?>