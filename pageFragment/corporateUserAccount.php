<?php

//function corporateSelfTotalAmount(){
//   //$query = " SELECT begning_credit FROM `corporate` WHERE web_user_id ='".$_SESSION['uid']."' LIMIT 0 , 30";    
//$result = mysql_query($query);       
//echo $result[0];      
// echo '111'.$result->begning_credit;    
// /*if( mysql_num_rows($result) == 1 ){       
// echo '111'.$result['begning_credit'];       
// echo '111'.$result->begning_credit;      
//  echo $result[0];    }*/   //}
//  
//  
//  
//  /*function corporateRemaningCreditAmount(){
//    $query = " SELECT login.id, login.email, users.corporate_id, users.id, users.email_id, account.trip_id, account.customer_id, account.payment_amount  
//          FROM login        LEFT JOIN users ON login.id = users.corporate_id 
//                 LEFT JOIN account ON users.id = account.customer_id     
//                    WHERE login.id =9        GROUP BY account.trip_id  
//                          LIMIT 0 , 30";    $result = mysql_query($query); 
//                             if( mysql_num_rows($result) > 0 ){  
//                                  $amount = mysql_fetch_object($result);  
//                                        $valueAmount = 0; 
//                                               //print_r($amount);  
//                                                     /*($amount->total_sum);  
//                                                           foreach ($amount as $value){  
//                                                                     $valueAmount += $value->total_sum;
//                                                                                echo ($value->total_sum);  
//                                                                                      }        //echo $valueAmount;    }   }
//*function corporateLastSevendayAmount(){    $query ="SELECT login.id, login.email, users.corporate_id, users.id, users.email_id, account.*, SUM( account.payment_amount ) AStotal_sumFROM loginLEFT JOIN users ON login.id = users.corporate_idLEFT JOIN account ON users.id = account.customer_idWHERE login.id ='".$_SESSION['uid']."' AND  account.add_on <= NOW()and add_on >= Date_add(Now(),interval - 7 day)GROUP BY account.trip_id";    $result = mysql_query($query);	$num = mysql_num_rows($result);	$getArray = mysql_fetch_array($getAttemp);}*/?>