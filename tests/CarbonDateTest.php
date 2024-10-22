<?php

namespace DoctrineExtensions\Tests;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Tools\SchemaTool;
use DoctrineExtensions\Tests\Entities\CarbonDate as Entity;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Carbon/Carbon object.
 *
 * @author Steve Lacey <steve@stevelacey.net>
 */
final class CarbonDateTest extends TestCase
{
    private EntityManager $em;

    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        foreach (self::typeProvider() as [$type,, $class]) {
            Type::addType($type, $class);
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    protected function setUp(): void
    {
        $config = new Configuration();
        $config->setMetadataCache(new ArrayAdapter());
        $config->setQueryCache(new ArrayAdapter());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\Tests\PHPUnit\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl(new AttributeDriver([__DIR__ . '/../Entities']));

        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ], $config);

        $this->em = new EntityManager($connection, $config);

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropDatabase();
        $schemaTool->createSchema([
            $this->em->getClassMetadata(Entity::class),
        ]);

        $entity = new Entity();
        $entity->id = 1;
        foreach (self::typeProvider() as [, $field,, $value]) {
            $entity->{$field} = $value;
        }
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @dataProvider typeProvider
     */
    public function testAllFields(string $type, string $field, string $class, CarbonInterface $value): void
    {
        $entity = $this->em->find(Entity::class, 1);
        $this->assertInstanceOf($value::class, $entity->{$field});

        if (in_array($field, ['date', 'date_immutable'])) {
            $this->assertEquals($value->format('Y-m-d'), $entity->{$field}->format('Y-m-d'));
        } else {
            $this->assertEquals($value, $entity->{$field});
        }
    }

    /**
     * @dataProvider typeProvider
     * @throws Exception
     */
    public function testTypesThatMapToAlreadyMappedDatabaseTypesRequireCommentHint(string $type): void
    {
        $platform = $this->getMockBuilder(AbstractPlatform::class)->getMock();
        $this->assertTrue(Type::getType($type)->requiresSQLCommentHint($platform));
    }


    public static function typeProvider(): array
    {
        return [
            ['CarbonDate',                'date',                  Types\CarbonDateType::class,                Carbon::createFromDate(2015, 1, 1)],
            ['CarbonDateTime',            'datetime',              Types\CarbonDateTimeType::class,            Carbon::create(2015, 1, 1, 0, 0, 0)],
            ['CarbonDateTimeTz',          'datetime_tz',           Types\CarbonDateTimeTzType::class,          Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific')],
            ['CarbonTime',                'time',                  Types\CarbonTimeType::class,                Carbon::createFromTime(12, 0, 0, 'Europe/London')],
            ['CarbonImmutableDate',       'date_immutable',        Types\CarbonImmutableDateType::class,       CarbonImmutable::createFromDate(2015, 1, 1)],
            ['CarbonImmutableDateTime',   'datetime_immutable',    Types\CarbonImmutableDateTimeType::class,   CarbonImmutable::create(2015, 1, 1, 0, 0, 0)],
            ['CarbonImmutableDateTimeTz', 'datetime_tz_immutable', Types\CarbonImmutableDateTimeTzType::class, CarbonImmutable::create(2012, 1, 1, 0, 0, 0, 'US/Pacific')],
            ['CarbonImmutableTime',       'time_immutable',        Types\CarbonImmutableTimeType::class,       CarbonImmutable::createFromTime(12, 0, 0, 'Europe/London')],
        ];
    }
}
