<?php namespace Ejimba\Pesapal\Models;

use Illuminate\Database\Eloquent\Model;

class PesapalPayment extends Model {

	public $table = 'pesapalpayments';

	protected $fillable = array(
								'tracking_id',
								'payment_method',
								'description',
								'currency',
								'user',
								'first_name',
								'last_name',
								'email',
								'phone_number',
								'amount',
								'reference',
								'type',
								'enabled',
								'updated_at',
	);
}