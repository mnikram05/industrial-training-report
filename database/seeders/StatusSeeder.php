<?php

declare(strict_types=1);

namespace Database\Seeders;

use RuntimeException;
use App\Support\Status\Status;
use Illuminate\Database\Seeder;
use App\Support\Status\StatusType;
use App\Support\Status\StatusCatalog;
use App\Support\Transfer\DataTransferStatus;
use App\Modules\Landing\Enums\LandingStatusEnum;
use Modules\PortalAdministration\Enums\ArticleStatusEnum;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now        = now();
        $moduleRows = [
            [
                'type'       => StatusType::Module->value,
                'key'        => StatusType::Article->value,
                'parent_id'  => null,
                'name_en'    => 'Article',
                'name_ms'    => 'Artikel',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type'       => StatusType::Module->value,
                'key'        => StatusType::Landing->value,
                'parent_id'  => null,
                'name_en'    => 'Landing',
                'name_ms'    => 'Pendaratan',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type'       => StatusType::Module->value,
                'key'        => StatusType::DataTransfer->value,
                'parent_id'  => null,
                'name_en'    => 'Data Transfer',
                'name_ms'    => 'Pemindahan Data',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Status::query()->upsert(
            $moduleRows,
            ['type', 'key'],
            ['parent_id', 'name_en', 'name_ms', 'updated_at'],
        );

        $moduleParentRows = Status::query()
            ->where( 'type', StatusType::Module->value )
            ->whereIn( 'key', [
                StatusType::Article->value,
                StatusType::Landing->value,
                StatusType::DataTransfer->value,
            ] )
            ->pluck( 'id', 'key' )
            ->all();

        /** @var array<string, int|string> $moduleParents */
        $moduleParents = [];

        foreach ( $moduleParentRows as $key => $id ) {
            if ( ! is_string( $key ) ) {
                continue;
            }

            if ( is_numeric( $id ) ) {
                $moduleParents[$key] = (int) $id;
            }
        }

        $articleParentId  = $this->parentIdFor( $moduleParents, StatusType::Article );
        $landingParentId  = $this->parentIdFor( $moduleParents, StatusType::Landing );
        $transferParentId = $this->parentIdFor( $moduleParents, StatusType::DataTransfer );

        $rows = [];

        foreach ( ArticleStatusEnum::cases() as $status ) {
            $rows[] = [
                'type'       => StatusType::Article->value,
                'key'        => $status->value,
                'parent_id'  => $articleParentId,
                'name_en'    => $status->nameEn(),
                'name_ms'    => $status->nameMs(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach ( LandingStatusEnum::cases() as $status ) {
            $rows[] = [
                'type'       => StatusType::Landing->value,
                'key'        => $status->value,
                'parent_id'  => $landingParentId,
                'name_en'    => $status->nameEn(),
                'name_ms'    => $status->nameMs(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach ( DataTransferStatus::cases() as $status ) {
            $rows[] = [
                'type'       => StatusType::DataTransfer->value,
                'key'        => $status->value,
                'parent_id'  => $transferParentId,
                'name_en'    => $status->nameEn(),
                'name_ms'    => $status->nameMs(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        Status::query()->upsert(
            $rows,
            ['type', 'key'],
            ['parent_id', 'name_en', 'name_ms', 'updated_at'],
        );

        StatusCatalog::reset();
    }

    /**
     * @param  array<string, int|string>  $moduleParents
     */
    private function parentIdFor( array $moduleParents, StatusType $type ): int
    {
        $id = $moduleParents[$type->value] ?? null;

        if ( is_numeric( $id ) ) {
            return (int) $id;
        }

        throw new RuntimeException( sprintf( 'Missing module parent status for [%s].', $type->value ) );
    }
}
