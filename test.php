<?php

/**
 * Class Polindrom
 *
 * Если введенная строка является полиндромом - вывести строку.
 * Если введенная строка не является полиндромом - вывести самый длинный подполиндром в строке
 * Если максимальный подполиндром состоит из одной буквы - вывести первую букву строки
 */
class Polindrom {
    protected $max;

    /**
     * Проверка, является ли строка полиндромом
     *
     * @param string $text
     *
     * @return bool
     */
    public function isPolindrom($text) {
        $flag = false;
        $len = mb_strlen($text);

        for ($i=0; $i < $len; $i++) {
            if ($i >= $len - $i) { break; }

            $flag = mb_substr($text, $i, 1) == mb_substr($text, -($i+1), 1);

            if (!$flag) { break; }
        }

        return $flag;
    }

    /**
     * Поиск полиндрома в строке
     *
     * @param string $text
     *
     * @return string
     */
    public function search($text)
    {
        $this->max = "";

        // убираем пробелы и приводим все символы к одному регистру
        $text = str_replace(" ", "", $text);
        $text = mb_strtolower($text);

        if ($this->isPolindrom($text)) {
            // введенный текст - полиндром
            $this->max = $text;
        } else {
            // ищем подполиндромы
            $len = mb_strlen($text);

            for ($l=0; $l < $len; $l++) {
                for ($r=$l+1; $r < $len; $r++) {
                    $str = mb_substr($text, $l, $r-$l);

                    if ($this->isPolindrom($str)) {
                        // запоминаем полиндром максимальной длины
                        if (mb_strlen($this->max) < mb_strlen($str)) {
                            $this->max = $str;
                        }
                    }
                }
            }

            // если полиндром максимум из одного символа -
            if (mb_strlen($this->max) < 2) {
                $this->max = mb_substr($text, 0, 1);
            }

        }

        return $this->max;
    }
}


$p = new Polindrom();

echo $p->search('А роза упала на лапу Азора.'); echo  "<br>\n";
echo $p->search('Аргентина манит негра'); echo  "<br>\n";
echo $p->search('Sum summus mus'); echo  "<br>\n";
echo $p->search('Карл у Клары украл кораллы'); echo  "<br>\n";
