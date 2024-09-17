<?php 
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 

$idoth = $_REQUEST['idoth'];

?>
<div class="col-6">
                    <div class="card card-info">
                    <div class="card-header card-primary">
                      <h3 class="card-title">Others Componets </h3>


                      <div class="card-tools">
                 
                        <button type="button" class=" " data-card-widget="remove"><i class="fas fa-times"></i> Close
                        </button>
                      </div>

                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    
                      <div class="container">
                      <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Type Component:</label>
                          <div class="col-sm-10">
                          <select class="form-control" name="cmbtypecomp<?php echo $idoth; ?>" id="cmbtypecomp<?php echo $idoth; ?>" required oninvalid="setCustomValidity('Area is required.')" oninput="setCustomValidity('')">
                                <option value=""> - Select - </option>
                                  <?php
                                    $sql = $connect->prepare("select * from components_types WHERE idtypecomponets <>6  order by nametypecomponets");
                                    $sql->execute();
                                    
                                    $resultado = $sql->fetchAll();
                                    foreach ($resultado as $row) {
                                      ?>
                                      <option value="<?php echo $row['idtypecomponets'];  ?>"><?php echo  $row['nametypecomponets'] ;  ?></option> 
                                      <?php
                                    }
                                  ?>
                                  
										      	</select>
                          </div>
                        </div>
                        <div class="row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">CIU:</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="nuevosnciu_<?php echo $idoth; ?>" name="nuevosnciu_<?php echo $idoth; ?>">
                          </div>
                        </div>
                        <div class=" row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">SN:</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="nuevosnunit_<?php echo $idoth; ?>" name="nuevosnunit_<?php echo $idoth; ?>">
                          </div>
                        </div>
                   
                        <div class=" row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Revision:</label>
                          <div class="col-sm-10">
                          <input type="number" class="form-control" id="nuevorev_<?php echo $idoth; ?>" name="nuevorev_<?php echo $idoth; ?>">
                          </div>
                        </div>
                      
                        
                      </div>
                   
                    
                  </div>
            </div>