<?php

/**
 * Консольная программа
 */

use Classes\TerminalDrawer;

require_once __DIR__ . '/classes/TerminalDrawer.php';
date_default_timezone_set('Europe/Moscow');

/**
 * Запрос даты рождения по очереди: число, месяц, год
 *
 * @throws Exception
 * @return DateTime
 */
function readBirthday(): DateTime
{
    $day = readline('Введите день (1-31): ');
    if ($day < 1 || $day > 31) {
        throw new Exception('День должен быть в диапазоне от 1 до 31');
    }

    $month = readline('Введите месяц (1-12): ');
    if ($month < 1 || $month > 12) {
        throw new Exception('Месяц должен быть в диапазоне от 1 до 12');
    }

    $max_month_day = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][$month - 1];
    if ($max_month_day < $day) {
        $month_str = ['январе', 'феврале', 'марте', 'апреле', 'мае', 'июне', 'июле', 'августе', 'сентябре', 'октябре', 'ноябре', 'декабре'][$month - 1];
        throw new Exception("В {$month_str} не может быть {$day} числа");
    }

    $year = readline('Введите год: ');
    $current_year = intval(date('Y'));
    if ($current_year < $year) {
        throw new Exception('Год рождения не может быть больше текущего года');
    }
    if (date('Y') - $year > 150) {
        throw new Exception('По мнению международной группы учёных, человек не способен жить больше 150 лет');
    }

    if (! is_leap_year($year) && $month == 2 && $day == 29) {
        throw new Exception("В {$year} году нет 29 февраля");
    }

    $birthday = new DateTime("{$year}-{$month}-{$day}");
    if (time() < $birthday->getTimestamp()) {
        throw new Exception('Дата рождения не может быть в будущем');
    }

    return $birthday;
}

/**
 * Возвращает название дня недели по дате
 *
 * @param DateTime $date
 * @return string
 */
function weekByDate(DateTime $date): string
{
    $weekdays = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
    $weekday = $weekdays[(int) $date->format('N') - 1];
    return $weekday;
}

/**
 * Проверяет, является ли год високосным
 *
 * @param int $year
 * @return int
 */
function is_leap_year(int $year): bool
{
    return (int) date("L", mktime(0, 0, 0, 2, 1, $year)) === 1;
}

/**
 * Возвращает возраст по дате рождения
 *
 * @param DateTime $birthday
 * @return int
 */
function calculateAge(DateTime $birthday): int
{
    $current_date = new DateTime();
    return $current_date->diff($birthday)->y;
}

/********************
 * Запуск программы
 *******************/

echo "Введите дату рождения\n";

/** @var DateTime $birthday */
$birthday = null;
while ($birthday === null) {
    try {
        $birthday = readBirthday();
    } catch (Exception $e) {
        echo "\nОшибка ввода: {$e->getMessage()}\n";
    }
}

$week_day = mb_strtolower(weekByDate($birthday));
echo "\nДень Вашего рождения - {$week_day}\n";

$leap = is_leap_year($birthday->format('Y')) ? 'високосный' : 'не високосный';
echo "Это был {$leap} год\n";

$age = calculateAge($birthday);
echo "Ваш возраст - {$age}\n\n";

echo new TerminalDrawer($birthday->format('d m Y'));
echo PHP_EOL;
