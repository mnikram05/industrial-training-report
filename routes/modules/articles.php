<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\Article\Controllers\ArticleController;
use App\Modules\Article\Controllers\ExportArticleController;
use App\Modules\Article\Controllers\ImportArticleController;
use App\Modules\Article\Controllers\PublishArticleController;
use App\Modules\Article\Controllers\UnpublishArticleController;

Route::middleware( ['auth'] )->group( function (): void {
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
