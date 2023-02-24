

<?php


echo '<link rel="stylesheet" href="../css/style_lab_1-13_1.css">';


class CLASS_LAB 
{
   function c_lab_send(){
        if(!empty($_POST))
        {
            echo '<pre>';
            print_r($_POST);
            die();
        }
        else{
            echo "no date";
        }
        
    }

    function lab_14_TASK ($mnozenna,$num_tr,$num_td, $TB_delete_td,$TB_delete_td_2)
    {
        $table_peremenna=null;
        $table_style_1=null;

        $table_style_1='<a style="color:blue;font-weight:900">';

        
        $table_peremenna .= '<table class="php_table_1" style="border:1px solid green">';

        for($for_tr=0; $for_tr<$num_tr; $for_tr++)
        { 
           $table_peremenna .='<tr>';                   
             
              for($for_td_1=1; $for_td_1<$num_td; $for_td_1++)
              {  
                if($for_td_1==$TB_delete_td)
                {}
                else if($for_tr==0)
                 {
                     if($for_td_1%2 ==0) {      
                        $table_peremenna .= '<th>';
                        $table_peremenna .=  $table_style_1.$for_td_1.'<a>';
                        $table_peremenna .=  '</th>';
                     }
                  else
                  {  
                    $table_peremenna .= '<th>';                   
                    $table_peremenna .=  $for_td_1;
                    $table_peremenna .=  '</th>';
                  }
                 }
                 else
                 {
                  $table_peremenna .= '<td>';
                   for($for_td_2=1; $for_td_2<$num_td; $for_td_2++)
                    {
                     if($for_td_2==$TB_delete_td_2)
                     {

                     }
                     else if($for_td_1%2 ==0) {
                        $rez_a=$for_td_1*$for_td_2;
                        $for_td_1_style= $table_style_1.$for_td_1.'<a>';
                        $table_peremenna .=  $for_td_1_style.'*'.$for_td_2.'='.$rez_a.'<br>';  
                     }
                     else if($for_td_2%2 ==0) {
                        $rez_a=$for_td_1*$for_td_2;
                        $for_td_2_style= $table_style_1.$for_td_2.'<a>';
                        $table_peremenna .=  $for_td_1.'*'.$for_td_2_style.'='.$rez_a.'<br>'; 
                     }

                     else
                     {
                      $rez_a=$for_td_1*$for_td_2;
                      $table_peremenna .=  $for_td_1.'*'.$for_td_2.'='.$rez_a.'<br>';   
                     }
                   } 
                   $table_peremenna .= '</td>';
                 }
            } 
              $table_peremenna .=  '</tr>';   
        }        
        $table_peremenna .=  '</table>';
        
        
        
        echo $table_peremenna;
    }


    function lab_15_TASK($mnozenna, $num_tr, $num_td, $TB_delete_td, $TB_delete_td_2) {
        $table_style_1 = '<a style="color:blue;font-weight:900">';
        $table = '<table class="php_table_1" style="border:1px solid green">';
        
        for ($tr = 0; $tr < $num_tr; $tr++) {
            $table .= '<tr>';
            for ($td1 = 1; $td1 < $num_td; $td1++) {
                if ($TB_delete_td === $td1 || $TB_delete_td_2 === 0) {
                    continue;
                }
                $td_tag = ($tr === 0) ? 'th' : 'td';
                $td_style = ($td1 % 2 === 0) ? $table_style_1 : '';
                $table .= "<$td_tag>";
                if ($tr === 0) {
                    $table .= $td_style . $td1 . '</a>';
                } else {
                    for ($td2 = 1; $td2 < $num_td; $td2++) {
                        if ($TB_delete_td_2 === $td2 || $TB_delete_td === 0) {
                            continue;
                        }
                        $rez_a = $td1 * $td2;
                        $td2_style = ($td2 % 2 === 0) ? $table_style_1 : '';
                        $table .= $td_style . $td1 . '</a>' . '*' . $td2_style . $td2 . '</a>' . '=' . $rez_a . '<br>';
                    }
                }
                $table .= "</$td_tag>";
            }
            $table .= '</tr>';
        }
        $table .= '</table>';
        echo $table;
    }




    function Doska_Shaxmat($Doska_kilk){
        $Doska_table_create=null;
        $Doska_table_create_pole_1=null;

        $Doska_table_create .= '<table class="php_table_2" style="border:5px solid green">';
       
            for($d_for_tr=1; $d_for_tr<$Doska_kilk; $d_for_tr++)
            {
                $Doska_table_create .= '<tr>';
                for($d_for_tr_2=1; $d_for_tr_2<$Doska_kilk; $d_for_tr_2++)
                {
                    $Doska_table_create .= '<td>';  
                    /*$Doska_table_create .= $d_for_tr_2;  */
                    $Doska_table_create .= '</td>';                    
                }
                $Doska_table_create .= '</tr>';    
            }


        echo $Doska_table_create;

    }

    /*--------------------------------------------------------------------------------------------------------*/
    function lab_13_2 ($kilk_chusel, $vubir_zavdanna)
    {
        $fiind_1=0;
        $fiind_2=0;
        $fiind_3=0;
        $fiind_4=0;
        $fiind_5=0;
        $fiind_6=0;
        $date_rez=0;
        $date_counter=$kilk_chusel;

        echo ('<h1>'.'Завдання №'.$vubir_zavdanna.'</h1>');

        for($i=0; $i<$date_counter; $i++)
        {
            $date_rez=$date_rez+1;

            $fiind_1=$date_rez/100000%10;
            $fiind_2=$date_rez/10000%10;
            $fiind_3=$date_rez/1000%10;
            $fiind_4=$date_rez/100%10;
            $fiind_5=$date_rez/10%10;
            $fiind_6=$date_rez%10;

            if($kilk_chusel>10000){
                $date_rez_0=$fiind_1.$fiind_2.$fiind_3.$fiind_4.$fiind_5.$fiind_6;
            }
            else{
                $date_rez_0=$fiind_3.$fiind_4.$fiind_5.$fiind_6;
            }

            
            
            switch ($vubir_zavdanna){
         case "0":       
            echo '$fiind_6-->'.$fiind_6=$date_rez/100000%10;
            echo '$fiind_5-->'.$fiind_5=$date_rez/10000%10;
            echo '$fiind_4-->'.$fiind_4=$date_rez/1000%10;
            echo '$fiind_3-->'.$fiind_3=$date_rez/100%10;
            echo '$fiind_2-->'.$fiind_2=$date_rez/10%10;
            echo '$fiind_1-->'.$fiind_1=$date_rez%10;  
            echo '<br>----------->>>>'.$fiind_0=$fiind_6.$fiind_5.$fiind_4.$fiind_3.$fiind_2.$fiind_1;
            echo '<br>';
             break;

         
        case "1":       
               if($fiind_3*$fiind_4==$fiind_5+$fiind_6){
             /*   echo $fiind_1.'*'.$fiind_2.'-->'.$F_REZ1=$fiind_1*$fiind_2;
                echo '=='.$fiind_3.'+'.$fiind_4.'-->'.$F_REZ1=$fiind_3+$fiind_4.'-->';
               */ echo $date_rez_0.'<br>';
             }            
        break;

        case "2":
                if($fiind_1+$fiind_2+$fiind_3==$fiind_4+$fiind_5+$fiind_6){
                    echo ($date_rez_0.', '); 
             }
        break;

            case "3":     
              if($fiind_3*$fiind_6==$fiind_4+$fiind_5){
                 echo ($date_rez_0.', '); 
              }      
        break;

            case "4":
                $f_1=$fiind_1.$fiind_2.$fiind_3;
                $f_2=$fiind_4.$fiind_5.$fiind_6;
                $f_1_2=$f_1-$f_2;
                if($f_1_2==77){
                    echo $date_rez_0.', '; 
                }  
                else{
                    break;
                }  
        

        case "5":
            
             $f_1=$fiind_1.$fiind_2.$fiind_3;
             $f_2=$fiind_4.$fiind_5.$fiind_6;
             $f_1_2=$f_1+$f_2;
             if($f_1_2==1000){
              echo $date_rez_0.', '; 
            }            
    break;   

        case "6":
             $f_1=$fiind_3-$fiind_4;
             $f_2=$fiind_5-$fiind_6;
            if($f_1==$f_2){
            echo $date_rez_0.', '; 
        }
    break;

        case "7":
            $f_1=$fiind_1+$fiind_2;
            $f_2=$fiind_3+$fiind_4+$fiind_5+$fiind_6;
            if($f_1==$f_2){
            echo $date_rez_0.',<br>';       
        }     
    break;

    case "8":{
         $f_1=$fiind_3+$fiind_4+$fiind_5;
        $f_2=pow($fiind_6,2);
        if($f_1==$f_2){
        echo $date_rez_0.', '; 
        }
    }       
    break;

    case "9":{
        $f_1=$fiind_1.$fiind_2.$fiind_3;
        $f_2=$fiind_3.$fiind_4.$fiind_6;

        if($f_1>$f_2){
            $f1_RIZ=$f_1-$f_2;
            $f1_SUM=$fiind_1+$fiind_2+$fiind_3+$fiind_4+$fiind_5+$fiind_6;

             if($f1_RIZ<$f1_SUM){
                echo $date_rez_0.', '; 
             }
             else{
                break;
            }
        }
        else{
            break;
        }
        
   }       
   break;

   case "10":{
    $f_1=$fiind_1+$fiind_2;
    $f_2=$fiind_3+$fiind_4;
    $f_3=$fiind_5+$fiind_6;

   if($f_1==$f_2){
    if($f_1==$f_3){
         echo $date_rez_0.', '; 
    }
   }else{
    break;
   }
}       
break;
        }
        
    }
}
}

$post_date=$_POST['n_tab_1'];


switch($post_date){               
case "task_1":{
    $test_2= new CLASS_LAB;
    $test_2->lab_13_2('9999','1');
}
break;

case "task_2":{
    $test_2= new CLASS_LAB;   
    $test_2->lab_13_2('999999','2');
}
break;

case "task_3":{
    $test_2= new CLASS_LAB;   
    $test_2->lab_13_2('9999','3');
}
break;

case "task_4":{
    $test_2= new CLASS_LAB;   
    $test_2->lab_13_2('999999','4');
}
break;

case "task_5":{
    $test_2= new CLASS_LAB;   
    $test_2->lab_13_2('999999','5');
}
break;

case "task_6":{
    $test_2= new CLASS_LAB;   
    $test_2->lab_13_2('9999','6');
}
break;

case "task_7":{
    $test_2= new CLASS_LAB;   
    $test_2->lab_13_2('999999','7');
}
break;

case "task_8":{
    $test_2= new CLASS_LAB;   
    $test_2->lab_13_2('9999','8');
}
break;

case "task_9":{
    $test_2= new CLASS_LAB;   
    $test_2->lab_13_2('999999','9');
}
break;

case "task_10":{
    $test_2= new CLASS_LAB;   
    $test_2->lab_13_2('999999','10');
}
break;

case "task_2_1":{
    $lab_14= new CLASS_LAB;   
    $lab_14->lab_14_TASK('1','2','11','4','7');
}
break;

case "task_3_1":{
    $lab_14= new CLASS_LAB;   
    $lab_14->Doska_Shaxmat('10');
}
break;
}


?>

