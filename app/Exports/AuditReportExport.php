<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use OwenIt\Auditing\Models\Audit;

class AuditReportExport implements FromView
{
    private $std;
    private $end;
    private $user_id;
    private $sr_text;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    public function __construct($std, $end, $user_id, $sr_text)
    {
        $this->std = $std;
        $this->end = $end;
        $this->user_id = $user_id;
        $this->sr_text = $sr_text;
    }
    public function view(): View
    {
        $auditQry = Audit::query();
        if($this->user_id != '') {
            $auditQry->where('user_id', $this->user_id);
        }
        $srText = $this->sr_text;
        if($srText != '') {
            $auditQry->where(function ($qr) use($srText) { $qr->where('event', 'LIKE', '%'.$srText.'%')
                                                                ->orWhere('auditable_type', 'LIKE', '%'.$srText.'%')
                                                                ->orWhere('auditable_id', 'LIKE', '%'.$srText.'%')
                                                                ->orWhere('source', 'LIKE', '%'.$srText.'%');});
        }
        $auditQry->whereBetween('created_at', [$this->std." 00:00:00", $this->end." 23:59:59"]);
        $audits = $auditQry->orderBy('created_at', 'ASC')->get();

        return view('exports.customerlog_report', ['audits'=>$audits]);
        // return view('pages.order_management.order_quotation.order_item_csv', [
        //     'order'=>$order, 'orderItem'=>$orderItem, 'blackQty'=>$blackQty, 'numQty'=>$numQty
        // ]);

    }
}
