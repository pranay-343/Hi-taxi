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
<div id="errorMessage"></div>
<table id="viewZoneDetails" class="display select" cellspacing="0" width="100%">
   <thead>
      <tr>
         <th>Título</th>
         <th>Descripción</th>
         <th>En crear</th>
         <th>Acción</th>
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
   var table = $('#viewZoneDetails').DataTable({
      'ajax': {
         'url': "getData.php?mode=<?php echo base64_encode('getZoneDetails'); ?>" 
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

function deleteCreatedZone(a)
{
	swal({
        title: "¿Estas seguro?",
        text: "No podras recuperar los detalles de la zona una vez eliminada",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
      },
      function(){
        $.post('getData.php',{mode:'<?php echo base64_encode("deleteZoneDetail");?>',a:a},function(response){
        	if(response == '1')
        	{
        		swal("Eliminado", "Los detalles de la zona han sido eliminados", "Éxito");
        		location.reload();
        	}
        	else
        	{
        		$('#errorMessage').html(response);
        		$('.sweet-overlay').hide();
        		$('.sweet-alert').hide();
        	}
        }); 
       // return false;
      });
    return false;
}
</script>
</body>
</html>
