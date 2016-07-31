<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\dialog;

use Yii;
use yii\base\Widget;
use yii\widgets\Pjax;

/**
 * Class DialogContainer TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class DialogContainer extends Widget
{

    /**
     * @var Pjax
     */
    private $_pjax;

    public function init()
    {
        if (Yii::$app->request->isPjax) {
            $id = Yii::$app->request->headers->get('X-PJAX-Container');
            if ($id) {
                $this->id = substr($id, 1);
                $this->_pjax = Pjax::begin([
                    'id' => $this->getId(),
                ]);
            }
        }
        parent::init();
    }

    public function run()
    {
        if ($this->_pjax) {
            $this->_pjax->end();
        }
        parent::run();
    }

}
