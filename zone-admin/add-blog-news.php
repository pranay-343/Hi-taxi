<?php 
include '../include/define.php';
include '../include/head.php'; 
?>
<body>
    <?php include '../include/zone-navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/zone-admin-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <div class="c-acc-status mg5 sv1">
              <h2 class="txt-style-3">Add New Blog</h2>
              <?php
               if (isset($_POST['submitNews'])) 
              { 
                submitNews(); 
                HTMLRedirectURL(ZONE_URL."blog-news.php");
              }
              ?>
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="row bts">
                  <!-- <div class="col-sm-4">
                    <div class="form-group">           
                      <label> Taxi Driver Name </label>                      
                   <input type="text" name="txtDname" required class="input-style" placeholder="Enter Text Here" onkeyup="showHint(this.value)"/>
                    </div>
                  </div>  -->                    
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> TITLE</label>
                      <input type="text" name="title" id="title" class="input-style" placeholder="TITLE" required/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> DESCRIPTION </label>
                      <!-- <input type="text" name="discription" id="discription" class="input-style" placeholder="Enter Discription" /> -->
                      <textarea name="discription" id="discription" class="input-style" required></textarea>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> IMAGE </label>
                      <!-- <input type="text" name="discription" id="discription" class="input-style" placeholder="Enter Discription" /> -->
                       <input type="file" name="file" class="input-style"/ required>
                    </div>
                  </div>  
               <div class="clearfix"></div>
                  <div class="col-lg-12" style="text-align:center;">
                    <!-- <a href="<?php echo TAXI_URL; ?>payment_confirm.php" class="dash-button hvr-wobble-horizontal">Add Payment</a> -->
                     <button class="dash-button hvr-wobble-horizontal" name="submitNews"   type="submit">Add News</button>
                  </div>
                </div>
              </form>
            </div>           
            <?php
           // if (isset($_POST['submitNews'])) 
           // { 

           //      submitNews(); 
           //      HTMLRedirectURL(ZONE_URL."blog-news.php");

             // $title=$_REQUEST['title'];
             // $discription=$_REQUEST['discription'];
             // $addedon=date('Y-m-d');
             // function GetImageExtension($imagetype)
             //   {
             //     if(empty($imagetype)) return false;
             //     switch($imagetype)
             //     {
             //         case 'image/bmp': return '.bmp';
             //         case 'image/gif': return '.gif';
             //         case 'image/jpeg': return '.jpg';
             //         case 'image/png': return '.png';
             //         default: return false;
             //     }
             //   }
   
 
             //   $file_name=$_FILES["file"]["name"];
             //   $temp_name=$_FILES["file"]["tmp_name"];
             //   $imgtype=$_FILES["file"]["type"];
             //   $ext= GetImageExtension($imgtype);
             //   $imagename=date("d-m-Y")."-".time().$ext;
             //   $target_path = "news/".$imagename;
             //   move_uploaded_file($temp_name, $target_path);
                             
             // $str="insert into news (`title`,`discription`,`newsImage`,`added_on`,`added_by`) values ('$title','$discription','$target_path','$addedon','".$_SESSION['uid']."')";
             // $res=mysql_query($str) or die(mysql_error());
             // if($res)
             // {
             //  echo "<script>alert('Data Inserted successfully');
             //        window.location.href='blog-news.php'</script>";
             // }
             // else
             // {
             //  echo "Error";
             // }            
           // }
           ?>
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
    alert('Estamos trabajando�');
    swal({
        title: "¿Estas seguro?",
        text: "No podras recuperar los detalles de la central y todos los conductores, viajes y otros detalles también serán eliminados",
        type: "advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Sí, estoy seguro!',
        closeOnConfirm: false
      },
      function(){
        swal("Eliminado", "La central de taxi fue eliminada", "Éxito");
      });
    
    return false;
}
</script>
<script type="text/javascript">
var $start = $('#start'),
  $end = $('#end');
  $start.datepicker({
    language: 'en',
    minDate: 0,
    onSelect: function (fd, date) {
      $end.data('datepicker')
        .update('minDate', date)
    }
  })
  $end.datepicker({
    language: 'en',
    minDate: 0,
    onSelect: function (fd, date) {
      $start.data('datepicker')
        .update('maxDate', date)
    }
  })
</script>
</body>
</html>