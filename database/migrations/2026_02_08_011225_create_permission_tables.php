<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $teams     = (bool) config( 'permission.teams' );
        $isTesting = (bool) config( 'permission.testing' );

        $tableNamesConfig  = config( 'permission.table_names' );
        $columnNamesConfig = config( 'permission.column_names' );

        if ( ! is_array( $tableNamesConfig ) || $tableNamesConfig === [] ) {
            throw new Exception( 'Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.' );
        }

        if ( ! is_array( $columnNamesConfig ) ) {
            throw new Exception( 'Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.' );
        }

        $permissionsTable         = $this->getConfigString( $tableNamesConfig, 'permissions' );
        $rolesTable               = $this->getConfigString( $tableNamesConfig, 'roles' );
        $modelHasPermissionsTable = $this->getConfigString( $tableNamesConfig, 'model_has_permissions' );
        $modelHasRolesTable       = $this->getConfigString( $tableNamesConfig, 'model_has_roles' );
        $roleHasPermissionsTable  = $this->getConfigString( $tableNamesConfig, 'role_has_permissions' );

        $pivotRole       = $this->getOptionalConfigString( $columnNamesConfig, 'role_pivot_key' ) ?? 'role_id';
        $pivotPermission = $this->getOptionalConfigString( $columnNamesConfig, 'permission_pivot_key' ) ?? 'permission_id';
        $modelMorphKey   = $this->getOptionalConfigString( $columnNamesConfig, 'model_morph_key' ) ?? 'model_id';
        $teamForeignKey  = $this->getOptionalConfigString( $columnNamesConfig, 'team_foreign_key' );

        if ( $teams && $teamForeignKey === null ) {
            throw new Exception( 'Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.' );
        }

        Schema::create( $permissionsTable, static function ( Blueprint $table ): void {
            // $table->engine('InnoDB');
            $table->bigIncrements( 'id' ); // permission id
            $table->string( 'name' );       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string( 'guard_name' ); // For MyISAM use string('guard_name', 25);
            $table->timestamps();

            $table->unique( ['name', 'guard_name'] );
        } );

        Schema::create( $rolesTable, static function ( Blueprint $table ) use ( $teams, $isTesting, $teamForeignKey ): void {
            // $table->engine('InnoDB');
            $table->bigIncrements( 'id' ); // role id
            if ( $teams || $isTesting ) { // permission.testing is a fix for sqlite testing
                $teamKey = $teamForeignKey ?? 'team_id';

                $table->unsignedBigInteger( $teamKey )->nullable();
                $table->index( $teamKey, 'roles_team_foreign_key_index' );
            }
            $table->string( 'name' );       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string( 'guard_name' ); // For MyISAM use string('guard_name', 25);
            $table->timestamps();
            if ( $teams || $isTesting ) {
                $teamKey = $teamForeignKey ?? 'team_id';

                $table->unique( [$teamKey, 'name', 'guard_name'] );
            } else {
                $table->unique( ['name', 'guard_name'] );
            }
        } );

        Schema::create( $modelHasPermissionsTable, static function ( Blueprint $table ) use ( $permissionsTable, $modelMorphKey, $pivotPermission, $teamForeignKey, $teams ): void {
            $table->unsignedBigInteger( $pivotPermission );

            $table->string( 'model_type' );
            $table->uuid( $modelMorphKey );
            $table->index( [$modelMorphKey, 'model_type'], 'model_has_permissions_model_id_model_type_index' );

            $table->foreign( $pivotPermission )
                ->references( 'id' ) // permission id
                ->on( $permissionsTable )
                ->cascadeOnDelete();
            if ( $teams ) {
                $teamKey = $teamForeignKey ?? 'team_id';

                $table->unsignedBigInteger( $teamKey );
                $table->index( $teamKey, 'model_has_permissions_team_foreign_key_index' );

                $table->primary( [$teamKey, $pivotPermission, $modelMorphKey, 'model_type'],
                    'model_has_permissions_permission_model_type_primary' );
            } else {
                $table->primary( [$pivotPermission, $modelMorphKey, 'model_type'],
                    'model_has_permissions_permission_model_type_primary' );
            }
        } );

        Schema::create( $modelHasRolesTable, static function ( Blueprint $table ) use ( $modelMorphKey, $pivotRole, $rolesTable, $teamForeignKey, $teams ): void {
            $table->unsignedBigInteger( $pivotRole );

            $table->string( 'model_type' );
            $table->uuid( $modelMorphKey );
            $table->index( [$modelMorphKey, 'model_type'], 'model_has_roles_model_id_model_type_index' );
            $table->index( ['model_type', $pivotRole], 'model_has_roles_model_type_role_id_index' );

            $table->foreign( $pivotRole )
                ->references( 'id' ) // role id
                ->on( $rolesTable )
                ->cascadeOnDelete();
            if ( $teams ) {
                $teamKey = $teamForeignKey ?? 'team_id';

                $table->unsignedBigInteger( $teamKey );
                $table->index( $teamKey, 'model_has_roles_team_foreign_key_index' );

                $table->primary( [$teamKey, $pivotRole, $modelMorphKey, 'model_type'],
                    'model_has_roles_role_model_type_primary' );
            } else {
                $table->primary( [$pivotRole, $modelMorphKey, 'model_type'],
                    'model_has_roles_role_model_type_primary' );
            }
        } );

        Schema::create( $roleHasPermissionsTable, static function ( Blueprint $table ) use ( $permissionsTable, $pivotPermission, $pivotRole, $rolesTable ): void {
            $table->unsignedBigInteger( $pivotPermission );
            $table->unsignedBigInteger( $pivotRole );

            $table->foreign( $pivotPermission )
                ->references( 'id' ) // permission id
                ->on( $permissionsTable )
                ->cascadeOnDelete();

            $table->foreign( $pivotRole )
                ->references( 'id' ) // role id
                ->on( $rolesTable )
                ->cascadeOnDelete();

            $table->primary( [$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary' );
        } );

        $cacheStoreConfig = config( 'permission.cache.store' );
        $cacheStore       = is_string( $cacheStoreConfig ) && $cacheStoreConfig !== 'default'
            ? $cacheStoreConfig
            : null;

        $cacheKeyConfig = config( 'permission.cache.key' );
        $cacheKey       = is_string( $cacheKeyConfig ) ? $cacheKeyConfig : 'spatie.permission.cache';

        app( 'cache' )
            ->store( $cacheStore )
            ->forget( $cacheKey );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNamesConfig = config( 'permission.table_names' );

        if ( ! is_array( $tableNamesConfig ) || $tableNamesConfig === [] ) {
            throw new Exception( 'Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.' );
        }

        $roleHasPermissionsTable  = $this->getConfigString( $tableNamesConfig, 'role_has_permissions' );
        $modelHasRolesTable       = $this->getConfigString( $tableNamesConfig, 'model_has_roles' );
        $modelHasPermissionsTable = $this->getConfigString( $tableNamesConfig, 'model_has_permissions' );
        $rolesTable               = $this->getConfigString( $tableNamesConfig, 'roles' );
        $permissionsTable         = $this->getConfigString( $tableNamesConfig, 'permissions' );

        Schema::drop( $roleHasPermissionsTable );
        Schema::drop( $modelHasRolesTable );
        Schema::drop( $modelHasPermissionsTable );
        Schema::drop( $rolesTable );
        Schema::drop( $permissionsTable );
    }

    /**
     * @param  array<mixed>  $config
     */
    private function getConfigString( array $config, string $key ): string
    {
        $value = $config[$key] ?? null;

        if ( ! is_string( $value ) || $value === '' ) {
            throw new Exception( "Error: missing config key [{$key}] in config/permission.php." );
        }

        return $value;
    }

    /**
     * @param  array<mixed>  $config
     */
    private function getOptionalConfigString( array $config, string $key ): ?string
    {
        $value = $config[$key] ?? null;

        if ( $value === null || $value === '' ) {
            return null;
        }

        if ( ! is_string( $value ) ) {
            throw new Exception( "Error: invalid config key [{$key}] in config/permission.php." );
        }

        return $value;
    }
};
