<?php

namespace common\models\search;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * Модель поиска по данным продукта.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'quantity'], 'integer'],
            [['manufactured_at'], 'string'],
            [['name', 'description'], 'safe'],
            [['cost'], 'number'],
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
     * @return ActiveDataProvider
     * @throws InvalidConfigException
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (strtotime($this->manufactured_at) > 0) {
            $query->andFilterWhere(['to_timestamp(' . Product::tableName() . '.manufactured_at)::date' => Yii::$app->formatter->asDate($this->manufactured_at, 'php:yy-m-d')]);
        }

        $query->andFilterWhere([
            'cost' => $this->cost,
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
