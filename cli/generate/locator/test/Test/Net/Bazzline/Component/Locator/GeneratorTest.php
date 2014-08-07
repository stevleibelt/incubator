<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-06-26 
 */

namespace Test\Net\Bazzline\Component\Locator;

/**
 * Class GeneratorTest
 * @package Test\Net\Bazzline\Component\Locator
 */
class GeneratorTest extends LocatorTestCase
{
    public function testSetters()
    {
        $generator = $this->getGenerator();

        $this->assertEquals($generator, $generator->setFactoryInterfaceGenerator($this->getMockOfFactoryInterfaceGenerator()));
        $this->assertEquals($generator, $generator->setInvalidArgumentExceptionGenerator($this->getMockOfInvalidArgumentExceptionGenerator()));
        $this->assertEquals($generator, $generator->setLocatorGenerator($this->getMockOfLocatorGenerator()));
    }

    /**
     * @return array
     */
    public static function generateTestDataProvider()
    {
        return array(
            'just locator generator' => array(
                'hasFactoryInstances' => false,
                'hasSharedInstances' => false
            ),
            'with factory interface' => array(
                'hasFactoryInstances' => true,
                'hasSharedInstances' => false
            ),
            'with shared instances' => array(
                'hasFactoryInstances' => false,
                'hasSharedInstances' => true
            ),
            'with factory interface and shared instances' => array(
                'hasFactoryInstances' => true,
                'hasSharedInstances' => true
            )
        );
    }

    /**
     * @dataProvider generateTestDataProvider
     * @param bool $hasFactoryInstance
     * @param bool $hasSharedInstances
     */
    public function testGenerate($hasFactoryInstance, $hasSharedInstances)
    {
        $generator = $this->getGenerator();
        $configuration = $this->getMockOfConfiguration();
        $fileExistsStrategy = $this->getMockOfFileExistsStrategyInterface();
        $locatorGenerator = $this->getMockOfLocatorGenerator();

        $configuration->shouldReceive('getFilePath')
            ->andReturn(sys_get_temp_dir())
            ->twice();
        $configuration->shouldReceive('hasFactoryInstances')
            ->andReturn($hasFactoryInstance)
            ->twice();
        $configuration->shouldReceive('hasSharedInstances')
            ->andReturn($hasSharedInstances)
            ->atMost();

        $locatorGenerator->shouldReceive('setConfiguration')
            ->with($configuration)
            ->once();
        $locatorGenerator->shouldReceive('setFileExistsStrategy')
            ->with($fileExistsStrategy)
            ->once();
        $locatorGenerator->shouldReceive('generate')
            ->once();

        if ($hasFactoryInstance) {
            $factoryInterfaceGenerator = $this->getMockOfFactoryInterfaceGenerator();

            $factoryInterfaceGenerator->shouldReceive('setConfiguration')
                ->with($configuration)
                ->once();
            $factoryInterfaceGenerator->shouldReceive('setFileExistsStrategy')
                ->with($fileExistsStrategy)
                ->once();
            $factoryInterfaceGenerator->shouldReceive('generate')
                ->once();

            $generator->setFactoryInterfaceGenerator($factoryInterfaceGenerator);
        }

        if ($hasFactoryInstance || $hasSharedInstances) {
            $invalidArgumentExceptionGenerator = $this->getMockOfInvalidArgumentExceptionGenerator();

            $invalidArgumentExceptionGenerator->shouldReceive('setConfiguration')
                ->with($configuration)
                ->once();
            $invalidArgumentExceptionGenerator->shouldReceive('setFileExistsStrategy')
                ->with($fileExistsStrategy)
                ->once();
            $invalidArgumentExceptionGenerator->shouldReceive('generate')
                ->once();

            $generator->setInvalidArgumentExceptionGenerator($invalidArgumentExceptionGenerator);
        }

        $generator->setConfiguration($configuration);
        $generator->setFileExistsStrategy($fileExistsStrategy);
        $generator->setLocatorGenerator($locatorGenerator);

        $generator->generate();
    }
}