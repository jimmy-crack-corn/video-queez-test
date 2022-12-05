<?php

namespace app\components;

use yii\base\Behavior;
use yii\base\Model;

class QueezFormBehavior extends Behavior {

    public function events() {
        return [
            Model::EVENT_BEFORE_VALIDATE => function ($event) {
                $post = \Yii::$app->request->post();
                $formData = !empty($post['QueezForm']) ? $post['QueezForm'] : null;
                if (!is_null($formData)) {
                    $questionIds = $formData['questionId'];
                    if (!empty($questionIds)) {
                        foreach ($questionIds as $questionId) {
                            $answerIds = $post['answerId-' . $questionId];
                            /** @var  $answerComplexId - содержит в себе id вопроса и id ответа,
                             поэтому разбиваю */
                            foreach ($answerIds as $answerComplexId) {
                                if (!empty($answerComplexId)) {
                                    $resultArray = explode('-', $answerComplexId);
                                    $answerId = $resultArray[1];
                                    $this->owner->result[$questionId] = $answerId;
                                }
                            }
                        }
                    }
                }
            }
        ];
    }

}