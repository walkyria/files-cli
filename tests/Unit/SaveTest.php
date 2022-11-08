<?php
declare(strict_types=1);

use App\FileValidator;
use App\Services\FileManager;
use PHPUnit\Framework\TestCase;

class SaveTest extends TestCase
{
    protected FileManager $sut;
    protected FileValidator $mockValidator;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockValidator = $this->createMock(FileValidator::class);
        $this->sut = new FileManager($this->mockValidator);
    }

    public function testItValidatesFile(): void
    {
        $this->mockValidator
            ->expects($this->once())
            ->method('getValidFile')
            ->willReturn(null);

        $this->sut->save('invalidFile.txt');
    }
}
