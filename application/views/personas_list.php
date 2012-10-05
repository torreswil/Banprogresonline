<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css" media="screen">
            @import "<?php echo base_url()?>css/site_jui.css";
            @import "<?php echo base_url()?>css/demo_table_jui.css";
            @import "<?php echo base_url()?>css/jquery-ui-1.7.2.custom.css";
            
            /*
             * Override styles needed due to the mix of three different CSS sources! For proper examples
             * please see the themes example in the 'Examples' section of this site
             */
            .dataTables_info { padding-top: 0; }
            .dataTables_paginate { padding-top: 0; }
            .css_right { float: right; }
            #tabla_wrapper .fg-toolbar { font-size: 0.8em }
            #theme_links span { float: left; padding: 2px 10px; }
            #tabla_wrapper { -webkit-box-shadow: 2px 2px 6px #666; box-shadow: 2px 2px 6px #666; border-radius: 5px; }
            #tabla tbody {
                border-left: 1px solid #AAA;
                border-right: 1px solid #AAA;
            }
            #tabla thead th:first-child { border-left: 1px solid #AAA; }
            #tabla thead th:last-child { border-right: 1px solid #AAA; }
        </style>
        <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.dataTables.js"></script>



<?php
echo anchor(base_url().'index.php/personas/add/','Add');
if(!$results){
	echo '<h1>No Data</h1>';
	exit;
}
	$header = array_keys($results[0]);

for($i=0;$i<count($results);$i++){
            $id = array_values($results[$i]);
            $results[$i]['Edit']     = anchor(base_url().'index.php/personas/edit/'.$id[0],'Edit');
            $results[$i]['Delete']   = anchor(base_url().'index.php/personas/delete/'.$id[0],'Delete',array('onClick'=>'return deletechecked(\' '.base_url().'index.php/personas/delete/'.$id[0].' \')'));                                          
			array_shift($results[$i]);                        
        }
        
$clean_header = clean_header($header);
array_shift($clean_header);
$this->table->set_heading($clean_header); 

// view
echo $this->table->generate($results); 
echo $this->pagination->create_links();
?>
<script type="text/javascript">
function deletechecked(link)
{
    var answer = confirm('Delete item?')
    if (answer){
        window.location = link;
    }
    
    return false;  
}

</script>