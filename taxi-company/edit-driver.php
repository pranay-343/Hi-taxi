<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
$data = mysql_fetch_array(mysql_query("select * from `driver` where 1 and id = '".$_GET['a']."'"));


if($data['insurance_expired'] == '1')
{
  $insurance_expired = 'checked';
}
else
{
  $insurance_expired = ''; 
}
if($data['insurance_overdue'] == '1')
{
  $insurance_overdue = 'checked';
}
else
{
  $insurance_overdue = ''; 
}
if($data['non_payment'] == '1')
{
  $non_payment = 'checked';
}


if($data['status'] == 200)
  {$active = 'checked';}
if($data['status'] == 99)
  {$block = 'checked';}
if($data['status'] == 400)
  {$suspend = 'checked';}
?>

<body>
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/taxi-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <h1 class="txt-style-1">Detalles del conductor</h1>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Actualizar datos del conductor</h2>
<?php
if(isset($_POST['editDriver']) and $_POST['editDriver']!=""){
editDriver();
unset($_POST);
HTMLRedirectURL(TAXI_URL."view-drivers.php");
}
?>
              <form method="post" enctype="multipart/form-data">
                <div id="errorMessage"></div>
                <div class="row">
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label>Nombre </label>
                      <input type="text" name="name" id="name" class="input-style" placeholder="Ingresa aquí el nombre del conductor" required value="<?php echo $data['name']?>"/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Imagen del conductor </label>
                      <input type="file" name="image" id="image" class="input-style" placeholder="Ingresa la imagen del conductor aquí" />
                    </div>
                  </div>
                </div>
                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> Número de licencia </label>
                      <input type="text" id="liecence_number" name="liecence_number" class="input-style" placeholder="Ingrese el número de licencia aquí" required value="<?php echo $data['liecence_number']?>"/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Nro. Contacto </label>
                      <input type="text" name="contactno" id="contactno" class="input-style" placeholder="Introduzca usuario Información del contacto Número" required value="<?php echo $data['contact_number']?>"/>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> Vencimiento del seguro </label>
                      <input type="text" id="insurance_expiration_date" name="insurance_expiration_date" class="datepicker-here input-style" placeholder="Ingresa la fecha de vencimiento del seguro" required value="<?php echo $data['insurance_expiration_date']?>"/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Vencimiento de la licencia </label>
                      <input type="text" name="licence_expiration_date" id="licence_expiration_date" class="datepicker-here input-style" placeholder="Ingresa la fecha de vencimiento de la licencia de conducir" required value="<?php echo $data['licence_expiration_date']?>"/>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> Nombre del dueño del vehículo </label>
                      <input type="text" id="vehicle_owner_name" name="vehicle_owner_name" class="input-style" placeholder="Ingresa el nombre del dueño del vehículo " required value="<?php echo $data['vehicle_owner_name']?>"/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Nro. Contacto del dueño del vehículo </label>
                      <input type="text" name="vehicle_contact" id="vehicle_contact" class="input-style" placeholder="Ingresa el número de contacto del dueño del vehículo" required value="<?php echo $data['vehicle_contact']?>"/>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> Nombre del vehículo </label>
                      <input type="text" id="vehicle_name" name="vehicle_name" class="input-style" placeholder="Ingresa el nombre del vehículo aquí" required value="<?php echo $data['vehicle_name']?>"/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Nro. De vehículo </label>
                      <input type="text" name="vehicle_number" id="vehicle_number" class="input-style" placeholder="Ingresa el número de vehículo" required value="<?php echo $data['vehicle_number']?>"/>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Usuario </label>
                      <input type="text" name="username" id="username" class="input-style" placeholder="Ingresa el nombre de usuario" required value="<?php echo $data['username']?>"/>
                    </div>
                  </div>

                <div class="col-sm-6">
                  <div class="form-group">
                     <label> Estado del documento </label>
                  <input type="checkbox" name="insurance_expired" id="insurance_expired" <?php echo $insurance_expired;?> value="0"> <span>Seguro expirado</span>
                  <input type="checkbox" name="insurance_overdue" id="insurance_overdue" <?php echo $insurance_overdue;?> value="0"> <span>Seguro no recibido</span>
                  <input type="checkbox" name="non_payment" id="non_payment" <?php echo $non_payment;?> value="0"> <span>No pagado</span>
                    </div>
                  </div>
                </div>
              <div class="row">

                 <div class="col-sm-6">
                  <div class="form-group">
                     <label> Tarifa del viaje por KM </label>
                      <input type="text" name="trip_fare" id="trip_fare" class="input-style" placeholder="Ingresa la tarifa por KM" required value="<?php echo $data['trip_fare'];?>"/>
                    </div>
                  </div>
               
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Estado </label>
                     <input type="radio" name="status" id="status" value="200" <?php echo $active; ?>> <span>activo</span>
<input type="radio" name="status" id="status" value="99" <?php echo $block; ?>> <span>Inactivo</span>
<input type="radio" name="status" id="status" value="400" <?php echo $suspend; ?>> <span>Suspendido</span>
                    </div>
                  </div>
                </div>







                <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('editDriver')?>" />
                    <input type="hidden" name="driverId" id="driverId" value="<?php echo $_GET['a'];?>" />
                    <input class="dash-button hvr-wobble-horizontal w100" type="submit" name="editDriver" id="editDriver" value="Actualizar conductor" />
                    </div>
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
</body>
</html>
