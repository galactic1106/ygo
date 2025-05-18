<?php

namespace App\Services;
use App\Models\Item;

class ItemService
{
	public function getItemById($id)
	{
		return Item::findOrFail($id);
	}

	public function createItem(array $data)
	{
		return Item::create($data);
	}

	public function updateItem(Item $item, array $data)
	{
		return $item->update($data);
	}

	public function deleteItem(Item $item)
	{
		return $item ? $item->delete() : false;
	}
}