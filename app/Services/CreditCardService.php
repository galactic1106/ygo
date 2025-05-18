<?php

namespace App\Services;
use App\Models\CreditCard;

class CreditCardService
{
	public function get($id)
	{
		return CreditCard::findOrFail($id);
	}

	public function create(array $data)
	{
		return CreditCard::create($data);
	}

	public function update(CreditCard $creditCard, array $data)
	{
		return $creditCard->update($data);
	}

	public function delete(CreditCard $creditCard)
	{
		return $creditCard ? $creditCard->delete() : false;
	}
	public function all()
	{
		return CreditCard::all();
	}
}