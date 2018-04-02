<?php

namespace Ridibooks\Cms\Thrift;

use Thrift\Protocol\TJSONProtocol;
use Thrift\TMultiplexedProcessor;
use Thrift\Transport\TMemoryBuffer;

class ThriftServer
{
    private $processor = null;

    public function __construct($services)
    {
        $processor = new TMultiplexedProcessor();

        foreach ($services as $service_name => $service) {
            $processor_class = __NAMESPACE__ . '\\' . $service_name . '\\' . $service_name . 'ServiceProcessor';
            $sub_processor = new $processor_class($service);
            $processor->registerProcessor($service_name, $sub_processor);
        }

        $this->processor = $processor;
    }

    public function process(string $input): string
    {
        $readTransport = new TMemoryBuffer($input);
        $writeTransport = new TMemoryBuffer();
        $readProtocol = new TJSONProtocol($readTransport);
        $writeProtocol = new TJSONProtocol($writeTransport);

        $readTransport->open();
        $writeTransport->open();

        $this->processor->process($readProtocol, $writeProtocol);

        $readTransport->close();
        $writeTransport->close();

        $output = $writeTransport->getBuffer();
        return $output;
    }
}
