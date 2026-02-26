<?php

declare(strict_types=1);

namespace App\Support\Export;

use DateTimeInterface;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;

trait InteractsWithLargeXlsxExport
{
    private const MAX_ROWS_PER_SHEET = 1_048_576;

    private int $currentSheetRows = 0;

    private int $sheetNumber = 1;

    /**
     * @param  array<int, string>  $headers
     */
    protected function initializeWorksheet( Writer $writer, string $sheetPrefix, array $headers ): void
    {
        $this->sheetNumber      = 1;
        $this->currentSheetRows = 0;

        $writer->getCurrentSheet()->setName( $this->sheetName( $sheetPrefix, $this->sheetNumber ) );
        $writer->addRow( Row::fromValues( $headers ) );

        $this->currentSheetRows = 1;
    }

    /**
     * @param  array<int, string>  $headers
     * @param  array<int, bool|int|float|string|DateTimeInterface|null>  $values
     */
    protected function addDataRow( Writer $writer, string $sheetPrefix, array $headers, array $values ): void
    {
        if ( $this->currentSheetRows >= self::MAX_ROWS_PER_SHEET ) {
            $this->sheetNumber++;
            $writer->addNewSheetAndMakeItCurrent()->setName( $this->sheetName( $sheetPrefix, $this->sheetNumber ) );
            $writer->addRow( Row::fromValues( $headers ) );
            $this->currentSheetRows = 1;
        }

        $writer->addRow( Row::fromValues( $values ) );
        $this->currentSheetRows++;
    }

    protected function ensureDirectory( string $fullPath ): void
    {
        $dir = dirname( $fullPath );

        if ( ! is_dir( $dir ) ) {
            mkdir( $dir, 0755, true );
        }
    }

    protected function cellValue( mixed $value ): bool|int|float|string|DateTimeInterface|null
    {
        if ( $value instanceof DateTimeInterface ) {
            return $value;
        }

        if ( is_bool( $value ) || is_int( $value ) || is_float( $value ) || is_string( $value ) ) {
            return $value;
        }

        return null;
    }

    protected function exportChunkSize(): int
    {
        return 2_000;
    }

    private function sheetName( string $prefix, int $sheetNumber ): string
    {
        $suffix = ' ' . $sheetNumber;
        $base   = trim( $prefix ) !== '' ? trim( $prefix ) : 'Export';

        return substr( $base, 0, 31 - strlen( $suffix ) ) . $suffix;
    }
}
