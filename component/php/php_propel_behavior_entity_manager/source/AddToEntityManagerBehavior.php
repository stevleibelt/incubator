<?php

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-08-02
 * @todo make parameters optional (only set them when they are set) - this would enable it to define everything in the database scope and the rest in the table scope without overwriting database scoped things
 */
class AddToEntityManagerBehavior extends Behavior
{
    const PARAMETER_ADD_IT          = 'add_it';
    const PARAMETER_INDENTION       = 'indention';
    const PARAMETER_NAMESPACE       = 'namespace';
    const PARAMETER_PATH_TO_OUTPUT  = 'path_to_output';

    /** @var array */
    protected $parameters = array(
        self::PARAMETER_ADD_IT          => true,
        self::PARAMETER_INDENTION       => '    ',
        self::PARAMETER_NAMESPACE       => '',
        self::PARAMETER_PATH_TO_OUTPUT  => 'data'
    );

    /** @var bool */
    private $parametersNotUsed = true;

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
    /**
    public function objectMethods($builder)
    {
        $this->addObjectToEntityManager($builder);

        return '';
    }
     */

    /**
     * @param DataModelBuilder $builder
     */
    public function addObjectToEntityManager(DataModelBuilder $builder)
    {
        if ($this->addIt() {
            $generator = $this->getGenerator();

            //add query method
            $generator->add(
                $builder->getDatabase()->getName(),
                $builder->getStubObjectBuilder()->getClassname(),
                $builder->getStubObjectBuilder()->getFullyQualifiedClassname()
            );
        }
    }

    /**
     * @param DataModelBuilder $builder
     */
    public function addQueryToEntityManager(DataModelBuilder $builder)
    {
        if ($this->addIt() {
            $generator = $this->getGenerator();

            //add query method
            $generator->add(
                $builder->getDatabase()->getName(),
                $builder->getStubQueryBuilder()->getClassname(),
                $builder->getStubQueryBuilder()->getFullyQualifiedClassname()
            );
        }
    }

    /**
     * @return EntityManagerGenerator
     */
    private function getGenerator()
    {
        $generator = EntityManagerGenerator::getInstance();

        if ($this->parametersNotUsed) {
            $this->parametersNotUsed = false;
            $generator->setIndention($this->parameters[self::PARAMETER_INDENTION]);
            $generator->setPathToOutput($this->parameters[self::PARAMETER_PATH_TO_OUTPUT]);
        }

        return $generator;
    }

    /**
     * @return bool
     */
    private function addIt()
    {
        return (isset($this->parameters[self::PARAMETER_ADD_IT]))
            ? $this->parameters[self::PARAMETER_ADD_IT]
            : false;
    }
}
