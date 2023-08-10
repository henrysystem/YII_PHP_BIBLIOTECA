<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Libro;
use yii\grid\GridView;

/**
 * LibroSearch represents the model behind the search form of `app\models\Libro`.
 */
class LibroSearch extends Libro
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['lb_codigo'], 'integer'],
      [['lb_titulo', 'imagen', 'id_format'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function scenarios()
  {
    // bypass scenarios() implementation in the parent class
    return Model::scenarios();
  }

  /**
   * Creates data provider instance with search query applied
   *
   * @param array $params
   *
   * @return ActiveDataProvider
   */
  public function search($params)
  {
    $query = Libro::find();

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => ['pageSize' => 2]
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    // grid filtering conditions
    $query->andFilterWhere([
      'lb_codigo' => $this->lb_codigo,
    ]);

    $query->andFilterWhere(['like', 'lb_titulo', $this->lb_titulo])
      ->andFilterWhere(['like', 'imagen', $this->imagen])
      ->andFilterWhere(['like', 'id_format', $this->id_format]);

    return $dataProvider;
  }
}
