<?php

include('../model/motor-quote.php');

$MotorQuote = new MotorQuote;
try {
    $result['result'] = 1;
    $result['resultDesc'][] = '200 : save ok';
    list($result['refid'], $result['refno'])  = $MotorQuote->saveQuote($allVar, $save_rule);
} catch (Exception $e) {
    $result['result-save'] = -1;
    $result['error'][] = $e->getMessage();
}
