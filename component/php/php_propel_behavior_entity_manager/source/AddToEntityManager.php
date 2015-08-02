<?php

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-08-02
 */
class AddToEntityManager extends Behavior
{
    /**
     * @param DataModelBuilder $builder
     * @return string
     */
    public function queryMethods($builder)
    {
        $this->addToEntityManager($builder);

        return '';
    }

    /**
     * @param DataModelBuilder $builder
     */
    public function addToEntityManager(DataModelBuilder $builder)
    {
        $generator  = EntityManagerGenerator::getInstance();
        $className  = $builder->getStubObjectBuilder()->getFullyQualifiedClassname();
    }
}