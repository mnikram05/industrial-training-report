<?php

declare(strict_types=1);

namespace Database\Seeders;

use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Modules\User\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Modules\User\Models\Password;
use App\Modules\Article\Models\Article;
use App\Modules\Landing\Models\Landing;
use Spatie\Activitylog\Models\Activity;
use App\Modules\Article\Enums\ArticleStatusEnum;
use App\Modules\Landing\Enums\LandingStatusEnum;
use App\Modules\Role\Constants\RoleNameConstants;

class TestLoadSeeder extends Seeder
{
    private const DEFAULT_USER_COUNT = 1000000;

    private const DEFAULT_ARTICLE_COUNT = 1000000;

    private const DEFAULT_LANDING_COUNT = 1000000;

    private const DEFAULT_ACTIVITY_LOG_COUNT = 1000000;

    private const DEFAULT_EXTRA_ROLE_COUNT = 100;

    private const INSERT_CHUNK_SIZE = 400;

    public function __construct(
        private int $userCount = self::DEFAULT_USER_COUNT,
        private int $articleCount = self::DEFAULT_ARTICLE_COUNT,
        private int $landingCount = self::DEFAULT_LANDING_COUNT,
        private int $activityLogCount = self::DEFAULT_ACTIVITY_LOG_COUNT,
        private int $extraRoleCount = self::DEFAULT_EXTRA_ROLE_COUNT,
    ) {
        $this->userCount        = $this->intConfig( 'seed.testload.users', $this->userCount );
        $this->articleCount     = $this->intConfig( 'seed.testload.articles', $this->articleCount );
        $this->landingCount     = $this->intConfig( 'seed.testload.landings', $this->landingCount );
        $this->activityLogCount = $this->intConfig( 'seed.testload.activity_logs', $this->activityLogCount );
        $this->extraRoleCount   = $this->intConfig( 'seed.testload.roles', $this->extraRoleCount );
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->logProgress( 'Starting role and permission seeding...' );
        $this->call( RoleAndPermissionSeeder::class );
        $this->call( StatusSeeder::class );

        $this->logProgress( 'Seeding roles...' );
        $roles = $this->seedRoles();
        $this->logProgress( 'Seeding users...' );
        $this->seedUsers( $roles );
        $this->logProgress( 'Seeding articles...' );
        $this->seedArticles();
        $this->logProgress( 'Seeding landings...' );
        $this->seedLandings();
        $this->logProgress( 'Seeding activity logs...' );
        $this->seedActivityLogs();
        $this->logProgress( 'Test load seeding complete.' );
    }

    /**
     * @param  Collection<int, Role>  $roles
     */
    private function seedUsers( Collection $roles ): void
    {
        if ( $roles->isEmpty() || $this->userCount === 0 ) {
            return;
        }

        $roleIds = $roles
            ->pluck( 'id' )
            ->filter( static fn ( mixed $id ): bool => is_int( $id ) || ( is_string( $id ) && is_numeric( $id ) ) )
            ->map( static fn ( int|string $id ): int => (int) $id )
            ->values()
            ->all();

        if ( $roleIds === [] ) {
            return;
        }

        $modelHasRolesTable = $this->stringConfig( 'permission.table_names.model_has_roles', 'model_has_roles' );
        $passwordHash       = Hash::make( 'password' );
        $faker              = fake();

        $userRows     = [];
        $passwordRows = [];
        $roleRows     = [];

        for ( $i = 0; $i < $this->userCount; $i++ ) {
            $userId    = (string) Str::uuid();
            $createdAt = now()->subDays( $faker->numberBetween( 0, 365 ) );
            $updatedAt = $createdAt->copy()->addDays( $faker->numberBetween( 0, 30 ) );

            $userRows[] = [
                'id'                => $userId,
                'name'              => $faker->name(),
                'email'             => 'seed-user-' . $i . '-' . Str::lower( Str::random( 10 ) ) . '@example.test',
                'email_verified_at' => $createdAt->copy()->addMinutes( $faker->numberBetween( 0, 240 ) ),
                'remember_token'    => Str::random( 10 ),
                'created_at'        => $createdAt,
                'updated_at'        => $updatedAt,
            ];

            $passwordRows[] = [
                'user_id'    => $userId,
                'password'   => $passwordHash,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            $roleRows[] = [
                'role_id'    => Arr::random( $roleIds ),
                'model_type' => User::class,
                'model_id'   => $userId,
            ];

            if ( count( $userRows ) >= self::INSERT_CHUNK_SIZE ) {
                User::query()->insert( $userRows );
                Password::query()->insert( $passwordRows );
                DB::table( $modelHasRolesTable )->insert( $roleRows );

                $userRows     = [];
                $passwordRows = [];
                $roleRows     = [];
            }

            if ( ( $i + 1 ) % 50000 === 0 ) {
                $this->logProgress( 'Seeded users: ' . number_format( $i + 1 ) . '/' . number_format( $this->userCount ) );
            }
        }

        if ( $userRows !== [] ) {
            User::query()->insert( $userRows );
            Password::query()->insert( $passwordRows );
            DB::table( $modelHasRolesTable )->insert( $roleRows );
        }
    }

    /**
     * @return Collection<int, Role>
     */
    private function seedRoles(): Collection
    {
        $roles = collect( RoleNameConstants::all() );

        if ( $this->extraRoleCount === 0 ) {
            return Role::query()->whereIn( 'name', $roles )->get();
        }

        $faker = fake();

        for ( $i = 0; $i < $this->extraRoleCount; $i++ ) {
            $name = 'load-' . Str::slug( $this->wordsToString( $faker->unique()->words( 3, true ) ) ) . '-' . $i;

            Role::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                ['name' => $name, 'guard_name' => 'web'],
            );

            $roles->push( $name );
        }

        return Role::query()->whereIn( 'name', $roles )->get();
    }

    private function seedArticles(): void
    {
        if ( $this->articleCount === 0 ) {
            return;
        }

        $userIds = $this->userIdPool();

        if ( $userIds === [] ) {
            return;
        }

        $faker = fake();
        $chunk = [];

        for ( $i = 0; $i < $this->articleCount; $i++ ) {
            $title  = $faker->sentence( 6 ) . ' ' . Str::uuid()->toString();
            $status = $faker->boolean( 65 )
                ? ArticleStatusEnum::Published
                : ArticleStatusEnum::Draft;

            $createdAt = now()->subDays( $faker->numberBetween( 0, 90 ) );

            $chunk[] = [
                'user_id'      => Arr::random( $userIds ),
                'title'        => $title,
                'slug'         => Str::slug( $title ),
                'excerpt'      => $faker->sentence( 18 ),
                'content'      => $faker->paragraphs( 3, true ),
                'status_id'    => $status->id(),
                'published_at' => $status === ArticleStatusEnum::Published
                    ? $createdAt->copy()->addDays( $faker->numberBetween( 0, 10 ) )
                    : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt->copy()->addDays( $faker->numberBetween( 0, 15 ) ),
            ];

            if ( count( $chunk ) >= 400 ) {
                Article::query()->insert( $chunk );
                $chunk = [];
            }

            if ( ( $i + 1 ) % 100000 === 0 ) {
                $this->logProgress( 'Seeded articles: ' . number_format( $i + 1 ) . '/' . number_format( $this->articleCount ) );
            }
        }

        if ( $chunk !== [] ) {
            Article::query()->insert( $chunk );
        }
    }

    private function seedLandings(): void
    {
        if ( $this->landingCount === 0 ) {
            return;
        }

        $faker = fake();
        $rows  = [];

        for ( $i = 0; $i < $this->landingCount; $i++ ) {
            $title     = 'Seed Landing ' . $this->wordsToString( $faker->words( 3, true ) ) . ' ' . Str::uuid()->toString();
            $createdAt = now()->subDays( $faker->numberBetween( 0, 45 ) );
            $heroTitle = $faker->sentence( 5 );
            $heroBody  = $faker->sentence( 10 );

            $rows[] = [
                'slug'    => Str::slug( $title ),
                'content' => json_encode( [
                    'hero' => [
                        'title'          => ['en' => $title, 'ms' => $title],
                        'subtitle'       => ['en' => $heroBody, 'ms' => $heroBody],
                        'primary_button' => [
                            'text' => ['en' => 'Get Started', 'ms' => 'Mula Sekarang'],
                            'url'  => '/login',
                        ],
                        'secondary_button' => [
                            'text' => ['en' => 'Documentation', 'ms' => 'Dokumentasi'],
                            'url'  => 'https://laravel.com/docs',
                        ],
                    ],
                    'banner' => [
                        'title'    => ['en' => $faker->sentence( 4 ), 'ms' => $faker->sentence( 4 )],
                        'subtitle' => ['en' => $faker->sentence( 8 ), 'ms' => $faker->sentence( 8 )],
                        'image'    => null,
                        'alt'      => ['en' => '', 'ms' => ''],
                    ],
                    'about' => [
                        'title' => ['en' => $faker->sentence( 3 ), 'ms' => $faker->sentence( 3 )],
                        'body'  => ['en' => $faker->sentence( 10 ), 'ms' => $faker->sentence( 10 )],
                        'image' => null,
                        'alt'   => ['en' => '', 'ms' => ''],
                    ],
                    'security' => [
                        'title' => ['en' => $faker->sentence( 3 ), 'ms' => $faker->sentence( 3 )],
                        'body'  => ['en' => $faker->sentence( 10 ), 'ms' => $faker->sentence( 10 )],
                        'image' => null,
                        'alt'   => ['en' => '', 'ms' => ''],
                    ],
                    'articles' => [
                        [
                            'article_slug' => null,
                            'title'        => ['en' => $faker->sentence( 4 ), 'ms' => $faker->sentence( 4 )],
                            'excerpt'      => ['en' => $faker->sentence( 10 ), 'ms' => $faker->sentence( 10 )],
                            'image'        => null,
                            'alt'          => ['en' => '', 'ms' => ''],
                        ],
                        [
                            'article_slug' => null,
                            'title'        => ['en' => $faker->sentence( 4 ), 'ms' => $faker->sentence( 4 )],
                            'excerpt'      => ['en' => $faker->sentence( 10 ), 'ms' => $faker->sentence( 10 )],
                            'image'        => null,
                            'alt'          => ['en' => '', 'ms' => ''],
                        ],
                        [
                            'article_slug' => null,
                            'title'        => ['en' => $faker->sentence( 4 ), 'ms' => $faker->sentence( 4 )],
                            'excerpt'      => ['en' => $faker->sentence( 10 ), 'ms' => $faker->sentence( 10 )],
                            'image'        => null,
                            'alt'          => ['en' => '', 'ms' => ''],
                        ],
                    ],
                    'features' => [
                        [
                            'icon'        => 'sparkles',
                            'title'       => ['en' => $faker->words( 3, true ), 'ms' => $faker->words( 3, true )],
                            'description' => ['en' => $faker->sentence( 10 ), 'ms' => $faker->sentence( 10 )],
                        ],
                        [
                            'icon'        => 'shield',
                            'title'       => ['en' => $faker->words( 3, true ), 'ms' => $faker->words( 3, true )],
                            'description' => ['en' => $faker->sentence( 10 ), 'ms' => $faker->sentence( 10 )],
                        ],
                        [
                            'icon'        => 'globe',
                            'title'       => ['en' => $faker->words( 3, true ), 'ms' => $faker->words( 3, true )],
                            'description' => ['en' => $faker->sentence( 10 ), 'ms' => $faker->sentence( 10 )],
                        ],
                    ],
                    'footer' => [
                        'text' => ['en' => 'Built with Laravel', 'ms' => 'Dibina dengan Laravel'],
                    ],
                ] ),
                'status_id' => $faker->boolean( 70 )
                    ? LandingStatusEnum::Published->id()
                    : LandingStatusEnum::Draft->id(),
                'created_at' => $createdAt,
                'updated_at' => $createdAt->copy()->addDays( $faker->numberBetween( 0, 15 ) ),
            ];

            if ( count( $rows ) >= self::INSERT_CHUNK_SIZE ) {
                Landing::query()->insert( $rows );
                $rows = [];
            }

            if ( ( $i + 1 ) % 100000 === 0 ) {
                $this->logProgress( 'Seeded landings: ' . number_format( $i + 1 ) . '/' . number_format( $this->landingCount ) );
            }
        }

        if ( $rows !== [] ) {
            Landing::query()->insert( $rows );
        }
    }

    private function seedActivityLogs(): void
    {
        if ( $this->activityLogCount === 0 ) {
            return;
        }

        $causerIds = $this->userIdPool();

        if ( $causerIds === [] ) {
            return;
        }

        $subjectPool = Article::query()
            ->inRandomOrder()
            ->limit( 200 )
            ->get( ['id', 'title'] );

        $faker = fake();
        $rows  = [];

        for ( $i = 0; $i < $this->activityLogCount; $i++ ) {
            $causerId = Arr::random( $causerIds );
            $subject  = $subjectPool->isEmpty()
                ? null
                : $subjectPool->random();

            $createdAt = now()->subMinutes( $faker->numberBetween( 0, 60 * 24 * 14 ) );

            $rows[] = [
                'log_name'     => 'seed-load',
                'description'  => $faker->sentence( 4 ),
                'event'        => 'seeded',
                'subject_id'   => $subject?->id,
                'subject_type' => $subject !== null ? Article::class : null,
                'causer_id'    => $causerId,
                'causer_type'  => User::class,
                'properties'   => json_encode( [
                    'label' => 'test-load',
                ] ),
                'batch_uuid' => (string) Str::uuid(),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            if ( count( $rows ) >= 400 ) {
                Activity::query()->insert( $rows );
                $rows = [];
            }

            if ( ( $i + 1 ) % 100000 === 0 ) {
                $this->logProgress( 'Seeded activity logs: ' . number_format( $i + 1 ) . '/' . number_format( $this->activityLogCount ) );
            }
        }

        if ( $rows !== [] ) {
            Activity::query()->insert( $rows );
        }
    }

    /**
     * @return array<int, string>
     */
    private function userIdPool( int $limit = 5000 ): array
    {
        return User::query()
            ->limit( $limit )
            ->pluck( 'id' )
            ->filter( static fn ( mixed $id ): bool => is_string( $id ) || is_int( $id ) )
            ->map( static fn ( string|int $id ): string => (string) $id )
            ->values()
            ->all();
    }

    /**
     * @param  array<mixed>|string  $words
     */
    private function wordsToString( array|string $words ): string
    {
        if ( is_array( $words ) ) {
            $values = array_values(
                array_filter(
                    $words,
                    static fn ( mixed $word ): bool => is_string( $word ) || is_int( $word ) || is_float( $word )
                )
            );

            return implode(
                ' ',
                array_map(
                    static fn ( string|int|float $word ): string => (string) $word,
                    $values
                )
            );
        }

        return $words;
    }

    private function intConfig( string $key, int $default ): int
    {
        $value = config( $key, $default );

        if ( is_int( $value ) ) {
            return $value;
        }

        if ( is_string( $value ) && is_numeric( $value ) ) {
            return (int) $value;
        }

        return $default;
    }

    private function stringConfig( string $key, string $default ): string
    {
        $value = config( $key, $default );

        return is_string( $value ) && $value !== ''
            ? $value
            : $default;
    }

    private function logProgress( string $message ): void
    {
        if ( $this->command !== null ) {
            $this->command->info( $message );
        }
    }
}
