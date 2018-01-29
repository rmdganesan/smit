<?php

namespace app\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\common\models\Users;

/**
 * UsersSearch represents the model behind the search form about `app\common\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'clientid', 'default_Group', 'default_Location', 'default_template', 'default_address'], 'integer'],
            [['stripeId', 'type', 'displayname', 'firstname', 'lastname', 'companyname', 'email', 'image', 'dob', 'corpuser', 'createddate', 'updateddate', 'status', 'cardnumber'], 'safe'],
            [['nXBalance'], 'number'],
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
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
            'pagesize' => 2 // in case you want a default pagesize
        ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'clientid' => $this->clientid,
            'default_Group' => $this->default_Group,
            'default_Location' => $this->default_Location,
            'nXBalance' => $this->nXBalance,
            'dob' => $this->dob,
            'createddate' => $this->createddate,
            'updateddate' => $this->updateddate,
            'default_template' => $this->default_template,
            'default_address' => $this->default_address,
        ]);

        $query->andFilterWhere(['like', 'stripeId', $this->stripeId])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'displayname', $this->displayname])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'companyname', $this->companyname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'corpuser', $this->corpuser])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'cardnumber', $this->cardnumber]);

        return $dataProvider;
    }
}
