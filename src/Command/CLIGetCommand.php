<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CLIGetCommand extends CLICommand
{
    protected static $defaultName = 'cli.open';

    protected function configure(): void
    {
        $this
            ->addArgument('fileName', InputArgument::REQUIRED, 'Name of existing file');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input === null) {
            $this->logger->error("Invalid command");
            return 0;
        }

        if (empty($input->getArgument('fileName'))) {
            $this->logger->alert("Please provide file name");
            return 0;
        }

        $path = $this->fileManager->get($input->getArgument('fileName'));
        if (!$path) {
            return 0;
        }

        $this->logger->info($path);
        return 1;
    }
}
