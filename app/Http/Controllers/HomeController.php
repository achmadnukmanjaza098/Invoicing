<?php

namespace App\Http\Controllers;

use App\Models\DetailInvoice;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        if (view()->exists($request->path())) {
            $user = Auth::user()->role !== 'admin' ? Auth::user()->id : '';

            if ($request->currentMonth || $request->currentYear) {
                $currentMonth = $request->currentMonth;
                $currentYear = $request->currentYear;
                $currentDate = $currentYear . '-' . $currentMonth . '-01';
            } else {
                $currentMonth = date('m');
                $currentYear = date('Y');
                $currentDate = date('Y-m-d');
            }

            $previousMonth = strtotime('-1 month', strtotime($currentDate));
            $labelPreviousMonth = date('F', $previousMonth);

            $previousMonth = ($currentMonth == 1) ? 12 : $currentMonth - 1;
            $previousYear = ($previousMonth == 12) ? $currentYear - 1 : $currentYear;

            $currentHour = date('H');
            if ($currentHour >= 23 && $currentHour < 12) {
                $timeOfDay = 'Pagi';
            } elseif ($currentHour >= 12 && $currentHour < 15) {
                $timeOfDay = 'Siang';
            } elseif ($currentHour >= 15 && $currentHour < 19) {
                $timeOfDay = 'Sore';
            } else {
                $timeOfDay = 'Malam';
            }

            $currentOrder = Invoice::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->where('created_by', 'like', '%' . $user . '%')
                ->count();

            $previousOrder = Invoice::whereMonth('created_at', $previousMonth)
                ->whereYear('created_at', $previousYear)
                ->where('created_by', 'like', '%' . $user . '%')
                ->count();

            $percentageOrder = 0;
            if ($currentOrder !== 0) {
                $percentageOrder = (($currentOrder - $previousOrder) / ($currentOrder)) * 100;
            }

            $currentProduct = DetailInvoice::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->where('created_by', 'like', '%' . $user . '%')
                ->sum('qty');

            $previousProduct = DetailInvoice::whereMonth('created_at', $previousMonth)
                ->whereYear('created_at', $previousYear)
                ->where('created_by', 'like', '%' . $user . '%')
                ->sum('qty');

            $percentageProduct = 0;
            if ($currentProduct !== 0) {
                $percentageProduct = (($currentProduct - $previousProduct) / ($currentProduct)) * 100;
            }

            $currentIncome = Invoice::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->where('created_by', 'like', '%' . $user . '%')
                ->sum('total');

            $previousIncome = Invoice::whereMonth('created_at', $previousMonth)
                ->whereYear('created_at', $previousYear)
                ->where('created_by', 'like', '%' . $user . '%')
                ->sum('total');

            $percentageIncome = 0;
            if ($currentIncome !== 0) {
                $percentageIncome = (($currentIncome - $previousIncome) / ($currentIncome)) * 100;
            }

            $bestSellerProduct = DetailInvoice::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->where('created_by', 'like', '%' . $user . '%')
                ->groupBy('item')
                ->orderBy('total_qty', 'desc')
                ->select('item', DB::raw('sum(qty) as total_qty'))
                ->limit(3)
                ->get();

            $salesReport = Invoice::select([
                    'users.name as name',
                    DB::raw("(SELECT count(*) FROM invoices WHERE created_by = invoices.created_by AND MONTH(created_at) = {$currentMonth} AND YEAR(created_at) = {$currentYear}) as total_order"),
                    DB::raw('SUM(detail_invoices.qty) as total_qty'),
                    DB::raw('SUM(invoices.total) as total_pendapatan')
                ])
                ->join('detail_invoices', 'detail_invoices.invoice_id', '=', 'invoices.id')
                ->join('users', 'users.id', '=', 'invoices.created_by')
                ->whereMonth('invoices.created_at', $currentMonth)
                ->whereYear('invoices.created_at', $currentYear)
                ->where('invoices.created_by', 'like', '%' . $user . '%')
                ->groupBy('invoices.created_by')
                ->get();

            return view($request->path())
                    ->with('order', $currentOrder)
                    ->with('percentageOrder', $percentageOrder)
                    ->with('product', $currentProduct)
                    ->with('percentageProduct', $percentageProduct)
                    ->with('income', $currentIncome)
                    ->with('percentageIncome', $percentageIncome)
                    ->with('bestSellerProduct', $bestSellerProduct)
                    ->with('salesReport', $salesReport)
                    ->with('timeOfDay', $timeOfDay)
                    ->with('currentMonth', $currentMonth ?? '')
                    ->with('currentYear', $currentYear ?? '')
                    ->with('labelPreviousMonth', $labelPreviousMonth);
        }
        return abort(404);
    }

    public function root()
    {
        $user = Auth::user()->role !== 'admin' ? Auth::user()->id : '';

        $currentDate = date('Y-m-d');
        $currentMonth = date('m');
        $currentYear = date('Y');

        $previousMonth = strtotime('-1 month', strtotime($currentDate));
        $labelPreviousMonth = date('F', $previousMonth);

        $previousMonth = ($currentMonth == 1) ? 12 : $currentMonth - 1;
        $previousYear = ($previousMonth == 12) ? $currentYear - 1 : $currentYear;

        $currentHour = date('H');
        if ($currentHour >= 23 && $currentHour < 12) {
            $timeOfDay = 'Pagi';
        } elseif ($currentHour >= 12 && $currentHour < 15) {
            $timeOfDay = 'Siang';
        } elseif ($currentHour >= 15 && $currentHour < 19) {
            $timeOfDay = 'Sore';
        } else {
            $timeOfDay = 'Malam';
        }

        $currentOrder = Invoice::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('created_by', 'like', '%' . $user . '%')
            ->count();

        $previousOrder = Invoice::whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            ->where('created_by', 'like', '%' . $user . '%')
            ->count();

        $percentageOrder = (($currentOrder - $previousOrder) / ($currentOrder)) * 100;

        $currentProduct = DetailInvoice::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('created_by', 'like', '%' . $user . '%')
            ->sum('qty');

        $previousProduct = DetailInvoice::whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            ->where('created_by', 'like', '%' . $user . '%')
            ->sum('qty');

        $percentageProduct = (($currentProduct - $previousProduct) / ($currentProduct)) * 100;

        $currentIncome = Invoice::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('created_by', 'like', '%' . $user . '%')
            ->sum('total');

        $previousIncome = Invoice::whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            ->where('created_by', 'like', '%' . $user . '%')
            ->sum('total');

        $percentageIncome = (($currentIncome - $previousIncome) / ($currentIncome)) * 100;

        $bestSellerProduct = DetailInvoice::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('created_by', 'like', '%' . $user . '%')
            ->groupBy('item')
            ->orderBy('total_qty', 'desc')
            ->select('item', DB::raw('sum(qty) as total_qty'))
            ->limit(3)
            ->get();

        $salesReport = Invoice::select([
                'users.name as name',
                DB::raw("(SELECT count(*) FROM invoices WHERE created_by = invoices.created_by AND MONTH(created_at) = {$currentMonth} AND YEAR(created_at) = {$currentYear}) as total_order"),
                DB::raw('SUM(detail_invoices.qty) as total_qty'),
                DB::raw('SUM(invoices.total) as total_pendapatan')
            ])
            ->join('detail_invoices', 'detail_invoices.invoice_id', '=', 'invoices.id')
            ->join('users', 'users.id', '=', 'invoices.created_by')
            ->whereMonth('invoices.created_at', $currentMonth)
            ->whereYear('invoices.created_at', $currentYear)
            ->where('invoices.created_by', 'like', '%' . $user . '%')
            ->groupBy('invoices.created_by')
            ->get();

        return view('index')
                ->with('order', $currentOrder)
                ->with('percentageOrder', $percentageOrder)
                ->with('product', $currentProduct)
                ->with('percentageProduct', $percentageProduct)
                ->with('income', $currentIncome)
                ->with('percentageIncome', $percentageIncome)
                ->with('bestSellerProduct', $bestSellerProduct)
                ->with('salesReport', $salesReport)
                ->with('timeOfDay', $timeOfDay)
                ->with('currentMonth', $currentMonth)
                ->with('currentYear', $currentYear)
                ->with('labelPreviousMonth', $labelPreviousMonth);
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->dob = date('Y-m-d', strtotime($request->get('dob')));

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            if (file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
            $user->avatar = '/images/' . $avatarName;
        }
        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'isSuccess' => true,
                'Message' => "User Details Updated successfully!"
            ], 200); // Status code here
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json([
                'isSuccess' => true,
                'Message' => "Something went wrong!"
            ], 200); // Status code here
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'string'],
        ]);

        if ($request->get('password') !== $request->get('password_confirmation')) {
            return response()->json([
                'isSuccess' => false,
                'code' => 'password_confirmation',
                'Message' => "Your New password & Confirm Password does not matches. Please try again."
            ], 200);
        }

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'code' => 'password',
                'Message' => "Your Current Password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }
}
