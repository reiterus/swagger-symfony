<?php

namespace App\Service;

/**
 * Random service: date, name, etc
 */
class Random
{
    /**
     * Random date between 1972-11-11 and 2022-11-11
     * @return string
     */
    public function date(): string
    {
        $int = mt_rand(90277201, 1668114001);
        return date("Y-m-d",$int);
    }

    /**
     * Random person full name
     * @return string
     */
    public function name(): string
    {
        $items = [
            'Michelle B. Williams',
            'William S. McCroy',
            'Benjamin P. Cunningham',
            'Иванов Иван Иванович',
            'Петров Петр Петрович',
            'Сидоров Сидор Сидорович',
        ];
        shuffle($items);
        return current($items);
    }

    /**
     * Random email address
     * @param string $domain
     * @return string
     */
    public function email(string $domain = 'yandex.ru'): string
    {
        $str = 'qwertyuiopasdfghjklzxcvbnm';
        $shuffled = str_shuffle($str);
        $substr = substr($shuffled, 0, 8);
        return sprintf('%s@%s', $substr, $domain);
    }

    /**
     * Random integer value
     * @return int
     */
    public function int(): int
    {
        return rand(7, 77);
    }

    /**
     * Random float value
     * @return float
     */
    public function float(): float
    {
        $num = floatval(mt_rand(1000, 5000)/99);
        return number_format($num, 2, '.', '');
    }

    /**
     * Random leading zeros value
     * @return string
     */
    public function leadZeros(): string
    {
        return sprintf("%06d", mt_rand(100, 300));
    }
}
