<?php

namespace Ridibooks\Cms\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DockerDown extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('docker:down')
            ->setDescription('Clean docker containders and network.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        shell_exec("COMPOSE_PROJECT_NAME=cms docker-compose -f $this->docker_config down");
    }
}
