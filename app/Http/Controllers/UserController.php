<?php

namespace App\Http\Controllers;

use App\Exports\UserLogExport;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use OwenIt\Auditing\Contracts\Auditable;
class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $orderValues = Order::select('id','invoice_no')->get();

        // $usHolidays = OrderItem::select('date')->where('active', '1')->get();

        return view('users.index',['orderValues'=>$orderValues]);
    }

    public function user_log(Request $request)
    {
        // dd($request->all());
        if(auth()->user()->can('view user logs')){
            $users = User::all();
            $service = app(\App\Services\Users\UserAuditQuery::class);
            $filters = $service->filters($request);
            $audits = $service->build($filters)->orderBy('created_at', 'DESC')->paginate(50)->withQueryString();

            $auditableModels = [];

            $modelsPath = app_path('Models'); // adjust if your models are somewhere else
            $files = File::allFiles($modelsPath);

            foreach ($files as $file) {
                $path = $file->getRealPath();
                $class = 'App\\Models\\' . str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());

                if (class_exists($class) && in_array(Auditable::class, class_implements($class))) {
                    $auditableModels[] = $class;
                }
            }

            return view('pages.user_log.index', array_merge($filters, compact('users', 'auditableModels', 'audits')));
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function getLogDetail($id, $type)
    {
        $this->authorize('view user logs');
        $audits = Audit::findOrFail($id)->getModified();
        return view('pages.user_log.partials.view', compact('audits', 'type'));
        // return json_encode($audits);
    }

    public function user_log_export(Request $request)
    {
        $this->authorize('view user logs');

        $service = app(\App\Services\Users\UserAuditQuery::class);
        $audits = $service->build($service->filters($request))->orderBy('created_at', 'ASC')->get();

        return Excel::download(new UserLogExport($audits), 'Customer_Log_Report.xlsx');

    }

    public function deleteLogDetail(Request $request)
    {
        if(auth()->user()->can('delete user logs')){

            try {
                $actionType = $request->action_type;

                if($actionType == 'selected'){
                    Audit::whereIn('id', $request->audit_ids)->delete();
                } elseif($actionType == 'filtered') {
                    $auditQry = Audit::query();
                    if(isset($request->user_id) && $request->user_id != '') {
                        $auditQry->where('user_id', $request->user_id);
                    }
                    if(isset($request->search_text) && $request->search_text != '') {
                        $auditQry->where(function ($qr) use($request) { $qr->where('event', 'LIKE', '%'.$request->search_text.'%')
                                                                            ->orWhere('auditable_type', 'LIKE', '%'.$request->search_text.'%')
                                                                            ->orWhere('auditable_id', 'LIKE', '%'.$request->search_text.'%')
                                                                            ->orWhere('source', 'LIKE', '%'.$request->search_text.'%');});
                    }
                    $auditQry->whereBetween('created_at', [$request->start_date." 00:00:00", $request->end_date." 23:59:59"])->delete();
                }
                return json_encode(['response'=>'success', 'title'=>'Success!', 'message'=>'Audits Have Been Deleted Successfully!']);
            } catch (\Throwable $th) {
                return json_encode(['response'=>'error', 'title'=>'Error!', 'message'=>$th->getMessage()]);
                //throw $th;
            }

        } else {
            return json_encode(['response'=>'error', 'title'=>'Error!', 'message'=>'Permission Not Granted!']);
        }

    }
    public function impersonateUser($userId)
    {
        $actor = auth()->user();
        abort_unless($actor && $actor->isAdmin() && (int) $actor->active === 1, 403);
        abort_if(session()->has('original_user_id'), 403);

        $user = User::findOrFail($userId);
        $protection = app(\App\Services\Users\AccountProtection::class);
        abort_if((int) $user->active !== 1 || $protection->privileged($user), 403);
        abort_if((int) $actor->id === (int) $user->id, 403);

        session(['original_user_id' => $actor->id]);
        Auth::login($user);
        session()->regenerate();

        return redirect('/')->with('success', 'You are now logged in as '.$user->name);
    }

    public function revertImpersonation()
    {
        $originalId = session()->pull('original_user_id');
        abort_unless(auth()->check() && $originalId, 403);

        $originalUser = User::find($originalId);
        if (! $originalUser || ! $originalUser->isAdmin() || (int) $originalUser->active !== 1) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('login')->with('error', 'The original administrator account is unavailable.');
        }

        Auth::login($originalUser);
        session()->regenerate();

        return redirect('/')->with('success', 'You are back as Admin');
    }

    public function updateUserStatus(Request $request)
    {
        $this->authorize('edit users');
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|boolean',
        ]);

        $user = User::findOrFail($data['user_id']);
        $protection = app(\App\Services\Users\AccountProtection::class);
        $protection->assertCanEdit($request->user(), $user);
        if (! (bool) $data['status']) {
            $protection->assertCanDeactivate($request->user(), $user);
        }

        $user->active = (bool) $data['status'];
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.',
        ]);
    }
}
