(function () {
    if (window.__shadcnDatatablesBooted) {
        return;
    }

    const configElement = document.getElementById('shadcn-datatables-config');
    let config = {};

    if (configElement && configElement.textContent) {
        try {
            config = JSON.parse(configElement.textContent);
        } catch (error) {
            config = {};
        }
    }

    const fallbackDefaultOptions = {
        processing: false,
        serverSide: true,
        lengthChange: false,
        pagingType: 'simple_numbers',
        scrollX: false,
    };

    const fallbackTranslations = {
        filterPlaceholder: 'Filter...',
        clear: 'Clear',
        columns: 'Columns',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        infoEmpty: 'Showing 0 to 0 of 0 entries',
        zeroRecords: 'No matching records found',
        emptyTable: 'No data available in table',
        processing: 'Processing...',
        loadingRecords: 'Loading...',
        first: 'First',
        previous: 'Previous',
        next: 'Next',
        last: 'Last',
    };

    const defaultDataTableOptions =
        typeof config.defaultOptions === 'object' && config.defaultOptions !== null
            ? config.defaultOptions
            : fallbackDefaultOptions;

    const dataTableTranslations =
        typeof config.translations === 'object' && config.translations !== null
            ? config.translations
            : fallbackTranslations;

    window.__shadcnDatatablesBooted = true;
    const dataTableClasses = {
        wrapper: 'w-full bg-transparent text-sm text-foreground',
        hiddenBuiltIn: 'hidden',
        frame: 'relative w-full overflow-x-auto overflow-y-hidden rounded-[calc(var(--radius)-2px)] border border-border bg-background',
        toolbar: 'mb-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between',
        searchRoot: 'relative w-full sm:max-w-sm',
        searchInput: 'h-9 w-full rounded-md border border-input bg-background px-3 pr-10 text-sm text-foreground placeholder:text-muted-foreground outline-none ring-offset-background focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50 [&::-webkit-search-cancel-button]:hidden [&::-webkit-search-cancel-button]:appearance-none [&::-webkit-search-decoration]:appearance-none',
        searchClearButton: 'absolute inset-y-0 right-1 my-auto inline-flex size-7 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 outline-none',
        columnsRoot: 'relative w-full sm:w-auto',
        columnsButton: 'inline-flex h-9 w-full items-center justify-center gap-2 rounded-md border border-input bg-background px-3 text-sm font-medium text-foreground shadow-xs transition-colors hover:bg-accent hover:text-accent-foreground sm:w-auto',
        columnsMenu: 'fixed z-[100] min-w-44 max-h-[70vh] overflow-y-auto rounded-md border border-border bg-popover p-1 text-popover-foreground shadow-md',
        columnsItem: 'flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm transition-colors hover:bg-accent hover:text-accent-foreground',
        footer: 'mt-3 flex flex-col items-stretch gap-3 sm:flex-row sm:items-center sm:justify-between',
        info: 'm-0 w-full whitespace-normal break-words text-center text-sm font-normal text-muted-foreground sm:w-auto sm:text-left',
        paging: 'flex w-full justify-center overflow-x-auto pb-1 text-sm sm:w-auto sm:justify-end sm:overflow-visible sm:pb-0',
        pagingNoNav: 'flex items-center justify-center gap-2',
        pagingNav: 'mx-auto flex min-w-max items-center justify-center gap-1.5 sm:mx-0 sm:gap-2',
        pageButton: 'inline-flex h-8 items-center justify-center gap-1 whitespace-nowrap rounded-[10px] border border-border bg-background px-2.5 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted hover:text-foreground sm:px-3.5',
        pageIconOnly: 'min-w-8 px-2',
        pageNumber: 'min-w-9 px-2',
        pagePrevNext: 'min-w-[72px] sm:min-w-[96px]',
        pageCurrent: 'bg-muted text-foreground',
        pageDisabled: 'pointer-events-none opacity-50',
        table: 'min-w-[760px] w-full border-separate border-spacing-0 text-sm',
        headCell: 'border-b border-border bg-background px-4 py-3 text-left font-medium text-foreground whitespace-nowrap',
        bodyCell: 'border-b border-border px-4 py-3 align-middle text-foreground whitespace-nowrap',
        bodyCellLastRow: 'border-b-0',
        loadingOverlay: 'dt-loading-overlay pointer-events-none absolute inset-0 z-30 hidden items-center justify-center',
        loadingSurface: 'min-w-44 rounded-md border border-border bg-popover p-3 text-popover-foreground shadow-md',
    };

    const dataTableProcessingMarkup = document.getElementById('dt-progress-template')
        ?.innerHTML
        ?.trim() || dataTableTranslations.processing;
    const firstPageIconMarkup =
        '<svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">' +
        '<path d="m11 17-5-5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
        '<path d="m18 17-5-5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
        '</svg>';
    const lastPageIconMarkup =
        '<svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">' +
        '<path d="m6 7 5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
        '<path d="m13 7 5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
        '</svg>';
    const previousPageIconMarkup =
        '<svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">' +
        '<path d="m15 18-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
        '</svg>';
    const nextPageIconMarkup =
        '<svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">' +
        '<path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
        '</svg>';
    const searchClearIconMarkup =
        '<svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">' +
        '<path d="m18 6-12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
        '<path d="m6 6 12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
        '</svg>';

    const applyClassString = function (element, classString) {
        if (element && element.length && classString) {
            element.addClass(classString);
        }
    };

    const hideBuiltInProcessing = function (wrapper) {
        wrapper.find('.dataTables_processing, .dt-processing')
            .addClass(dataTableClasses.hiddenBuiltIn)
            .attr('aria-hidden', 'true');
    };

    const ensureFrame = function (wrapper) {
        let frame = wrapper.children('.dt-table-frame').first();

        if (frame.length) {
            applyClassString(frame, dataTableClasses.frame);
            return frame;
        }

        const scrollContainer = wrapper.find('.dataTables_scroll, .dt-scroll').first();

        if (scrollContainer.length) {
            scrollContainer.wrap('<div class="dt-table-frame"></div>');
            frame = scrollContainer.parent();
        } else {
            const tableElement = wrapper.find('table.dataTable').first();

            if (tableElement.length && !tableElement.parent().hasClass('dt-table-frame')) {
                tableElement.wrap('<div class="dt-table-frame"></div>');
                frame = tableElement.parent();
            }
        }

        applyClassString(frame, dataTableClasses.frame);

        return frame;
    };

    const ensureLoadingOverlay = function (frame) {
        if (!frame || !frame.length) {
            return null;
        }

        let overlay = frame.children('.dt-loading-overlay').first();

        if (!overlay.length) {
            overlay = window.jQuery(
                '<div class="' + dataTableClasses.loadingOverlay + '">' +
                '<div class="' + dataTableClasses.loadingSurface + '">' + dataTableProcessingMarkup +
                '</div>' +
                '</div>'
            );

            frame.append(overlay);
        }

        return overlay;
    };

    const styleTable = function (wrapper) {
        const tableElement = wrapper.find('table.dataTable').first();

        if (!tableElement.length) {
            return;
        }

        tableElement
            .removeAttr('width')
            .css({
                width: '100%',
                tableLayout: 'auto',
            });
        applyClassString(tableElement, dataTableClasses.table);
        applyClassString(tableElement.find('thead th, thead td'), dataTableClasses.headCell);
        applyClassString(tableElement.find('tbody td'), dataTableClasses.bodyCell);
        applyClassString(tableElement.find('tbody tr:last-child td'), dataTableClasses.bodyCellLastRow);
        applyClassString(tableElement.find('thead th:last-child, thead td:last-child'), 'text-right');
        applyClassString(tableElement.find('tbody td:last-child'), 'text-right');
        tableElement.find('thead th:last-child, thead td:last-child, tbody td:last-child')
            .css({
                width: '1%',
                whiteSpace: 'nowrap',
            });

        const emptyCells = tableElement.find('tbody td.dataTables_empty, tbody td.dt-empty');
        emptyCells
            .removeClass('text-right')
            .addClass('text-center text-muted-foreground')
            .css({
                textAlign: 'center',
                width: 'auto',
                whiteSpace: 'normal',
            });

        const fixedHeadTable = wrapper.find(
            '.dataTables_scrollHead table.dataTable, .dt-scroll-head table.dataTable').first();

        if (fixedHeadTable.length) {
            fixedHeadTable
                .removeAttr('width')
                .css({
                    width: '100%',
                    tableLayout: 'auto',
                });
            applyClassString(fixedHeadTable, dataTableClasses.table);
            applyClassString(fixedHeadTable.find('thead th, thead td'), dataTableClasses.headCell);
            applyClassString(fixedHeadTable.find('thead th:last-child, thead td:last-child'), 'text-right');
            fixedHeadTable.find('thead th:last-child, thead td:last-child')
                .css({
                    width: '1%',
                    whiteSpace: 'nowrap',
                });
        }
    };

    const stylePagination = function (wrapper, table) {
        const info = wrapper.find('.dt-footer .dataTables_info, .dt-footer .dt-info').last().length ?
            wrapper.find('.dt-footer .dataTables_info, .dt-footer .dt-info').last() :
            wrapper.find('.dataTables_info, .dt-info').last();
        const paging = wrapper.find('.dt-footer .dataTables_paginate, .dt-footer .dt-paging').last()
            .length ?
            wrapper.find('.dt-footer .dataTables_paginate, .dt-footer .dt-paging').last() :
            wrapper.find('.dataTables_paginate, .dt-paging').last();

        if (!paging.length) {
            return;
        }

        info.removeAttr('style');
        applyClassString(info, dataTableClasses.info);

        paging.addClass('hidden').attr('aria-hidden', 'true');

        const footer = wrapper.children('.dt-footer').first();
        if (!footer.length || !table || typeof table.page !== 'function') {
            return;
        }

        let customPaging = footer.children('.dt-custom-paging').first();
        if (!customPaging.length) {
            customPaging = window.jQuery('<div class="dt-custom-paging"></div>');
            footer.append(customPaging);
        }

        customPaging.empty();
        applyClassString(customPaging, dataTableClasses.paging);

        const customPagingNav = window.jQuery('<div class="dt-custom-paging-nav"></div>');
        applyClassString(customPagingNav, dataTableClasses.pagingNav);

        const pageInfo = table.page.info();
        const totalPages = Number(pageInfo?.pages ?? 0);
        const currentPageIndex = Number(pageInfo?.page ?? 0);
        const currentPage = totalPages > 0 ? currentPageIndex + 1 : 1;
        const hasPrevious = currentPageIndex > 0;
        const hasNext = totalPages > 0 && currentPageIndex < totalPages - 1;
        const hasFirst = hasPrevious;
        const hasLast = hasNext;

        const firstButton = window.jQuery('<button type="button"></button>')
            .addClass(dataTableClasses.pageButton)
            .addClass(dataTableClasses.pageIconOnly)
            .attr('aria-label', dataTableTranslations.first)
            .attr('title', dataTableTranslations.first)
            .append(firstPageIconMarkup);

        if (!hasFirst) {
            firstButton.attr('disabled', 'disabled').addClass(dataTableClasses.pageDisabled);
        } else {
            firstButton.on('click.shadcnPaging', function (event) {
                event.preventDefault();
                table.page('first').draw('page');
            });
        }

        const previousButton = window.jQuery('<button type="button"></button>')
            .addClass(dataTableClasses.pageButton)
            .addClass(dataTableClasses.pagePrevNext)
            .attr('aria-label', dataTableTranslations.previous)
            .attr('title', dataTableTranslations.previous)
            .append(previousPageIconMarkup)
            .append('<span class="hidden sm:inline">' + dataTableTranslations.previous + '</span>');

        if (!hasPrevious) {
            previousButton.attr('disabled', 'disabled').addClass(dataTableClasses.pageDisabled);
        } else {
            previousButton.on('click.shadcnPaging', function (event) {
                event.preventDefault();
                table.page('previous').draw('page');
            });
        }

        const currentButton = window.jQuery('<button type="button" aria-current="page" disabled></button>')
            .addClass(dataTableClasses.pageButton)
            .addClass(dataTableClasses.pageNumber)
            .addClass(dataTableClasses.pageCurrent)
            .addClass(dataTableClasses.pageDisabled)
            .text(String(currentPage));

        const nextButton = window.jQuery('<button type="button"></button>')
            .addClass(dataTableClasses.pageButton)
            .addClass(dataTableClasses.pagePrevNext)
            .attr('aria-label', dataTableTranslations.next)
            .attr('title', dataTableTranslations.next)
            .append('<span class="hidden sm:inline">' + dataTableTranslations.next + '</span>')
            .append(nextPageIconMarkup);

        if (!hasNext) {
            nextButton.attr('disabled', 'disabled').addClass(dataTableClasses.pageDisabled);
        } else {
            nextButton.on('click.shadcnPaging', function (event) {
                event.preventDefault();
                table.page('next').draw('page');
            });
        }

        const lastButton = window.jQuery('<button type="button"></button>')
            .addClass(dataTableClasses.pageButton)
            .addClass(dataTableClasses.pageIconOnly)
            .attr('aria-label', dataTableTranslations.last)
            .attr('title', dataTableTranslations.last)
            .append(lastPageIconMarkup);

        if (!hasLast) {
            lastButton.attr('disabled', 'disabled').addClass(dataTableClasses.pageDisabled);
        } else {
            lastButton.on('click.shadcnPaging', function (event) {
                event.preventDefault();
                table.page('last').draw('page');
            });
        }

        customPagingNav.append(firstButton, previousButton, currentButton, nextButton, lastButton);
        customPaging.append(customPagingNav);
    };

    const ensureToolbar = function (wrapper, table, config) {
        if (wrapper.children('.dt-toolbar').length) {
            return;
        }

        wrapper.find('.dataTables_filter, .dataTables_length, .dt-search, .dt-length')
            .addClass(dataTableClasses.hiddenBuiltIn);

        let searchInput = wrapper.find(
            '.dt-search input[type="search"], .dataTables_filter input[type="search"]').first();

        if (searchInput.length) {
            searchInput = searchInput.detach();
        } else {
            searchInput = window.jQuery('<input type="search">');
        }

        searchInput
            .removeAttr('style')
            .attr('placeholder', config.placeholder)
            .addClass(dataTableClasses.searchInput)
            .off('input.shadcn')
            .on('input.shadcn', function () {
                table.search(this.value).draw();
                syncClearButtonVisibility();
            });

        const searchRoot = window.jQuery('<div class="dt-search-root"></div>').addClass(dataTableClasses
            .searchRoot);
        const clearButton = window.jQuery('<button type="button" class="dt-search-clear"></button>')
            .addClass(dataTableClasses.searchClearButton)
            .attr('aria-label', config.clearLabel)
            .attr('title', config.clearLabel)
            .append(searchClearIconMarkup)
            .append('<span class="sr-only">' + config.clearLabel + '</span>')
            .addClass('hidden');

        const syncClearButtonVisibility = function () {
            const searchValue = String(searchInput.val() ?? '').trim();

            clearButton.toggleClass('hidden', searchValue === '');
        };

        clearButton.on('click.shadcn', function (event) {
            event.preventDefault();
            searchInput.val('');
            table.search('').draw();
            syncClearButtonVisibility();
            searchInput.trigger('focus');
        });

        searchRoot.append(searchInput).append(clearButton);
        syncClearButtonVisibility();

        const toolbar = window.jQuery('<div class="dt-toolbar"></div>').addClass(dataTableClasses.toolbar);
        const columns = window.jQuery('<div class="dt-columns"></div>').addClass(dataTableClasses
            .columnsRoot);
        const columnsButton = window.jQuery('<button type="button" class="dt-columns-btn"></button>')
            .addClass(dataTableClasses.columnsButton)
            .append('<span>' + config.columnsLabel + '</span>')
            .append(
                '<svg class="size-4 text-muted-foreground" viewBox="0 0 24 24" fill="none" aria-hidden="true">' +
                '<path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
                '</svg>'
            );
        const columnsMenu = window.jQuery('<div class="dt-columns-menu hidden"></div>')
            .addClass(dataTableClasses.columnsMenu);

        columns.append(columnsButton);
        toolbar.append(searchRoot).append(columns);
        wrapper.prepend(toolbar);
        window.jQuery(document.body).append(columnsMenu);

        const containerId = (table.table().container().id || 'datatable').replace(/[^A-Za-z0-9_-]/g, '-');
        const menuEventNamespace = '.shadcnColumns' + containerId.replace(/[^A-Za-z0-9]/g, '');

        const closeColumnsMenu = function () {
            columnsMenu.addClass('hidden');
        };

        const positionColumnsMenu = function () {
            if (columnsMenu.hasClass('hidden') || !columnsButton.length || !columnsMenu.length) {
                return;
            }

            const buttonRect = columnsButton[0].getBoundingClientRect();
            const menuWidth = columnsMenu.outerWidth() || 176;
            const menuHeight = columnsMenu.outerHeight() || 200;
            const horizontalPadding = 8;
            const verticalPadding = 8;

            let left = buttonRect.right - menuWidth;
            left = Math.max(horizontalPadding, Math.min(left, window.innerWidth - menuWidth -
                horizontalPadding));

            let top = buttonRect.bottom + verticalPadding;
            if (top + menuHeight > window.innerHeight - verticalPadding) {
                top = buttonRect.top - menuHeight - verticalPadding;
            }
            top = Math.max(verticalPadding, top);

            columnsMenu.css({
                left: left + 'px',
                top: top + 'px',
            });
        };

        table.columns().every(function (index) {
            const header = window.jQuery(this.header());
            const title = header.find('.dt-column-title').first().text().trim() || header.text()
                .trim();

            if (!title) {
                return;
            }

            const checkboxId = containerId + '-column-' + index;
            const item = window.jQuery('<label for="' + checkboxId + '"></label>').addClass(
                dataTableClasses.columnsItem);
            const checkbox = window.jQuery(
                '<input type="checkbox" class="size-4 rounded border-input accent-primary">')
                .attr('id', checkboxId);
            const text = window.jQuery('<span></span>').text(title);

            checkbox.prop('checked', this.visible());
            checkbox.on('change.shadcn', () => {
                table.column(index).visible(checkbox.is(':checked'));
            });

            item.append(checkbox).append(text);
            columnsMenu.append(item);
        });

        columnsButton.on('click.shadcn', function (event) {
            event.preventDefault();
            event.stopPropagation();
            if (columnsMenu.hasClass('hidden')) {
                columnsMenu.removeClass('hidden');
                positionColumnsMenu();
                return;
            }

            closeColumnsMenu();
        });

        window.jQuery(document)
            .off('click' + menuEventNamespace)
            .on('click' + menuEventNamespace, function (event) {
                if (!columns.is(event.target) && columns.has(event.target).length === 0 && !columnsMenu
                    .is(event.target) && columnsMenu.has(event.target).length === 0) {
                    closeColumnsMenu();
                }
            });

        window.jQuery(window)
            .off('resize' + menuEventNamespace + ' scroll' + menuEventNamespace)
            .on('resize' + menuEventNamespace + ' scroll' + menuEventNamespace, function () {
                if (!columnsMenu.hasClass('hidden')) {
                    positionColumnsMenu();
                }
            });

        columnsMenu.on('click.shadcn', 'input[type="checkbox"], label', function () {
            window.setTimeout(function () {
                if (!columnsMenu.hasClass('hidden')) {
                    positionColumnsMenu();
                }
            }, 0);
        });

        wrapper.on('remove.shadcn' + menuEventNamespace, function () {
            closeColumnsMenu();
            columnsMenu.remove();
            window.jQuery(document).off('click' + menuEventNamespace);
            window.jQuery(window).off('resize' + menuEventNamespace + ' scroll' +
                menuEventNamespace);
        });
    };

    const ensureFooter = function (wrapper, table) {
        const allInfo = wrapper.find('.dataTables_info, .dt-info');
        const allPaging = wrapper.find('.dataTables_paginate, .dt-paging');
        const info = allInfo.last();
        const paging = allPaging.last();

        if (!info.length || !paging.length) {
            return;
        }

        let footer = wrapper.children('.dt-footer').first();

        if (!footer.length) {
            footer = window.jQuery('<div class="dt-footer"></div>').addClass(dataTableClasses.footer);
            wrapper.append(footer);
        } else {
            applyClassString(footer, dataTableClasses.footer);
        }

        if (!info.parent().is(footer)) {
            info.detach().appendTo(footer);
        }

        if (!paging.parent().is(footer)) {
            paging.detach().appendTo(footer);
        }

        allInfo.not(info).remove();
        allPaging.not(paging).remove();

        stylePagination(wrapper, table);
    };

    const setupShadcnDataTable = function (table, options = {}) {
        if (!table || typeof table.table !== 'function') {
            return;
        }

        const config = Object.assign({
            placeholder: dataTableTranslations.filterPlaceholder,
            clearLabel: dataTableTranslations.clear,
            columnsLabel: dataTableTranslations.columns,
        }, options);

        const wrapper = window.jQuery(table.table().container());

        if (!wrapper.length || wrapper.data('shadcn-ready')) {
            return;
        }

        applyClassString(wrapper, dataTableClasses.wrapper);
        hideBuiltInProcessing(wrapper);
        const frame = ensureFrame(wrapper);
        const loadingOverlay = ensureLoadingOverlay(frame);
        if (loadingOverlay) {
            table.on('preXhr.dt.shadcn', function () {
                frame.addClass('is-loading');
                loadingOverlay.removeClass('hidden').addClass('flex');
            });

            table.on('xhr.dt.shadcn error.dt.shadcn draw.dt.shadcn', function () {
                frame.removeClass('is-loading');
                loadingOverlay.removeClass('flex').addClass('hidden');
            });
        }

        ensureToolbar(wrapper, table, config);
        ensureFooter(wrapper, table);
        styleTable(wrapper);

        table.on('draw.dt.shadcnClasses', function () {
            hideBuiltInProcessing(wrapper);
            styleTable(wrapper);
            ensureFooter(wrapper, table);
            stylePagination(wrapper, table);
        });

        window.setTimeout(function () {
            hideBuiltInProcessing(wrapper);
            styleTable(wrapper);
            ensureFooter(wrapper, table);
            stylePagination(wrapper, table);
        }, 0);

        wrapper.data('shadcn-ready', true);
    };

    const applyShadcnTablePresentation = function (table) {
        if (!table || typeof table.table !== 'function') {
            return;
        }

        const wrapper = window.jQuery(table.table().container());

        if (!wrapper.length) {
            return;
        }

        hideBuiltInProcessing(wrapper);
        styleTable(wrapper);
        ensureFooter(wrapper, table);
        stylePagination(wrapper, table);
    };

    const queuePresentationPasses = function (table, passes = 8, delay = 70) {
        let remainingPasses = passes;

        const runPass = function () {
            applyShadcnTablePresentation(table);
            remainingPasses -= 1;

            if (remainingPasses > 0) {
                window.setTimeout(runPass, delay);
            }
        };

        runPass();
    };

    if (!window.setupShadcnDataTable) {
        window.setupShadcnDataTable = setupShadcnDataTable;
    }

    if (!window.initShadcnDataTables) {
        window.initShadcnDataTables = function (root = document) {
            if (typeof window.jQuery === 'undefined' || typeof window.jQuery.fn.DataTable === 'undefined') {
                return;
            }

            const $ = window.jQuery;

            $(root).find('table[data-datatable="1"]').each(function () {
                if ($.fn.dataTable.isDataTable(this)) {
                    return;
                }

                const ajaxUrl = this.getAttribute('data-ajax-url');
                const columnsRaw = this.getAttribute('data-columns');
                const placeholder = this.getAttribute('data-filter-placeholder') ||
                    dataTableTranslations.filterPlaceholder;

                if (!ajaxUrl || !columnsRaw) {
                    return;
                }

                let columns = [];

                try {
                    columns = JSON.parse(columnsRaw);
                } catch (error) {
                    columns = [];
                }

                if (!Array.isArray(columns) || columns.length === 0) {
                    return;
                }

                const existingLanguage = typeof defaultDataTableOptions.language === 'object' &&
                    defaultDataTableOptions.language !== null ?
                    defaultDataTableOptions.language : {};
                const existingPaginate = typeof existingLanguage.paginate === 'object' &&
                    existingLanguage.paginate !== null ?
                    existingLanguage.paginate : {};

                const options = Object.assign({}, defaultDataTableOptions, {
                    ajax: ajaxUrl,
                    columns: columns,
                    language: Object.assign({}, existingLanguage, {
                        info: dataTableTranslations.info,
                        infoEmpty: dataTableTranslations.infoEmpty,
                        zeroRecords: dataTableTranslations.zeroRecords,
                        emptyTable: dataTableTranslations.emptyTable,
                        processing: dataTableProcessingMarkup,
                        loadingRecords: dataTableTranslations.loadingRecords,
                        paginate: Object.assign({}, existingPaginate, {
                            previous: dataTableTranslations.previous,
                            next: dataTableTranslations.next,
                        }),
                    }),
                });

                const existingInitComplete = options.initComplete;
                options.initComplete = function (settings, json) {
                    if (typeof existingInitComplete === 'function') {
                        existingInitComplete.call(this, settings, json);
                    }

                    const api = new $.fn.dataTable.Api(settings);

                    window.setupShadcnDataTable(api, {
                        placeholder: placeholder,
                        columnsLabel: dataTableTranslations.columns,
                    });

                    queuePresentationPasses(api);
                };

                const existingDrawCallback = options.drawCallback;
                options.drawCallback = function (settings) {
                    if (typeof existingDrawCallback === 'function') {
                        existingDrawCallback.call(this, settings);
                    }

                    const api = new $.fn.dataTable.Api(settings);

                    queuePresentationPasses(api, 3, 50);
                };

                if (!options.pagingType && !(options.paging && options.paging.type)) {
                    options.pagingType = 'simple_numbers';
                }

                if (typeof options.scrollX === 'undefined') {
                    options.scrollX = false;
                }
                options.processing = false;

                const table = $(this).DataTable(options);

                window.setupShadcnDataTable(table, {
                    placeholder: placeholder,
                    columnsLabel: dataTableTranslations.columns,
                });

                queuePresentationPasses(table);
            });
        };
    }

    document.addEventListener('DOMContentLoaded', function () {
        window.initShadcnDataTables?.();
    });
})
    ();
