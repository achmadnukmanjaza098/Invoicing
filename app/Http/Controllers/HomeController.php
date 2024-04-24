<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
            $invoice = Invoice::count();
            $invoicePrice = Invoice::sum('total');

            $invoiceBelumDp = Invoice::where('status_invoice', '=', 'Belum DP')->count();
            $invoiceBelumDpPrice = Invoice::where('status_invoice', '=', 'Belum DP')->sum('total');

            $invoiceSudahDp = Invoice::where('status_invoice', '=', 'Sudah DP')->count();
            $invoiceSudahDpPrice = Invoice::where('status_invoice', '=', 'Sudah DP')->sum('total');

            $invoiceMenungguPelunasan = Invoice::where('status_invoice', '=', 'Menunggu Pelunasan')->count();
            $invoiceMenungguPelunasanPrice = Invoice::where('status_invoice', '=', 'Menunggu Pelunasan')->sum('total');

            $invoiceLunas = Invoice::where('status_invoice', '=', 'Lunas')->count();
            $invoiceLunasPrice = Invoice::where('status_invoice', '=', 'Lunas')->sum('total');

            return view($request->path())
                    ->with('invoice', $invoice)
                    ->with('invoicePrice', $invoicePrice)
                    ->with('invoiceBelumDp', $invoiceBelumDp)
                    ->with('invoiceBelumDpPrice', $invoiceBelumDpPrice)
                    ->with('invoiceSudahDp', $invoiceSudahDp)
                    ->with('invoiceSudahDpPrice', $invoiceSudahDpPrice)
                    ->with('invoiceMenungguPelunasan', $invoiceMenungguPelunasan)
                    ->with('invoiceMenungguPelunasanPrice', $invoiceMenungguPelunasanPrice)
                    ->with('invoiceLunas', $invoiceLunas)
                    ->with('invoiceLunasPrice', $invoiceLunasPrice);
        }
        return abort(404);
    }

    public function root()
    {
        $invoice = Invoice::count();
        $invoicePrice = Invoice::sum('total');

        $invoiceBelumDp = Invoice::where('status_invoice', '=', 'Belum DP')->count();
        $invoiceBelumDpPrice = Invoice::where('status_invoice', '=', 'Belum DP')->sum('total');

        $invoiceSudahDp = Invoice::where('status_invoice', '=', 'Sudah DP')->count();
        $invoiceSudahDpPrice = Invoice::where('status_invoice', '=', 'Sudah DP')->sum('total');

        $invoiceMenungguPelunasan = Invoice::where('status_invoice', '=', 'Menunggu Pelunasan')->count();
        $invoiceMenungguPelunasanPrice = Invoice::where('status_invoice', '=', 'Menunggu Pelunasan')->sum('total');

        $invoiceLunas = Invoice::where('status_invoice', '=', 'Lunas')->count();
        $invoiceLunasPrice = Invoice::where('status_invoice', '=', 'Lunas')->sum('total');

        return view('index')
                ->with('invoice', $invoice)
                ->with('invoicePrice', $invoicePrice)
                ->with('invoiceBelumDp', $invoiceBelumDp)
                ->with('invoiceBelumDpPrice', $invoiceBelumDpPrice)
                ->with('invoiceSudahDp', $invoiceSudahDp)
                ->with('invoiceSudahDpPrice', $invoiceSudahDpPrice)
                ->with('invoiceMenungguPelunasan', $invoiceMenungguPelunasan)
                ->with('invoiceMenungguPelunasanPrice', $invoiceMenungguPelunasanPrice)
                ->with('invoiceLunas', $invoiceLunas)
                ->with('invoiceLunasPrice', $invoiceLunasPrice);

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
