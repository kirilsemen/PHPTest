<?php

$main_array = ['vasya', 'pupkin', 'apple', 23, 41, 55, 1, 2];
$result = [];
$secondary_array = [];

unset($argv[0]);
foreach ($argv as $el) {
    $secondary_array[] = $el;
}

//Слова true и false должны быть преобразованы в boolean типы true и false соответственно.
searchForBoolValues(['true', 'false'], $secondary_array);

//Убедиться что в $main_array нету булевского значение true
$result[] = searchForBoolValueTrue($main_array);

//Убедиться что во входящих параметрах есть булевского значение true (если оно было введено)
if (in_array('true', $argv)) {
    $result[] = searchForBoolValueTrue($secondary_array);
}

//Объединить массив и входящие параметры
$result[] = array_merge($main_array, $secondary_array);

//Определить каких данных нету в $main_array но они есть во входящих параметрах$
$result[] = checkOnExistenceData($main_array, $secondary_array, 'not_exist');

//Определить какие данные есть в $main_array и во входящих параметрах
$result[] = checkOnExistenceData($main_array, $secondary_array, 'exist');

//Все строковые значения в $main_array перевести в верхний регистр символов
$result[] = stringValuesToUpperCase($main_array);

//Получить массив чисел из входящих параметров если были введены цифры
$result[] = getNumericArray($argv);

//Отсортировать $main_array таким образом чтобы цифры стали первыми элементами массива
$result[] = sortArray($main_array);


print_r($result);

//Functions
function searchForBoolValues(array $needle, array &$array): void
{
    for ($i = 0; $i < sizeof($needle); $i++) {
        if (in_array($needle[$i], $array)) {
            $key = array_search($needle[$i], $array, true);
            $array[$key] = $array[$key] === 'true';
        }
    }
}

function searchForBoolValueTrue(array $array): bool
{
    return in_array(true, $array, true);
}

function checkOnExistenceData(array $main_array, array $needle_array, string $check): array
{
    $tmp_array = [];

    if ($check === 'exist') {
        $tmp_array['exist'] = array_intersect($main_array, $needle_array);
    }

    if ($check === 'not_exist') {
        $tmp_array['not_exist'] = array_diff($needle_array, $main_array);
    }

    return $tmp_array;
}

function stringValuesToUpperCase(array $main_array): array
{
    foreach ($main_array as $el) {
        if (gettype($el) === 'string') {
            $key = array_search($el, $main_array);
            $main_array[$key] = strtoupper($el);
        }
    }

    return $main_array;
}

function getNumericArray(array $array): array
{
    $tmp_array = [];

    foreach ($array as $el) {
        if (preg_match("/^[0-9]+$/", $el)) {
            $tmp_array[] = (int) $el;
        }
    }

    return $tmp_array;
}

function sortArray(array $array): array
{
    sort($array);
    return $array;
}