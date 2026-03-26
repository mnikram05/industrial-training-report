<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\PortalAdministration\Http\Controllers\MenuController;
use Modules\PortalAdministration\Http\Controllers\MediaController;
use Modules\PortalAdministration\Http\Controllers\ArticleController;
use Modules\PortalAdministration\Http\Controllers\ExportArticleController;
use Modules\PortalAdministration\Http\Controllers\ImportArticleController;
use Modules\PortalAdministration\Http\Controllers\PortalSettingsController;
use Modules\PortalAdministration\Http\Controllers\PublishArticleController;
use Modules\PortalAdministration\Http\Controllers\UnpublishArticleController;

/*
|--------------------------------------------------------------------------
| Portal Settings (authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'portal-settings', [PortalSettingsController::class, 'edit'] )->name( 'portal-settings.edit' );
    Route::put( 'portal-settings', [PortalSettingsController::class, 'update'] )->name( 'portal-settings.update' );
} );

/*
|--------------------------------------------------------------------------
| Articles (authenticated + public show)
|--------------------------------------------------------------------------
*/
Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'api/menus-by-type/{menuType}', function ( \Modules\PortalAdministration\Models\Menu $menuType ) {
        $menus = \Modules\PortalAdministration\Models\Menu::query()
            ->where( 'parent_id', $menuType->id )
            ->where( 'status_id', 1 )
            ->ordered()
            ->get( ['id', 'title_my', 'title_en'] );

        return response()->json( $menus );
    } )->name( 'api.menus-by-type' );

    Route::get( 'articles/export', ExportArticleController::class )
        ->name( 'articles.export' );

    Route::post( 'articles/import', ImportArticleController::class )
        ->name( 'articles.import' );

    Route::patch( 'articles/{article}/publish', PublishArticleController::class )
        ->name( 'articles.publish' );

    Route::patch( 'articles/{article}/unpublish', UnpublishArticleController::class )
        ->name( 'articles.unpublish' );

    Route::resource( 'articles', ArticleController::class )
        ->except( ['show'] );
} );

Route::get( 'articles/{article:slug}', [ArticleController::class, 'show'] )
    ->name( 'articles.show' );

/*
|--------------------------------------------------------------------------
| Media (authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware( ['auth'] )->group( function (): void {
    Route::resource( 'media', MediaController::class )
        ->except( ['edit'] );
} );

/*
|--------------------------------------------------------------------------
| Menus (authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware( ['auth'] )->prefix( 'portal-administration' )->name( 'portal-administration.' )->group( function (): void {
    Route::patch( 'menus/{menu}/restore', [MenuController::class, 'restore'] )
        ->name( 'menus.restore' );

    Route::delete( 'menus/{menu}/force-delete', [MenuController::class, 'forceDelete'] )
        ->name( 'menus.force-delete' );

    Route::patch( 'menus/{menu}/toggle-status', [MenuController::class, 'toggleStatus'] )
        ->name( 'menus.toggle-status' );

    Route::get( 'menus/sort-options/{parentId?}', [MenuController::class, 'sortOptionsApi'] )
        ->name( 'menus.sort-options' );

    Route::resource( 'menus', MenuController::class );

    Route::patch( 'menus/{menu}/update-sort', [MenuController::class, 'updateSort'] )
        ->name( 'menus.update-sort' );
} );
