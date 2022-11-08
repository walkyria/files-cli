<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CLISaveCommand extends CLICommand
{
    protected static $defaultName = 'cli.save';
    protected static $defaultDescription = "Saves file to 'remote' file system";

    protected function configure(): void
    {
        $this->addArgument(
            'filePath',
            InputArgument::REQUIRED,
            'Full source file path'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input === null) {
            $this->logger->error("Invalid command");
            return 0;
        }

        if (empty($input->getArgument('filePath'))) {
            $this->logger->alert("Please provide full file path");
            return 0;
        }

        return (int) $this->fileManager->save($input->getArgument('filePath'));
    }
}
