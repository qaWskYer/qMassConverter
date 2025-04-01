<?php
namespace MassConverter\Test;

use MassConverter\Converter\JpegToGifConverter;
use MassConverter\Converter\JpegToPngConverter;
use MassConverter\FileFinder\FileFinder;
use MassConverter\FileFinder\RegexFilter;
use MassConverter\MassConverter;
use MassConverter\validators\JpegValidator;
use PHPUnit\Framework\TestCase;

class MassConvertTest extends TestCase
{
    public function test_collect()
    {
        $reflClass = new \ReflectionClass(get_class($this));
        $dir = dirname($reflClass->getFileName()) . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR . 'test1' . DIRECTORY_SEPARATOR;
        
        $converter = new MassConverter($dir, new FileFinder(new JpegValidator(), new RegexFilter('/.*/')), new JpegToPngConverter());
        $result = $converter->collectFiles()
            ->getFiles();
        
        $this->assertCount(1, $result);
        $this->assertFileExists($result[0]);
    }
    
    public function test_convert()
    {
        $reflClass = new \ReflectionClass(get_class($this));
        $dirSource      = dirname($reflClass->getFileName()) . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR . 'test1' . DIRECTORY_SEPARATOR;
        $dirDestination = dirname($reflClass->getFileName()) . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR . 'test1_dest' . DIRECTORY_SEPARATOR;
        
        $converter = new MassConverter($dirSource, new FileFinder(new JpegValidator(), new RegexFilter('/.*/')), new JpegToPngConverter());
        $result = $converter->collectFiles()
            ->setQuality(1)
            ->enableCreateDirectory(true)
            ->convert($dirDestination);
        
        $this->assertEquals([], $converter->getErrors());
        $this->assertTrue($result);
        $this->assertFileExists($dirDestination . 'SampleJPGImage_50kbmb.png');
    }
    
    public function test_convertToGif()
    {
        $reflClass = new \ReflectionClass(get_class($this));
        $dirSource      = dirname($reflClass->getFileName()) . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR . 'test1' . DIRECTORY_SEPARATOR;
        $dirDestination = dirname($reflClass->getFileName()) . DIRECTORY_SEPARATOR . '_data' . DIRECTORY_SEPARATOR . 'test2_dest' . DIRECTORY_SEPARATOR;
        
        $converter = new MassConverter($dirSource, new FileFinder(new JpegValidator(), new RegexFilter('/.*/')), new JpegToGifConverter());
        $result = $converter->collectFiles()
            ->enableCreateDirectory(true)
            ->convert($dirDestination);
        
        $this->assertEquals([], $converter->getErrors());
        $this->assertTrue($result);
        $this->assertFileExists($dirDestination . 'SampleJPGImage_50kbmb.gif');
    }
}
