<?php
include '../include/define.php';
// echo "<script>alert('hello');</script>";
$mode = $_POST['mode'];
$q = $_GET["term"];

if ($q == '' || $q == null) {
    
} else {
    $mode = 'corporation';
}


switch ($mode) {
    case "corporation":
   
        $query = "SELECT name, id FROM login WHERE name like '%$q%' and account_type ='4' and added_by='".$_SESSION['uid']."'";
        $result = mysql_query($query);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == "0") {
            $json[] = array('value' => 'not found');
        } else
         {
            while ($row = mysql_fetch_array($result))
             {
                $json[] = array(
                    //'id' => $row['id'],
                    'value' => $row['name']
                );
            }
        }
        echo json_encode($json);
       
        // $nj = '';$njj = '';
        // $query = mysql_query("SELECT id, name, account_type, added_by FROM `login` WHERE 1 AND added_by =  '".$_SESSION['uid']."'");
        // while($data = mysql_fetch_array($query))
        // {
        //       $nj .= $data[id].',';
        // }
        // $nj = rtrim($nj,',');
        // $query = mysql_query("SELECT id, name, account_type, added_by FROM `login` WHERE 1 AND added_by in ($nj)");
        // while($data = mysql_fetch_array($query))
        // {
        //       $njj .= $data[id].',';
        // }
        // $njj = rtrim($njj,',');

        // $query="SELECT name FROM `users` where 1 and corporate_id in ($njj) and name like '%".$q."%' ";
        // $result = mysql_query($query);
        // $num_rows = mysql_num_rows($result);
        // if ($num_rows == "0") {
        //     $json[] = array('value' => 'not found');
        // } else
        // {
        //     while ($row = mysql_fetch_array($result))
        //     {
        //         $json[] = array(
        //             //'id' => $row['id'],
        //             'value' => $row['name']
        //         );
        //     }
        // }
        // echo json_encode($json);
        break;
    }
?>