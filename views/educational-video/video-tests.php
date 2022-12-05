<?php
/** @var yii\web\View $this */
/** @var $params */

/** @var \app\models\VideoQueez $quuez */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$quuez = $params['queez'];
$model = $params['model'];
$videoUrl = $quuez->video_url;
$questions = $quuez->questions;
?>
<?php $this->beginPage(); ?>
<div class="container">
    <div>
        <iframe width="560" height="315" src="<?=$videoUrl?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <h4>Пройдя этот тест вы заработаете <?=$quuez->points;?> балла</h4>
    <?php $form = ActiveForm::begin(); ?>
    <?php foreach ($questions as $index => $question): ?>
        <div class="container">
            <h5><?= ($index + 1) . '. ' . $question->question; ?></h5>
            <?php
                $itemList = [];
                /**
                 * @var  int $index
                 * @var  \app\models\VideoQueezAnswers $answer
                 */
                foreach ($question->answers as $answer){
                    $itemList[$question->id . '-' . $answer->id] = $answer->answer;
                }
            ?>
            <?php //foreach ($question->answers as $index => $answer):?>
                <div class="form-check">
                    <?php echo $form->field($model, 'questionId[]')->hiddenInput(['value' => $question->id])->label(false); ?>
                    <?php echo $form->field($model, 'answerId[]')->radioList($itemList, ['separator' => '<br>', 'name' => "answerId-$question->id[]"])->label(false)?>

                </div>
            <?php //endforeach; ?>
        </div>
    <?php endforeach; ?>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']); ?>
    <?php ActiveForm::end(); ?>
</div>

<?php $this->endPage(); ?>
