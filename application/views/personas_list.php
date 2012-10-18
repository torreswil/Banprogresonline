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

        <script type="text/javascript">     
            $(document).ready(function() {
                oTable = $('#tabla').dataTable({
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers"
                });
            } );
        </script>
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla">
                <thead>
                <tr>
                    <th>Nombre</th> 
                    <th>Departamento</th>
                    <th>Municipio</th>
                    <th>Vereda</th>
                    <th>Direccion</th>
                    <th>Fecha creacion</th>
                    <th></th>
                    <th></th>
                </tr>

                </thead>
                <tbody>
                    <?php
                        $lats = "";         // string with latitude values
                        $lngs = "";         // string with longitude values // string with address values
                        $names = "";
                        $i=0;
                    ?>
            
                    <?php foreach($query->result()as $fila): ?>
                        <tr class="odd gradeX"> 
                            <td><a onmouseover="highlightMarker(<?php echo $i;?>)"><?php echo $fila->Nombre;?></a></td>
                            <td><?php echo $fila->Departamento;?></td>
                            <td><?php echo $fila->Muncipio;?></td>
                            <td><?php echo $fila->Vereda;?></td>    
                            <td><?php echo $fila->Direccion;?></td>
                            <?php 
                            $lats .= $fila->Latitud.";;";
                            $lngs .= $fila->longitud.";;";
                            $names .= $fila->Nombre.";;";
                            
                            ?>
                            
                            <td><?php echo $fila->Fecha;?></td>
                            <td><a class="btn btn-success" href="<?php echo base_url().'index.php/banco/edit/'.$fila->Id;?>"><i class="icon-refresh icon-white"></i> Editar</a></td>
                            <td><?php echo anchor(base_url().'index.php/banco/delete/'.$fila->Id,'<i class="icon-trash icon-white"></i> Eliminar',array('class'=>'btn btn-danger','onClick'=>'return deletechecked(\' '.base_url().'index.php/banco/delete/'.$fila->Id.' \')'));?></td> 
                        </tr>
                        
                    <?php $i++; endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
</table>
<br>