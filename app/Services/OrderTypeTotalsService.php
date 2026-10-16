<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\StoreOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class OrderTypeTotalsService
{
    /** Shared eligibility rules for the receivable card and pending-payment table. */
    public function filterReceivableOrders(QueryBuilder $query): QueryBuilder
    {
        $query->where('o.order_status_id', 3)
            ->whereNotIn('o.organization_id', [1377, 2890]) // Encore Inventory, Test Organization
            ->whereRaw('COALESCE(org.internal_team, 0) = 0');
        return $this->filterTypes($query, ['bulk', 'wl']);
    }

    public function receivables(QueryBuilder $payments): array
    {
        $paid = DB::query()->fromSub($payments, 'receipts')->selectRaw('order_id, SUM(amount) as received_amount')->groupBy('order_id');
        $query = DB::table((new \App\Models\Order)->getTable() . ' as o')
            ->leftJoin((new Organization)->getTable() . ' as org', 'org.id', '=', 'o.organization_id')
            ->leftJoinSub($paid, 'p', 'p.order_id', '=', 'o.id')
            ->where('o.order_status_id', 3)
            ->whereRaw('o.order_total > COALESCE(p.received_amount, 0)');
        $rows = $this->filterReceivableOrders($query)
            ->selectRaw($this->typeExpression() . ' as order_category, COUNT(*) as order_count, SUM(o.order_total - COALESCE(p.received_amount, 0)) as amount')
            ->groupBy('order_category')->get();
        $types = array_fill_keys(['bulk', 'wl'], ['count' => 0, 'amount' => 0.0]);
        foreach ($rows as $row) {
            $types[$row->order_category] = ['count' => (int) $row->order_count, 'amount' => round((float) $row->amount, 2)];
        }
        return ['types' => $types, 'count' => array_sum(array_column($types, 'count')), 'total' => round(array_sum(array_column($types, 'amount')), 2)];
    }

    public const TYPES = ['tsr', 'bulk', 'internal', 'wl'];

    // Internal takes precedence over TSR and WL so each order contributes exactly once.
    private function typeExpression(): string
    {
        return "CASE WHEN COALESCE(org.internal_team, 0) = 1 THEN 'internal'
            WHEN o.order_no LIKE 'TSR%' THEN 'tsr'
            WHEN COALESCE(o.plorder, 0) = 1 THEN 'wl' ELSE 'bulk' END";
    }

    /** Apply to an order query using aliases o (orders) and org (organizations). */
    public function filterTypes(QueryBuilder $query, array $types): QueryBuilder
    {
        if (!$types || array_diff($types, self::TYPES)) {
            throw new InvalidArgumentException('Unknown order type.');
        }
        $placeholders = implode(', ', array_fill(0, count($types), '?'));
        return $query->whereRaw('(' . $this->typeExpression() . ") IN ($placeholders)", $types);
    }

    /** Aggregate any filtered Order query without loading individual orders. */
    public function summarize(Builder $orders, array $types = self::TYPES): array
    {
        $source = (clone $orders)->reorder()->select(['id', 'organization_id', 'order_no', 'plorder', 'order_total'])->toBase();
        // Aggregate first: joining individual purchases would multiply the order count.
        // Saved checkout totals preserve each store's selling price and invoice adjustments.
        $storeTotals = DB::table((new StoreOrder)->getTable())
            ->whereNotNull('system_order_no')
            ->selectRaw('system_order_no, SUM(CASE WHEN active = 1 AND is_payment_success = 1 THEN COALESCE(total, 0) ELSE 0 END) as total')
            ->groupBy('system_order_no');
        $query = DB::query()->fromSub($source, 'o')
            ->leftJoin((new Organization)->getTable() . ' as org', 'org.id', '=', 'o.organization_id')
            ->leftJoinSub($storeTotals, 'store_totals', 'store_totals.system_order_no', '=', 'o.order_no');
        // Legacy TSR orders without linked purchases retain their recorded order total.
        $amount = "CASE WHEN o.order_no LIKE 'TSR%' THEN COALESCE(store_totals.total, o.order_total) ELSE o.order_total END";
        $rows = $this->filterTypes($query, $types)
            ->selectRaw($this->typeExpression() . " as order_category, COUNT(*) as order_count, COALESCE(SUM($amount), 0) as amount")
            ->groupBy('order_category')->get();
        $breakdown = array_fill_keys($types, ['count' => 0, 'amount' => 0.0]);
        foreach ($rows as $row) {
            $breakdown[$row->order_category] = ['count' => (int) $row->order_count, 'amount' => round((float) $row->amount, 2)];
        }
        return ['types' => $breakdown, 'count' => array_sum(array_column($breakdown, 'count')),
            'total' => round(array_sum(array_column($breakdown, 'amount')), 2)];
    }
}
