<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<style>
button.dash-button.hvr-wobble-horizontal {
    float: right;
    margin: -10px;
    padding: 0px;
    width: 17% !important;
}
</style>
<body>
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/taxi-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <h1 class="txt-style-1">Ver conductores
              <button class="dash-button hvr-wobble-horizontal"><a href="add-driver.php">Nuevo conductor</a></button></h1>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Ver lista conductores</h2>

<table id="viewAdministrator" class="display select" cellspacing="0" width="100%">
   <thead>
      <tr>
         <th>Nombre</th>
         <th>Nro. Contacto</th>
         <th>Nro. Licencia</th>
         <th>Creado en</th>
         <th>Estado</th>
         <th>Estado de sesión</th>
         <th>Acciones</th>
      </tr>
   </thead>
  
</table>

            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
<script type="text/javascript">
$(document).ready(function (){
   // Array holding selected row IDs
   var rows_selected = [];
   var table = $('#viewAdministrator').DataTable({
      'ajax': {
         'url': "getData.php?mode=<?php echo base64_encode('getDriverDetails'); ?>" 
      },
      'columnDefs': [{
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '';
         }
      }],
      'order': [[0, 'asc']]
   });
});


function editDriver(a)
{
  window.location = "<?php echo $TAXI_URL; ?>edit-driver.php?a="+a;
}


function suspendDriver(a)
{
  $.post('getData.php',{mode:'<?php echo base64_encode("suspendDriver");?>',a:a},function(response){
    $('#errorMessage').html(response);
    location.reload();
  });
}

function activeDriver(a)
{
 $.post('getData.php',{mode:'<?php echo base64_encode("activeDriver");?>',a:a},function(response){
    $('#errorMessage').html(response);
    location.reload();
  }); 
}

function deleteDriver(a)
{
    swal({
        title: "¿Estas seguro?",
        text: "No podras recuperar los detalles del conductor, y todos los viajes y otros detalles también serán eliminados",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
      },
      function(){
        $.post('getData.php',{mode:'<?php echo base64_encode("deleteDriver");?>',a:a},function(response){
          $('#errorMessage').html(response);
          location.reload();
        }); 
        swal("Eliminado", "El conductor fue eliminado", "Éxito");
      });
    return false;
}
</script>
</body>
</html>
