<?php

namespace app\traits;

use app\components\JsonConnection;
use app\components\ModelError;

trait DataManipulationTrait
{
    /**
     * Set and populate model with attributes
     * from JSON file
     *
     * @param $model
     *
     * @return mixed
     */
    public static function resolveAttributes($model)
    {
        $connectionData = [
            'host'    => 'app/data/' . $model->myName . '.json',
            'command' => 'r'
        ];

        $connection = new JsonConnection($connectionData);
        if (is_string($connection->bootstrap())) {
            $model->addError(new ModelError('JsonConnection', $connection->bootstrap()));
        }
        $connection->bootstrap();
        $attributes = $connection->getDataCollection($connection->connection);
        if (!is_array($attributes)) {
            $model->addError(new ModelError('JsonConnection', $attributes));
        }
        $connection->end();

        if (is_array($attributes['name'])) {
            shuffle($attributes['name']);
            $attributes['name'] = $attributes['name'][0];
        }

        if (!$model->hasErrors()) {
            $model->loadAttributes($attributes);
        }

        return $model;
    }

    /**
     * Set initial value for attributes based on range
     *
     * @param $model
     *
     * @return mixed
     */
    public static function initAttributes($model)
    {
        if ($model->data['attributes']) {
            foreach ($model->data['attributes'] as $name => $range) {
                $model->data['attributes'][$name] = self::setRandomNumber($range);
            }
        } else {
            unset($model->data['attributes']);
        }

        return $model;
    }

    /**
     * Set random number from a range
     *
     * @param array $range
     *
     * @return integer
     */
    public static function setRandomNumber(array $range)
    {
        return mt_rand($range[0], $range[1]);
    }

    /**
     * Calculate chance by percent
     *
     * @param $percent
     *
     * @return bool
     */
    public static function probabilityByPercent($percent)
    {
        return mt_rand(1, 100) < $percent;
    }

}
