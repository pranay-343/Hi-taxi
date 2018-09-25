<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
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
            <div class="c-acc-status mg5">
              <h2 class="txt-style-3">AÃ±adir Pago</h2>
              <form>
                  <div style="background:#fff; padding:15px;"> 
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1 paymnt_confirm" style="background:#fff;">
             <h4> TAXI DRIVER DATA </h4>
              <tr>
                <td class="tab-txt2">TAXI DRIVER NOMBRE</td>
                <td class="tab-txt2">Nro. Contacto </td>
                <td class="tab-txt2">Matrícula del vehículo</td>
              </tr>
              <tr>
                <td class="tab-txt2">TAXI DRIVER NOMBRE</td>
                <td class="tab-txt2">Nro. Contacto </td>
                <td class="tab-txt2">Matrícula del vehículo</td>
              </tr>
              <tr>
                <td class="tab-txt2">TAXI DRIVER NOMBRE</td>
                <td class="tab-txt2">Nro. Contacto </td>
                <td class="tab-txt2">Matrícula del vehículo</td>
              </tr>
              <tr>
                <td class="tab-txt2">TAXI DRIVER NOMBRE</td>
                <td class="tab-txt2">Nro. Contacto</td>
                <td class="tab-txt2">Matrícula del vehículo</td>
              </tr>
            </table>
            </div>
            
            <div class="row" style="margin-top:20px;">
					<div class="col-md-4"><div class="form-group">
                    	<label>DÃA DE PAGO</label>
                    	<label><strong>Día</strong></label>
                    </div></div>
                    <div class="col-md-4">
                    <div class="form-group">
                    	<label>Elija la fecha aquí</label>
                    	<input type="text" name="txtname" class="input-style" placeholder="Elija la fecha aquí" />
                    </div>
                    </div>
                    <div class="col-md-4"><div class="form-group">
                    	<label>Cantidad</label>
                    	<label><strong>&nbsp;</strong></label>
                    </div></div>
                </div>
                
                
                <div class="row">
                  <div class="col-lg-12" style="text-align:center;">
                    <button class="dash-button hvr-wobble-horizontal" style="margin-top:0px;">CONFIRMAR</button>
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
<script type="text/javascript">
$(document).ready(function (){
   // Array holding selected row IDs
   var rows_selected = [];
   var table = $('#viewAdministrator').DataTable({
      'ajax': {
         'url': "getData.php?mode=<?php echo base64_encode('getAccountAdministratorDetails'); ?>" 
      },
      'columnDefs': [{
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '';
         }
      }],
      'order': [[1, 'asc']]
   });

  

});

function deleteTaxiCompany(a,b)
{
    alert('Estamos trabajando…');
    swal({
        title: "¿Estas seguro?",
        text: "No podras recuperar los detalles de la central y todos los conductores, viajes y otros detalles también serán eliminados",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
      },
      function(){
        swal("Eliminado", "La central de taxi fue eliminada", "Éxito");
      });
    
    return false;
}
</script>
</body>
</html>