<?php
declare(strict_types=1);
namespace App\Services;

use App\FileValidator;
use Exception;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

class FileManager
{
    protected FileValidator $validator;
    protected ConsoleLogger $logger;

    public function __construct(
        FileValidator $validator
    ) {
        $this->validator = $validator;
        $this->logger = new ConsoleLogger(new ConsoleOutput());
    }

    public function save(string $filePath): bool
    {
        $file = $this->validator->getValidFile($filePath);
        if (!$file) {
            $this->logger->critical("Failed saving the file");
            return false;
        }

        try {
            $targetPath = $this->getPath() . "/" . $file->getName();
            file_put_contents($targetPath, $file->getContents());
        } catch (Exception $exception) {
            $this->logger->critical("Could not save the file");
            return false;
        }

        return true;
    }

    public function delete(string $fileName): bool
    {
        $path = $this->getPath();
        $fullFilePath = "$path/$fileName";
        $file = $this->validator->getValidFile($fullFilePath);
        if (!$file) {
            $this->logger->critical("File not found");
            return false;
        }

        try {
            unlink($fullFilePath);
        } catch (Exception $e) {
            $this->logger->critical("Could not delete file!");
            return false;
        }

        return true;
    }

    /*
     * returning remote path when file exists
     */
    public function get(string $fileName): ?string
    {
        $path = $this->getPath();
        $fullFilePath = "$path/$fileName";
        $file = $this->validator->getValidFile($fullFilePath);
        if (!$file) {
            $this->logger->critical("File not found");
            return null;
        }

        return $path;
    }

    protected function getPath() : string
    {
        //TODO: load path from config
        return '/tmp';
    }
}
