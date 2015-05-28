<?php namespace Ejimba\Pesapal;

use \Config, \URL;
use \Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Redirect;
use \Ejimba\Pesapal\Models\PesapalPayment;
use \Ejimba\Pesapal\OAuth\OAuthConsumer;
use \Ejimba\Pesapal\OAuth\OAuthRequest;
use \Ejimba\Pesapal\OAuth\OAuthSignatureMethodHMACSHA1;

class Pesapal {

    protected $enabled;
    protected $currency;
    protected $consumer_key;
    protected $consumer_secret;
    protected $ipn_url;
    protected $iframe_url;
    protected $controller;
    protected $key;
    protected $redirectTo;
    protected $mail;
    protected $email;
    protected $name;
    protected $payment_email_view;

    public function __construct()
    {
        $this->enabled = Config::get('pesapal::enabled');
        $this->consumer_key = Config::get('pesapal::consumer_key');
        $this->consumer_secret = Config::get('pesapal::consumer_secret');
        $this->currency = Config::get('pesapal::currency');
        if($this->enabled){
            $this->iframe_url = Config::get('pesapal::url.iframe_live');
            $this->ipn_url = Config::get('pesapal::url.ipn_live');
        }
        else{
            $this->iframe_url = Config::get('pesapal::url.iframe_demo');
            $this->ipn_url = Config::get('pesapal::url.ipn_demo');
        }
        $this->controller = Config::get('pesapal::controller');
        $this->key = Config::get('pesapal::key');
        $this->redirectTo = Config::get('pesapal::redirectTo');
        $this->mail = Config::get('pesapal::mail');
        $this->email = Config::get('pesapal::email');
        $this->name = Config::get('pesapal::name');
        $this->payment_email_view = Config::get('pesapal::views.payment_email');
    }

    /**
     *  Generates the iframe from the given details
     * 
     *  @param array $values
     *  
     *  This array should contain the fields required by pesapal
     * 
     *  description - description of the item or service
     *  currency - if set will override the config settings you have of currency
     *  user - which should be your client user id if you have a system of users
     *  first_name- the first name of the user that is paying
     *  last_name - the last name of the user that is paying
     *  email - this should be a valid email or pesapal will throw an error
     *  phone_number - optional if you have the email
     *  amount - the total amount to be posted to pesapal
     *  reference - a unique key to the transaction. if left empty, it will be auto generated
     *  type - default is MERCHANT
     *  frame_height - this is the height of the iframe. please provide integers as in 900 without the px
     *
     *  @return string
     * 
     *  The string contains the iframe of pesapal
     * 
     */

    public function Iframe($values = array())
    {
        if(!isset($values['amount']))
        {
            throw new PesapalException("Missing Data : The payment amount is missing", 101);
        }
        else
        {
            $amount = $values['amount'];
        }

        if(!isset($values['description']))
        {
            $description = 'Payment to '.URL::to('/');
        }
        else
        {
            $description = $values['description'];
        }

        if(!isset($values['type']))
        {
            $type = 'MERCHANT';
        }
        else
        {
            $type = $values['type'];
        }

        if(!isset($values['reference']))
        {
            $ref = str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 5);
            $reference = substr(str_shuffle($ref), 0, 10);
        }
        else
        {
            $reference = $values['reference'];
        }

        if(!isset($values['first_name']))
        {
            throw new PesapalException("Missing Data : The first_name of the customer is required", 102);
        }
        else
        {
            $first_name = $values['first_name'];
        }

        if(!isset($values['last_name']))
        {
            throw new PesapalException("Missing Data : The last_name of the customer is required", 103);
        }
        else
        {
            $last_name = $values['last_name'];
        }

        if(!isset($values['email']) && !isset($values['phone_number']))
        {
            throw new PesapalException("Missing Data : The email or phone number of the customer is required", 104);
        }
        else
        {
            isset($values['email']) ? $email = $values['email']: $email = '';
            isset($values['phone_number']) ? $phone_number = $values['phone_number']: $phone_number = '';
        }

        if(!isset($values['currency']))
        {
            $currency = $this->currency;
        }
        else
        {
            $currency = $values['currency'];
        }

        if(isset($values['user']))
        {
            $user = $values['user'];
        }
        elseif(isset($values['user_id']))
        {
            $user = $values['user_id'];
        }
        elseif(isset($values['id']))
        {
            $user = $values['id'];
        }
        else
        {
            throw new PesapalException("Missing Data : The user id of the customer is required", 103);
        }

        $data = array(
            "currency" => $currency,
            "amount" => $amount,
            "description" => $description,
            "type" => $type,
            "reference" => $reference,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "phone_number" => $phone_number,
            "user" => $user,
            "email" => $email,
        );

        $recs = PesapalPayment::where("reference", '=', $reference)->count();

        if($recs < 1)
        {
            PesapalPayment::create($data);
        }

        //redirect url, the page that will handle the response from pesapal.

        $callback_url = URL::to('pesapal_redirect');

        $post_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Amount=\"".$amount."\" Description=\"".$description."\" Type=\"".$type."\" Reference=\"".$reference."\" FirstName=\"".$first_name."\" LastName=\"".$last_name."\" Email=\"".$email."\" PhoneNumber=\"".$phone_number."\" xmlns=\"http://www.pesapal.com\" />";
        $post_xml = htmlentities($post_xml);
        $token = $params = NULL;
        $consumer = new OAuthConsumer($this->consumer_key, $this->consumer_secret);
        $signature_method = new OAuthSignatureMethodHMACSHA1;

        //post transaction to pesapal
        $iframe_src = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $this->iframe_url, $params);
        $iframe_src->set_parameter("oauth_callback", $callback_url);
        $iframe_src->set_parameter("pesapal_request_data", $post_xml);
        $iframe_src->sign_request($signature_method, $consumer, $token);

        isset($values['frame_height']) ? $frame_height = $values['frame_height']: $frame_height = 600;

        return '<iframe src="' . $iframe_src . '" width="100%" height="' . $frame_height . 'px" scrolling="no" frameBorder="0"><p>Unable to load the payment page</p> </iframe>';
    }

    /**
    * This the main function that will control the ipn queries
    */
    public function listentToIpn()
    {
        $pesapal_notification = Input::get('pesapal_notification_type');
        $pesapal_tracking_id = Input::get('pesapal_transaction_tracking_id');
        $pesapal_merchant_reference = Input::get('pesapal_merchant_reference');

        if($pesapal_notification == "CHANGE" && $pesapal_tracking_id != '')
        {
            $token = $params = NULL;
            $consumer = new OAuthConsumer($this->consumer_key, $this->consumer_secret);
            $signature_method = new OAuthSignatureMethodHMACSHA1;

            //get transaction status
            $request_status = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $this->ipn_url, $params);
            $request_status->set_parameter("pesapal_merchant_reference", $pesapal_merchant_reference);
            $request_status->set_parameter("pesapal_transaction_tracking_id", $pesapal_tracking_id);
            $request_status->sign_request($signature_method, $consumer, $token);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $request_status);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            if(defined('CURL_PROXY_REQUIRED')) if (CURL_PROXY_REQUIRED == 'True')
            {
                $proxy_tunnel_flag = (defined('CURL_PROXY_TUNNEL_FLAG') && strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE') ? false : true;
                curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
                curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
                curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
            }

            $response = curl_exec($ch);

            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $raw_header  = substr($response, 0, $header_size - 4);
            $headerArray = explode("\r\n\r\n", $raw_header);
            $header      = $headerArray[count($headerArray) - 1];

            //transaction status
            $elements = preg_split("/=/",substr($response, $header_size));
            $status = $elements[1];

            curl_close ($ch);

            //UPDATE YOUR DB TABLE WITH NEW STATUS FOR TRANSACTION WITH pesapal_transaction_tracking_id $pesapal_tracking_id
            $payment = PesapalPayment::where("reference", '=', $pesapal_merchant_reference)->first();

            if (!is_null($payment))
            {
                $payment->status = $status;
                if($payment->tracking_id !=''){
                    $payment->tracking_id = $pesapal_tracking_id;
                }
                $payment->save();
            }

            //if status is COMPLETE and the controller is not empty
            //then call controller defined by the user to do whatever it has to
            if($status == "COMPLETED" && $this->controller !=""){
                $obj = new $this->controller();
                echo $obj->updateItem($this->key,$pesapal_merchant_reference);
                
                if($this->mail == true){
                    $data = array(
                        'status'=>$status,
                        'tracking_id'=>$pesapal_tracking_id,
                        'reference' =>$pesapal_merchant_reference,
                        'name'=>$this->name
                        );
                    $user = array(
                        'email'=>$this->email,
                        'name'=>$this->name
                        );
                    Mail::send($this->payment_email_view, $data, function($message) use ($user)
                    {
                        $message->to($user['email'], $user['name'])->subject('Payment was processed!');
                    });
                }

            }
            //we do not need to show the pesapal any data if the status is empty
            //so for pesapal to keep querying us when the status changes
            if($status   != "PENDING")
            {
                $resp="pesapal_notification_type=$pesapal_notification&pesapal_transaction_tracking_id=$pesapal_tracking_id&pesapal_merchant_reference=$pesapal_merchant_reference";
                ob_start();
                echo $resp;
                ob_flush();
                exit;
            }
        }
    }

    /**
    *
    *   Redirect to the specified url
    *
    *   @return mixed
    *
    */

    public function redirectAfterPayment()
    {
        $tracking_id = Input::get("pesapal_transaction_tracking_id");
        $reference = Input::get("pesapal_merchant_reference");
        
        $payment = PesapalPayment::where("reference", '=', $reference)->first();

        if (!is_null($payment)) {
            $payment->tracking_id = $tracking_id;
            $payment->save();
        }

        return Redirect::to($this->redirectTo);
    }

    public static function checkStatus()
    {
        return 'Error';
    }
}