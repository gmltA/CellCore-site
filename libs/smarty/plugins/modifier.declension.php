<?php

/**
 * Smarty plugin - declension modifier
 * @package Smarty
 * @subpackage plugins
*/

/**
 * Модификатор declension: склонение существительных по правилам английского языка
 *
 * @param array $forms (напр: 0 => article, 1 => articles)
 * @param int $count
 * @return string
*/
function smarty_modifier_declension_en($forms, $count)
{
    if ($count == 1)
        return $forms[0];
    else
        return $forms[1];
}

/**
 * Модификатор declension: склонение существительных по правилам русского языка
 *
 * @param array $forms (напр: 0 => пень, 1 => пня, 2 => пней)
 * @param int $count
 * @return string
*/
function smarty_modifier_declension_ru($forms, $count)
{
    $ending = $count%10==1 && $count%100!=11 ? 0 : ($count%10>=2 && $count%10<=4 && ($count%100<10 or $count%100>=20) ? 1 : 2);
    return $forms[$ending];
}
 
/**
 * Модификатор declension: склонение существительных
 *
 * @param int $count
 * @param string $forms
 * @param string $language
 * @return string
*/
function smarty_modifier_declension($count, $forms, $print_count = false, $language = '')
{
    if (!$language)
        $language = 'en';

    $count = abs($count);

    // Выделяем отдельные словоформы
    $forms = explode(';', $forms);

    $fn = 'smarty_modifier_declension_'.$language;
    if (function_exists($fn))
    {
        // Есть персональная функция для текущего языка
        if ($print_count)
            return $count.$fn($forms, $count);
        else
            return $fn($forms, $count);
    } 
    else
    {
        // Действуем по образу и подобию английского языка
        if ($print_count)
            return $count.smarty_modifier_declension_en($forms, $count);
        else
            return smarty_modifier_declension_en($forms, $count);
    }
}

?>