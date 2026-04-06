<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Modules\PortalAdministration\Support\PortalPublicMediaPaths;

class SyncPortalPublicMediaCommand extends Command
{
    protected $signature = 'portal:sync-public-media
                            {--force : Overwrite files that already exist under media/portal/}';

    protected $description = 'Copy legacy hashed uploads into media/portal/* (stable paths for deployment)';

    public function handle(): int
    {
        $disk = Storage::disk('public');

        foreach (PortalPublicMediaPaths::legacyPathMap() as $legacy => $target) {
            if (! $disk->exists($legacy)) {
                $this->warn("Skip (source missing): {$legacy}");

                continue;
            }

            if ($disk->exists($target) && ! $this->option('force')) {
                $this->line("Skip (destination exists): {$target}");

                continue;
            }

            $dir = dirname($target);
            if ($dir !== '.' && $dir !== '') {
                $disk->makeDirectory($dir);
            }

            if ($disk->exists($target) && $this->option('force')) {
                $disk->delete($target);
            }

            $disk->copy($legacy, $target);
            $this->info("Copied {$legacy} → {$target}");
        }

        $this->newLine();
        $this->components->info('Done. Point seeders at media/portal/* and deploy that folder with your release.');

        return self::SUCCESS;
    }
}
