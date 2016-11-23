<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;

class CCodeBlogChangePasswordComponent extends \CBitrixComponent
{

    protected $requiredModules = [];

    protected function isAjax() {
        return isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'y';
    }

    protected function checkModules() {
        foreach ($this->requiredModules as $moduleName) {
            if (!Loader::includeModule($moduleName)) {
                throw new SystemException(Loc::getMessage('COMPONENT_CHANGE_NO_MODULE', ['#MODULE#',
                                                                                         $moduleName]));
            }
        }

        return $this;
    }

    /**
     * Event called from includeComponent before component execution.
     * Takes component parameters as argument and should return it formatted as needed.
     *
     * @param  array [string]mixed $arParams
     *
     * @return array[string]mixed
     */
    public function onPrepareComponentParams($params) {

        $request = Application::getInstance()->getContext()->getRequest();

        $params['INPUT_DATA']['LOGIN']                  = trim($request->getQuery('USER_LOGIN'));
        $params['INPUT_DATA']['USER_CHECKWORD']         = trim($request->getQuery('USER_CHECKWORD'));
        $params['INPUT_DATA']['USER_PASSWORD']          = trim($request->getQuery('USER_PASSWORD'));
        $params['INPUT_DATA']['USER_CONFIRM_PASSWORD']  = trim($request->getQuery('USER_CONFIRM_PASSWORD'));
        $params['INPUT_DATA']['CHANGE_PASSWORD_SUBMIT'] = trim($request->getQuery('CHANGE_PASSWORD_SUBMIT'));

        return $params;
    }

    /**
     * Event called from includeComponent before component execution.
     * Includes component.php from within lang directory of the component.
     *
     * @return void
     */
    public function onIncludeComponentLang() {
        $this->includeComponentLang(basename(__FILE__));
        Loc::loadMessages(__FILE__);
    }

    protected function prepareResult() {

        if ($this->arParams['INPUT_DATA']['CHANGE_PASSWORD_SUBMIT'] == 'y') {

            global $USER;

            $this->arResult = $USER->ChangePassword($this->arParams['INPUT_DATA']['LOGIN'], $this->arParams['INPUT_DATA']['USER_CHECKWORD'], $this->arParams['INPUT_DATA']['USER_PASSWORD'], $this->arParams['INPUT_DATA']['USER_CONFIRM_PASSWORD']);
 
        } else {
            $this->arResult = ['MESSAGE' => '',
                               'TYPE'    => 'EMPTY'];
        }

        return $this;
    }

    public function executeComponent() {

        global $APPLICATION;


        try {
            $this->checkModules()->prepareResult();

            if ($this->isAjax()) {
                $APPLICATION->restartBuffer();
                echo json_encode(['status' => 'ok',
                                  'data'   => $this->arResult], JSON_FORCE_OBJECT);
                die();
            }

            $this->includeComponentTemplate();
        } catch (SystemException $e) {

            if ($this->isAjax()) {
                $APPLICATION->restartBuffer();
                echo json_encode(['status' => 'error',
                                  'data'   => $e->getMessage()], JSON_FORCE_OBJECT);
                die();
            }

            self::__showError($e->getMessage());
        }
    }
}