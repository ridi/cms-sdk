<?php

namespace Ridibooks\Cms\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DockerUp extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('docker:up')
            ->setDescription('Create docker nework and containers.');

        $this->addOption(
            'detached',
            'd',
            InputOption::VALUE_NONE,
            'Run with detached mode'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $detached_option = $input->getOption('detached') ? '-d' : '';
        shell_exec("docker-compose -f $this->docker_config up $detached_option");
    }
}
