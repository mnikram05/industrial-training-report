<?php

declare(strict_types=1);

namespace App\Modules\Landing\Enums;

use App\Support\Status\StatusType;
use App\Support\Status\StatusCatalog;

enum LandingStatusEnum: string
{
    case Draft     = 'draft';
    case Published = 'published';

    public static function default(): self
    {
        return self::Draft;
    }

    public function id(): int
    {
        return StatusCatalog::id( StatusType::Landing, $this->value );
    }

    public function label(): string
    {
        return StatusCatalog::label( StatusType::Landing, $this->value );
    }

    public function nameEn(): string
    {
        return match ( $this ) {
            self::Draft     => 'Draft',
            self::Published => 'Published',
        };
    }

    public function nameMs(): string
    {
        return match ( $this ) {
            self::Draft     => 'Draf',
            self::Published => 'Diterbitkan',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach ( self::cases() as $status ) {
            $options[$status->id()] = $status->label();
        }

        return $options;
    }
}
