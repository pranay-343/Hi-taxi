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
            <h1 class="txt-style-1">Superadministrador Central Taxi</h1>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Agregar Area de Trabajo</h2>
              <form>
                <div class="row">
                  
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Administrador </label>
                      <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                     
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Nombre </label>
                      <input type="text" name="txtname" class="input-style" placeholder="Introduzca texto aquí" />
                     
                    </div>
                  </div>
                </div>
                
                
                <div class="row">
                <div class="col-sm-7">
                	<div class="form-group">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m12!1m8!1m3!1d60189.31694888878!2d-99.1923650338201!3d19.46279547576147!3m2!1i1024!2i768!4f13.1!2m1!1staxi+near+Central%2C+Euzkadi%2C+Mexico+City%2C+Mexico!5e0!3m2!1sen!2sin!4v1449929683790" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                     </div>
                </div>
                	<div class="col-sm-5">
                    	<div class="chart">
                        	<img src="../images/chart.jpg" alt="" title="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-4 col-sm-offset-4">
                    	<button class="dash-button hvr-wobble-horizontal w100">Agregar Zona de Trabajo</button>
                    </div>
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>
<script>
		function loadDummyData(ev, itemName) {
			ev.preventDefault();

			closeMenu();
			gridWrapper.innerHTML = '';
			classie.add(gridWrapper, 'content--loading');
			setTimeout(function() {
				classie.remove(gridWrapper, 'content--loading');
				gridWrapper.innerHTML = '<ul class="products">' + dummyData[itemName] + '<ul>';
			}, 700);
		}
	})();
	</script>
     