<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('lib/function.inc.php');

try {
    var_dump(check_hkid('B','521364', '4') );
            
            
        } catch (Exception $e) {
            $result['error'][] = $e->getMessage();
            print_r($result);
        }

