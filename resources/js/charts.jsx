import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import {
    Area,
    AreaChart,
    CartesianGrid,
    XAxis,
    RadialBar,
    RadialBarChart,
    Radar,
    RadarChart,
    PolarGrid,
    Tooltip,
    Legend,
    PolarAngleAxis,
} from 'recharts';
import { TrendingUp } from 'lucide-react';

// ============================================================================
// Chart Tooltip Component (mimics shadcn ChartTooltipContent)
// ============================================================================
function ChartTooltipContent({ active, payload, hideLabel = false, nameKey = 'name', labelFormatter }) {
    if (!active || !payload?.length) return null;

    return (
        <div className="rounded-lg border bg-background p-2 shadow-md text-sm">
            {!hideLabel && payload[0]?.payload && (
                <p className="font-medium mb-1">
                    {labelFormatter ? labelFormatter(payload[0].payload[nameKey]) : payload[0].payload[nameKey]}
                </p>
            )}
            {payload.map((entry, index) => (
                <div key={index} className="flex items-center gap-2">
                    <span
                        className="h-2.5 w-2.5 rounded-[2px]"
                        style={{ backgroundColor: entry.payload?.fill || entry.color }}
                    />
                    <span className="text-muted-foreground">{entry.payload?.[nameKey] || entry.name}:</span>
                    <span className="font-medium">{entry.value?.toLocaleString()}</span>
                </div>
            ))}
        </div>
    );
}

// ============================================================================
// Area Chart - Interactive (chart only, header handled by Blade)
// ============================================================================
function AreaChartInteractive({ data = [], timeRange = '90d' }) {
    const filteredData = data.filter((item) => {
        const date = new Date(item.date);
        const referenceDate = data.length > 0 ? new Date(data[data.length - 1].date) : new Date();
        let daysToSubtract = 90;
        if (timeRange === '30d') daysToSubtract = 30;
        else if (timeRange === '7d') daysToSubtract = 7;
        const startDate = new Date(referenceDate);
        startDate.setDate(startDate.getDate() - daysToSubtract);
        return date >= startDate;
    });

    const [dimensions, setDimensions] = React.useState({ width: 0, height: 0 });
    const containerRef = React.useRef(null);

    React.useEffect(() => {
        const updateDimensions = () => {
            if (containerRef.current) {
                const { width, height } = containerRef.current.getBoundingClientRect();
                if (width > 0 && height > 0) {
                    setDimensions({ width, height });
                }
            }
        };
        updateDimensions();
        window.addEventListener('resize', updateDimensions);
        return () => window.removeEventListener('resize', updateDimensions);
    }, []);

    return (
        <div ref={containerRef} style={{ width: '100%', height: '100%' }}>
            {dimensions.width > 0 && dimensions.height > 0 && (
                <AreaChart data={filteredData} width={dimensions.width} height={dimensions.height}>
                    <defs>
                        <linearGradient id="fillDesktop" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="5%" stopColor="hsl(199, 89%, 48%)" stopOpacity={0.8} />
                            <stop offset="95%" stopColor="hsl(199, 89%, 48%)" stopOpacity={0.1} />
                        </linearGradient>
                        <linearGradient id="fillMobile" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="5%" stopColor="hsl(221, 83%, 53%)" stopOpacity={0.8} />
                            <stop offset="95%" stopColor="hsl(221, 83%, 53%)" stopOpacity={0.1} />
                        </linearGradient>
                    </defs>
                    <CartesianGrid vertical={false} stroke="hsl(214, 32%, 91%)" />
                    <XAxis
                        dataKey="date"
                        tickLine={false}
                        axisLine={false}
                        tickMargin={8}
                        minTickGap={32}
                        tick={{ fontSize: 12, fill: 'hsl(215, 16%, 47%)' }}
                        tickFormatter={(value) => {
                            const date = new Date(value);
                            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                        }}
                    />
                    <Tooltip
                        cursor={false}
                        content={({ active, payload, label }) => {
                            if (!active || !payload?.length) return null;
                            return (
                                <div className="rounded-lg border bg-background p-2 shadow-md text-sm">
                                    <p className="font-medium mb-1">
                                        {new Date(label).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })}
                                    </p>
                                    {payload.map((entry, index) => (
                                        <div key={index} className="flex items-center gap-2">
                                            <span className="h-2.5 w-2.5 rounded-full" style={{ backgroundColor: entry.color }} />
                                            <span className="text-muted-foreground">{entry.name}:</span>
                                            <span className="font-medium">{entry.value}</span>
                                        </div>
                                    ))}
                                </div>
                            );
                        }}
                    />
                    <Area
                        name="Login"
                        dataKey="login"
                        type="natural"
                        fill="url(#fillMobile)"
                        stroke="hsl(221, 83%, 53%)"
                        strokeWidth={2}
                        stackId="a"
                    />
                    <Area
                        name="Logout"
                        dataKey="logout"
                        type="natural"
                        fill="url(#fillDesktop)"
                        stroke="hsl(199, 89%, 48%)"
                        strokeWidth={2}
                        stackId="a"
                    />
                    <Legend
                        verticalAlign="bottom"
                        height={36}
                        content={({ payload }) => (
                            <div className="flex justify-center gap-4 pt-4">
                                {payload?.map((entry, index) => (
                                    <div key={index} className="flex items-center gap-2 text-sm">
                                        <span className="h-3 w-3 rounded-sm" style={{ backgroundColor: entry.color }} />
                                        <span>{entry.value}</span>
                                    </div>
                                ))}
                            </div>
                        )}
                    />
                </AreaChart>
            )}
        </div>
    );
}

// ============================================================================
// Radial Chart - Simple
// ============================================================================
function RadialChartSimple({ data = [], title = 'Radial Chart', description = '', footerTrend = '', footerDescription = '' }) {
    const colors = [
        'hsl(221, 83%, 33%)',
        'hsl(212, 95%, 40%)',
        'hsl(217, 91%, 50%)',
        'hsl(213, 94%, 58%)',
        'hsl(199, 89%, 68%)',
    ];

    const chartData = data.length > 0
        ? data.map((item, index) => {
            const rawValue = item.users ?? item.value ?? item.visitors ?? 0;
            const normalizedValue = Number.isFinite(Number(rawValue)) ? Number(rawValue) : 0;

            return {
                name: item.role || item.name,
                visitors: normalizedValue,
                fill: colors[index % colors.length],
            };
        })
        : [
            { name: 'Chrome', visitors: 275, fill: colors[0] },
            { name: 'Safari', visitors: 200, fill: colors[1] },
            { name: 'Firefox', visitors: 187, fill: colors[2] },
            { name: 'Edge', visitors: 173, fill: colors[3] },
            { name: 'Other', visitors: 90, fill: colors[4] },
        ];

    const maxValue = Math.max(1, ...chartData.map((item) => item.visitors));
    const isUniformMax = chartData.every((item) => item.visitors === maxValue);

    return (
        <div className="flex flex-col rounded-xl border bg-card text-card-foreground shadow h-full">
            <div className="flex flex-col space-y-1.5 p-6 items-center pb-0">
                <h3 className="font-semibold leading-none tracking-tight">{title}</h3>
                {description && <p className="text-sm text-muted-foreground">{description}</p>}
            </div>
            <div className="flex-1 p-6 pb-0 flex items-center justify-center">
                <RadialBarChart
                    data={chartData}
                    width={250}
                    height={250}
                    innerRadius={30}
                    outerRadius={110}
                    startAngle={90}
                    endAngle={-270}
                >
                    <PolarAngleAxis
                        type="number"
                        domain={[0, maxValue]}
                        angleAxisId={0}
                        tick={false}
                    />
                    <Tooltip
                        cursor={false}
                        content={({ active, payload }) => {
                            if (!active || !payload?.length) return null;
                            const data = payload[0]?.payload;
                            return (
                                <div className="rounded-lg border bg-background px-3 py-2 shadow-md text-sm">
                                    <div className="flex items-center gap-2">
                                        <span
                                            className="h-2.5 w-2.5 rounded-[2px]"
                                            style={{ backgroundColor: data?.fill }}
                                        />
                                        <span className="font-medium">{data?.name}:</span>
                                        <span>{data?.visitors?.toLocaleString()}</span>
                                    </div>
                                </div>
                            );
                        }}
                    />
                    <RadialBar
                        background={{ fill: 'hsl(214, 32%, 91%)' }}
                        dataKey="visitors"
                        angleAxisId={0}
                        cornerRadius={isUniformMax ? 0 : 10}
                    />
                </RadialBarChart>
            </div>
            <div className="flex flex-col items-center gap-2 p-6 pt-0 text-sm">
                {footerTrend && (
                    <div className="flex items-center gap-2 font-medium leading-none">
                        {footerTrend} <TrendingUp className="h-4 w-4" />
                    </div>
                )}
                {footerDescription && (
                    <div className="leading-none text-muted-foreground">
                        {footerDescription}
                    </div>
                )}
            </div>
        </div>
    );
}

// ============================================================================
// Radial Chart - Grid
// ============================================================================
function RadialChartGrid({ data = [], title = 'Radial Chart - Grid', description = '', footerTrend = '', footerDescription = '' }) {
    const colors = [
        'hsl(221, 83%, 33%)',
        'hsl(212, 95%, 40%)',
        'hsl(217, 91%, 50%)',
        'hsl(213, 94%, 58%)',
        'hsl(199, 89%, 68%)',
    ];

    const chartData = data.length > 0
        ? data.map((item, index) => {
            const rawValue = item.users ?? item.value ?? item.visitors ?? 0;
            const normalizedValue = Number.isFinite(Number(rawValue)) ? Number(rawValue) : 0;

            return {
                name: item.role || item.name,
                visitors: normalizedValue,
                fill: colors[index % colors.length],
            };
        })
        : [
            { name: 'Chrome', visitors: 275, fill: colors[0] },
            { name: 'Safari', visitors: 200, fill: colors[1] },
            { name: 'Firefox', visitors: 187, fill: colors[2] },
            { name: 'Edge', visitors: 173, fill: colors[3] },
            { name: 'Other', visitors: 90, fill: colors[4] },
        ];

    const maxValue = Math.max(1, ...chartData.map((item) => item.visitors));
    const isUniformMax = chartData.every((item) => item.visitors === maxValue);

    return (
        <div className="flex flex-col rounded-xl border bg-card text-card-foreground shadow h-full">
            <div className="flex flex-col space-y-1.5 p-6 items-center pb-0">
                <h3 className="font-semibold leading-none tracking-tight">{title}</h3>
                {description && <p className="text-sm text-muted-foreground">{description}</p>}
            </div>
            <div className="flex-1 p-6 pb-0 flex items-center justify-center">
                <RadialBarChart
                    data={chartData}
                    width={250}
                    height={250}
                    innerRadius={30}
                    outerRadius={100}
                    startAngle={90}
                    endAngle={-270}
                >
                    <PolarAngleAxis
                        type="number"
                        domain={[0, maxValue]}
                        angleAxisId={0}
                        tick={false}
                    />
                    <PolarGrid gridType="circle" />
                    <Tooltip
                        cursor={false}
                        content={({ active, payload }) => {
                            if (!active || !payload?.length) return null;
                            const data = payload[0]?.payload;
                            return (
                                <div className="rounded-lg border bg-background px-3 py-2 shadow-md text-sm">
                                    <div className="flex items-center gap-2">
                                        <span
                                            className="h-2.5 w-2.5 rounded-[2px]"
                                            style={{ backgroundColor: data?.fill }}
                                        />
                                        <span className="font-medium">{data?.name}:</span>
                                        <span>{data?.visitors?.toLocaleString()}</span>
                                    </div>
                                </div>
                            );
                        }}
                    />
                    <RadialBar
                        dataKey="visitors"
                        angleAxisId={0}
                        cornerRadius={isUniformMax ? 0 : 10}
                    />
                </RadialBarChart>
            </div>
            <div className="flex flex-col items-center gap-2 p-6 pt-0 text-sm">
                {footerTrend && (
                    <div className="flex items-center gap-2 font-medium leading-none">
                        {footerTrend} <TrendingUp className="h-4 w-4" />
                    </div>
                )}
                {footerDescription && (
                    <div className="leading-none text-muted-foreground">
                        {footerDescription}
                    </div>
                )}
            </div>
        </div>
    );
}

// ============================================================================
// Radar Chart - Dots
// ============================================================================
function RadarChartDots({
    data = [],
    title = 'Radar Chart - Dots',
    description = '',
    footerTrend = '',
    footerDescription = '',
    seriesLabel = 'Logins',
}) {
    const chartData = data.length > 0
        ? data.map((item) => {
            const rawValue = item.desktop ?? item.value ?? 0;
            const normalizedValue = Number.isFinite(Number(rawValue)) ? Number(rawValue) : 0;

            return {
                month: item.month || '',
                desktop: normalizedValue,
            };
        })
        : [
            { month: 'January', desktop: 186 },
            { month: 'February', desktop: 305 },
            { month: 'March', desktop: 237 },
            { month: 'April', desktop: 273 },
            { month: 'May', desktop: 209 },
            { month: 'June', desktop: 214 },
        ];

    const hasFooterTrend = footerTrend.trim() !== '';
    const [dimensions, setDimensions] = React.useState({ width: 0, height: 0 });
    const chartContainerRef = React.useRef(null);

    React.useEffect(() => {
        const updateDimensions = () => {
            if (chartContainerRef.current) {
                const { width, height } = chartContainerRef.current.getBoundingClientRect();
                if (width > 0 && height > 0) {
                    setDimensions({ width, height });
                }
            }
        };

        updateDimensions();
        window.addEventListener('resize', updateDimensions);

        return () => {
            window.removeEventListener('resize', updateDimensions);
        };
    }, []);

    return (
        <div className="flex flex-col rounded-xl border bg-card text-card-foreground shadow h-full">
            <div className="flex flex-col space-y-1.5 p-6 items-center text-center">
                <h3 className="font-semibold leading-none tracking-tight">{title}</h3>
                {description && <p className="text-sm text-muted-foreground">{description}</p>}
            </div>
            <div className="overflow-visible px-2 pb-0 sm:px-4">
                <div
                    ref={chartContainerRef}
                    className="mx-auto h-[280px] w-full max-w-[380px] overflow-visible sm:h-[320px]"
                >
                    {dimensions.width > 0 && dimensions.height > 0 && (
                        <RadarChart
                            data={chartData}
                            width={dimensions.width}
                            height={dimensions.height}
                            margin={{
                                top: 28,
                                right: 56,
                                bottom: 28,
                                left: 56,
                            }}
                        >
                            <Tooltip
                                cursor={false}
                                content={({ active, payload }) => (
                                    <ChartTooltipContent active={active} payload={payload} nameKey="month" />
                                )}
                            />
                            <PolarAngleAxis
                                dataKey="month"
                                tickLine={false}
                                axisLine={false}
                                tick={{ fontSize: 12, fill: 'hsl(215, 16%, 47%)' }}
                            />
                            <PolarGrid />
                            <Radar
                                name={seriesLabel}
                                dataKey="desktop"
                                stroke="hsl(221, 83%, 53%)"
                                fill="hsl(221, 83%, 53%)"
                                fillOpacity={0.6}
                                dot={{
                                    r: 4,
                                    fill: 'hsl(221, 83%, 53%)',
                                    fillOpacity: 1,
                                }}
                            />
                        </RadarChart>
                    )}
                </div>
            </div>
            <div className="flex flex-col items-center gap-2 p-6 pt-4 text-sm">
                {hasFooterTrend && (
                    <div className="flex items-center gap-2 font-medium leading-snug text-center">
                        {footerTrend} <TrendingUp className="h-4 w-4" />
                    </div>
                )}
                {footerDescription && (
                    <div className="text-muted-foreground flex items-center gap-2 text-center leading-snug">
                        {footerDescription}
                    </div>
                )}
            </div>
        </div>
    );
}

// ============================================================================
// Mount Charts
// ============================================================================

// Store roots for re-rendering
const areaChartRoots = new Map();

window.__renderAreaChart = function (el, data, timeRange) {
    let root = areaChartRoots.get(el);
    if (!root) {
        root = createRoot(el);
        areaChartRoots.set(el, root);
    }
    root.render(<AreaChartInteractive data={data} timeRange={timeRange} />);
};

document.querySelectorAll('[data-react-area-chart]').forEach((el) => {
    // Only auto-mount if not controlled by Alpine
    if (!el.closest('[x-data]')) {
        const data = JSON.parse(el.dataset.chartData || '[]');
        window.__renderAreaChart(el, data, '90d');
    }
});

document.querySelectorAll('[data-react-radial-chart]').forEach((el) => {
    const data = JSON.parse(el.dataset.chartData || '[]');
    const showGrid = el.dataset.showGrid === 'true';
    const title = el.dataset.title || 'Radial Chart';
    const description = el.dataset.description || '';
    const footerTrend = el.dataset.footerTrend || '';
    const footerDescription = el.dataset.footerDescription || '';

    // Wait for next frame to ensure container has dimensions
    requestAnimationFrame(() => {
        if (showGrid) {
            createRoot(el).render(<RadialChartGrid data={data} title={title} description={description} footerTrend={footerTrend} footerDescription={footerDescription} />);
        } else {
            createRoot(el).render(<RadialChartSimple data={data} title={title} description={description} footerTrend={footerTrend} footerDescription={footerDescription} />);
        }
    });
});

document.querySelectorAll('[data-react-radar-dots-chart]').forEach((el) => {
    const data = JSON.parse(el.dataset.chartData || '[]');
    const title = el.dataset.title || 'Radar Chart - Dots';
    const description = el.dataset.description || '';
    const footerTrend = el.dataset.footerTrend || '';
    const footerDescription = el.dataset.footerDescription || '';
    const seriesLabel = el.dataset.seriesLabel || 'Logins';

    requestAnimationFrame(() => {
        createRoot(el).render(
            <RadarChartDots
                data={data}
                title={title}
                description={description}
                footerTrend={footerTrend}
                footerDescription={footerDescription}
                seriesLabel={seriesLabel}
            />
        );
    });
});

// Notify Alpine that charts are ready
document.dispatchEvent(new CustomEvent('charts:ready'));
