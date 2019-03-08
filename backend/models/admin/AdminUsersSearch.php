<?php

namespace plathir\user\backend\models\admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use plathir\user\backend\models\admin\AdminUsers;

/**
 * UserProfileSearch represents the model behind the search form about `common\extensions\user\models\UserProfile`.
 */
class AdminUsersSearch extends AdminUsers {

    public $full_name;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'username', 'email', 'status'], 'safe'],
            [['id', 'status'], 'integer'],
            [['timezone'], 'string'],
            [['full_name'], 'string'],
            [['created_at', 'updated_at'], 'date', 'format' => Yii::$app->settings->getSettings('ShortDateFormat'), 'message' => '{attribute} must be DD/MM/YYYY format.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = AdminUsers::find();
        $query->join('LEFT OUTER JOIN', 'user_profile', '{{%user.id}} = user_profile.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Set Sorting fields 
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'username',
                'full_name' => [
                    'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ],
                'email',
                'status',
                'created_at',
                'updated_at'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            '{{%user}}.id' => $this->id,
            'username' => $this->username,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', "( FROM_UNIXTIME({{%user}}.created_at, '" . Yii::$app->settings->getSettings('DBShortDateFormat') . " %h:%i:%s %p' ))", $this->created_at])
                ->andFilterWhere(['like', "( FROM_UNIXTIME({{%user}}.updated_at, '" . Yii::$app->settings->getSettings('DBShortDateFormat') . " %h:%i:%s %p' ))", $this->updated_at])
                ->andFilterWhere(['like', '{{%user_profile}}.first_name', $this->full_name])
                ->orFilterWhere(['like', '{{%user_profile}}.last_name', $this->full_name]);

        return $dataProvider;
    }

}
