<?php

namespace Ridibooks\Cms\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ServiceAdd extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('service:add')
            ->setDescription('Add a service to the docker-compose configuration.');

        $this->addArgument(
            'service',
            InputArgument::OPTIONAL,
            'Service name'
        );

        $this->addArgument(
            'path',
            InputArgument::OPTIONAL,
            'Url sub path to be defined in HAProxy'
        );

        $this->addArgument(
            'dir',
            InputArgument::OPTIONAL,
            'Web application path'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $service = $input->getArgument('service');
        if (!isset($service)) {
            $question = new Question('Enter a service name (default = test): ', 'test');
            $service = $helper->ask($input, $output, $question);
        }

        $service_list = $this->getServices();
        if (in_array($service, $service_list)) {
            $output->writeln("The name '$service' is already exist!");
            return 1;
        }

        $path = $input->getArgument('path');
        if (!isset($path)) {
            $question = new Question('Enter sub path to check in HAProxy (default = test): ', 'test');
            $path = $helper->ask($input, $output, $question);
        }

        $dir = $input->getArgument('dir');
        if (!isset($dir)) {
            $question = new Question("Enter a service directory to be mounted in docker. (default = $this->project_dir): ", $this->project_dir);
            $dir = $helper->ask($input, $output, $question);
        }

        $this->addService($service, $path, $dir);
        $output->writeln("$service is added.");
        return 0;
    }
}
