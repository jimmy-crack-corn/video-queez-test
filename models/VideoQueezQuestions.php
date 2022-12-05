<?php

namespace app\models;

use yii\db\ActiveRecord;

class VideoQueezQuestions extends ActiveRecord {

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers() {
        return $this->hasMany(VideoQueezAnswers::className(), ['question_id' => 'id']);
    }

}