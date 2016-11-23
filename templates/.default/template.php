<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

?>
<div class="row">
    <div class="col-lg-offset-6 col-lg-3">
        <h3><?= Loc::getMessage('AUTH_CHANGE_PASSWORD') ?></h3>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-offset-6 col-lg-3">
            <? if ($arResult['TYPE'] == 'OK') { ?>
                <div class="alert alert-success">
                    <?= Loc::getMessage('AUTH_NEW_PASSWORD_CHANGED') ?>
                </div>
                <?
                return;
            } elseif ($arResult['TYPE'] == 'ERROR') { ?>
                <div class="alert alert-danger">
                    <? ShowMessage($arResult); ?>
                </div>
                <?
            } ?>

            <form method="get" action="<?= $arResult['AUTH_FORM'] ?>" name="bform">

                <input type="hidden" name="CHANGE_PASSWORD_SUBMIT" value="y">
                <input type="hidden" name="change_password" value="yes">
                <div class="form-group">
                    <label class="control-label"
                           for="email"><?= Loc::getMessage('AUTH_EMAIL') ?></label>
                    <div class="bx-authform-input-container">
                        <input class="form-control" type="text" name="USER_LOGIN" maxlength="255"
                               value="<?= $arParams['INPUT_DATA']['LOGIN'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"
                           for="email"><?= Loc::getMessage('AUTH_CHECKWORD') ?></label>
                    <input class="form-control" type="text" name="USER_CHECKWORD" maxlength="255"
                           value="<?= $arParams['INPUT_DATA']['USER_CHECKWORD'] ?>">
                </div>


                <div class="form-group">
                    <label class="control-label"
                           for="email"> <?= Loc::getMessage('AUTH_NEW_PASSWORD_REQ') ?></label>
                    <input class="form-control" type="password" name="USER_PASSWORD" maxlength="255"
                           value="<?= $arResult['USER_PASSWORD'] ?>"
                           autocomplete="off">
                </div>


                <div class="form-group">
                    <label class="control-label"
                           for="email"> <?= Loc::getMessage('AUTH_NEW_PASSWORD_CONFIRM') ?></label>
                    <input class="form-control" type="password" name="USER_CONFIRM_PASSWORD"
                           value="<?= $arResult['USER_CONFIRM_PASSWORD'] ?>" autocomplete="off">
                </div>

                <div class="form-group bx-authform-formgroup-container">
                    <input class="form-control btn btn-primary btn-block" type="submit" name="change_pwd"
                           value="<?= Loc::getMessage('AUTH_CHANGE') ?>">
                </div>

                <div class="bx-authform-description-container">
                    <?= $arResult['GROUP_POLICY']['PASSWORD_REQUIREMENTS']; ?>
                </div>

                <div class="bx-authform-link-container">
                    <a href="/personal/auth/"><b><?= Loc::getMessage('AUTH_AUTH') ?></b></a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    document.bform.USER_LOGIN.focus();
</script>