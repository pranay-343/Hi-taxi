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
              <h2 class="txt-style-3">Centrales de taxi</h2>
              <form>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Nombre </label>
                      <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Credit Limit</label>
                      <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Converse</label>
						<input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                    </div>
                  </div>
                </div>
                
                <div class="row">
                	<div class="col-lg-12"> 
                    <input type="checkbox" /> <span>Bloquear la cuenta si el usuario excede el límite de crédito</span> </li>
                    </div>
               	</div>
                
				<h2 class="txt-style-3" style="margin-top:25px;">Precio a las colonias</h2>

				<div class="row">
            	<div class="col-sm-12">
                	<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d115002.39064241787!2d-100.35138939102713!3d25.743309851093922!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1staxi+near+Central%2C+Monterrey%2C+Mexico!5e0!3m2!1sen!2sin!4v1450159257013" width="100%" height="370" frameborder="0" style="border:0" allowfullscreen></iframe>
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
