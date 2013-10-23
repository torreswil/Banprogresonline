<?php
class Creditos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('codegen_model','',TRUE);
		$this->load->model('cliente');
		$this->load->model('bancos');
		$this->load->model('ubigeo');
		$this->load->model('lineas');
		$this->load->model('transacciones');
		$this->load->model('credito');
        $this->load->model('pagos');
        $this->load->library('cuotas');
        date_default_timezone_set('America/Bogota');
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'index.php/creditos/manage/';
        $config['total_rows'] = $this->codegen_model->count('creditos');
        $config['per_page'] = 3;	
        $this->pagination->initialize($config); 	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->codegen_model->get('creditos','id_credito,monto,plazo,linea_credito,periodo_intereses,periodo_capital,fecha_registro,transaccion','',$config['per_page'],$this->uri->segment(3));
       
	   $this->load->view('creditos_list', $this->data); 
       //$this->template->load('content', 'creditos_list', $this->data); // if have template library , http://maestric.com/doc/php/codeigniter_template
		
    }
	
    function add(){
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('creditos') == false or $this->form_validation->run('transaccion') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            
            $transac=array(
            		'banco'=> $this->uri->segment(4),
            		'tipo_transac'=>1,
            		'valor'=>set_value('monto'),
            		'fecha'=>set_value('fecha_desembolso')
            	);

            if ($this->codegen_model->add('transacciones',$transac) == TRUE) {
            	$transaccion=$this->transacciones->obtener_ultimo_id();
            	if($transaccion){
            		$data = array(
            		'banco'=> $this->uri->segment(4),
            		'persona'=> $this->uri->segment(3),
                    'monto' => set_value('monto'),
					'plazo' => set_value('plazo'),
					'linea_credito' => set_value('linea_credito'),
					'periodo_intereses' => set_value('periodo_intereses'),
					'periodo_capital' => set_value('periodo_capital'),
					'transaccion'=>$transaccion,
            		);

            		if ($this->codegen_model->add('creditos',$data) == TRUE)
						{
							//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
							// or redirect
							redirect(base_url().'index.php/personas/ver/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
						}
						else
						{
							$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

						}
            	}
            }
           
			
		}
		$this->data['lineas']=$this->lineas->obtener_todas($id_banco=$this->uri->segment(4));
		$this->ver_cliente();  
		$this->load->view('creditos_add', $this->data);   
        //$this->template->load('content', 'creditos_add', $this->data);
    }	
    
    function edit(){
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('creditos') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'monto' => $this->input->post('monto'),
					'plazo' => $this->input->post('plazo'),
					'linea_credito' => $this->input->post('linea_credito'),
					'periodo_intereses' => $this->input->post('periodo_intereses'),
					'periodo_capital' => $this->input->post('periodo_capital'),
					'fecha_registro' => $this->input->post('fecha_registro'),
					'transaccion' => $this->input->post('transaccion')
            );
           
			if ($this->codegen_model->edit('creditos',$data,'id_credito',$this->input->post('id_credito')) == TRUE)
			{
				redirect(base_url().'creditos/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}

		$this->data['result'] = $this->codegen_model->get('creditos','id_credito,monto,plazo,linea_credito,periodo_intereses,periodo_capital,fecha_registro,transaccion','id_credito = '.$this->uri->segment(3),NULL,NULL,true);
		
		$this->load->view('creditos_edit', $this->data);		
        //$this->template->load('content', 'creditos_edit', $this->data);
    }
	
    function delete(){
            $banco=$this->input->get('banco');
            $credito=$this->input->get('credito');
            $cliente=$this->input->get('persona');
            $transa=$this->credito->obtener_transac($banco,$cliente,$credito);
            $numAbonos=$this->pagos->num_abonos($banco,$credito);
            if ($numAbonos===0){

                if($this->codegen_model->delete('transacciones','id',$transa)==true){
                    echo 'El credito ha sido eliminado con exito';
                }
            }
            else{
                echo 'Este credito tiene '.$numAbonos.' abonos, no puede ser eliminado';
            }
    }

    function ver_cliente(){
	    $id_banco=$this->uri->segment(4);
		$id_cliente=$this->uri->segment(3);
		$cliente=$this->cliente->devolver_cliente($id_banco,$id_cliente);
		$this->data['cliente']=$cliente;
		$this->data['municipio']=$this->ubigeo->devolver_mun($cliente->Municipio);
		$this->data['banco']=$this->bancos->devolver_nombre_banco($id_banco);
		return $this->data;	
    }


    function ver(){
    	$id_banco=$this->uri->segment(5);
    	$id_credito=$this->uri->segment(3);
    	$id_cliente=$this->uri->segment(4);
    	$cliente=$this->cliente->devolver_cliente($id_banco,$id_cliente);
    	$credito=$this->credito->devolver_credito($id_banco,$id_credito);
    	if($credito){
        $intereses=$this->credito->devolver_intereses($id_banco,$id_credito);
        $this->data['banco']=$this->bancos->devolver_nombre_banco($id_banco);
    	$this->data['intereses']=$intereses;
    	$this->data['credito']=$credito;
    	$this->data['cliente']=$cliente;
    	$this->data['linea']=$this->lineas->devolver_intereses($intereses->linea_credito,$id_banco);
    	$this->data['municipio']=$this->ubigeo->devolver_mun($cliente->Municipio);
   		/*$abonos=$this->abonos->devolver_abonos($credito->banco,$credito->id_credito);*/
    	
    	$this->load->view('detalles_credito', $this->data); 
        }   
    }

    function linea(){
    	$linea=$this->input->get('id');	
    	$banco=$this->input->get('banco');
		$interes=$this->lineas->devolver_intereses($linea,$banco);
		/*echo '<input id="corriente" name="txtInteres" value="'.$interes->int_corriente.'"><input type="hidden" name="txtInteres" value="'.$interes->int_mora.'">';*/
    	
    	echo '<div class="oculto"><label id="corriente">'.$interes->int_corriente.'</label>'.'<label id="mora">Interes Mora'.' '.$interes->int_mora.'</label></div>';
    }

    public function saldos()
    {   
        $banco=$this->input->get('banco');
        $creditos=$this->credito->devolver_creditos($banco);
        $total_corriente=0;
        $total_mora=0;
        $total_capital=0;
        $total_banco=0;
        $total_vencido=0;
        echo '
        <h2>Informe General de Cartera</h2>
        <br>
        <table class="table table-striped" id="cartera">
                                      <thead>
                                        <tr>
                                        <th colspan="3">Datos del Credito</th>
                                        <th colspan="4">Saldos</th>
                                        </tr>
                                          <tr>
                                              <th class="span3">Nombre del Cliente</th>
                                              <th>Fecha</th>
                                              <th>Valor Aprobado</th>
                                              <th>Int. Corriente</th>
                                              <th>Int. Mora</th>
                                              <th>Capital Vencido</th>
                                              <th>Saldo Capital</th>
                                              <th>Total</th>
                                        </tr>
                                      </thead>
                                      <tbody id="tabla-cuotas">
                                            
                                      ';
        foreach ($creditos as $credito) {
            $saldos_credito=$this->distribuir_abonos($banco,$credito);
             echo '<tr>
                    <td>'.$credito->Nombre1.' '.$credito->Nombre2.' '.$credito->Apellido1.'</td>
                    <td>'.$credito->fecha_desembolso.'</td>
                    <td>$ '.number_format($credito->monto, 0, ',', '.').'</td>
                    <td>$ '.number_format($saldos_credito['interes_corriente'], 0, ',', '.').'</td>
                    <td>$ '.number_format($saldos_credito['interes_mora'], 0, ',', '.').'</td>
                    <td>$ '.number_format($saldos_credito['deuda_capital'], 0, ',', '.').'</td>
                    <td>$ '.number_format($saldos_credito['saldo_capital'], 0, ',', '.').'</td>
                    <td>$ '.number_format($saldos_credito['saldo_total'], 0, ',', '.').'</td>
                <tr>';
            $total_vencido+=$saldos_credito['deuda_capital'];
            $total_corriente+=$saldos_credito['interes_corriente'];
            $total_mora+=$saldos_credito['interes_mora'];
            $total_capital+=$saldos_credito['saldo_capital'];
            $total_banco+=$saldos_credito['saldo_total'];
        }
        echo '</tbody>
                <tfoot id="footer-cartera">
                <td colspan="3">Totales</td>
                <td>$ '.number_format($total_corriente, 0, ',', '.').'</td>
                <td>$ '.number_format($total_mora, 0, ',', '.').'</td>
                <td>$ '.number_format($total_vencido, 0, ',', '.').'</td>
                <td>$ '.number_format($total_capital, 0, ',', '.').'</td>
                <td>$ '.number_format($total_banco, 0, ',', '.').'</td>
              </tfoot></table>';
        
    }
    function distribuir_abonos($banco, $credito)
    {
        $abonos=$this->pagos->devolver_abonos($banco,$credito->Idcredito);
        $cuotas=$this->cuotas->calcular_cuotas($credito);
        $saldo=$credito->monto;
        $fecha_credito=new DateTime($credito->fecha_desembolso);
        $corriente_pactado=$credito->interes_corriente;
        $corriente_pactado=$credito->interes_corriente;
        $ultimo_capital=$fecha_credito;
        $interes_pagado_total=0;
        $interes_corriente_pagado=0;
        $capital_pagado=0;
        $i=1;
        $devolucion=0;

        if($abonos){

            foreach ($abonos as $abono) {
                $interes_mora_abono=0;
                $interes_corriente_abono=0;
                $capital_abono=0;
                $dinero=$abono->valor;
                $fecha_abono=new DateTime($abono->fecha);
                //$interes_corriente_generado=
                //ciclo para pagar interes de mora
                $dias_mora=0;
                //echo '<p>Abono No:'.$i.'por:'.$dinero.'</p>';
                $c=0;
                //Se calcula y distribuye el interes de mora generado para cada cuota
                foreach ($cuotas as $cuota) {
                    $dias_mora=0;
                    $interes_mora=0;
                    $fecha_cuota=new DateTime($cuota['fechaCuota']);
                    $fecha_ult_mora= new DateTime($cuota['fecha_ult_abono_mora']);
                    
                    //Si hay dinero lo distribuyo en los interes de mora.
                    if($dinero>0){
                        if($credito->interes_mora>0) {
                            if($fecha_abono>$fecha_cuota){
                                $intervalo=$fecha_ult_mora->diff($fecha_abono);
                                $dias_mora=$intervalo->format('%R%a');
                                $interes_mora=$cuota['deuda_capital']*(($credito->interes_mora/100)/30)*$dias_mora;
                                $interes_mora+=$cuota['interes_mora_deuda'];
                                $cuota['fecha_ult_abono_mora']=$fecha_abono->format('Y-m-d');
                                //$interes_mora+=$cuota['interes_mora_deuda'];
                                //echo  '<p>debe:'.$cuota['deuda_capital'].'</p>';
                                if($dinero>=$interes_mora){
                                    $cuota['interes_mora_pagado']=0;
                                    $cuota['interes_mora_deuda']=0;
                                    $dinero-=$interes_mora;
                                    $cuota['fecha_ult_abono_mora']=$fecha_abono->format('Y-m-d');
                                    //echo $fecha_abono->format('Y-m-d');
                                }
                                else{
                                    $cuota['interes_mora_pagado']+=$dinero;
                                    $cuota['interes_mora_deuda']=$interes_mora-$dinero;
                                    $cuota['fecha_ult_abono_mora']=$fecha_abono->format('Y-m-d');

                                    $interes_mora=$dinero;
                                    $dinero=0;
                                }
                            }
                            $interes_mora_abono+=$interes_mora;
                        }
                    }
                    $cuotas[$c]=$cuota;
                    $c++;
                }
                $interes_pagado_total+=$interes_mora_abono;
                //echo $interes_pagado_total;
                //si queda dinero, distribuyo en los intereses corrientes vencidos hasta la fecha.
                if($dinero>0&&$saldo>0&&$fecha_credito<$fecha_abono){
                    $intervalo_corriente=$ultimo_capital->diff($fecha_abono);
                    $meses_corriente=$intervalo_corriente->format('%m');
                    $años_corriente=$intervalo_corriente->format('%y');
                    $meses_corriente+=($años_corriente*12);
                    $dias_corriente=$intervalo_corriente->format('%d');
                    $corriente_en_meses=($corriente_pactado/100)*$saldo*$meses_corriente;
                    $corriente_en_dias=(($corriente_pactado/100)/30)*$saldo*$dias_corriente;
                    $corriente_total=$corriente_en_meses+$corriente_en_dias;
                    $interes_corriente_abono=$corriente_total-$interes_corriente_pagado;
                    //si queda mas dinero que lo que debo de interes corriente, 
                    //le descuento estos intereses al dinero y el interes corriente queda pagado hasta la fecha del abono.
                    if($dinero>$interes_corriente_abono){
                        $dinero-=$interes_corriente_abono;
                        $interes_corriente_pagado=$corriente_total;
                    }

                    //sino pago lo que alcance y se lo sumo a los intereses pagados.
                    else{
                        $interes_corriente_abono=$dinero;
                        $interes_corriente_pagado+=$interes_corriente_abono;
                        $dinero=0;
                    }
                }


                //si queda saldo, abono lo que quede a capital.
                
                if($saldo>0&&$dinero>0){

                    if($dinero>$saldo){
                        $capital_abono=$dinero;
                        $ultimo_capital=$fecha_abono;
                        $interes_corriente_pagado=0;
                        $capital_pagado+=$capital_abono;
                        $dinero-=$saldo;
                        $saldo=0;
                        $devolucion=$dinero;
                    }
                    else{
                        $capital_abono=$dinero;
                        $capital_pagado+=$capital_abono;
                        $ultimo_capital=$fecha_abono;
                        $interes_corriente_pagado=0;
                        $saldo-=$capital_abono;
                    }

                }
                else{
                    $devolucion+=$dinero;
                }
                $ncta=0;
                //Distribuyo el capital abonado entre las diferentes cuotas con capital pactado.
                $capital_abonado=$capital_pagado;
                foreach ($cuotas as $cuota) {
                    if($capital_abonado>0){
                        if($cuota['capitalCuota']<$capital_abonado){
                            $capital_abonado-=$cuota['capitalCuota'];
                            $cuota['deuda_capital']=0;
                            $cuota['interes_mora_pagado']=0;
                        }
                        else{
                            $cuota['deuda_capital']=$cuota['capitalCuota']-$capital_abonado;
                            $capital_abonado=0;
                            $cuota['interes_mora_pagado']=0;

                        }
                    }
                    $cuotas[$ncta]=$cuota;
                    $ncta++;
                }

                $i++;
                //$intervalo_corriente=$ultimo_capital->diff($fecha_abono);
                //$meses_corriente=$intervalo_corriente->format('%m');
                //$dias_corriente=$intervalo_corriente->format('%d');
                //echo $meses_corriente.' ';
            }

        }
        else{
        }

        $saldo_corriente_total=0;
        $fecha_act=date('Y-m-d');
        $fecha_actual= new DateTime($fecha_act);
        if($fecha_actual>$ultimo_capital){
            $intervalo_ultimo_cap=$ultimo_capital->diff($fecha_actual);
            $meses_corriente=$intervalo_ultimo_cap->format('%m');
            $años_corriente=$intervalo_ultimo_cap->format('%y');
            $meses_corriente+=($años_corriente*12);
            $dias_corriente=$intervalo_ultimo_cap->format('%d');
            $saldo_corriente_en_meses=($corriente_pactado/100)*$saldo*$meses_corriente;
            $saldo_corriente_en_dias=(($corriente_pactado/100)/30)*$saldo*$dias_corriente;
            $saldo_corriente_total=($saldo_corriente_en_meses+$saldo_corriente_en_dias)-$interes_corriente_pagado;
        }
        //echo 'Ultimo capital:'.$ultimo_capital->format('Y-m-d').' Fecha Actual:'. $fecha_act .' Cpagado:'.$interes_corriente_pagado;
        $interes_mora_fecha=0;
        $deuda_capital=0;
        //En este ciclo se calcula el interes de mora generado hasta la fecha.
        foreach ($cuotas as $cuota) {
            $dias_mora=0;
            $interes_mora=0;
            $fecha_cuota=new DateTime($cuota['fechaCuota']);
            $fecha_ult_mora= new DateTime($cuota['fecha_ult_abono_mora']);
            
            if($credito->interes_mora>0) {
                //echo '<p>'.$cuota['deuda_capital'].'</p>';
                
                //echo'<p>PAGADO '. $cuota['interes_mora_pagado'].'</p>';
                if($fecha_actual>$fecha_cuota&&$cuota['deuda_capital']>0){
                    $intervalo=$fecha_ult_mora->diff($fecha_actual);
                    $dias_mora=$intervalo->format('%R%a');
                    $interes_mora=$cuota['deuda_capital']*(($credito->interes_mora/100)/30)*$dias_mora;
                    //echo'<p>MORA '. $interes_mora.'</p>';
                    //echo'<p>PAGADO '. $cuota['interes_mora_pagado'].'</p>';
                    $interes_mora-=$cuota['interes_mora_pagado'];
                    $deuda_capital+=$cuota['deuda_capital'];
                }
                
                $interes_mora_fecha+=$interes_mora;
            }
        }
        $total_fecha=0;
        $total_fecha=$saldo+$saldo_corriente_total+$interes_mora_fecha;

        $saldo_credito= array(
                'saldo_total' => $total_fecha,
                'interes_corriente' => $saldo_corriente_total,
                'interes_mora' => $interes_mora_fecha,
                'saldo_capital' => $saldo,
                'devolucion' => $devolucion,
                'deuda_capital' => $deuda_capital
        );
        return $saldo_credito;
    }


}
/* End of file creditos.php */
/* Location: ./system/application/controllers/creditos.php */