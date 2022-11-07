<?php
declare(strict_types=1);

namespace App;


use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

class FileValidator
{
    public const ALLOWED_FILE_TYPES = ['png', 'jpg', 'jpeg', 'bmp'];

    protected ConsoleLogger $logger;

    public function __construct()
    {
        $this->logger = new ConsoleLogger(new ConsoleOutput());
    }

    public function getValidFile(string $filePath) : ?File
    {
        $contents = $this->getValidContents($filePath);
        $name = $this->getValidName($filePath);
        $type = $this->getValidType($filePath);
        $size = $this->getValidSize($filePath);

        if ($contents !== null &&
            $name !== null &&
            $type !== null &&
            $size !== null
        ) {
            $file = new File();
            $file->setContents($contents);
            $file->setName($name);
            $file->setSize($size);
            $file->setType($type);
        }

        return null;
    }

    protected function getValidContents(string $filePath) : ?string
    {
        if (!$contents = file_get_contents($filePath, true)) {
            $this->logger->error("Cannot open this file!");
            return null;
        }

        return $contents;
    }

    protected function getValidName(string $filePath) : ?string
    {
        if (strpos($filePath, '.', 0) === 0) {
            $this->logger->error("Names starting with '.' are not allowed");
            return null;
        }

        return basename($filePath);
    }

    protected function getValidSize(string $filePath) : ?float
    {
        $size = filesize($filePath);

        if(!$size) {
            $this->logger->error("Invalid file");
            return null;
        }

        if($size > 5) {
            $this->logger->error("File size too big. Max 5Mb");
            return null;
        }

        return $size;
    }

    protected function getValidType(string $filePath) : ?string
    {
        $type = filetype($filePath);
        if (!in_array($type, self::ALLOWED_FILE_TYPES, true)) {
            $this->logger->error("File type not allowed");
            return null;
        }

        return $type;
    }
}
