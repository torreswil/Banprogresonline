<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * CI Generator
 * http://projects.keithics.com/crud-generator-for-codeigniter/ 
 * Copyright (c) 2011 Keith Levi Lumanog
 * Dual MIT and GPL licenses.
 *
 * A CI generator to easily generates CRUD CODE, feel free to improve my code or customized it the way you like.
 * as inspired by Gii of Yii Framework. Last update August 15, 2011
 */
 

class Codegen extends CI_Controller {


    function index(){
        $data = '';
        $this->load->library('form_validation');
		$this->load->database();
		$this->load->helper('url');
        if ($this->input->post('table_data') || !$_POST)
        {
            // get table data
            $this->form_validation->set_rules('table', 'Table', 'required|trim|xss_clean|max_length[200]');

            if ($this->form_validation->run() == false)
            {
				
            } else
            {

                $table = $this->db->list_tables();
                $data['table'] = $table[$this->input->post('table')];
                $result = $this->db->query("SHOW FIELDS from " . $data['table']);
                $data['alias'] = $result->result();
                

                
            }
            
            
            $this->load->view('codegen', $data);

        } else
            if ($this->input->post('generate'))
            {
                $this->load->helper('file');
                
                $all_files = array(
                    'application/config/form_validation.php',
                    'application/controllers/'.$this->input->post('controller').'.php',
                    'application/models/codegen_model.php',
                    'application/views/'.$this->input->post('view').'_add.php',
                    'application/views/'.$this->input->post('view').'_edit.php',
                    'application/views/'.$this->input->post('view').'_list.php'
                    );

                //checking of files if they existed. comment if you want to overwrite files!
                $err = 0;
                /*** // uncomment me to allow overwrites
                foreach($all_files as $af){
                    if($this->fexist($af)){
                        $err++;
                        echo $this->fexist($af)."<br>";    
                    }
                }
                
                if($err > 0){
					echo 'Files Exists - Generator stopped.<br>';
                    echo '<h3>Post Data Below:</h3><br>';
                    echo '<pre>';
                    print_r($_POST);
                    echo '<pre>';
                    exit;
                }
                ***/
                $rules = $this->input->post('rules');
                $label = $this->input->post('field');
                $type = $this->input->post('type');
                
                
                // looping of labels and forms , for edit and add
                foreach($label as $k => $v){
                    if($type[$k][0] != 'exclude'){
                    $labels[] = $v;
                    $form_fields[] = $k;
                    if($rules[$k][0] != 'required'){
                        $required = '';
                    }else{
                        $required = '<span class="required">*</span>';        
                    }
                    // this will create a form for Add and Edit , quite dirty for now
                    if($type[$k][0] == 'textarea'){
                         $add_form[] = '
                                    <p><label for="'.$k.'">'.$v.$required.'</label>                                
                                    <textarea id="'.$k.'" name="'.$k.'"><?php echo set_value(\''.$k.'\'); ?></textarea>
                                    <?php echo form_error(\''.$k.'\',\'<div>\',\'</div>\'); ?>
                                    </p>
                                    ';
                                    
                         $edit_form[] = '
                                    <p><label for="'.$k.'">'.$v.$required.'</label>                                
                                    <textarea id="'.$k.'" name="'.$k.'"><?php echo $result->'.$k.' ?></textarea>
                                    <?php echo form_error(\''.$k.'\',\'<div>\',\'</div>\'); ?>
                                    </p>
                                    ';                                    
                                    
                    }else if($this->input->post($k.'default')){
                        $enum = explode(',',$this->input->post($k.'default'));
                         $add_form[] = '
                                    <p><label for="'.$k.'">'.$v.$required.'</label>                                
                                    <?php
                                    $enum = array('.$this->input->post($k.'default').'); 
                                    echo form_dropdown(\''.$k.'\', $enum); 
                                    ?>
                                    <?php echo form_error(\''.$k.'\',\'<div>\',\'</div>\'); ?>
                                    </p>
                                    ';
                        $edit_form[] = '
                                    <p><label for="'.$k.'">'.$v.$required.'</label>
                                    <?php
                                    $enum = array('.$this->input->post($k.'default').');                                                                    
                                    echo form_dropdown(\''.$k.'\', $enum,$result->'.$k.'); ?>
                                    <?php echo form_error(\''.$k.'\',\'<div>\',\'</div>\'); ?>
                                    </p>
                                    ';                                    
                    }
                    else{
                        //input
                        $add_form[] = '
                                    <p><label for="'.$k.'">'.$v.$required.'</label>                                
                                    <input id="'.$k.'" type="'.$type[$k][0].'" name="'.$k.'" value="<?php echo set_value(\''.$k.'\'); ?>"  />
                                    <?php echo form_error(\''.$k.'\',\'<div>\',\'</div>\'); ?>
                                    </p>
                                    ';
                        $edit_form[] = '
                                    <p><label for="'.$k.'">'.$v.$required.'</label>                                
                                    <input id="'.$k.'" type="'.$type[$k][0].'" name="'.$k.'" value="<?php echo $result->'.$k.' ?>"  />
                                    <?php echo form_error(\''.$k.'\',\'<div>\',\'</div>\'); ?>
                                    </p>
                                    ';
                        }
                    }
                }
              
                // this will ensure that the primary key will be selected first.
                $fields_list[] = $this->input->post('primaryKey');
                // looping of rules 
                foreach($rules as $k => $v){
                    $rules_array = array();
                    if($type[$k][0] != 'exclude'){
                        
                        foreach($rules[$k] as $k1 => $v1){
                            if($v1){
                            $rules_array[] = $v1;
                            }
                        }
                        $form_rules = implode('|',$rules_array);
                        $form_val_data[] = "array(
                                \t'field'=>'".$k."',
                                \t'label'=>'".$label[$k]."',
                                \t'rules'=>'".$form_rules."'
                                )";
                        $controller_form_data[] = "'".$k."' => set_value('".$k."')";
                        $controller_form_editdata[] = "'".$k."' => \$this->input->post('".$k."')";
                        $fields_list[] = $k;   
                    }
                }
                
                
                $fields = implode(',',$fields_list);
                
                $form_data = implode(','."\n\t\t\t\t\t\t\t\t",$form_val_data);
                
                $file_validation = 'application/config/form_validation.php';
                
                //$search_form = array('{validation_name}','{form_val_data}');
               // $replace_form = array($this->input->post('validation'),$form_data);
				$form_validation_data = "'".$this->input->post('table')."' => array(".$form_data.")";
				
				if(file_exists('application/config/form_validation.php')){
					$form_v = file_get_contents('application/config/form_validation.php');
					 $old_form =  str_replace(array('<?php','?>','$config = array(',');'),'',$form_v)."\t\t\t\t,\n\n\t\t\t\t";
					include('application/config/form_validation.php');
					
					if(isset($config[$this->input->post('table')])){
						// rules already existed , reload rules
						$form_content = str_replace('{form_validation_data}',$form_validation_data,file_get_contents('templates/form_validation.php'));	
					}else{
						// append new rule
						$form_content = str_replace('{form_validation_data}',$old_form.$form_validation_data,file_get_contents('templates/form_validation.php'));	
					}
				
				}else{	
                	$form_content = str_replace('{form_validation_data}',$form_validation_data,file_get_contents('templates/form_validation.php'));
				
            	}
               ////////////////////
                $c_path = 'application/controllers/';
                $m_path = 'application/models/'; 
                $v_path = 'application/views/';                              
                
                ///////////////// controller
                $controller = file_get_contents('templates/controller.php');
                $search = array('{controller_name}', '{view}', '{table}','{validation_name}',
                '{data}','{edit_data}','{controller_name_l}','{primaryKey}','{fields_list}');
                $replace = array(
                            ucfirst($this->input->post('controller')), 
                            $this->input->post('view'),
                            $this->input->post('table'),
                             $this->input->post('validation'),
                             implode(','."\n\t\t\t\t\t",$controller_form_data),
                             implode(','."\n\t\t\t\t\t",$controller_form_editdata),
                             $this->input->post('controller'),
                             $this->input->post('primaryKey'),
                             $fields
                            );

                $c_content = str_replace($search, $replace, $controller);

                
                $file_controller = $c_path . $this->input->post('controller') . '.php';
                

              
                // create view/form, TODO, make this a function! and make a stop overwriting files
                
                //VIEW/LIST FORM
                $list_v = file_get_contents('templates/list.php');
                
                $list_content = str_replace('{controller_name_l}',$this->input->post('controller'),$list_v);
                
 
                
                //ADD FORM
                $add_v = file_get_contents('templates/add.php');
                
                $add_content = str_replace('{forms_inputs}',implode("\n",$add_form),$add_v);
                
                //EDIT FORM
                $edit_v = file_get_contents('templates/edit.php');
                $edit_search = array('{forms_inputs}','{primary}');
                $edit_replace = array(implode("\n",$edit_form),'<?php echo form_hidden(\''.$this->input->post('primaryKey').'\',$result->'.$this->input->post('primaryKey').') ?>');
                
                $edit_content = str_replace($edit_search,$edit_replace,$edit_v);
                
                $write_files = array(
                                'Controller' => array($file_controller, $c_content),
                                'view_edit'  => array($v_path.$this->input->post('view').'_edit.php', $edit_content),
                                'view_list'  => array($v_path.$this->input->post('view').'_list.php', $list_content),
                                'view_add'  => array($v_path.$this->input->post('view').'_add.php', $add_content),
                               'form_validation'  => array($file_validation, $form_content) 
                                );
                foreach($write_files as $wf){
                    if($this->writefile($wf[0],$wf[1])){
                        $err++;
                        echo $this->writefile($wf[0],$wf[1]);
                    }
                }        
                                                    
               if($err >0){
                    exit;
                }else{
                    $data['list_content'] = $list_content;
                    
                    $data['add_content'] = $add_content;
                                        
                    $data['edit_content'] = $edit_content;
                    
                    $data['controller'] = $c_content;
                    
                    $this->load->view('done',$data);
                    //echo 'DONE! view it here '. anchor(base_url().'index.php/'.$this->input->post('controller').'/');
                }   
            }// if generate
    }
    
    function fexist($path){
             if (file_exists($path))
            {
                // todo , automatically adds new validation
                return $path.' - File exists <br>';                    
            }
            else{
                return false;
            }        
    }
    
    function writefile($file,$content){
        
        if (!write_file($file, $content))
        {
            return $file. ' - Unable to write the file';
        } else
        {
            return false;
        }
    }


}

/* End of file codegen.php */
/* Location: ./application/controllers/codegen.php */
