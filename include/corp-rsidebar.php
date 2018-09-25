<h1 class="txt-style-1">Administrador de <?php echo $_SESSION['uname'];?> Corporación</h1>
<div class="row">
    <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
            <div class="cicon1 hvr-float-shadow">
                <img src="../images/cimage1.png" alt="" title="" />
            </div>
            <?php
                // Total amount for corporator login user
                function corporateSelfTotalAmount(){
                    // $query = " SELECT begning_credit FROM `corporate` WHERE web_user_id ='".$_SESSION['uid']."' LIMIT 0 , 30";    
                    // $query="SELECT * FROM `manage_master_amount` where `corporate_id`='".$_SESSION['uid']."'";
                    // $result = mysql_query($query);   
                    // $amount = 0;
                    // if($row=mysql_fetch_array($result))
                    // {
                    //     $amount +=$row['amount'];
                    // }    
                    // echo $amount;
                   // echo $_SESSION['uid']."id";
                    
                    /*$query = "SELECT `users`.id,`trip`.customer_id,`trip`.trip_ammount from `users` LEFT JOIN `trip` on `users`.id = `trip`.customer_id where `users`.corporate_id = '".$_SESSION['uid']."' ";
                    $result = mysql_query($query);
                    while($row=mysql_fetch_array($result))
                    {
                         $amount +=$row['trip_ammount'];
                    }    
                    echo $amount;*/
                    
                    $query1="SELECT * FROM `manage_master_amount` where `corporate_id`='".$_SESSION['uid']."'";
                    $result1 = mysql_query($query1);   
                    $amount = 0;
                    if($row=mysql_fetch_array($result1)){
                        $amount += $row['amount'];
                    }  
                    echo $amount;
                    
                }
                
             //Total amount by booked user   
            function corporateRemaningCreditAmount()
            {
                // $query = " SELECT login.id, login.email, users.corporate_id, users.id, users.email_id, account.trip_id, account.customer_id, account.payment_amount, corporate.begning_credit, corporate.web_user_id"
                //     . " FROM login LEFT JOIN users ON login.id = users.corporate_id "
                //     . " LEFT JOIN account ON users.id = account.customer_id LEFT JOIN corporate ON login.id = corporate.web_user_id"
                //     . " WHERE login.id =9 and login.id ='".$_SESSION['uid']."'  GROUP BY account.trip_id  LIMIT 0 , 30";
                $query="SELECT `users`.added_by,`users`.id,`trip`.customer_id,`trip`.trip_ammount FROM `users`
                       LEFT JOIN `trip` ON `users`.id = `trip`.customer_id where `users`.added_by='".$_SESSION['uid']."' AND trip.payment_mode ='credit'";
                $result=mysql_query($query);
                while($rows=mysql_fetch_array($result))
                {
                    $noitems1 += $rows['trip_ammount'];
                }
                $query1="SELECT * FROM `manage_master_amount` where `corporate_id`='".$_SESSION['uid']."'";
                    $result1 = mysql_query($query1);   
                    $amount = 0;
                    if($row=mysql_fetch_array($result1))
                    {
                        $amount += $row['amount'];
                    }    
                 
                //echo $noitems = $noitems1 - $amount;
				echo $noitems = $amount - $noitems1;                

            }
            //Total remaing amount
            function remains_amount() {
                $amount_remains = corporateSelfTotalAmount() - corporateRemaningCreditAmount();
                echo $amount_remains;
            }
            
            // last seven days amount
            function corporateLastSevendayAmount()
            {
                //$query="SELECT * from users where added_by='".$_SESSION['uid']."'";
                $noitems = '0';
                $query="SELECT `users`.added_by,`users`.id,`trip`.customer_id,`trip`.trip_ammount FROM `users`
                       LEFT JOIN `trip` ON `users`.id = `trip`.customer_id where `users`.added_by='".$_SESSION['uid']."' and `tripdatetime` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                $result=mysql_query($query);
                while($rows=mysql_fetch_array($result))
                {
                    $noitems +=$rows['trip_ammount'];
                }
                echo $noitems;
                // $query ="SELECT login.id, login.email, users.corporate_id, users.id, users.email_id, account.*, "
                //         . "SUM( account.payment_amount ) AS total_sum "
                //         . "FROM login LEFT JOIN users ON login.id = users.corporate_id "
                //         . "LEFT JOIN account ON users.id = account.customer_id "
                //         . "WHERE login.id ='".$_SESSION['uid']."' AND  account.add_on <= NOW()and add_on >= Date_add(Now(),interval - 7 day) "
                //         . "GROUP BY account.trip_id";    
                // $result = mysql_query($query);	
                // $rows = mysql_num_rows($result);
                // $noitems = 0;  
                // while($info = mysql_fetch_array($result)){
                //     $numberitems = explode(',',$info['payment_amount']);
                //     for ($i = 0; $i < $rows; $i++) {
                //         $noitems += $numberitems[$i];
                //     }
                // }
                // echo $noitems; 
                
            }
            ?>
            
            <span class="txt-style-2" id="actual_balance">REAL BALANCE :  $<?php corporateSelfTotalAmount(); ?></span>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
            <div class="cicon1 hvr-float-shadow">
                <img src="../images/cimage2.png" alt="" title="" />
            </div>
            <span class="txt-style-2">REMAINING CREDIT : $<?php corporateRemaningCreditAmount(); ?></span>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12 strs">
        <div class="c-dash-1">
            <div class="cicon1 hvr-float-shadow">
                <img src="../images/cimage3.png" alt="" title="" />
            </div>
            <span class="txt-style-2">Last 7 Days Balance : $<?php corporateLastSevendayAmount(); ?></span>
        </div>
    </div>
</div>
