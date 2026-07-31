<?php

namespace App\Enums;

enum PolicyType: string
{
    case TERMS = 'terms';

    case PRIVACY = 'privacy';

    case PDPA = 'pdpa';

    public function label(): string
    {
        return match ($this) {
            self::TERMS => 'ข้อกำหนดการใช้งาน',
            self::PRIVACY => 'นโยบายความเป็นส่วนตัว',
            self::PDPA => 'นโยบายคุ้มครองข้อมูลส่วนบุคคล',
        };
    }
}