<?php
declare(strict_types=1);

use App\File;
use App\FileValidator;
use App\Services\FileManager;
use PHPUnit\Framework\TestCase;

class FileManagerTest extends TestCase
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

        $result = $this->sut->save('invalidFile.txt');

        $this->assertFalse($result);
    }

    public function testItSavesFile(): void
    {
        $fullFileName = "tests/Unit/fixture/test.png";
        $file = $this->getRealFile($fullFileName);

        $this->mockValidator
            ->expects($this->once())
            ->method('getValidFile')
            ->willReturn($file);

        $result = $this->sut->save($fullFileName);

        $this->assertTrue($result);
    }

    public function testItGetsExistingFile(): void
    {
        $fullFileName = "tests/Unit/fixture/test.png";
        $file = $this->getRealFile($fullFileName);

        $this->mockValidator
            ->expects($this->exactly(2))
            ->method('getValidFile')
            ->willReturn($file);

        $result = $this->sut->save($fullFileName);
        $this->assertTrue($result);

        $result = $this->sut->get("test.png");
        $this->assertNotEmpty($result);
    }


    public function testItDeletesExistingFile(): void
    {
        $fullFileName = "tests/Unit/fixture/test.png";
        $file = $this->getRealFile($fullFileName);

        $this->mockValidator
            ->expects($this->exactly(2))
            ->method('getValidFile')
            ->willReturn($file);

        $result = $this->sut->save($fullFileName);
        $this->assertTrue($result);

        $result = $this->sut->delete("test.png");
        $this->assertNotEmpty($result);
    }

    /**
     * @param string $fullFileName
     * @return File
     */
    protected function getRealFile(string $fullFileName): File
    {
        //I would have preferred to mock the file but i did not
        //find a package for that in time
        $realFile = file_get_contents($fullFileName);

        $file = new File();
        $file->setName(basename($fullFileName));
        $file->setType(filetype($fullFileName));
        $file->setSize(filesize($fullFileName));
        $file->setContents($realFile);
        return $file;
    }
}
