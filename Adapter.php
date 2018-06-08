<?php
namespace Sweetkit\Foundation\Di;

abstract class Adapter
{
	protected $data = [];

	// abstract public function getId() : string;
	// abstract public function getClass() : string;
	// abstract public function getMethods() : array;
	// abstract public function getArguments() : array;
	// abstract public function getAttributes() : array;

	public function setData(array $data) : void
	{
		$this->data = $data;
	}
	public function getData() : array
	{
		return $this->data;
	}
}