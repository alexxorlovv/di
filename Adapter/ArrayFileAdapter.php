<?php
namespace Sweetkit\Foundation\Di\Adapter;

use Sweetkit\Foundation\Di\Adapter;

class ArrayFileAdapter extends Adapter
{
	
	function __construct(string $path)
	{
		if(!file_exists($path)) {
			return;
		}

		$this->setData(require($path));
	}
}