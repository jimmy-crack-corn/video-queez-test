<?php

namespace app\helpers;

use app\models\VideoQueez;
use app\models\VideoQueezAnswers;
use app\models\VideoQueezToEmployee;

class VideoQueezHelper {

    public function __construct() {
    }

    public static function getQueezById($id) {
        return VideoQueez::find()->where(['id' => $id])->with('questions')->one();
    }

    public static function checkIfAnswersCorrect($data) {
        $questionByAnswer = [];
        $answerIds = [];
        foreach ($data as $questionId => $answerId) {
            $questionByAnswer[$answerId] = $questionId;
            $answerIds[] = $answerId;
        }
        /** @var VideoQueezAnswers $answersFromBase */
        $answersFromBase = VideoQueezAnswers::find()->where(['id' => $answerIds])->all();
        foreach ($answersFromBase as $answerFromBase) {
            $isCorrect = $answerFromBase->is_correct;
            if (!$isCorrect) return [false, $questionByAnswer[$answerFromBase->id]];
        }
        return [true];
    }

    public static function setQueezAsPassed($queezId, $userGuid) {
        $currentQueez = VideoQueezToEmployee::find()->where(['queez_id' => $queezId, 'guid' => $userGuid])->one();
        $currentQueez->is_passed = true;
        $currentQueez->save();
    }

    public static function getNextQueezId($guid) {
        $availableQueezes = VideoQueezToEmployee::find()
            ->where(['guid' => $guid, 'is_passed' => false])
            ->orderBy(['id' => SORT_ASC])
            ->all();
        if (!empty($availableQueezes)) {
            return $availableQueezes[0];
        }
    }

}