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
     * @var string Начальная дата производства
     */
    public $date_from;

    /**
     * @var string Конечная дата производства
     */
    public $date_to;

    /**
     * @var string Цены и склады
     */
    public $prices;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'date_from', 'date_to'], 'string'],
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
        $query = Product::find()
            ->with('prices.warehouse')
            ->orderBy(['manufactured_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (strtotime($this->date_from) > 0 || strtotime($this->date_to) > 0) {
            $query->andFilterWhere(['>=', 'to_timestamp(' . Product::tableName() . '.manufactured_at)::date', Yii::$app->formatter->asDate($this->date_from, 'php:yy-m-d')]);
            $query->andFilterWhere(['<=', 'to_timestamp(' . Product::tableName() . '.manufactured_at)::date', Yii::$app->formatter->asDate($this->date_to, 'php:yy-m-d')]);
        }

        $query->andFilterWhere(['ilike', 'name', $this->name]);

        return $dataProvider;
    }
}
