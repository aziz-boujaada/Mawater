<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListingQueryService
{
    public static function apply(Builder $query, Request $request, array $config = []): Builder
    {
        self::applySearch($query, $request->query('search'), $config);
        self::applyExactFilters($query, $request, $config);
        self::applyDateFilters($query, $request, $config);
        self::applyAmountFilters($query, $request, $config);

        return $query;
    }

    private static function applySearch(Builder $query, mixed $rawSearch, array $config): void
    {
        $search = trim((string) $rawSearch);

        if ($search === '') {
            return;
        }

        $searchColumns = $config['search'] ?? [];
        $searchRelations = $config['relations'] ?? [];

        if ($searchColumns === [] && $searchRelations === []) {
            return;
        }

        $needle = '%' . Str::lower($search) . '%';

        $query->where(function (Builder $group) use ($searchColumns, $searchRelations, $needle) {
            foreach ($searchColumns as $column) {
                $group->orWhereRaw('LOWER(' . $column . ') LIKE ?', [$needle]);
            }

            foreach ($searchRelations as $relation => $columns) {
                $group->orWhereHas($relation, function (Builder $relationQuery) use ($columns, $needle) {
                    $relationQuery->where(function (Builder $relatedGroup) use ($columns, $needle) {
                        foreach ($columns as $column) {
                            $relatedGroup->orWhereRaw('LOWER(' . $column . ') LIKE ?', [$needle]);
                        }
                    });
                });
            }
        });
    }

    private static function applyExactFilters(Builder $query, Request $request, array $config): void
    {
        foreach (($config['exact'] ?? []) as $requestKey => $column) {
            $value = $request->query($requestKey);

            if ($value === null || $value === '') {
                continue;
            }

            $query->where($column, $value);
        }
    }

    private static function applyDateFilters(Builder $query, Request $request, array $config): void
    {
        $dateField = $config['date_field'] ?? null;

        if ($dateField === null) {
            return;
        }

        $dateRange = $request->query('date_range');
        if (filled($dateRange)) {
            self::applyPresetDateRange($query, $dateField, (string) $dateRange);
        }

        $from = $request->query('from');
        $to = $request->query('to');

        if (filled($from)) {
            $query->whereDate($dateField, '>=', $from);
        }

        if (filled($to)) {
            $query->whereDate($dateField, '<=', $to);
        }
    }

    private static function applyAmountFilters(Builder $query, Request $request, array $config): void
    {
        $amountField = $config['amount_field'] ?? null;

        if ($amountField === null) {
            return;
        }

        $minAmount = $request->query('min_amount');
        $maxAmount = $request->query('max_amount');

        if (filled($minAmount)) {
            $query->where($amountField, '>=', $minAmount);
        }

        if (filled($maxAmount)) {
            $query->where($amountField, '<=', $maxAmount);
        }
    }

    private static function applyPresetDateRange(Builder $query, string $dateField, string $range): void
    {
        $now = Carbon::now();

        match ($range) {
            'today' => $query->whereDate($dateField, $now->toDateString()),
            'week' => $query->whereBetween($dateField, [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]),
            'month' => $query->whereBetween($dateField, [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()]),
            'year' => $query->whereBetween($dateField, [$now->copy()->startOfYear(), $now->copy()->endOfYear()]),
            'custom' => null,
            default => null,
        };
    }
}