<?php
    include('../init.php');

    $fetch_type = $_POST['fetch_type'];

    if($fetch_type == 'fetch_specification')
    {
        if(isset($_REQUEST['subcat_id']) && $_REQUEST['subcat_id']!='')
        {
            $subcat_id = $_REQUEST['subcat_id'];
            $sub_cat = find('all','specification','*','where subcat_id = '.$subcat_id.'',array());

?>
            <div class='row product-item'>
                <div class="col-md-1"><div class="float-left">
                    <input type="checkbox" name="item_index[]" />
                </div></div>
                <div class='col-md-5'>
                
                    <select name="specification" class="each-field  specification">
							
                        <option value="" >Select Your Specification</option>
                        <?php if(isset($sub_cat)){
                            foreach ($sub_cat as $key => $val) { ?>
                            <option value="<?php echo $val["spec_id"]; ?>"><?php echo $val["spec_name"]; ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class='col-md-6'>
                    <div class="float-left">
                        <input type="text" class='each-field' name="item_name[]" placeholder="Specification"/>
                    </div>      
                </div>
            
            </div>
<?php
      
        }
    }

?>