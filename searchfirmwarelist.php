<?php

    error_reporting(0);
    //control ataques de querystring
    if( $_REQUEST['mkt_tok']<> '')
    {
    echo "Error...";
    exit();
    }

    // Desactivar toda notificación de error
    error_reporting(0);

    include("db_conect.php"); 
        header('Content-Type: application/json');
        
        session_start();
        //FIXME: Change connection
        $connection = pg_connect("host=localhost dbname=dbfiplex user=postgres password=Cajal69709901");
        if(!$connection){
            echo "Connection error<br>";
            exit;
        }
        function is_ajax_request() {
            return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
        }
    
        $search = $_POST['search'] ?? '';
    
    
    
        if(is_ajax_request()) {
            $viewFirm = pg_query($connection, "SELECT * FROM fas_firmwarelist 
                                                WHERE namefirmware SIMILAR TO '%$search%' 
                                                ORDER BY idfas_firmwarelist, idrev;");
            if(!$viewFirm){
                echo "Table error<br>";
                exit;
            }
            echo '<div class="contenedorFirmware">
                    <div class="contenidoFirmware">
                        <table class="table table-bordered table-striped table-sm">
                            <tr id="headertable">
                                <th>ID</th>
                                <th>Version</th>
                                <th>Firmware name</th>
                                <th>Fpga file</th>
                                <th>Micro file</th>
                                <th>Ethernet file</th>
                                <th>Fpga fas</th>
                                <th>Micro fas</th>
                                <th>Ethernet fas</th>
                                <th>Active</th>
                            </tr>';
            while($row = pg_fetch_assoc($viewFirm)){
                $id = is_numeric($row['idfas_firmwarelist']) ? htmlspecialchars($row['idfas_firmwarelist']) : 'N/A';
                $namefirmware = !empty($row['namefirmware']) ? htmlspecialchars($row['namefirmware']) : 'N/A';
                $idrev = is_numeric($row['idrev']) ? htmlspecialchars($row['idrev']) : 'N/A';
                $fpga_file = !empty($row['fpga_file']) ? htmlspecialchars($row['fpga_file']) : 'N/A';
                $micro_file = !empty($row['micro_file']) ? htmlspecialchars($row['micro_file']) : 'N/A';
                $eth_file = !empty($row['eth_file']) ? htmlspecialchars($row['eth_file']) : 'N/A';
                $fpga_fas = !empty($row['fpga_fas']) ? htmlspecialchars($row['fpga_fas']) : 'N/A';
                $micro_fas = !empty($row['micro_fas']) ? htmlspecialchars($row['micro_fas']) : 'N/A';
                $eth_fas = !empty($row['eth_fas']) ? htmlspecialchars($row['eth_fas']) : 'N/A';
                $active = !empty($row['active']) ? htmlspecialchars($row['active']) : 'N/A';
                $calrstring = !empty($row['calrstring']) ? htmlspecialchars($row['calrstring']) : '';
                $fpga_description = !empty($row['fpga_description']) ? htmlspecialchars($row['fpga_description']) : '';
                $uc_description = !empty($row['uc_description']) ? htmlspecialchars($row['uc_description']) : '';
                $eth_description = !empty($row['eht_description']) ? htmlspecialchars($row['eht_description']) : '';
                echo "
                <tr class='rowsFirmware' ondblclick='toggleRow(this)'>
                <td>{$id}</td>
                <td>{$idrev}</td>
                <td>{$namefirmware}</td>
                <td>{$fpga_file}</td>
                <td>{$micro_file}</td>
                <td>{$eth_file}</td>
                <td>{$fpga_fas}</td>
                <td>{$micro_fas}</td>
                <td>{$eth_fas}</td>
                <td>{$active}</td>
                </tr>
                <tr class='expandable' style='display: none;'>
                <td colspan='11'>
                <strong>Extra Information</strong><br>
                Calibration string : {$calrstring}<br>
                Datetime created: {$row['datetimemodif']}<br>";
                if(!empty($fpga_description)){
                    echo "Fpga description: {$fpga_description}<br>"; 
                }
                if(!empty($uc_description)){
                    echo "Uc description: {$uc_description}<br>"; 
                }
                if(!empty($eth_description)){
                    echo "Ethernet description: {$eth_description}<br>"; 
                }
                
                echo "
                <div class='extra'>
                <div class='extracomp'>
                <form id='delete' action='delfirmwarelist.php' method='POST' data_name='{$namefirmware}' data_idrev='{$idrev}'>
                <input type='button' class='deletebutton' value=' Delete '>
                </form>
                </div>
                <div class='extracomp'>
                <form id='modify' action='modfirmwarelist.php' method='POST' 
                data_name='{$namefirmware}' data_idrev='{$idrev}' 
                data_idfirm='{$id}' data_fpga_file='{$fpga_file}' 
                data_micro_file='{$micro_file}' data_eth_file='{$eth_file}' 
                data_fpga_fas='{$fpga_fas}' data_micro_fas='{$micro_fas}' 
                data_eth_fas='{$eth_fas}' data_active='{$active}' 
                data_calrstring='{$calrstring}' data_fpga_description='{$fpga_description}' 
                data_uc_description='{$uc_description}' data_eth_description='{$eth_description}'>
                <input type='button' class='modifybutton' value=' Modify '>
                </form>
                </div>
                </div>
                </td>
                </tr>
                </form>
                </div>
                </div>
                </div>
                ";
            }
        } else {
            echo "Invalid request. Please provide both 'namefirmware' and 'idrev'.";
        }
?>