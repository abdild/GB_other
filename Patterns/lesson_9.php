<?php

echo ("1.	Создать массив на миллион элементов и отсортировать его различными способами. Сравнить скорости.") . "<br>";

$arr = [];
for ($i = 0; $i < 1000; $i++) {
    $arr[] = rand(1, 10000000);
}
sort($arr);


function diffTime($func, $arr)
{
    $start = microtime(true);
    $func($arr);
    $end = microtime(true);
    $diff = $end - $start;
    echo "Длительность сортировки $func: " . $diff . '<br>';

    return $arrSort["$func"] = $diff;
}


// Пузырьковая сортировка
function bubbleSort($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        $count = count($arr);
        for ($j = $i + 1; $j < $count; $j++) {
            if ($arr[$i] > $arr[$j]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $temp;
            }
        }
    }
    return $arr;
}


// Шейкерная сортировка
function shakerSort($arr)
{
    $n = count($arr);
    $left = 0;
    $right = $n - 1;
    do {
        for ($i = $left; $i < $right; $i++) {
            if ($arr[$i] > $arr[$i + 1]) {
                list($arr[$i], $arr[$i + 1]) = array($arr[$i + 1], $arr[$i]);
            }
        }
        $right -= 1;
        for ($i = $right; $i > $left; $i--) {
            if ($arr[$i] < $arr[$i - 1]) {
                list($arr[$i], $arr[$i - 1]) = array($arr[$i - 1], $arr[$i]);
            }
        }
        $left += 1;
    } while ($left <= $right);
    return $arr;
}

// Быстрая сортировка
function quickSort(&$arr, $low = null, $high = null)
{
    $low = is_null($low) ? 0 : $low;
    $high = is_null($high) ? count($arr) - 1 : $high;
    $i = $low;
    $j = $high;
    $middle = $arr[($low + $high) / 2];
    do {
        while ($arr[$i] < $middle) ++$i;
        while ($arr[$j] > $middle) --$j;
        if ($i <= $j) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $temp;

            $i++;
            $j--;
        }
    } while ($i < $j);
    if ($low < $j) {
        quickSort($arr, $low, $j);
    }
    if ($i < $high) {
        quickSort($arr, $i, $high);
    }
    return $arr;
}

$arrSort = [];

$arrSort['bubbleSort'] = diffTime('bubbleSort', $arr);
$arrSort['quickSort'] = diffTime('quickSort', $arr);
$arrSort['shakerSort'] = diffTime('shakerSort', $arr);
print_r($arrSort);
echo "<br>";
arsort($arrSort);
print_r($arrSort);
echo "<br>";
echo "<br>";
echo "<br>";


echo ("2.	Реализовать удаление элемента массива по его значению. Обратите внимание на возможные дубликаты!") . "<br>";

$arr = [];
for ($i = 0; $i < 10; $i++) {
    $arr[] = rand(1, 5);
}
sort($arr);

function clearItem($arr, $item)
{
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] == $item) {
            unset($arr[$i]);
        }
    }
    return $arr;
}

print_r($arr);
echo "<br>";
$arr = clearItem($arr, 3);
print_r($arr);
echo "<br>";
echo "<br>";

echo ("3.	Подсчитать практически количество шагов при поиске описанными в методичке алгоритмами.");

$arr = [];
for ($i = 0; $i < 10; $i++) {
    $arr[] = rand(1, 5);
}
sort($arr);

echo "<br>";
print_r($arr);
echo "<br>";

function lineSearch($arr, $item)
{
    $count = count($arr);
    $steps = 0;

    for ($i = 0; $i < $count; $i++) {
        $steps++;
        if ($arr[$i] == $item) {
            echo "Количество шагов в линейном поиске: " . $steps . '<br>';
            return $i;
        } elseif ($arr[$i] > $item) {
            echo "Количество шагов в линейном поиске: " . $steps . '<br>';
            return null;
        }
    }
}


function binSearch($arr, $item)
{
    $left = 0;
    $right = count($arr) - 1;
    $steps = 0;
    while ($left <= $right) {
        $steps++;

        $middle = floor(($right + $left) / 2);
        if ($arr[$middle] == $item) {
            echo "Количество шагов в бинарном поиске: " . $steps . '<br>';
            return $middle;
        } elseif ($arr[$middle] > $item) {
            $right = $middle - 1;
        } elseif ($arr[$middle] < $item) {
            $left = $middle + 1;
        }
    }
    return null;
}


function interSearch($arr, $item)
{
    $start = 0;
    $last = count($arr) - 1;
    $steps = 0;
    while (($start <= $last) && ($item >= $arr[$start]) && ($item <= $arr[$last])) {
        $steps++;
        $pos = floor($start + ((($last - $start) / ($arr[$last] - $arr[$start])) * ($item - $arr[$start])));
        if ($arr[$pos] == $item) {
            echo "Количество шагов в интерполяционном поиске: " . $steps . '<br>';
            return $pos;
        }
        if ($arr[$pos] < $item) {
            $start = $pos + 1;
        } else {
            $last = $pos - 1;
        }
    }

    return null;
}


lineSearch($arr, 5);
binSearch($arr, 5);
interSearch($arr, 5);
