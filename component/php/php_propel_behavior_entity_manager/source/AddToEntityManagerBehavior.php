<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'Entity.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'EntityManagerGenerator.php');

use Net\Bazzline\Propel\Behavior\EntityManager\Entity;
use Net\Bazzline\Propel\Behavior\EntityManager\EntityManagerGenerator;

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-08-02
 * @todo make parameters optional (only set them when they are set) - this would enable it to define everything in the database scope and the rest in the table scope without overwriting database scoped things
 */
class AddToEntityManagerBehavior extends Behavior
{
    const PARAMETER_ENTITY_ADD_IT_TO_ENTITY_MANAGER = 'entity_add_to_entity_manager';
    const PARAMETER_ENTITY_MANAGER_CLASS_NAME       = 'entity_manager_class_name';
    const PARAMETER_ENTITY_MANAGER_INDENTION        = 'entity_manager_indention';
    const PARAMETER_ENTITY_MANAGER_NAMESPACE        = 'entity_manager_namespace';
    const PARAMETER_ENTITY_MANAGER_PATH_TO_OUTPUT   = 'entity_manager_path_to_output';
    const PARAMETER_ENTITY_METHOD_NAME_PREFIX       = 'entity_method_name_prefix';

    /** @var array */
    protected $parameters = array(
        self::PARAMETER_ENTITY_ADD_IT_TO_ENTITY_MANAGER => true,
        self::PARAMETER_ENTITY_MANAGER_CLASS_NAME       => 'EntityManager',
        self::PARAMETER_ENTITY_MANAGER_INDENTION        => '    ',
        self::PARAMETER_ENTITY_MANAGER_NAMESPACE        => null,
        self::PARAMETER_ENTITY_MANAGER_PATH_TO_OUTPUT   => 'data',
        self::PARAMETER_ENTITY_METHOD_NAME_PREFIX       => null
    );

    /** @var bool */
    private $isTheFirstTimeTheGeneratorIsUsed = true;

    /**
     * @param DataModelBuilder $builder
     * @return string
     */
    public function queryMethods($builder)
    {
        $this->addQueryToEntityManager($builder);

        return '';
    }

    /**
     * @param DataModelBuilder $builder
     * @return string
     */
    public function objectMethods($builder)
    {
        $this->addObjectToEntityManager($builder);

        return '';
    }

    /**
     * @param DataModelBuilder $builder
     */
    public function addObjectToEntityManager(DataModelBuilder $builder)
    {
        if ($this->addIt()) {
            $generator  = $this->getGenerator();
            $entity     = $this->buildEntityFromObject($builder);
            $generator->add($entity);
        }
    }

    /**
     * @param DataModelBuilder $builder
     */
    public function addQueryToEntityManager(DataModelBuilder $builder)
    {
        if ($this->addIt()) {
            $generator  = $this->getGenerator();
            $entity     = $this->buildEntityFromQuery($builder);
            $generator->add($entity);
        }
    }

    /**
     * @param DataModelBuilder $builder
     * @return Entity
     */
    private function buildEntityFromObject(DataModelBuilder $builder)
    {
        $methodNamePrefix = $this->returnDatabaseNameIfMethodNamePrefixIsNotProvided($builder);

        return new Entity(
            $builder->getDatabase()->getName(),
            $builder->getStubObjectBuilder()->getFullyQualifiedClassname(),
            $builder->getStubObjectBuilder()->getClassname(),
            $methodNamePrefix
        );
    }

    /**
     * @param DataModelBuilder $builder
     * @return Entity
     */
    private function buildEntityFromQuery(DataModelBuilder $builder)
    {
        $methodNamePrefix = $this->returnDatabaseNameIfMethodNamePrefixIsNotProvided($builder);

        return new Entity(
            $builder->getDatabase()->getName(),
            $builder->getStubQueryBuilder()->getFullyQualifiedClassname(),
            $builder->getStubQueryBuilder()->getClassname(),
            $methodNamePrefix
        );
    }

    /**
     * @param DataModelBuilder $builder
     * @return string
     */
    private function returnDatabaseNameIfMethodNamePrefixIsNotProvided(DataModelBuilder $builder)
    {
        $methodNamePrefix = (is_null($this->parameters[self::PARAMETER_ENTITY_METHOD_NAME_PREFIX]))
            ? $builder->getDatabase()->getName()
            : $this->parameters[self::PARAMETER_ENTITY_METHOD_NAME_PREFIX];

        return $methodNamePrefix;
    }

    /**
     * @return EntityManagerGenerator
     */
    private function getGenerator()
    {
        $generator = EntityManagerGenerator::getInstance();

        if ($this->isTheFirstTimeTheGeneratorIsUsed) {
            $this->isTheFirstTimeTheGeneratorIsUsed = false;
            $pathToOutput   = $this->parameters[self::PARAMETER_ENTITY_MANAGER_PATH_TO_OUTPUT];
            $isAbsolutePath = (strncmp($pathToOutput, DIRECTORY_SEPARATOR, strlen(DIRECTORY_SEPARATOR)) === 0);

            $absolutePathToOutput   = ($isAbsolutePath)
                ? $pathToOutput
                : getcwd() . (str_repeat(DIRECTORY_SEPARATOR . '..', 4)) . DIRECTORY_SEPARATOR . $pathToOutput;
            $className      = $this->parameters[self::PARAMETER_ENTITY_MANAGER_CLASS_NAME];
            $indention      = $this->parameters[self::PARAMETER_ENTITY_MANAGER_INDENTION];
            $namespace      = $this->parameters[self::PARAMETER_ENTITY_MANAGER_NAMESPACE];

            $generator->configure($absolutePathToOutput, $className, $indention, $namespace);
        }

        return $generator;
    }

    /**
     * @return bool
     */
    private function addIt()
    {
        return (isset($this->parameters[self::PARAMETER_ENTITY_ADD_IT_TO_ENTITY_MANAGER]))
            ? $this->parameters[self::PARAMETER_ENTITY_ADD_IT_TO_ENTITY_MANAGER]
            : false;
    }
}
