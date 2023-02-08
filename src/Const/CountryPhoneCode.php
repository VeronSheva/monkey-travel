<?php

namespace App\Const;

enum CountryPhoneCode: string
{
    case US = '+1';
    case TR = '+9';
    case UA = '+380';
    case PL = '+48';
    case MD = '+373';
    case IT = '+39';
    case PT = '+351';
    case UK = '+44';
    case FR = '+33';

    public static function label(string $val): int|null
    {
        foreach (self::cases() as $case) {
            if ($case->name === $val) {
                return $case->value;
            }
        }

        return null;
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
            $casesArray[] = ['code' => $case->value,
                'abr' => $case->name, ];
        }

        return $casesArray;
    }
}
