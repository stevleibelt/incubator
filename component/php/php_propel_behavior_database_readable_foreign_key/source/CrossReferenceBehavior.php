<?php

/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-03-19
 */
class CrossReferenceBehavior extends Behavior
{
    protected $parameters = array(
        'cross_reference_query_class_name',
        'cross_reference_column_name'
    );

    public function modifyTable()
    {
        //begin of dependencies
        $columnName = $this->getParameter('cross_reference_column_name');
        $table      = $this->getTable();
        //end of dependencies

        //begin of business logic
        $addColumn  = (!$table->hasColumn($columnName));

        if ($addColumn) {
            $table->addColumn(
                array(
                    'name'  => $columnName,
                    'type'  => 'INT'
                )
            );
        }
        //end of business logic
    }

    public function queryMethods(QueryBuilder $builder)
    {
        $script = '';

        $queryClassName         = $builder->getStubQueryBuilder()->getClassname();
        $createColumnConstant   = $this->getColumnConstant('create_column', $builder);
    }
}