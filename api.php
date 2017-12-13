<?php
/**
 * Created by Abderrahim El imame.
 * Email : abderrahim.elimame@gmail.com
 * Date: 19/02/2016
 * Time: 23:28
 */


// include the database connection class
include 'config/DataBase.php';
// include the config file
include 'config/Config.php';
// include the SessionsController class
include 'application/controllers/SessionsController.php';
// include the UsersController class
include 'application/controllers/UsersController.php';
// include the MessagesController class
include 'application/controllers/MessagesController.php';
// include the GroupsController class
include 'application/controllers/GroupsController.php';
// include the ProfileController class
include 'application/controllers/ProfileController.php';
// include the Pagination class
include 'application/helpers/Pagination.php';
// include the Helper class
include 'application/helpers/Helper.php';
// include the Security class
include 'application/helpers/Security.php';


$_DB = new DataBase($_Config);
$_DB->connect();
$_DB->selectDB();
$Security = new Security($_DB);
$_GB = new Helper($_DB);
$Groups = new GroupsController($_GB);
$Users = new UsersController($_GB, $Groups);
$Messages = new MessagesController($_GB, $Users);
$Profile = new ProfileController($_GB);


$cmd = $_GET['cmd'];

if (isset($cmd)) {
    if (isset($_SERVER['HTTP_TOKEN'])) {
        $token = $_SERVER['HTTP_TOKEN'];
        $userID = $Users->getUserIdByToken($token);
        $isValidToken = $Users->getSessionToken($token);

    } else {
        $token = null;
        $userID = 0;
        $isValidToken = false;
    }

    if (isset($_SERVER['HTTP_ACCEPT'])) {
        $Accept = $_SERVER['HTTP_ACCEPT'];
    } else {
        $Accept = null;
    }
    switch ($cmd) {


        case 'CheckNetwork':
            if ($isValidToken) {
                $array = array(
                    'connected' => true,
                    'status' => 'Connected'
                );
                $_GB->Json($array);
            } else {
                $array = array(
                    'connected' => false,
                    'status' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'DeleteUserAccount':
            if ($isValidToken) {
                if (isset($_POST['phone'])) {
                    $phone = $_POST['phone'];
                    $country = $_POST['country'];
                    $array = $Users->initDeleteAccount($userID, $phone, $country);
                    $_GB->Json($array);
                } else {
                    // failed to insert row
                    $array = array(
                        'success' => false,
                        'message' => 'Oops! some params are missing.',
                        'mobile' => null,
                        'smsVerification' => false,
                        'code' => null
                    );
                    $_GB->Json($array);
                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'DeleteUserAccountConfirmation':
            if ($isValidToken) {
                if (isset($_POST['code'])) {
                    $Users->deleteAccountConfirmation($_POST['code']);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Oops! some params are missing.'
                    );
                    $_GB->Json($array);
                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'Join':
            if (isset($_POST)) {
                $array = file_get_contents('php://input');
                $_POST = json_decode($array, true);
                $array = $Users->SignIn($_POST);
                $_GB->Json($array);
            } else {
                // failed to insert row
                $array = array(
                    'success' => false,
                    'message' => 'Oops! some params are missing.',
                    'mobile' => null,
                    'smsVerification' => false,
                    'code' => null,
                    'hasBackup' => false
                );
                $_GB->Json($array);
            }
            break;

        case 'verifyUser':
            if (isset($_POST['code'])) {
                $Users->activateUser($_POST['code']);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Oops! some params are missing.',
                    'userID' => null,
                    'token' => null,
                    'hasBackup' => false,
                    'backup_hash' => null,
                    'hasProfile' => false
                );
                $_GB->Json($array);
            }
            break;


        case 'resend':
            if (isset($_POST['phone'])) {
                $Users->ResendCode($_POST['phone']);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Oops! some params are missing.'
                );
                $_GB->Json($array);
            }
            break;

        case 'SendContacts':
            if ($isValidToken) {
                if (isset($_POST)) {
                    $array = file_get_contents('php://input');
                    $_POST = json_decode($array, true);
                    $Users->comparePhoneNumbers($_POST);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Oops! some params are missing.'
                    );
                    $_GB->Json($array);
                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;

        case 'updateRegisteredId':
            if ($isValidToken) {
                if (isset($_POST)) {
                    $array = file_get_contents('php://input');
                    $_POST = json_decode($array, true);
                    $Users->updateRegisteredId($userID, $_POST['registeredId']);
                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized',
                    'registered_id' => null
                );
                $_GB->Json($array);
            }

            break;
        case 'GetContact':
            $userId = $_GET['userID'];
            if ($isValidToken) {
                $Users->getContactInfo($userId);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;

        case 'blockUser':
            $userId = $_GET['userId'];
            if ($isValidToken) {
                $Users->blockUser($userID, $userId);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;

        case 'saveAcceptedCall':
            if ($isValidToken) {

                if (isset($_POST)) {
                    $array = file_get_contents('php://input');
                    $_POST = json_decode($array, true);
                    $Users->saveAcceptedCall($_POST);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Oops! some params are missing.'
                    );
                    $_GB->Json($array);
                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'saveEmittedCall':
            if ($isValidToken) {
                if (isset($_POST)) {
                    $array = file_get_contents('php://input');
                    $_POST = json_decode($array, true);

                    $Users->saveEmittedCall($_POST);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Oops! some params are missing.');

                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'saveReceivedCall':
            if ($isValidToken) {
                if (isset($_POST)) {
                    $array = file_get_contents('php://input');
                    $_POST = json_decode($array, true);

                    $Users->saveReceivedCall($_POST);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Oops! some params are missing.');

                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'unBlockUser':
            $userId = $_GET['userId'];
            if ($isValidToken) {
                $Users->unBlockUser($userID, $userId);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'GetGroup':
            $groupID = $_GET['groupID'];

            if ($isValidToken) {
                $Groups->getGroupInfo($groupID);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'GetGroupMembers':
            $groupID = $_GET['groupID'];
            $groupID = $_DB->escapeString($groupID);


            if ($isValidToken) {
                if ($userID != 0) {
                    $query = " SELECT GM.id ,GM.role,GM.groupID,GM.Deleted,U.id AS userId,U.username,U.phone,U.image,U.status,U.status_date,U.is_activated
                             FROM prefix_users U,prefix_groups G,prefix_group_members GM
                             WHERE
                             CASE
                             WHEN GM.userID = U.id
                             THEN GM.groupID = G.id
                              END
                              AND 
                              G.id = {$groupID}
                              AND
                              U.is_activated = 1  ORDER BY GM.id ASC";
                    $query = $_DB->MySQL_Query($query);
                    $Groups->GetGroupMembers($query);

                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;

        case 'EditName':
            if (isset($_POST)) {


                if ($isValidToken) {
                    $array = file_get_contents('php://input');
                    $_POST = json_decode($array, true);
                    $newstatus = $_POST['newStatus'];
                    $Users->editName($newstatus, $userID);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }

            break;

        case 'EditGroupName':
            if (isset($_POST)) {

                if ($isValidToken) {
                    $array = file_get_contents('php://input');
                    $_POST = json_decode($array, true);
                    $newstatus = $_POST['newStatus'];
                    $groupID = $_POST['statusID'];
                    $Groups->EditGroupName($newstatus, $groupID);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }

            break;

        case 'ExitGroup':

            $groupID = $_GET['groupID'];

            if ($isValidToken) {
                $Groups->exitGroup($userID, $groupID);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;

        case 'DeleteGroup':

            $groupID = $_GET['groupID'];

            if ($isValidToken) {
                $Groups->deleteGroup($userID, $groupID);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;

        case 'GetStatus':

            $userID = $_DB->escapeString($userID);


            if ($isValidToken) {
                if ($userID != 0) {
                    $query = "
                            SELECT S.*,U.status AS currentStatus,S.id AS currentStatusID
                           FROM prefix_users U,prefix_status S
                           WHERE
                           CASE
                           WHEN S.userID = {$userID}
                           THEN U.id = {$userID}
                           END
                           AND
                            S.status = U.status
                            AND
                            S.userID = U.id
                             GROUP BY S.id
                             UNION
                           SELECT * FROM (   SELECT S.*,U.is_activated AS currentStatus,S.status AS currentStatusID
                           FROM prefix_users U,prefix_status S
                           WHERE
                           CASE
                           WHEN S.userID = {$userID}
                           THEN U.id = {$userID}
                            END
                            AND
                            S.userID = U.id
                             AND
                            S.current = 0
                           GROUP BY S.id
                              ) t   ORDER BY currentStatusID DESC ";
                    $query = $_DB->MySQL_Query($query);
                    $rows = $_DB->numRows($query);
                    $page = (isset($_GET['page']) && !empty($_GET['page'])) ? $Security->MA_INT($_GET['page']) : 1;
                    $_PAG = new Pagination($page,
                        $rows
                        , 6,
                        'routes.php?page=#i#');
                    if ($page > $_PAG->pages) {
                        $_GB->Json(array());
                    } else {
                        $Users->getStatus($query);
                    }
                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'EditStatus':
            if (isset($_POST)) {

                if ($isValidToken) {
                    if ($userID != 0) {
                        $array = file_get_contents('php://input');
                        $_POST = json_decode($array, true);
                        $newstatus = $_POST['newStatus'];
                        $Users->insertStatus($userID, $newstatus);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }

            break;
        case 'UpdateStatus':
            $statusID = $_GET['statusID'];

            if ($isValidToken) {
                $Users->updateStatus($userID, $statusID);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'DeleteStatus':
            if ($isValidToken) {
                $Users->DeleteStatus($userID, $_GET['status']);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'DeleteAllStatus':

            $userID = $_DB->escapeString($userID);


            if ($isValidToken) {
                $query = "DELETE S.* FROM  prefix_status S
                           JOIN prefix_users U ON   S.userID = U.id
                           WHERE
                           CASE
                           WHEN S.userID = {$userID}
                           THEN U.id = {$userID}
                            END
                            AND
                            S.status != U.status";
                $query = $_DB->MySQL_Query($query);

                $Users->DeleteAllStatus($query);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }
            break;
        case 'saveMessageGroup':
            if ($isValidToken) {
                if (isset($_POST)) {
                    $array = file_get_contents('php://input');
                    $_POST = json_decode($array, true);
                    $Messages->saveMessageGroup($_POST);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Some Params are Missing'
                    );
                    $_GB->Json($array);
                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }

            break;
        case 'sendMessage':

            if ($isValidToken) {
                if (isset($_POST)) {
                    $array = file_get_contents('php://input');
                    $_POST = json_decode($array, true);
                    $Messages->sendMessage($_POST);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Some Params are Missing'
                    );
                    $_GB->Json($array);
                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }

            break;

        case 'createGroup':
            if (isset($_POST)) {
                $userID = $_POST['userID'];

                if ($isValidToken) {
                    if ($userID != 0) {
                        $groupID = $_POST['name'];
                        if (isset($_FILES['image'])) {
                            $imageID = $_GB->uploadImage($_FILES['image']);
                        } else {
                            $imageID = null;
                        }
                        $ids = $_POST['ids'];
                        $date = $_POST['date'];
                        $string = substr($date, 1, -1);
                        $Groups->createGroup($groupID, $imageID, $userID, $ids, $string);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }

            break;


        case 'addMembersToGroup':
            if (isset($_POST)) {


                if ($isValidToken) {
                    if ($userID != 0) {
                        $groupID = $_POST['groupID'];
                        $ids = $_POST['ids'];
                        $Groups->addMembersToGroup($groupID, $ids);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }


            break;

        case 'makeMemberAdmin':
            if (isset($_POST)) {


                if ($isValidToken) {
                    if ($userID != 0) {
                        $groupID = $_POST['groupID'];
                        $id = $_POST['id'];
                        $Groups->makeMemberAdmin($groupID, $id);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }


            break;
        case 'makeAdminMember':
            if (isset($_POST)) {

                if ($isValidToken) {
                    if ($userID != 0) {
                        $groupID = $_POST['groupID'];
                        $id = $_POST['id'];
                        $Groups->makeAdminMember($groupID, $id);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }


            break;
        case 'removeMemberFromGroup':
            if (isset($_POST)) {


                if ($isValidToken) {
                    if ($userID != 0) {
                        $groupID = $_POST['groupID'];
                        $id = $_POST['id'];
                        $Groups->removeMemberFromGroup($groupID, $id);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }


            break;
        case 'getGroups':
            if ($isValidToken) {
                $Groups->getGroups($userID);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }

            break;

        case 'uploadImage':
            if (isset($_POST)) {

                if ($isValidToken) {
                    if ($userID != 0) {
                        if (isset($_FILES['image'])) {
                            $imageHash = $_GB->uploadImage($_FILES['image']);
                        } else {
                            $imageHash = null;
                        }

                        $Profile->uploadProfileImage($imageHash, $userID);
                    } else {
                        $array = array(
                            'success' => false,
                            'userImage' => null,
                            'message' => 'Oops! Something went wrong'
                        );
                        $_GB->Json($array);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }

            break;


        case 'uploadGroupImage':
            if (isset($_POST)) {

                if ($isValidToken) {
                    if (isset($_FILES['image'])) {
                        $imageHash = $_GB->uploadImage($_FILES['image']);
                    } else {
                        $imageHash = null;
                    }
                    $groupID = $_POST['groupID'];
                    $Profile->uploadProfileGroupImage($imageHash, $groupID);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Unauthorized'
                    );
                    $_GB->Json($array);
                }
            }

            break;

        case 'uploadMessagesImage':
            if (isset($_POST)) {

                if ($isValidToken) {
                    if (isset($_FILES['image'])) {
                        $imageHash = $_GB->uploadImage($_FILES['image']);
                    } else {
                        $imageHash = null;
                    }

                    if ($imageHash != null) {
                        $array = array(
                            'success' => true,
                            'url' => $imageHash,
                            'videoThumbnail' => null
                        );
                        $_GB->Json($array);

                    } else {
                        $array = array(
                            'success' => false,
                            'url' => null,
                            'videoThumbnail' => null
                        );
                        $_GB->Json($array);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'url' => null,
                        'videoThumbnail' => null
                    );
                    $_GB->Json($array);
                }
            }

            break;
        case 'uploadMessagesAudio':
            if (isset($_POST)) {

                if ($isValidToken) {
                    if (isset($_FILES['audio'])) {
                        $audioHash = $_GB->uploadAudio($_FILES['audio']);
                    } else {
                        $audioHash = null;
                    }

                    if ($audioHash != null) {

                        $array = array(
                            'success' => true,
                            'url' => $audioHash,
                            'videoThumbnail' => null
                        );
                        $_GB->Json($array);

                    } else {
                        $array = array(
                            'success' => false,
                            'url' => null,
                            'videoThumbnail' => null
                        );
                        $_GB->Json($array);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'url' => null,
                        'videoThumbnail' => null
                    );
                    $_GB->Json($array);
                }
            }

            break;

        case 'uploadMessagesDocument':
            if (isset($_POST)) {

                if ($isValidToken) {
                    if (isset($_FILES['document'])) {
                        $documentHash = $_GB->uploadDocument($_FILES['document']);
                    } else {
                        $documentHash = null;
                    }

                    if ($documentHash != null) {
                        $array = array(
                            'success' => true,
                            'url' => $documentHash,
                            'videoThumbnail' => null
                        );
                        $_GB->Json($array);

                    } else {
                        $array = array(
                            'success' => false,
                            'url' => null,
                            'videoThumbnail' => null
                        );
                        $_GB->Json($array);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'url' => null,
                        'videoThumbnail' => null
                    );
                    $_GB->Json($array);
                }
            }

            break;
        case 'uploadMessagesVideo':
            if (isset($_POST)) {

                if ($isValidToken) {

                    if (isset($_FILES['video'])) {
                        $videoHash = $_GB->uploadVideo($_FILES['video']);
                    } else {
                        $videoHash = null;
                    }

                    if (isset($_FILES['thumbnail'])) {
                        $VideoThumbnailHash = $_GB->uploadVideoThumbnail($_FILES['thumbnail']);
                    } else {
                        $VideoThumbnailHash = null;
                    }

                    if ($videoHash != null) {
                        $url = $_GB->getVideoFileUrl($videoHash);
                        $urlThumbnail = $_GB->getVideoThumbnailFileUrl($VideoThumbnailHash);

                        $array = array(
                            'success' => true,
                            'url' => $videoHash,
                            'videoThumbnail' => $VideoThumbnailHash
                        );
                        $_GB->Json($array);

                    } else {
                        $array = array(
                            'success' => false,
                            'url' => null,
                            'videoThumbnail' => null
                        );
                        $_GB->Json($array);
                    }
                } else {
                    $array = array(
                        'success' => false,
                        'url' => null,
                        'videoThumbnail' => null
                    );
                    $_GB->Json($array);
                }
            }

            break;

        case 'userHasBackup':
            if (isset($_POST)) {
                if ($isValidToken) {
                    $hasBackup = $_POST['hasBackup'];
                    $Users->updateBackup($hasBackup, $userID);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => 'Ops !! something went wrong '
                    );
                    $this->_GB->Json($array);
                }
            }

            break;


        case 'GetAppSettings':

            if ($isValidToken) {
                $unitBannerID = $_GB->getSettings('banner_ads_unit_id');
                $adsBannerStatus = $_GB->getSettings('banner_ads_status');
                $appVersion = $_GB->getSettings('app_version');
                if ($adsBannerStatus == 1) {
                    $adsBannerStatus = true;
                } else {
                    $adsBannerStatus = false;
                }


                $unitVideoID = $_GB->getSettings('video_ads_unit_id');
                $appID = $_GB->getSettings('video_ads_app_id');
                $adsVideoStatus = $_GB->getSettings('video_ads_status');
                if ($adsVideoStatus == 1) {
                    $adsVideoStatus = true;
                } else {
                    $adsVideoStatus = false;
                }

                $unitInterstitialID = $_GB->getSettings('interstitial_ads_unit_id');
                $adsInterstitialStatus = $_GB->getSettings('interstitial_ads_status');
                if ($adsInterstitialStatus == 1) {
                    $adsInterstitialStatus = true;
                } else {
                    $adsInterstitialStatus = false;
                }

                $array = array(
                    'adsVideoStatus' => $adsVideoStatus,
                    'adsBannerStatus' => $adsBannerStatus,
                    'adsInterstitialStatus' => $adsInterstitialStatus,
                    'unitBannerID' => $unitBannerID,
                    'unitVideoID' => $unitVideoID,
                    'unitInterstitialID' => $unitInterstitialID,
                    'appVersion' => $appVersion,
                    'appID' => $appID
                );
                $_GB->Json($array);
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }

            break;
        case 'GetApplicationPrivacy':

            if ($isValidToken) {
                $app_version = $_GB->getSettings('privacy_policy');
                if ($app_version != null) {
                    $array = array(
                        'success' => true,
                        'message' => $app_version
                    );
                    $_GB->Json($array);
                } else {
                    $array = array(
                        'success' => false,
                        'message' => "Oops ! Something went wrong"
                    );
                    $_GB->Json($array);
                }
            } else {
                $array = array(
                    'success' => false,
                    'message' => 'Unauthorized'
                );
                $_GB->Json($array);
            }

            break;


    }

} else {

    $array = array(
        'success' => false,
        'message' => ' Required field(s) is missing'
    );
    $_GB->Json($array);

}
