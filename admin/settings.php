<?php
/**
 * Created by PhpStorm.
 * User: abderrahimelimame
 * Date: 8/10/16
 * Time: 03:23
 */
include 'header.php';
if ($_GB->getSession('admin') == false) {
    header("location:login.php");
}
?>

    <div class="box bg-gray-light ">
        <center>
            <div class="box-body ">
                <form role="form" action="" method="POST">
                    <div class="callout callout-info bg-blue-gradient">
                        <h4>General Settings</h4>
                    </div>
                    <div class="form-group">
                        <label for="privacy_policy">Privacy Policy</label>
                    <textarea class="form-control" rows="10" cols="50" name="privacy_policy" id="privacy_policy">
                        <?php echo htmlentities($_GB->getSettings('privacy_policy')); ?>
                    </textarea>

                    </div>

                    <div class="form-group">
                        <label for="app_version">Application Version Code Ex: 26</label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('app_version'); ?>"
                               name="app_version" id="app_version">

                    </div>
                    <div class="form-group">
                        <label for="app_name">Application Name Ex:WhatsClone</label>
                        <input class="form-control" type="text" value="<?php echo $_GB->getSettings('app_name'); ?>"
                               name="app_name" id="app_name" required>

                    </div>
                    <div class="callout callout-info bg-blue-gradient">
                        <h4>Twilio Settings</h4>
                    </div>
                    <div class="form-group">

                        <label for="sms_authentication_key">SMS Authentication Token</label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('sms_authentication_key'); ?>"
                               name="sms_authentication_key"
                               id="sms_authentication_key">
                    </div>

                    <div class="form-group">

                        <label for="account_sid">SMS provider Account Sid </label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('account_sid'); ?>"
                               name="account_sid" id="account_sid">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">SMS provider Sender Number</label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('phone_number'); ?>"
                               name="phone_number" id="phone_number">

                    </div>
                    <div class="form-group">
                        <label for="sms_verification">
                            <span>Enable SMS Verification</span>
                            <?php $status = $_GB->getSettings('sms_verification');
                            if ($status == 1) {
                                echo '<input type="checkbox" name="sms_verification" id="sms_verification" class="flat-red" checked>';
                            } else {
                                echo '<input type="checkbox" name="sms_verification" id="sms_verification" class="flat-red" >';
                            } ?>

                        </label>

                    </div>
                    <div class="callout callout-info bg-blue-gradient">
                        <h4>Admob Settings "Banner ads"</h4>
                    </div>
                    <div class="form-group">
                        <label for="admob_banner_ads_unit_id">Admob Banner Unit ID</label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('banner_ads_unit_id'); ?>"
                               name="admob_banner_ads_unit_id" id="admob_banner_ads_unit_id">

                    </div>
                    <div class="form-group">
                        <label for="admob_banner_ads_status">
                            <span>Enable Banner Ads</span>
                            <?php $status = $_GB->getSettings('banner_ads_status');
                            if ($status == 1) {
                                echo '<input type="checkbox" name="admob_banner_ads_status" id="admob_banner_ads_status" class="flat-red"  checked>';
                            } else {
                                echo '<input type="checkbox" name="admob_banner_ads_status" id="admob_banner_ads_status" class="flat-red"  >';
                            } ?>

                        </label>
                    </div>
                    <div class="callout callout-info bg-blue-gradient">
                        <h4>Admob Settings "Interstitial ads"</h4>
                    </div>
                    <div class="form-group">
                        <label for="admob_interstitial_unit_id">Admob Interstitial Unit ID</label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('interstitial_ads_unit_id'); ?>"
                               name="admob_interstitial_unit_id" id="admob_interstitial_unit_id">
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input-card-settings">


                        <label for="admob_interstitial_ads_status">
                            <span>Enable Interstitial Ads</span>
                            <?php $status = $_GB->getSettings('interstitial_ads_status');
                            if ($status == 1) {
                                echo '<input type="checkbox" name="admob_interstitial_ads_status" id="admob_interstitial_ads_status" class="flat-red" checked>';
                            } else {
                                echo '<input type="checkbox" name="admob_interstitial_ads_status" id="admob_interstitial_ads_status" class="flat-red" >';
                            } ?>

                        </label>

                    </div>
                    <div class="callout callout-info bg-blue-gradient">
                        <h4>Admob Settings "Video ads"</h4>
                    </div>
                    <div class="form-group">
                        <label for="admob_video_unit_id">Admob Video Unit ID</label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('video_ads_unit_id'); ?>"
                               name="admob_video_unit_id" id="admob_video_unit_id">

                        <label
                            for="admob_video_app_id">Admob Video APP ID</label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('video_ads_app_id'); ?>"
                               name="admob_video_app_id" id="admob_video_app_id">
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input-card-settings">


                        <label for="admob_video_ads_status">
                            <span>Enable Video Ads</span>
                            <?php $status = $_GB->getSettings('video_ads_status');
                            if ($status == 1) {
                                echo '<input type="checkbox" name="admob_video_ads_status" id="admob_video_ads_status" class="flat-red" checked>';
                            } else {
                                echo '<input type="checkbox" name="admob_video_ads_status" id="admob_video_ads_status" class="flat-red" >';
                            } ?>

                        </label>

                    </div>

                    <div class="callout callout-info bg-blue-gradient">
                        <h4>Firebase settings</h4>
                    </div>

                    <div class="form-group">
                        <label for="googleApiKey"> google Api Key</label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('googleApiKey'); ?>"
                               name="googleApiKey" id="googleApiKey" required>
                    </div>

                    <div class="form-group">
                        <label for="googleSenderId">google Sender Id</label>
                        <input class="form-control" type="text"
                               value="<?php echo $_GB->getSettings('googleSenderId'); ?>"
                               name="googleSenderId" id="googleSenderId" required>
                    </div>

                    <div class="form-group"></div>
                    <button type="submit"
                            class="btn  btn-success btn-lg">
                        <i>Save Changes</i></button>


                </form>
            </div>
        </center>
    </div>


<?php
if (isset($_POST['privacy_policy']) ||
    isset($_POST['app_name']) ||
    isset($_POST['googleApiKey']) ||
    isset($_POST['googleSenderId']) ||
    isset($_POST['app_version']) ||
    isset($_POST['account_sid']) ||
    isset($_POST['sms_authentication_key']) ||
    isset($_POST['phone_number']) ||
    isset($_POST['sms_verification']) ||
    isset($_POST['admob_banner_ads_unit_id']) ||
    isset($_POST['admob_banner_ads_status']) ||
    isset($_POST['admob_interstitial_unit_id']) ||
    isset($_POST['admob_interstitial_ads_status']) ||
    isset($_POST['admob_video_unit_id']) ||
    isset($_POST['admob_video_app_id']) ||
    isset($_POST['admob_video_ads_status'])
) {
    $privacy_policy = $_POST['privacy_policy'];
    $app_name = $_POST['app_name'];
    $googleApiKey = $_POST['googleApiKey'];
    $googleSenderId = $_POST['googleSenderId'];
    $app_version = $_POST['app_version'];
    $account_sid = $_POST['account_sid'];
    $sms_authentication_key = $_POST['sms_authentication_key'];
    $phone_number = $_POST['phone_number'];
    $sms_verification = $_POST['sms_verification'] ? "1" : "0";


    $admob_banner_ads_unit_id = $_POST['admob_banner_ads_unit_id'];
    $admob_banner_ads_status = $_POST['admob_banner_ads_status'] ? "1" : "0";
    $admob_interstitial_unit_id = $_POST['admob_interstitial_unit_id'];
    $admob_interstitial_ads_status = $_POST['admob_interstitial_ads_status'] ? "1" : "0";

    $admob_video_unit_id = $_POST['admob_video_unit_id'];
    $admob_video_app_id = $_POST['admob_video_app_id'];
    $admob_video_ads_status = $_POST['admob_video_ads_status'] ? "1" : "0";


    $_GB->updateSettings("privacy_policy", $privacy_policy);
    $_GB->updateSettings("app_name", $app_name);
    $_GB->updateSettings("app_version", $app_version);
    $_GB->updateSettings("account_sid", $account_sid);
    $_GB->updateSettings("sms_authentication_key", $sms_authentication_key);
    $_GB->updateSettings("phone_number", $phone_number);
    $_GB->updateSettings("banner_ads_unit_id", $admob_banner_ads_unit_id);
    $_GB->updateSettings("banner_ads_status", $admob_banner_ads_status);
    $_GB->updateSettings("interstitial_ads_unit_id", $admob_interstitial_unit_id);
    $_GB->updateSettings("interstitial_ads_status", $admob_interstitial_ads_status);


    $_GB->updateSettings("video_ads_unit_id", $admob_video_unit_id);
    $_GB->updateSettings("video_ads_status", $admob_video_ads_status);
    $_GB->updateSettings("video_ads_app_id", $admob_video_app_id);

    $_GB->updateSettings("sms_verification", $sms_verification);
    $_GB->updateSettings("googleApiKey", $googleApiKey);
    $_GB->updateSettings("googleSenderId", $googleSenderId);


    echo $_GB->ErrorDisplay('Settings updated successfully', 'yes');
    header("Refresh: 1; url=settings.php");

}

include 'footer.php';
?>