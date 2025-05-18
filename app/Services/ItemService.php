<?php

namespace App\Services;
use App\Models\Item;

class ItemService
{
	public function get($id)
	{
		return Item::findOrFail($id);
	}

	public function create(array $data)
	{
		return Item::create($data);
	}

	public function update(Item $item, array $data)
	{
		return $item->update($data);
	}

	public function delete(Item $item)
	{
		return $item ? $item->delete() : false;
	}

	public function all()
	{
		return Item::all();
	}
}