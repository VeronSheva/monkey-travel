<?php

namespace App\Const;

enum Countries: string
{
    case EGYPT = 'Єгипет';
    case TURKEY = 'Туреччина';
    case MALDIVES = 'Мальдіви';
    case GERMANY = 'Німеччина';
    case ITALY = 'Італія';
    case GREECE = 'Греція';

    public static function label(string $val): bool
    {
        foreach (self::cases() as $case) {
            if ($case->name === $val) {
                return true;
            }
        }

        return false;
    }

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }

    public static function names(): array
    {
        $names = [];
        foreach (self::cases() as $case) {
            $names[] = $case->name;
        }

        return $names;
    }

    public static function enumToArray(): array
    {
        $casesArray = [];
        foreach (self::cases() as $case) {
            $casesArray[] = ['ukr' => $case->value,
                'en' => $case->name, ];
        }

        return $casesArray;
    }
}
