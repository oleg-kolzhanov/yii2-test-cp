<?php

namespace api\components;

use yii\base\Arrayable;
use yii\rest\Serializer as RestSerializer;

class Serializer extends RestSerializer
{
    /**
     * Serializes a model object.
     *
     * @param Arrayable $model
     * @return Arrayable|null
     */
    protected function serializeModel($model)
    {
        if ($this->request->getIsHead()) {
            return null;
        }

        return $model;
    }

    /**
     * Serializes a set of models.
     * @param array $models
     * @return array the array representation of the models
     */
    protected function serializeModels(array $models)
    {
        return $models;
    }

}
