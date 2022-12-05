<?php

namespace app\models;

use yii\db\ActiveRecord;

class VideoQueez extends ActiveRecord {

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions() {
        return $this->hasMany(VideoQueezQuestions::className(), ['queez_id' => 'id']);
    }

}