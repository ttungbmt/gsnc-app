<?php

namespace common\modules\auth\search;

use common\libs\activitylog\Log;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\libs\activitylog\models\Activity;

/**
 * AuthLogSearch represents the model behind the search form about `common\libs\activitylog\models\Activity`.
 */
class LogAuthSearch extends Activity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'subject_id', 'causer_id'], 'integer'],
            [['log_name', 'description', 'subject_type', 'causer_type', 'properties', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Activity::find()
            ->joinWith(['causer', 'userInfo'])
            ->where(['log_name' => Log::AUTH]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'causer_id'  => $this->causer_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
