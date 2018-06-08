<?php

namespace Sweetkit\Foundation\Di;

use Sweetkit\Foundation\Di\Container;

trait ContainerAwareTrait
{
	protected $container;

	public function setContainer(Container $container)
	{
		$this->container = $container;
		return $this;
	}

}