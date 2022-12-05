<?php

namespace app\models;

use app\components\QueezFormBehavior;
use yii\base\Model;

class QueezForm extends Model {

    public $result;
    public $answerId;
    public $questionId;

    public function behaviors() {
        return [
            QueezFormBehavior::class
        ];
    }

    public function rules() {
        return [
        ];
    }

}