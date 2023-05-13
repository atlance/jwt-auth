<?php

declare(strict_types=1);

namespace Atlance\JwtAuth\Tests\Functional;

use Atlance\JwtAuth\Tests\Kernel\ContainerFactory;
use Faker\Factory as DataFactory;
use Faker\Generator as DataGenerator;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class KernelTestCase extends BaseTestCase
{
    protected ?ContainerInterface $container = null;

    protected ?DataGenerator $dataGenerator = null;

    protected static ContainerInterface $staticContainer;

    protected static DataGenerator $staticDataGenerator;

    protected function service(string $id)
    {
        return $this->container->get($id);
    }

    protected function parameter(string $name)
    {
        return $this->container->getParameter($name);
    }

    public static function dg(): DataGenerator
    {
        if (!isset(self::$staticDataGenerator)) {
            self::$staticDataGenerator = DataFactory::create();
        }

        return self::$staticDataGenerator;
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (!isset(self::$staticContainer)) {
            self::$staticContainer = (new ContainerFactory())
                ->create(getenv('APP_ENV'), (bool) getenv('APP_DEBUG'));
        }

        if (!isset(self::$staticDataGenerator)) {
            self::$staticDataGenerator = DataFactory::create();
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = self::$staticContainer;
        $this->dataGenerator = self::$staticDataGenerator;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->container = null;
        $this->dataGenerator = null;
    }
}
