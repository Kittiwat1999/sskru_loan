<?php

namespace App\Enums;

enum PolicyStatus: string
{
    case DRAFT = 'draft';

    case PUBLISHED = 'published';

    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'ฉบับร่าง',
            self::PUBLISHED => 'เผยแพร่แล้ว',
            self::ARCHIVED => 'จัดเก็บแล้ว',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-warning text-dark',
            self::PUBLISHED => 'bg-success',
            self::ARCHIVED => 'bg-secondary',
        };
    }

    public function badge(): string
    {
        return sprintf(
            '<span class="badge %s">%s</span>',
            $this->badgeClass(),
            $this->label()
        );
    }
}
