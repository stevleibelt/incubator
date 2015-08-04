<?php

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-08-02
 */
class AddToEntityManagerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $buildIsNeeded = ((!class_exists('Author'))
            || (!class_exists('Post')));

        if ($buildIsNeeded) {
            $path   = __DIR__;
            $schema = <<<EOF
<database name="create_entity_behavior" defaultIdMethod="native">
    <table name="Author">
        <column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />
    </table>

    <table name="Post">
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
            $configuration->setBuildProperty('behavior.add_to_entity_manager.class', __DIR__ . '/../source/AddToEntityManager');
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
