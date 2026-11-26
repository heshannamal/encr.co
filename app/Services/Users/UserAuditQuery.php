<?php

namespace App\Services\Users;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

final class UserAuditQuery
{
    public function filters(Request $request): array
    {
        $start = Carbon::now()->subMonth()->format('Y-m-d');
        $end = Carbon::now()->format('Y-m-d');

        if ($request->filled(['std', 'end'])) {
            $start = Carbon::parse($request->input('std'))->format('Y-m-d');
            $end = Carbon::parse($request->input('end'))->format('Y-m-d');
        }

        return [
            'std' => $start,
            'end' => $end,
            'userId' => $request->input('user_id') ?? '',
            'sr_text' => $request->input('sr_text') ?? '',
            'sr_event' => $request->input('sr_event') ?? '',
            'sr_module' => $request->input('sr_module') ?? '',
            'sr_id' => $request->input('sr_id') ?? '',
            'sr_update' => $request->input('sr_update') ?? '',
        ];
    }

    public function build(array $filters): Builder
    {
        $query = Audit::query();

        if ($filters['userId'] !== '') {
            if ($filters['userId'] === 'customer') {
                $query->whereNull('user_id');
            } else {
                $query->where('user_id', $filters['userId']);
            }
        }

        foreach (['sr_event' => 'event', 'sr_module' => 'auditable_type', 'sr_id' => 'auditable_id'] as $filter => $column) {
            if ($filters[$filter] !== '') {
                $query->where($column, $filters[$filter]);
            }
        }

        if ($filters['sr_text'] !== '') {
            $query->where('source', 'LIKE', '%'.$filters['sr_text'].'%');
        }

        if ($filters['sr_update'] !== '') {
            $query->where('old_values', 'LIKE', '%'.str_replace(' ', '_', $filters['sr_update']).'%');
        }

        return $query->whereBetween('created_at', [
            $filters['std'].' 00:00:00',
            $filters['end'].' 23:59:59',
        ]);
    }
}
