<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Warehouse;

/**
 * Модель поиска по данным складов.
 */
class WarehouseSearch extends Warehouse
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Создает экземпляр поставщика данных с примененным поисковым запросом.
     *
     * @param array $params Параметры запроса
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Warehouse::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'code' => $this->code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name]);

        return $dataProvider;
    }
}
