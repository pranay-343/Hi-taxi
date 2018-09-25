<?php 
include '../include/define.php';
include '../include/head.php'; 
?>
<body>
<?php include '../include/zone-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/zone-admin-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5">
        <?php include '../include/za-rsidebar.php'; ?>
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">Editar Taxi Company</h2>
          <form>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Dirección Línea 1</label>
                  <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Dirección Línea 2</label>
                  <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Teléfono no.</label>
                  <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                <label>Límites de trabajo</label>
                  <input type="number" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                  
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Por coste de activación semana</label>
                  <input type="number" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                </div>
              </div>
            </div>
             <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label> <strong>ARCHIVOS :-</strong> </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="ARCHIVOS">
                  <ul>
                    <li><a href="#">Archive 1</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="ARCHIVOS">
                  <ul>
                    <li><a href="#">Archive 1</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="ARCHIVOS">
                  <ul>
                    <li><a href="#">Archive 1</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4 col-sm-offset-2">
                <button class="dash-button hvr-wobble-horizontal w100">add ARCHIVOS</button>
              </div>
              <div class="col-sm-4">
                <button class="dash-button hvr-wobble-horizontal w100">actualizar</button>
              </div>
            </div>
            
           
          </form>
          <div> </div>
        </div>
        
        
        <div class="c-acc-status"> <br/>
        <h2 class="txt-style-3">Información del usuario de la empresa</h2>
        <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Nombre de usuario</label>
                  <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Contraseña</label>
                  <input type="password" name="password" class="input-style" placeholder="Introduzca texto aquí" />
                </div>
              </div>
              
            </div>
            <br/>
          <h2 class="txt-style-3">Taxistas</h2>
          <br/>
          <div>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tbody>
                <tr>
                  <th width="34%" class="tab-txt1">nombre</th>
                  <th width="33%" class="tab-txt1">Estado</th>
                  <th width="33%" class="tab-txt1">ver información</th>
                </tr>
                <tr>
                  <td class="tab-txt2">Mice Arisn</td>
                  <td class="tab-txt2">Activo</td>
                  <td class="tab-txt2"><a href="#">( + )</a></td>
                </tr>
                <tr>
                  <td class="tab-txt2">Mice Arisn</td>
                  <td class="tab-txt2">Activo</td>
                  <td class="tab-txt2"><a href="#">( + )</a></td>
                </tr>
              </tbody>
            </table>
            <br/>
            <h2 class="txt-style-3">usuarios</h2>
            <br/>
            <div class="row">
              <div class="col-sm-5">
                <div class="form-group">
                  <label> Nº de usuarios</label>
                </div>
                <div class="i100"> <img src="../images/chart.png" alt="" title="" /> </div>
              </div>
              <div class="col-sm-7">
                <div>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                    <tbody>
                      <tr>
                        <th width="34%" class="tab-txt1">nombre de pila</th>
                        <th width="33%" class="tab-txt1">tipo de usuario</th>
                        <th width="33%" class="tab-txt1">lanzamiento</th>
                      </tr>
                      <tr>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                      </tr>
                      <tr>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                      </tr>
                      <tr>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                      </tr>
                      <tr>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                      </tr>
                      <tr>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                      </tr>
                      <tr>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                        <td class="tab-txt2">test</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><br>

            <h2 class="txt-style-3">Datos y estadísticas</h2>
            <div class="row">
              <div class="col-sm-8">
                <label><strong>Total de este mes</strong></label>
              </div>
              <div class="col-sm-4">
                <label><strong>total</strong></label>
              </div>
            </div>
            <br>
            <p class="ssr">
         Activo / inactivo taxis, Número de Empresas de taxis, número de alarmas, Servicios completadas / Cancelado, Servicios De: Aplicación vs App Corp, Promedio de tiempo, medio de pago, Normal Cualificación de los controladores. 
         </p><br>

         <div class="row">
         	<div class="col-sm-6">
            	<div class="i100">
                	<img src="../images/chart.png" alt="" title="" />
                </div>
            </div>
            <div class="col-sm-6">
            	<div class="i100">
                	<img src="../images/car.png" alt="" title="" />
                </div>
            </div>
         </div>
            
              <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                  <a href="<?php echo ZONE_URL?>account-status.php" class="dash-button hvr-wobble-horizontal w100">estado de la cuenta</a>
                </div>
              </div>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html><!-- JQUERY SUPPORT -->
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/modernizr-custom.js"></script>

<!-- datepicker -->
<script src="../js/datepicker.js"></script>
<script src="../js/datepicker.en.js"></script>
<script>
var $start = $('#start'),
	$end = $('#end');
	$start.datepicker({
		language: 'en',
		onSelect: function (fd, date) {
			$end.data('datepicker')
				.update('minDate', date)
		}
	})
	$end.datepicker({
		language: 'en',
		onSelect: function (fd, date) {
			$start.data('datepicker')
				.update('maxDate', date)
		}
	})
</script>