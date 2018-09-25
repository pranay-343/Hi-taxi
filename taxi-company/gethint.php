<?php
include '../include/define.php';
$q = $_REQUEST["q"];
$str="select * from `driver` where name LIKE '%$q%'";
$res=mysql_query($str);
if(mysql_affected_rows()>0)
{
    while($row=mysql_fetch_array($res))
    {
        $name=$row['name'];    
    }
    ?>
    <div class="show" align="left">
               <a href=""><span class="name"><?php echo $name; ?></span></a>
            </div>
    <?php
  //  echo "$name";
}
else
{
    echo "No Record Found";
}
?>