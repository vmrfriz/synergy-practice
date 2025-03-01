<?php

namespace Classes;

/**
 * Класс для отрисовки цифровой строки в консоли (ascii art like)
 */
class TerminalDrawer
{
    /*
     * 00111122   - строка 1: индексы 0, 1, 2
     * 33    44   - строка 2: индексы 3, 4
     * 55666677   - строка 3: индексы 5, 6, 7
     * 88    99   - строка 4: индексы 8, 9
     * 10111112   - строка 5: индексы 10, 11, 12
     */
    public const SYMBOLS = [
        //      0  1  2  3  4  5  6  7  8  9 10 11 12
        '-' => [0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0],
        '.' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0],
        ' ' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        '0' => [1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1],
        '1' => [0, 0, 1, 0, 1, 0, 0, 1, 0, 1, 0, 0, 1],
        '2' => [1, 1, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1, 1],
        '3' => [1, 1, 1, 0, 1, 0, 1, 1, 0, 1, 1, 1, 1],
        '4' => [1, 0, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 1],
        '5' => [1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1],
        '6' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1],
        '7' => [1, 1, 1, 0, 1, 0, 0, 1, 0, 1, 0, 0, 1],
        '8' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        '9' => [1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1],
    ];

    public function __construct(
        public string $string
    ) {
        $accepted_chars = array_keys(self::SYMBOLS);
        $preg_chars = preg_quote(implode('', $accepted_chars), '/');
        if (! preg_match("/^[{$preg_chars}]*$/", $this->string)) {
            throw new Exception('Поддерживаются только следующие символы: \'' . implode('\', \'', $accepted_chars) . '\'');
        }
    }

    public function __toString(): string
    {
        return $this->draw();
    }

    public function toMatrix(): array
    {
        /** @var bool[][] $matrix Матрица[столбец][строка] */
        $matrix = [[], [], [], [], []];
        foreach (str_split($this->string) as $char) {
            foreach (self::SYMBOLS[$char] as $index => $filled) {
                $row = [0, 0, 0, 1, 1, 2, 2, 2, 3, 3, 4, 4, 4][$index];
                $matrix[$row][] = $filled;
                if (in_array($index, [3, 8])) {
                    $matrix[$row][] = 0;
                }
            }
            foreach ($matrix as $row => $_) {
                $matrix[$row][] = 0;
            }
        }

        return $matrix;
    }

    public function draw(): string
    {
        $strings = ['', '', '', '', ''];

        foreach ($this->toMatrix() as $row => $cells) {
            foreach ($cells as $filled) {
                $char = [' ', '*'][$filled];
                $asterisks = str_repeat($char, 2);
                $strings[$row] .= $asterisks;
            }
        }

        return implode("\n", $strings);
    }
}
