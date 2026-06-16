<?php

namespace App\Support;

use Carbon\Carbon;

class DashboardFilter
{
    public static function apply($query, ?array $filters = null)
    {
        $filters ??= [];

        if (! empty($filters['accountId'])) {
            $query->where(
                'account_id',
                $filters['accountId']
            );
        }

        if (! empty($filters['transactionType'])) {
            $query->where(
                'type',
                $filters['transactionType']
            );
        }

        $period = $filters['period'] ?? 'today';

        switch ($period) {

            case 'today':
                $query->whereDate(
                    'transaction_date',
                    today()
                );
                break;

            case 'week':
                $query->whereBetween(
                    'transaction_date',
                    [
                        now()->startOfWeek(),
                        now()->endOfWeek(),
                    ]
                );
                break;

            case 'month':
                $query->whereMonth(
                    'transaction_date',
                    now()->month
                )->whereYear(
                    'transaction_date',
                    now()->year
                );
                break;

            case 'year':
                $query->whereYear(
                    'transaction_date',
                    now()->year
                );
                break;

            case 'custom':

                if (
                    ! empty($filters['startDate'])
                    && ! empty($filters['endDate'])
                ) {
                    $query->whereBetween(
                        'transaction_date',
                        [
                            Carbon::parse($filters['startDate'])->startOfDay(),
                            Carbon::parse($filters['endDate'])->endOfDay(),
                        ]
                    );
                }

                break;
        }

        return $query;
    }
}