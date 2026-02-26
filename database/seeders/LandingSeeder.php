<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Landing\Models\Landing;
use App\Modules\Landing\Enums\LandingStatusEnum;

class LandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultContent = config( 'landing.default', [] );
        $content        = is_array( $defaultContent ) ? $defaultContent : [];

        Landing::firstOrCreate(
            ['slug' => 'landing'],
            [
                'status_id' => LandingStatusEnum::Published->id(),
                'content'   => array_replace_recursive( $content, [
                    'hero' => [
                        'title' => [
                            'en' => 'Landing Page',
                            'ms' => 'Laman Pendaratan',
                        ],
                    ],
                ] ),
            ]
        );
    }
}
