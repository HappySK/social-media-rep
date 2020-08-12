<?php
   function one()
   {
       //echo "Function one";
   }
   function two()
   {
       echo "Function two";
   }
   function three()
   {
       //echo "Function three";
   }
   switch($_GET['action'])
   {
       case 'one':one();
                break;
        case 'two':two();
                break;
        case 'three':three();
                break;
        default:echo "No Choices selected";  
   }
?>