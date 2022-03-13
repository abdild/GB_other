<?php

// 1. Написать аналог «Проводника» в Windows для директорий на сервере при помощи итераторов.

class Conductor
{
    public function dirConductor($path)
    {
        $dir = new DirectoryIterator($path);
        echo '<ol>';
        foreach ($dir as $item) {
            if ($item->valid() && $item != '.' && $item != '..') {
                if ($item->isDir()) {
                    echo '<li>' . "Папка: " . $item;
                } else {
                    echo '<li>' . "Файл: " . $item;
                }

                if ($item->isDir()) {
                    $this->dirConductor($path . '/' . $item);
                }
                echo '</li>';
            }
        }
        echo '</ol>';
    }
}

$dir = new Conductor();
$dir->dirConductor("../lesson8");


// 2.	Определить сложность следующих алгоритмов:

// ●	поиск элемента массива с известным индексом,
// O(n)

// ●	дублирование массива через foreach,
// O(2n)

// ●	рекурсивная функция нахождения факториала числа.
// O(n)


// 3.	Определить сложность следующих алгоритмов. Сколько произойдет итераций?

// 1)
$n = 100;
$array[]= [];
$sum = 0;

for ($i = 0; $i < $n; $i++) {
  for ($j = 1; $j < $n; $j *= 2) {
     $array[$i][$j]= true;
     $sum += 1;
} }
echo $sum."<br>";

// Ответ: сложность O(n^2), итераций 700.

// 2)
$n = 100;
$array[] = [];
$sum = 0;

for ($i = 0; $i < $n; $i += 2) {
  for ($j = $i; $j < $n; $j++) {
     $array[$i][$j]= true;
     $sum += 1;
} }
echo $sum."<br>";

// Ответ: сложность O(n^2), итераций 2550.