<?php

namespace Ridibooks\Cms\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class ServiceRemove extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('service:remove')
            ->setDescription('Add a service to the docker-compose configuration.');

        $this->addArgument(
            'service',
            InputArgument::OPTIONAL,
            'Service name'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service_list = $this->getServices();
        if (empty($service_list)) {
            $output->writeln('There is no service.');
            return 1;
        }

        $service = $input->getArgument('service');
        $helper = $this->getHelper('question');
        if (!isset($service)) {
            $question = new ChoiceQuestion('Please select service', $service_list);
            $question->setAutocompleterValues($service_list);
            $question->setErrorMessage('Wrong select.');
            $service = $helper->ask($input, $output, $question);
        } elseif (!in_array($service, $service_list)) {
            $output->writeln("The service '$service' is not exists.");
            return 1;
        }

        $this->removeService($service);
        $output->writeln("$service is removed.");
        return 0;
    }
}
