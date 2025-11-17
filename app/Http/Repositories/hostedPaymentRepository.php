<?php

namespace App\Http\Repositories;

use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\GetHostedPaymentPageRequest;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\SettingType;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\controller\GetHostedPaymentPageController;

/**
 * Class hostedPaymentRepository
 *
 * @todo - Implement methods to talk to Authorize.NET and show form.
 */
class hostedPaymentRepository
{
    public $response; // what did we get back?

    public $paymentFormToken;

    public function getHostedFormToken($request, $amount)
    {
        // Common setup for API credentials
        $merchantAuthentication = new MerchantAuthenticationType;
        $merchantAuthentication->setName(getSetting('api_login', 'api'));
        $merchantAuthentication->setTransactionKey(getSetting('transaction_key', 'api'));

        // create a transaction
        $transactionRequestType = new TransactionRequestType;
        $transactionRequestType->setTransactionType('authCaptureTransaction');
        $transactionRequestType->setAmount($amount);

        // Create the Bill To info
        $billto = new CustomerAddressType;
        $billto->setFirstName($request->input('firstname'));
        $billto->setLastName($request->input('lastname'));
        $billto->setAddress($request->input('address'));
        $billto->setCity($request->input('city'));
        $billto->setState($request->input('state'));
        $billto->setZip($request->input('zip'));
        $billto->setCountry('US');
        $billto->setEmail($request->input('email'));

        $transactionRequestType->setBillTo($billto);

        // Set Hosted Form options
        $setting1 = new SettingType;
        $setting1->setSettingName('hostedPaymentButtonOptions');
        $setting1->setSettingValue('{"text": "Complete Payment"}');

        $setting2 = new SettingType;
        $setting2->setSettingName('hostedPaymentOrderOptions');
        $setting2->setSettingValue('{"show": false}');

        $setting3 = new SettingType;
        $setting3->setSettingName('hostedPaymentReturnOptions');
        $setting3->setSettingValue('{"showReceipt" : false }');

        $setting4 = new SettingType;
        $setting4->setSettingName('hostedPaymentIFrameCommunicatorUrl');
        $setting4->setSettingValue('{"url": "'.url('/payment/response').'"}');

        $setting5 = new SettingType;
        $setting5->setSettingName('hostedPaymentBillingAddressOptions');
        $setting5->setSettingValue('{"show": false}');

        // Build transaction request
        $request = new GetHostedPaymentPageRequest;
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest($transactionRequestType);

        $request->addToHostedPaymentSettings($setting1);
        $request->addToHostedPaymentSettings($setting2);
        $request->addToHostedPaymentSettings($setting3);
        $request->addToHostedPaymentSettings($setting4);
        $request->addToHostedPaymentSettings($setting5);

        // execute request
        $controller = new GetHostedPaymentPageController($request);
        // $response = $controller->executeWithApiResponse(ANetEnvironment::PRODUCTION);
        $response = $controller->executeWithApiResponse((env('ANET_TESTING') == 'true') ? ANetEnvironment::SANDBOX : ANetEnvironment::PRODUCTION);

        if (($response == null) && ($response->getMessages()->getResultCode() != 'Ok')) {
            return false;
        }

        return $response->getToken();
    }

    public function getHostedFormTokenFromPayment($payment)
    {
        // Common setup for API credentials
        $merchantAuthentication = new MerchantAuthenticationType;
        $merchantAuthentication->setName(getSetting('api_login', 'api'));
        $merchantAuthentication->setTransactionKey(getSetting('transaction_key', 'api'));
        // $merchantAuthentication->setName(\Crypt::decrypt(\DB::table('settings')->select('value')->where('name','api_login')->first()->value));
        // $merchantAuthentication->setTransactionKey(\Crypt::decrypt(\DB::table('settings')->select('value')->where('name','transaction_key')->first()->value));

        // create a transaction
        $transactionRequestType = new TransactionRequestType;
        $transactionRequestType->setTransactionType('authCaptureTransaction');
        $transactionRequestType->setAmount($payment->amount);

        // Create the Bill To info
        $billto = new CustomerAddressType;
        if (isset($payment->fname)) {
            $billto->setFirstName($payment->fname);
            $billto->setLastName($payment->lname);
        } else {
            $billto->setFirstName($payment->firstname);
            $billto->setLastName($payment->lastname);
        }
        $billto->setAddress($payment->address);
        $billto->setCity($payment->city);
        $billto->setState($payment->state);
        $billto->setZip($payment->zip);
        $billto->setCountry('US');
        $billto->setEmail($payment->email);

        $transactionRequestType->setBillTo($billto);

        // Set Hosted Form options
        $setting1 = new SettingType;
        $setting1->setSettingName('hostedPaymentButtonOptions');
        $setting1->setSettingValue('{"text": "Complete Payment"}');

        $setting2 = new SettingType;
        $setting2->setSettingName('hostedPaymentOrderOptions');
        $setting2->setSettingValue('{"show": false}');

        $setting3 = new SettingType;
        $setting3->setSettingName('hostedPaymentReturnOptions');
        $setting3->setSettingValue('{"showReceipt" : false }');

        $setting4 = new SettingType;
        $setting4->setSettingName('hostedPaymentIFrameCommunicatorUrl');
        $setting4->setSettingValue('{"url": "'.url('/payment/response').'"}');

        $setting5 = new SettingType;
        $setting5->setSettingName('hostedPaymentBillingAddressOptions');
        $setting5->setSettingValue('{"show": false}');

        // Build transaction request
        $request = new GetHostedPaymentPageRequest;
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest($transactionRequestType);

        $request->addToHostedPaymentSettings($setting1);
        $request->addToHostedPaymentSettings($setting2);
        $request->addToHostedPaymentSettings($setting3);
        $request->addToHostedPaymentSettings($setting4);
        $request->addToHostedPaymentSettings($setting5);

        // execute request
        $controller = new GetHostedPaymentPageController($request);
        // $response = $controller->executeWithApiResponse(ANetEnvironment::PRODUCTION);
        $response = $controller->executeWithApiResponse((env('ANET_TESTING') == 'true') ? ANetEnvironment::SANDBOX : ANetEnvironment::PRODUCTION);

        if (($response == null) && ($response->getMessages()->getResultCode() != 'Ok')) {
            return false;
        }

        return $response->getToken();
    }
}
