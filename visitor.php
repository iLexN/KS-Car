<?php



header('Content-Type: application/javascript;charset=utf-8 ');



$mqid = (isset($_GET['mqid']) && !empty($_GET['mqid']))  ? $_GET['mqid'] : false;



$cookieValueJson = (isset($_COOKIE['_KSMotor']) && !empty($_COOKIE['_KSMotor']))  ? $_COOKIE['_KSMotor'] : false;
$cookieValueArray = json_decode($cookieValueJson,true);



if ( $mqid ) {
    if ( isset($cookieValueArray['mqid']) && !empty($cookieValueArray['mqid']) ){
        // TODO : del mqid
        // api post mqid , mode = remove
    }
    
    $cookieValueArray['mqid'] = $mqid ;
    unset($cookieValueArray['visitInfo']);
    unset($cookieValueArray['lastVisitInfo']);
    setcookie( "_KSMotor", json_encode($cookieValueArray) , strtotime( '+20 years' ));
    setcookie( "_KSVisitor", true , 0 ); // browser section cookie
} else {
    $postCheck = isset($_COOKIE['_KSVisitor']) ? $_COOKIE['_KSVisitor'] : false;
    if ( isset($cookieValueArray['mqid']) && !empty($cookieValueArray['mqid']) && !$postCheck  ){
        // TODO : log mqid
        // api post mqid , mode = write
        
        $postCheck = true;
    }
    if ( !$postCheck) {
        $lastVisitInfo = isset($cookieValueArray['lastVisitInfo']) ? $cookieValueArray['lastVisitInfo'] : false;
        if ( $lastVisitInfo ) {
            $logInfo = true;
        } else {
            $logInfo = true;
            $lastVisitInfo = array();
            $lastVisitInfo['firstVisitDateTime'] = date("Y-m-d H:i:s");
            $lastVisitInfo['numVistSite'] = 0;
        }
        
        if ( $logInfo ) {
            $lastVisitInfo['numVistSite']++;

            $pushInfoArray = array();
            $pushInfoArray['datetime'] = date("Y-m-d H:i:s");

            $count = count($cookieValueArray['visitInfo']) ;
            if ( $count >= 20 ) {
                array_shift($cookieValueArray['visitInfo']);
            }
            $cookieValueArray['visitInfo'][] = $pushInfoArray;
        }
        $cookieValueArray['lastVisitInfo'] = $lastVisitInfo;
    }
    setcookie( "_KSMotor", json_encode($cookieValueArray) , strtotime( '+20 years' ));
    setcookie( "_KSVisitor", true , 0 ); // browser section cookie
}

