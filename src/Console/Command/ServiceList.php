<?php

namespace Ridibooks\Cms\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServiceList extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('service:list')
            ->setDescription('List services configured in docker-composer file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service_list = $this->getServices();
        if (empty($service_list)) {
            $output->writeln('There is no service.');
            return 0;
        }

        foreach ($service_list as $service) {
            $service_dir = $this->getServiceDir($service);
            $output->writeln("* $service -> $service_dir");
        }
        return 0;
    }
}
