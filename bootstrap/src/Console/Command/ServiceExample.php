<?php

namespace Ridibooks\Cms\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ServiceExample extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('service:example')
            ->setDescription('Create example codes on service directory');

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
            $output->writeln("There is no service. Create service with 'service:add' first");
            return 1;
        }

        $service = $input->getArgument('service');
        $helper = $this->getHelper('question');
        if (!isset($service)) {
            $question = new ChoiceQuestion('Please select service to add example code.', $service_list);
            $question->setAutocompleterValues($service_list);
            $question->setErrorMessage('Wrong select.');
            $service = $helper->ask($input, $output, $question);
        } elseif (!in_array($service, $service_list)) {
            $output->writeln("The service '$service' is not exists.");
            return 1;
        }

        $service_dir = $this->getServiceDir($service);
        $output->writeln("The example will be created at $service_dir.");
        $output->writeln("\033[31m** CAUSION: It may overwrites existing files. **\033[0m");
        $question = new ConfirmationQuestion("Continue? (y/n): ", false);
        $confirm = $helper->ask($input, $output, $question);
        if (!$confirm) {
            $output->writeln('Canceled.');
            return 0;
        }

        if ($this->project_dir === $service_dir) {
            shell_exec("rsync --progress -r $this->bootstrap_dir/example/ $service_dir/ --exclude='composer.*'");
            shell_exec("composer require -d=$service_dir illuminate/database:^5.2 silex/silex:^2.0 twig/twig:^2.0 vlucas/phpdotenv:^2.4");
        } else {
            shell_exec("rsync --progress -r $this->bootstrap_dir/example/ $service_dir/");
            shell_exec("composer install -d=$service_dir");
        }

        $output->writeln("Example is created at $service_dir.");
        return 0;
    }
}
