<?php
namespace Sweetkit\Foundation\Di;

use Psr\Container\ContainerInterface;
use Sweetkit\Foundation\Di\Exceptions\{ContainerException, NotFoundException};

class Service
{
    protected $arguments = [];
    protected $attributes = [];
    protected $methodCall = [];
    protected $container;
    protected $compiled = false;
    protected $interface;



    public function get()
    {
        if($this->container->isShared($this->interface)) {
           if(!$this->compiled) {
                $this->compiled = $this->compile();
           }
           return $this->compiled;
        }

        return $this->compile();
    }

    public function __construct(string $interface, ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->interface = $interface;
    }

    public function setContainer(ContainerInterface $container) : void
    {
        $this->container = $container;
    }

    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }

    public function setArgument($argument) : void
    {
        $this->arguments[] = $argument;
    }

    public function setArguments(array $arguments) : void
    {
         $this->arguments = $arguments;
    }

    public function setAttribute($name, $attribute)
    {
        $this->attributes[] = ["key" => $name, "value" => $attribute];
    }

    public function setAtributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function setMethodCall($method, $attributes)
    {
        $this->methodCall[] = ["method" => $method, "attributes" => $attributes];
    }


    public function compileMethod($object)
    {
        for($i = 0; $i < sizeof($this->methodCall); $i++) {
            call_user_func_array([$object,$this->methodCall[$i]['method']], $this->methodCall[$i]['attributes']);
        }
        return $object;
    }

    public function complileAttributes($object)
    {
        for($i = 0; $i < sizeof($this->attributes); $i++) {
            $object->{$this->attributes[$i]['key']} = $this->attributes[$i]['value'];
        }
        return $object;
    }

    public function compile()
    {
        $reflection = new \ReflectionClass($this->container->getClass($this->interface));
        $compiled = $reflection->newInstanceArgs($this->arguments);
        $compiled = $this->complileAttributes($compiled);
        $compiled = $this->compileMethod($compiled);
        return $compiled;
    }


}