<?php

namespace app\components\abstractions\interfaces;

/**
 * Interface to be implemented by models classes and represents CRUD methods (Create, Read, Update and Delete)
 * Abstraction that force the model to implement it
 */
interface ModelInterface
{

    /**
     * Creation of the model.
     * Generally uses factories inside to delegate that job.
     */
    public static function create();

    /**
     * Validate the model
     */
    public function validate();

    /**
     * Find all the models
     *
     * @param $params
     */
    public static function findAll($params);

    /**
     * Find by params
     *
     * @param $params
     */
    public static function find($params);

    /**
     * Update on database
     */
    public function update();

    /**
     * Insert on database
     */
    public function insert();

    /**
     * Delete by params on database
     *
     * @param $params
     */
    public static function delete($params);
}
