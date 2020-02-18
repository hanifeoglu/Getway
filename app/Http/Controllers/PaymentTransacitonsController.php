<?php

namespace App\Http\Controllers;

use App\PaymentTransacitons;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

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
        $PaymentTransacitons->key =  Str::uuid()->toString();


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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentTransacitons  $paymentTransacitons
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentTransacitons $paymentTransacitons)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentTransacitons  $paymentTransacitons
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentTransacitons $paymentTransacitons)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentTransacitons  $paymentTransacitons
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentTransacitons $paymentTransacitons)
    {
        //
    }



    /**

     try {

    // Generate a version 1 (time-based) UUID object
    $uuid1 = Uuid::uuid1();
    echo $uuid1->toString() . "\n"; // i.e. e4eaaaf2-d142-11e1-b3e4-080027620cdd

    // Generate a version 3 (name-based and hashed with MD5) UUID object
    $uuid3 = Uuid::uuid3(Uuid::NAMESPACE_DNS, 'php.net');
    echo $uuid3->toString() . "\n"; // i.e. 11a38b9a-b3da-360f-9353-a5a725514269

    // Generate a version 4 (random) UUID object
    $uuid4 = Uuid::uuid4();
    echo $uuid4->toString() . "\n"; // i.e. 25769c6c-d34d-4bfe-ba98-e0ee856f3e7a

    // Generate a version 5 (name-based and hashed with SHA1) UUID object
    $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'php.net');
    echo $uuid5->toString() . "\n"; // i.e. c4a760a8-dbcf-5254-a0d9-6a4474bd1b62

    } catch (UnsatisfiedDependencyException $e) {

    // Some dependency was not met. Either the method cannot be called on a
    // 32-bit system, or it can, but it relies on Moontoast\Math to be present.
    echo 'Caught exception: ' . $e->getMessage() . "\n";

    }
     */

    public function makePayment(Request $request, $key)
    {
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
            "CardType" => 0,
            "Lang" => "EN",
            "MOTO" => ""
        ];
        $paymentResponse = $client(
            'POST', 
            config('services.denizbank.endpoint'),
            ['form_params' => $data]
        );
        dd($paymentResponse);
    }


}
