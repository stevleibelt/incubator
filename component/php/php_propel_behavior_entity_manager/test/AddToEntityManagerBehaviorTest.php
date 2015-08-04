<?php
use org\bovigo\vfs\vfsStream;

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-08-02
 */
class AddToEntityManagerBehaviorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $buildIsNeeded = ((!class_exists('CreateEntityBehaviorTableOne'))
            || (!class_exists('CreateEntityBehaviorTableTwo')));

        if ($buildIsNeeded) {
            $fileSystem = vfsStream::setup();
            $path       = $fileSystem->url();
            //$path       = __DIR__;
            $schema     = <<<EOF
<database name="create_entity_behavior" defaultIdMethod="native">
    <table name="CreateEntityBehaviorTableOne">
        <column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
    </table>

    <table name="CreateEntityBehaviorTableTwo">
        <column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
    </table>

    <behavior name="add_to_entity_manager">
        <parameter name="indention" value="    " />
        <parameter name="namespace" value="Net\Bazzline\Propel" />
        <parameter name="path_to_output" value="$path" />
    </behavior>
</database>
EOF;

            $builder        = new PropelQuickBuilder();
            $configuration  = $builder->getConfig();
            $configuration->setBuildProperty('behavior.add_to_entity_manager.class', __DIR__ . '/../source/AddToEntityManagerBehavior');
            $builder->setConfig($configuration);
            $builder->setSchema($schema);

            $builder->build();
        }
    }

    public function testFoo()
    {
        $this->assertTrue(true);
    }
/*
    public function testMethodExist()
    {
        $this->assertTrue(method_exists('PostQuery', 'createEntity'));
    }

    public function testCreateEntity()
    {
        $entity = new Post();
        $query  = PostQuery::create();

        $this->assertEquals($entity, $query->createEntity());
    }
*/
}
