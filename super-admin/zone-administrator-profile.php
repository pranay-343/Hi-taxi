<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/super-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
<h1 class="txt-style-1">Super Admin Taxi Central</h1>
<div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Agregar Administrador</h2>
              <form>
                <div class="row">
                  
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Administrador </label>
                      <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí">
                     
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label>Zonas de Trabajo</label>
                      <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí">
                     
                    </div>
                  </div>
                </div>
                <div class="row">
                	<div class="col-sm-12">
                    <label> Descripción </label>
                    	<textarea placeholder="Introduzca texto aquí" class="input-style"></textarea>
                    </div>
                </div>
                <br><br>
                <div class="row">
                <div class="col-sm-7">
                	<div class="form-group">
                     <label> <strong>ARCHIVOS :-</strong> </label>
                     </div>
                     <div class="files">
                     	<ul>
                        	<li><a href="#">Archive 1</a></li>
                            <li><a href="#">Archive 1</a></li>
                            <li><a href="#">Archive 1</a></li>
                        </ul>
                        <span><input type="file" value="Add Files" /></span>
                     </div>
                </div>
                	<div class="col-sm-5">
                    <label> <strong>Estadística :-</strong> </label>
                    	<div class="chart">
                        	<img src="../images/chart.jpg" alt="" title="">
                        </div>
                       <button class="dash-button hvr-wobble-horizontal w100">SALVAR</button>
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
