<?php
function calAge($dob)
{ // 25-02-2014
    
    if ( $dob == '00-00-0000' ) {
        return 0;
    }
    
    $dob_ar = explode('-', $dob);
    if (checkdate($dob_ar[1],  $dob_ar[0],  $dob_ar[2])) {
        $from   = new DateTime(DateTime::createFromFormat('d-m-Y', $dob)->format('Y-m-d'));
        $to   = new DateTime('today');

        if ($from > $to) {
            throw new Exception('wrong dob :: '. $dob);
        }

        $age = $from->diff($to)->y;
        if ($age < 18) {
            throw new Exception('wrong age :: '. $age);
        } else {
            return $age;
        }
    } else {
        throw new Exception('dob wrong format :: dd-mm-yyyy');
    }
}

function calYrMf($yr)
{
    $y = date("Y") - $yr;
    if ($y < 0) {
        throw new Exception('wrong YrMf :: '. $yr);
    } else {
        return $y;
    }
}

function checkEmpty($k, $v, $v2='')
{
    // need special check for ncd = 0  ?
    if (!empty($v) || !empty($v2)) {
        return $v;
    } else {
        throw new Exception('empty :: ' . $k);
    }
}
/**function genRefno() {
    $code = time() . mt_rand(0, 1000000);
    return sha1($code);
}*/
function checkEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        throw new Exception('error email :: ' . $email);
    }
}

/**
 *
 * @param string $lang en/zh
 */
function checkLang($lang)
{
    switch ($lang) {
            case 'hk':
            case 'ch':
            case 'chi':
            case 'zh':
                return 'zh';
                //break;
            case 'en':
            case 'eng':
                return 'en';
            default:
                throw new Exception('error lang :: ' . $lang);
        }
}

function check_hkid($chat , $hkid=000000, $check_digit='')
{
    
    $chat = trim($chat);
    
    // hkid = $hkid_1.$hkid_2 ($hkid_3)
    $i = 10;
    $id_check_ar = array();
    foreach (range('A', 'Z') as $char) {
        $id_check_ar[$char] = $i;
        $i++;
    }
    
    $countChat = strlen(trim($chat));
    if ( $countChat == 1 )  {
        $chatSum = 324 + $id_check_ar[strtoupper($chat[0])] * 8 ;
    } else if ( $countChat == 2 ) {
        $chatSum = $id_check_ar[strtoupper($chat[0])] * 9 ;
        $chatSum += $id_check_ar[strtoupper($chat[1])] * 8 ;
    }
    
    $hkid_sum = 11 - ( (
            $chatSum +
            $hkid[0] * 7 +
            $hkid[1] * 6 +
            $hkid[2] * 5 +
            $hkid[3] * 4 +
            $hkid[4] * 3 +
            $hkid[5] * 2) %11 );

    
    if ( $hkid_sum == 11 ) $hkid_sum = 0 ;
    if ( $hkid_sum == 10 ) $hkid_sum = 'A' ;
    
    if ($hkid_sum == strtoupper($check_digit) ) {
        return true;
    } else {
        throw new Exception('error hkid :: format');
        return false;
    }
}
