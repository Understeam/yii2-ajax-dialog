<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\dialog;
use yii\web\JsExpression;

/**
 * Class SubmitButton TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class SubmitButton extends Button
{

    public $id = 'dialog-btn-submit';

    public $label = 'Submit';

    public $cssClass = 'btn-success';

    public $autospin = true;

    public function init()
    {
        $this->action = new JsExpression(<<<JS
function (dialog) {
    dialog.\$modalBody.find('form').first().submit()
    var button = dialog.getButton('dialog-btn-submit');
    button.hide();
}
JS
        );
        parent::init();
    }

}
