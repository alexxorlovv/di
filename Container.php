<?php
namespace Sweetkit\Foundation\Di;

use Psr\Container\ContainerInterface;
use Sweetkit\Foundation\Di\Exceptions\{ContainerException, NotFoundException};
use Sweetkit\Foundation\Di\Service;

class Container implements ContainerInterface
{
	protected $services = [];
	protected $instantiated = [];
	protected $shared = [];


	public function __construct($config = false)
	{
		if($config !== false) {
			$config->setContainer($this)->configure();
		}
	}

	public function isShared(string $id) : bool
	{
		return $this->shared[$id];
	}

	public function getClass(string $id) : string
	{
		return $this->services[$id];
	}

	public function setMethodCall(string $id, string $method, array $attributes) : Container
	{
		$this->instantiated[$id]->setMethodCall($method,$attributes);
		return $this;
	}

	public function setArgument(string $id, $argument) : Container
	{
		$this->instantiated[$id]->setArgument($argument);
		return $this;
	}

	public function setAttribute(string $id, string $name, $attribute) : Container
	{
		$this->instantiated[$id]->setAttribute($name,$attribute);
		return $this;
	}

	public function set(string $id, string $class, bool $shared = true)
	{
		$this->services[$id] = $class;
		$this->shared[$id] = $shared;
		$this->instantiated[$id] = new Service($id, $this);
		return $this;

	}

	    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
    	if(!$this->has($id)) {
    		throw new NotFoundException("{$id} - not found.", 1);
    	}
    	return $this->instantiated[$id]->get();
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
    	return isset($this->services[$id]);
    }
}