<?php

declare(strict_types=1);

namespace App\Support\DataTable;

use Illuminate\Support\HtmlString;

abstract class BaseModuleDataTable
{
    public function table(): HtmlString
    {
        return new HtmlString(
            view( 'components.data-table', [
                'id'                => $this->tableId(),
                'headings'          => $this->headings(),
                'ajaxUrl'           => $this->ajaxUrl(),
                'columns'           => $this->columns(),
                'filterPlaceholder' => $this->filterPlaceholder(),
            ] )->render()
        );
    }

    public function scripts(): HtmlString
    {
        return new HtmlString( '' );
    }

    public function ajaxUrl(): string
    {
        return route( $this->ajaxRouteName() );
    }

    abstract protected function tableId(): string;

    abstract protected function ajaxRouteName(): string;

    /**
     * @return list<array{label: string, class?: string}>
     */
    abstract protected function headings(): array;

    /**
     * @return list<array<string, mixed>>
     */
    abstract public function columns(): array;

    abstract public function filterPlaceholder(): string;
}
