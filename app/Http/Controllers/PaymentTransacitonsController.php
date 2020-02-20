<?php

namespace App\Http\Controllers;

use App\PaymentTransacitons;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentTransacitonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $PaymentTransacitons = new PaymentTransacitons();
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'email|nullable',
            'phone' => 'string|nullable',
            'description' => 'required|string',
            'amount' => 'required|numeric|between:0,99999.99',

        ]);
        $PaymentTransacitons->name = $request->input('name');
        $PaymentTransacitons->email = $request->input('email');
        $PaymentTransacitons->phone = $request->input('phone');
        $PaymentTransacitons->description = $request->input('description');
        $PaymentTransacitons->amount = $request->input('amount');
        $PaymentTransacitons->key = Str::uuid()->toString();

        $PaymentTransacitons->save();
        return redirect(route('payments.list'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentTransacitons  $paymentTransacitons
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        $transaction = PaymentTransacitons::where('key', $key)->firstOrFail();

        return view('paymentform', compact('transaction'));

    }

    public function paymentsList()
    {
        $payments = PaymentTransacitons::latest()->get();
        return datatables()->of($payments)
            ->make(true);

    }

    public function detail($key)
    {
        return PaymentTransacitons::where('key', $key)->firstOrFail();
    }

    public function makePayment(Request $request, $key)
    {
        $request->validate([
            "pan" => "required|digits:16",
            "expiry" => "required|digits:4",
            "cvv2" => "required|digits:3",
            "type" => "required|in:visa,mastercard",
        ]);

        $paymentOrder = PaymentTransacitons::where('key', $key)->firstOrFail();
        $client = new Client();
        $data = [
            "ShopCode" => config('services.denizbank.shopcode'),
            "PurchAmount" => $paymentOrder->amount,
            "Currency" => config('services.denizbank.currencycode'),
            "OrderId" => "",
            "InstallmentCount" => "",
            "TxnType" => "Auth",
            "orgOrderId" => "",
            "UserCode" => config('services.denizbank.usercode'),
            "UserPass" => config('services.denizbank.userpass'),
            "SecureType" => "NonSecure",
            "Pan" => $request->input('pan'),
            "Expiry" => $request->input('expiry'),
            "Cvv2" => $request->input('cvv2'),
            "BonusAmount" => "",
            "CardType" => $request->input('type') == "visa" ? 0 : 1,
            "Lang" => "EN",
            "MOTO" => "",
        ];
        $paymentResponse = $client->request(
            'POST',
            config('services.denizbank.endpoint'),
            ['form_params' => $data]
        );
        $responseText = $paymentResponse->getBody()->getContents();

        $keysAndValues = explode(';;', $responseText);

        $resp = [];
        foreach ($keysAndValues as $keyAndValue) {
            $seperated = explode("=", $keyAndValue);
            $resp[$seperated[0]] = $seperated[1];
        }

        // Test kartının kart sahibi isim alanı bozuk karakterlerle geldiğinden JSON encode olmuyor, canlı ortamda kaldırılacak
        $resp["CardHolderName"] = "Falan Filan";

        return $resp;
    }

}
