<?php
// Реализовать построение и обход дерева для математического выражения

$exp = "5-30/6+4*12+1";

function expToArray(string $input) {
    $exp = str_split($input);
    $expArr = [];

    $temp = '';
    foreach ($exp as $v) {
        if ( $v != '+' && $v != '-' && $v != '*' && $v != '/') {
            $temp .= $v;
        } else {
            $expArr[] = $temp;
            $temp = '';

            $expArr[] = $v;
        }
    }
    $expArr[] = $temp;

    return $expArr;
}


function getOpPos($exp) {
    if (in_array('+', $exp)) return array_search('+', $exp);
    if (in_array('-', $exp)) return array_search('-', $exp);
    if (in_array('*', $exp)) return array_search('*', $exp);
    if (in_array('/', $exp)) return array_search('/', $exp);
    return false;
}


function calc(array $exp) {
    $pos = getOpPos($exp);

    if (!$pos) return $exp[0];
    
    $left = array_slice($exp, 0, $pos);
    $right = array_slice($exp, $pos + 1);
    
    switch ($exp[$pos]) {
        case '+':
            return calc($left) + calc($right);
        case '-':
            return calc($left) - calc($right);
        case '*':
            return calc($left) * calc($right);
        case '/':
            return calc($left) / calc($right);
    }
}

$expArr = expToArray($exp);
echo calc($expArr);