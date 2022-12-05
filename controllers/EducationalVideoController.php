<?php

namespace app\controllers;

use app\helpers\VideoQueezHelper;
use app\models\QueezForm;
use yii\web\Controller;

class EducationalVideoController extends Controller {

    public function __construct($id, $module, $config = []) {
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $userGuid = 'abcdefu';
        $currentQueez = VideoQueezHelper::getNextQueezId($userGuid);
        if (empty($currentQueez)) {
            return $this->render('congratulations');
        }
        /** @var int $queezId */
        $queezId = $currentQueez->id;
        $queez = VideoQueezHelper::getQueezById($queezId);
        $model = new QueezForm();
        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                $checkData = $model->result;
                $result = VideoQueezHelper::checkIfAnswersCorrect($checkData);
                if ($result[0]) {
                    VideoQueezHelper::setQueezAsPassed($queezId, $userGuid);
                    $this->refresh();
                } else {
                    echo 'Вы допустили ошибки. Попробуйте еще раз.';
                }
            } else {
                echo 'Форма не заполнена.';
            }
        }
        $params = [
            'queez' => $queez,
            'model' => $model
        ];
        return $this->render('video-tests', compact('params'));
    }

}