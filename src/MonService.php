<?php

namespace Acme\BlogBundle;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MonService 
{
    const HELLO = 'Hello, bienvenue dans Acme Blog Bundle';

    private $connections;
    private $logger;
    private $eventDispatcher;
    private $datas;

    public function __construct(LoggerInterface $logger = null, array $connections)
    {
        $this->logger = $logger;
        $this->connections = $connections;
    }
    
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher = null)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function addDatas(array $datas)
    {   
        $this->datas[] = $datas;
    }

    public function getHost(array $connections)
    {
        return $connections['host'];
    }
}