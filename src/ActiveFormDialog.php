<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\dialog;

/**
 * Class ActiveFormDialog TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class ActiveFormDialog extends Dialog
{

    public function init()
    {
        if (empty($this->buttons)) {
            $this->buttons = [
                CloseButton::className(),
                SubmitButton::className(),
            ];
        }
        parent::init();
    }

}
