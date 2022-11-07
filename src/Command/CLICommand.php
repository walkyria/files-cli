<?php
declare(strict_types=1);

namespace App\Command;

use App\Services\FileManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

Abstract class CLICommand extends Command
{
    protected ConsoleLogger $logger;
    protected FileManager $fileManager;

    public function __construct(
        FileManager $fileManager
    ) {
        parent::__construct();
        $this->logger = new ConsoleLogger(new ConsoleOutput());
        $this->fileManager = $fileManager;
    }
}
