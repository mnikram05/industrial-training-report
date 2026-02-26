<?php

declare(strict_types=1);

namespace App\Support\Import\Concerns;

use DateTimeInterface;
use Illuminate\Support\Str;
use OpenSpout\Reader\XLSX\Reader;
use Illuminate\Support\LazyCollection;

trait InteractsWithXlsxRows
{
    /**
     * @return LazyCollection<int, array<string, string|null>>
     */
    protected function rows( string $filePath ): LazyCollection
    {
        return LazyCollection::make( function () use ( $filePath ) {
            $reader = new Reader;
            $reader->open( $filePath );

            try {
                foreach ( $reader->getSheetIterator() as $sheet ) {
                    $headers = null;

                    foreach ( $sheet->getRowIterator() as $row ) {
                        $rowValues = array_values( $row->toArray() );

                        if ( $headers === null ) {
                            $headers = array_map(
                                fn ( mixed $header ): string => $this->normalizeHeader( $header ),
                                $rowValues,
                            );

                            continue;
                        }

                        $rowValues = $this->normalizeRowLength( $rowValues, count( $headers ) );
                        $rowValues = array_map(
                            fn ( mixed $value ): ?string => $this->normalizeCellValue( $value ),
                            $rowValues,
                        );

                        $combined = array_combine( $headers, $rowValues );
                        yield $combined;
                    }

                    break;
                }
            } finally {
                $reader->close();
            }
        } );
    }

    /**
     * @param  array<string, string|null>  $row
     */
    protected function value( array $row, string $key ): ?string
    {
        $value = $row[$key] ?? null;

        if ( ! is_string( $value ) ) {
            return null;
        }

        $value = trim( $value );

        return $value !== '' ? $value : null;
    }

    protected function normalizeHeader( mixed $header ): string
    {
        if ( ! is_string( $header ) ) {
            return '';
        }

        $header = trim( ltrim( $header, "\xEF\xBB\xBF" ) );

        if ( $header === '' ) {
            return '';
        }

        return Str::snake( $header );
    }

    /**
     * @param  array<int, mixed>  $rowValues
     * @return array<int, mixed>
     */
    private function normalizeRowLength( array $rowValues, int $headerCount ): array
    {
        if ( count( $rowValues ) < $headerCount ) {
            return array_pad( $rowValues, $headerCount, null );
        }

        if ( count( $rowValues ) > $headerCount ) {
            return array_slice( $rowValues, 0, $headerCount );
        }

        return $rowValues;
    }

    private function normalizeCellValue( mixed $value ): ?string
    {
        if ( $value === null ) {
            return null;
        }

        if ( $value instanceof DateTimeInterface ) {
            return $value->format( 'Y-m-d H:i:s' );
        }

        if ( is_bool( $value ) ) {
            return $value ? '1' : '0';
        }

        if ( is_int( $value ) || is_float( $value ) ) {
            return (string) $value;
        }

        if ( ! is_string( $value ) ) {
            return null;
        }

        $value = trim( $value );

        return $value !== '' ? $value : null;
    }
}
