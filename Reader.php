<?php

namespace Sweetkit\Foundation\Di;

use Sweetkit\Foundation\Di\Adapter;
use Sweetkit\Foundation\Di\Container;
use Sweetkit\Foundation\Di\ContainerAwareTrait;

class Reader
{
	use ContainerAwareTrait;

	protected $adapter;

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
	}



	public function configure()
	{
		if(sizeof($this->adapter->getData()) == 0) {
			return;
		}
			foreach ($this->adapter->getData() as $id => $data) {
				$shared = isset($data['shared']) ? $data['shared'] : true;
				$this->container->set($id,$data['class'],$shared);
				if(isset($data['arguments'])) {
					for($i = 0; $i < sizeof($data['arguments']); $i++) {
						$this->container->setArgument($id,$data['arguments'][$i]);
					}
				}

				if(isset($data['attributes'])) {
					foreach ($data['attributes'] as $key => $value) {
						$this->container->setAttribute($id,$key,$value);
					}
				}

				if(isset($data['methods'])) {
					foreach ($data['methods'] as $method => $attributes) {
						$this->container->setMethodCall($id,$method,$attributes);
					}
				}
			}
		
	}



}
