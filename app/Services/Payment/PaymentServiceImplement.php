<?php

namespace App\Services\Payment;

use App\Repositories\Package\PackageRepository;
use Xendit\Configuration;
use LaravelEasyRepository\Service;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Transaction\TransactionRepository;
use Exception;
use Xendit\Invoice\InvoiceApi;
use Auth;
class PaymentServiceImplement extends Service implements PaymentService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $packageRepository;
    protected $transactionRepository;

    public function __construct(PaymentRepository $mainRepository,PackageRepository $packageRepository,TransactionRepository $transactionRepository)
    {
        $this->mainRepository = $mainRepository;
        $this->packageRepository = $packageRepository;
        $this->transactionRepository = $transactionRepository;
        Configuration::setXenditKey("xnd_development_b6kvrty12JNBnsIWI1cedlRML7otRmmWi6uBh8xfJc1RBrUnwJWUBZgAiU3JIg1Z");
    }

    // Define your custom methods :)
    public function createInvoice($request)
    {
        try {

            //check if user have transaction pending exist
            $checkTransactionPending = $this->transactionRepository->findPendingTransactionByUser(Auth::user()->id);

            if($checkTransactionPending){
                return [
                    'code' => 400,
                    'status' => false,
                    'data' => ['invoice' => $checkTransactionPending],
                    'message' => 'You Have Transaction Exists'
                ];
            }

            $name = $request->name;
            $email = $request->email;
            $phoneNumber = $request->phone_number;
            $packageId = $request->package_id;
            $package = $this->packageRepository->find($packageId);
            $adminPrice = $package->admin_price;

            if($package->price == 0){
                return [
                    'code' => 400,
                    'status' => true,
                    'data' => ['invoice' => ''],
                    'message' => 'This Package Is Free'
                ];
            }

            $invoiceName = "INV-VOOW-".$package->name ."#".now()->format('dmyhis').rand(0,4);
            $amount = $package->price + $adminPrice;
            $params = [
                "external_id" => $invoiceName,
                "amount" => $amount,
                "description" => "Invoice ".$invoiceName,
                "invoice_duration" => 86400,
                "customer" => [
                    "given_names" => $name,
                    "surname" => $name,
                    "email" => $email,
                    "mobile_number" => $phoneNumber
                ],
                "customer_notification_preference" => [
                    "invoice_created" => ["whatsapp", "email"],
                    "invoice_reminder" => ["whatsapp", "email"],
                    "invoice_paid" => ["whatsapp", "email"],
                    "invoice_expired" => ["whatsapp", "email"],
                ],
                "success_redirect_url" => "https://www.voow.xyz",
                "failure_redirect_url" => "https://www.voow.xyz",
                "currency" => "IDR",
                "items" => [
                    [
                        "name" => $package->name,
                        "quantity" => 1,
                        "price" => $package->price,
                        "category" => "Invitation Online",
                        "url" => "https://voow.xyz",
                    ],
                ],
                "fees" => [["type" => "ADMIN", "value" => $adminPrice]],
            ];

            $serviceInvoceXendit = new InvoiceApi();

            $createInvoice = $serviceInvoceXendit->createInvoice($params);
            $transaction = [
                'user_id' => Auth::user()->id,
                'package_id' => $package->id,
                'invoice' => $invoiceName,
                'name' => $name,
                'email' => $email,
                'phone_number' => $phoneNumber,
                'price' => $package->price,
                'admin_price' => $adminPrice,
                'price_total' => $createInvoice['amount'],
                'invoice_url' => $createInvoice['invoice_url'],
                'expiry_date' => $createInvoice['expiry_date'],
                'status' => 'Pending',
                'rawJson' => json_encode($createInvoice)
            ];

            $transactionData = $this->transactionRepository->create($transaction);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['invoice' => $transactionData],
                'message' => 'Success Create Invoice'
            ];

        } catch (\Xendit\XenditSdkException $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
