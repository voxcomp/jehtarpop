<?php

namespace App\Http\Requests;

use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use Illuminate\Foundation\Http\FormRequest;

class CardVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'card_number' => ['required', new CardNumber],
            'amount' => ['required', 'numeric', 'min:1'],
            'expiration_year' => ['required', 'integer', 'between:2023,2034'],
            'expiration_month' => ['required', 'between:1,12'],
            'reference' => ['nullable', 'max:50'],
            'cvc' => ['required', new CardCvc($this->get('card_number'))]
        ];
    }

    public function messages()
    {
        return [
	        'amount.min'=>'The amount must be a minimum of 1.00',
	        'reference.max'=>'Reference number must be less than 50 characters',
            'card_number.required' => 'The card number is required',
            'expiration_year.required' => 'The expiration year is required',
            'expiration_month.required' => 'The expiration month is required',
            'cvc.required' => 'The CVV code is required',
            'card_number.validation.credit_card.card_checksum_invalid' => 'The card number is invalid'
        ];
    }
}