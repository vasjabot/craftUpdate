<?

//print_r("bitrix gavno");
//echo nl2br("\r\n");

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
//require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
CModule::IncludeModule("iblock");
//require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/iblock/prolog.php");
//IncludeModuleLangFile(__FILE__);
//if(!CModule::IncludeModule("webservice") || !CModule::IncludeModule("iblock"))
//    return;

//отключаем тест
//shell_exec("echo yes>/home/bitrix/www/bitrix/components/esfull/FirstUploadFull/sleep");

$temp_work_tp = '';
$temp_work_ap = '';
$ABS_FILE_NAME_PROTOTYPES = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/prototypes_work.xml';
$ABS_FILE_NAME_PROTOTYPES_ALL = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/prototypes_0.xml';
$ABS_FILE_NAME_PROTOTYPES_TEST = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/prototypes_work_test.xml';
$ABS_FILE_NAME_PROTOTYPES_TEMP = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/prototypes_work_temp.xml';
$ABS_FILE_NAME_OFFERS = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/offers_work.xml';
$ABS_FILE_NAME_OFFERS_ALL = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/offers_0.xml';
$ABS_FILE_NAME_OFFERS_TEST = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/offers_work_test.xml';
$ABS_FILE_NAME_OFFERS_TEMP = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/offers_work_temp.xml';
$ABS_FILE_NAME_PATTERN = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/pattern_work.xml';
$ABS_FILE_NAME_UPLOAD = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/upload_work.xml';
$ABS_FILE_NAME_AUTH = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/es/FirstUpload/AUTH.txt';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$ABS_FILE_NAME_PRICES = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/prices_work.xml';
$ABS_FILE_NAME_PRICES_TEMP = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/prices_work_temp.xml';
$ABS_FILE_NAME_INSTOCK = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/instock_work.xml';
$ABS_FILE_NAME_INSTOCK_TEMP = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/instock_work_temp.xml';
$WORK_DIR_UPLOAD = $_SERVER["DOCUMENT_ROOT"] . '/upload/';
$WORK_DIR_UPLOAD_CATALOG = $_SERVER["DOCUMENT_ROOT"] . '/upload/upload/catalog/';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$ABS_FILE_NAME_COMPATIBILITY_ALL = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/compatibility_0.xml';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/updateLOG.txt');
$ABS_LOG_FILENAME = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/esfull/FirstUploadFull/updateLOG.txt';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$WORK_DIR_NAME = substr($ABS_FILE_NAME_PROTOTYPES, 0, strrpos($ABS_FILE_NAME_PROTOTYPES, "/") + 1);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
unlink($ABS_FILE_NAME_PROTOTYPES);
    AddMessage2Log("Удаляем файл prototypes_work.xml", "FirstUpload");
unlink($ABS_FILE_NAME_COMPATIBILITY_ALL);
    AddMessage2Log("Удаляем файл compatibility_0.xml", "FirstUpload");
unlink($ABS_FILE_NAME_OFFERS);
    AddMessage2Log("Удаляем файл offers_work.xml", "FirstUpload");
/*rmdir('acupic');
    AddMessage2Log("Удаляем папку acupic", "FirstUpload");
rmdir('telpic');
    AddMessage2Log("Удаляем папку telpic", "FirstUpload");
unlink($ABS_FILE_NAME_OFFERS_ALL);
unlink($ABS_FILE_NAME_OFFERS_TEMP);
unlink($ABS_FILE_NAME_PRICES);
unlink($ABS_FILE_NAME_PRICES_TEMP);
unlink($ABS_FILE_NAME_INSTOCK);
unlink($ABS_FILE_NAME_INSTOCK_TEMP);
unlink($ABS_FILE_NAME_PROTOTYPES_ALL);
unlink($ABS_FILE_NAME_PROTOTYPES_TEMP);*/
$Zapusk = 1;
//Zapusk2:
if ($Zapusk != 1)
{
	AddMessage2Log("Второй запуск обновления", "FirstUpload");
} else
{
	AddMessage2Log("Первый запуск обновления", "FirstUpload");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
chdir($WORK_DIR_NAME);
$file_atth = fopen($ABS_FILE_NAME_AUTH, 'r');
$fread_result_auth = fread($file_atth, filesize($ABS_FILE_NAME_AUTH));
fclose($file_atth);
$pieces = explode(";", $fread_result_auth);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$LOGIN = $pieces[0];
$PWS = $pieces[1];
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$PRODUCERS_IS_CHANGED = FALSE;
$THERE_IS_NO_MATCH = TRUE;
$CRAFTMIDDLE_IS_DEAD = FALSE;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xml_pattern = simplexml_load_file($ABS_FILE_NAME_PATTERN);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////global variable//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$GLOBAL_IBLOCK_ID = 12;
$THERE_IS_NO_MATCH_OFFERS = TRUE;
$THERE_IS_FIRST_UPLOAD = TRUE;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////razdel variable//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$producers = array();
$number_producers = 0;
$first_input_flag = TRUE;
$flag_exist_member = FALSE;
$flag_increment_member = FALSE;
$ID = 3002;
$global_article_temp_groups = 11111111;
$global_article_temp_offers = 22222222;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////end of razdel variable///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////offers variable//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$global_groups_offer = array();
$number_global_groups_offer = 0;
$ID_offers = 709;
$ID_global_groups_offer = 2000;
$first_input_flag_offers = TRUE;
$flag_exist_member_offers = FALSE;
$flag_increment_member_offers = FALSE;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////end of offers variable///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////FUNCTIONS()//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function GetCurlData($CurlUrl, $CurlLogin, $CurlPws)
{
    $ch_func = curl_init();
    curl_setopt($ch_func, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch_func, CURLOPT_URL, $CurlUrl);
    curl_setopt($ch_func, CURLOPT_USERPWD, "$CurlLogin:$CurlPws");
    $result_func = curl_exec($ch_func);
    curl_close($ch_func);
    if (!$result_func) exit(1);
    return $result_func;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function SaveFileXML($FileName, $ABSFileName, $result_to_write)
{
    //print_r($FileName);
    //echo nl2br("\r\n");
    chdir(substr($ABSFileName, 0, strrpos($ABSFileName, "/") + 1));
    $file_xml = fopen($FileName, 'w');
    fwrite($file_xml, $result_to_write);
    fclose($file_xml);
    $file_xml = mb_convert_encoding($file_xml, 'UTF-8', 'OLD-ENCODING');
    $xml_save = simplexml_load_file($ABSFileName);

    //print_r($FileName);
    //echo nl2br("\r\n");
    $xml_save->asXML($ABSFileName);
    //print_r($FileName);
    //echo nl2br("\r\n");

    return $xml_save;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function IsParamMatchTrue($FirstXML, $SecondXML, $patam_to_match)
{
    $FLAG_THERE_IS_NO_MATCH_OFFERS = TRUE;
    if ($FirstXML->xpath('//dataWs'))
    {
        $i_offers_match = 0;
        foreach ($FirstXML->xpath('//dataWs') as $item_offers_match)
        {
            $i_offers_match++;
            $matchvar_article = $item_offers_match->$patam_to_match;
            $matchvar_article = (array)$matchvar_article;
            if ($SecondXML->xpath('//dataWs'))
            {
                $i_offers_0 = 0;
                foreach ($SecondXML->xpath('//dataWs') as $item_offers_0)
                {
                    $i_offers_0++;
                    $Ovar_article = $item_offers_0->$patam_to_match;
                    $Ovar_article = (array)$Ovar_article;
                    if ($matchvar_article[0] == $Ovar_article[0])
                    {
                        //print_r($matchvar_article[0]);
                        //echo nl2br("\r\n");
                        //print_r('IT_IS_MATCH!!!');
                        //echo nl2br("\r\n");
                        $FLAG_THERE_IS_NO_MATCH_OFFERS = FALSE;
                    }
                }
            }
        }
    } else
    {
        $FLAG_THERE_IS_NO_MATCH_OFFERS = FALSE;
    }
    return $FLAG_THERE_IS_NO_MATCH_OFFERS;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function GetCurlTelPIC($CurlArticle, $CurlUrl, $CurlLogin, $CurlPws, $CurlPICdir)
{
    $ch_func = curl_init();
    curl_setopt($ch_func, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch_func, CURLOPT_URL, $CurlUrl);
    curl_setopt($ch_func, CURLOPT_USERPWD, "$CurlLogin:$CurlPws");
    $result_func = curl_exec($ch_func);
    curl_close($ch_func);

    chdir($CurlPICdir);
    //$Curl_file_name = $CurlArticle . '_' . rand(1, 99) . '.jpg';
    $Curl_file_name = $CurlArticle . '.jpg';
    $file = fopen($Curl_file_name, 'w');
    fwrite($file, $result_func);
    fclose($file);
    if (exif_imagetype($Curl_file_name)==3) {
       $Curl_file_name_png = $CurlArticle . '.png';
       rename ($Curl_file_name,$Curl_file_name_png);
       $Curl_file_name = $Curl_file_name_png;
       //AddMessage2Log("Обнаружено PNG изображение " . $Curl_file_name_png, "FirstUpload");
    }
    return 'telpic' . '/' . $Curl_file_name;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function GetCurlAcuPIC($CurlArticle, $CurlUrl, $CurlLogin, $CurlPws, $CurlPICdir, $CurlNumPic)
{
    $ch_func = curl_init();
    curl_setopt($ch_func, CURLOPT_RETURNTRANSFER, 1);
    $CurlUrl = $CurlUrl . '/' . $CurlNumPic;
    curl_setopt($ch_func, CURLOPT_URL, $CurlUrl);
    curl_setopt($ch_func, CURLOPT_USERPWD, "$CurlLogin:$CurlPws");
    $result_func = curl_exec($ch_func);
    curl_close($ch_func);

    //echo getcwd();
    //echo nl2br("\r\n");
    chdir($CurlPICdir);
    //echo getcwd();
    //echo nl2br("\r\n");
    if (!is_dir($CurlPICdir . $CurlArticle))
    {
        mkdir($CurlArticle);
    }
    chdir($CurlArticle);
    //print_r($CurlPICdir . $CurlArticle);
    //echo nl2br("\r\n");
    $Curl_file_name = $CurlArticle . '_' . $CurlNumPic . '.jpg';
    //$Curl_file_name = $CurlArticle . '_' . $CurlNumPic . '_' . rand(1, 99) . '.jpg';
    $file = fopen($Curl_file_name, 'w');
    fwrite($file, $result_func);
    fclose($file);
    return 'acupic' . '/' . $CurlArticle . '/' . $Curl_file_name;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function SaveCustomFile($arFile, $strSavePath, $CustomPath, $bForceMD5 = false, $bSkipExt = false, $dirAdd = '')
{
    $strFileName = GetFileName($arFile["name"]);    /* filename.gif */
    if (isset($arFile["del"]) && $arFile["del"] <> '')
    {
        CFile::DoDelete($arFile["old_file"]);
        if ($strFileName == '')
            return "NULL";
    }
    if ($arFile["name"] == '')
    {
        if (isset($arFile["description"]) && intval($arFile["old_file"]) > 0)
        {
            CFile::UpdateDesc($arFile["old_file"], $arFile["description"]);
        }
        return false;
    }
    if (isset($arFile["content"]))
    {
        print_r("arFile(content) isset = )" . $arFile["content"]);
        echo nl2br("\r\n");
        if (!isset($arFile["size"]))
        {
            $arFile["size"] = CUtil::BinStrlen($arFile["content"]);
        }
    } else
    {
        //try
        //{
        //    $file = new IO\File(IO\Path::convertPhysicalToLogical($arFile["tmp_name"]));
        //    $arFile["size"] = $file->getSize();
        //}
        //catch(IO\IoException $e)
        //{
        //    $arFile["size"] = 0;
        //}
    }
    $arFile["ORIGINAL_NAME"] = $strFileName;
    //translit, replace unsafe chars, etc.
    //$strFileName = CAllFile::transformName($strFileName, $bForceMD5, $bSkipExt);  //CFile::SaveFile
    //transformed name must be valid, check disk quota, etc.
    //if (self::validateFile($strFileName, $arFile) !== "")
    //{
    //    return false;
    //}
    if ($arFile["type"] == "image/pjpeg" || $arFile["type"] == "image/jpg")
    {
        $arFile["type"] = "image/jpeg";
    }
    $bExternalStorage = false;
    foreach (GetModuleEvents("main", "OnFileSave", true) as $arEvent)
    {
        if (ExecuteModuleEventEx($arEvent, array(&$arFile, $strFileName, $strSavePath, $bForceMD5, $bSkipExt, $dirAdd)))
        {
            $bExternalStorage = true;
            break;
        }
    }
    if (!$bExternalStorage)
    {
        $upload_dir = COption::GetOptionString("main", "upload_dir", "upload");
        $io = CBXVirtualIo::GetInstance();
        if ($bForceMD5 != true && COption::GetOptionString("main", "save_original_file_name", "N") == "Y")
        {
            $dir_add = $dirAdd;
            $i = 0;
            while (true && empty($dir_add))
            {
                $dir_add = substr(md5(uniqid("", true)), 0, 3);
                if (!$io->FileExists($_SERVER["DOCUMENT_ROOT"] . "/" . $upload_dir . "/" . $strSavePath . "/" . $dir_add . "/" . $strFileName))
                {
                    break;
                }
                if ($i >= 25)
                {
                    $j = 0;
                    while (true)
                    {
                        $dir_add = substr(md5(mt_rand()), 0, 3) . "/" . substr(md5(mt_rand()), 0, 3);
                        if (!$io->FileExists($_SERVER["DOCUMENT_ROOT"] . "/" . $upload_dir . "/" . $strSavePath . "/" . $dir_add . "/" . $strFileName))
                        {
                            break;
                        }
                        if ($j >= 25)
                        {
                            $dir_add = substr(md5(mt_rand()), 0, 3) . "/" . md5(mt_rand());
                            break;
                        }
                        $j++;
                    }
                    break;
                }
                $i++;
            }
            if (substr($strSavePath, -1, 1) <> "/")
                $strSavePath .= "/" . $dir_add;
            else
                $strSavePath .= $dir_add . "/";
        } else
        {
            $strFileExt = ($bSkipExt == true || ($ext = GetFileExtension($strFileName)) == '' ? '' : "." . $ext);
            while (true)
            {
                if (substr($strSavePath, -1, 1) <> "/")
                    $strSavePath .= "/" . substr($strFileName, 0, 3);
                else
                    $strSavePath .= substr($strFileName, 0, 3) . "/";
                if (!$io->FileExists($_SERVER["DOCUMENT_ROOT"] . "/" . $upload_dir . "/" . $strSavePath . "/" . $strFileName))
                    break;
                //try the new name
                $strFileName = md5(uniqid("", true)) . $strFileExt;
            }
        }
        $arFile["SUBDIR"] = $CustomPath;
        $arFile["FILE_NAME"] = $strFileName;
        $strDirName = $_SERVER["DOCUMENT_ROOT"] . "/" . $upload_dir . "/" . $strSavePath . "/";
        $strDbFileNameX = $strDirName . $strFileName;
        $strPhysicalFileNameX = $io->GetPhysicalName($strDbFileNameX);
        CheckDirPath($strDirName);
        if (is_set($arFile, "content"))
        {
            $f = fopen($strPhysicalFileNameX, "ab");
            if (!$f)
                return false;
            if (fwrite($f, $arFile["content"]) === false)
                return false;
            fclose($f);
        } elseif (
            !copy($arFile["tmp_name"], $strPhysicalFileNameX)
            && !move_uploaded_file($arFile["tmp_name"], $strPhysicalFileNameX)
        )
        {
            CFile::DoDelete($arFile["old_file"]);
            return false;
        }
        if (isset($arFile["old_file"]))
            CFile::DoDelete($arFile["old_file"]);
        @chmod($strPhysicalFileNameX, BX_FILE_PERMISSIONS);
        //flash is not an image
        $flashEnabled = !CFile::IsImage($arFile["ORIGINAL_NAME"], $arFile["type"]);
        $imgArray = CFile::GetImageSize($strDbFileNameX, false, $flashEnabled);
        if (is_array($imgArray))
        {
            $arFile["WIDTH"] = $imgArray[0];
            $arFile["HEIGHT"] = $imgArray[1];
            if ($imgArray[2] == IMAGETYPE_JPEG)
            {
                $exifData = CFile::ExtractImageExif($strPhysicalFileNameX);
                if ($exifData && isset($exifData['Orientation']))
                {
                    //swap width and height
                    if ($exifData['Orientation'] >= 5 && $exifData['Orientation'] <= 8)
                    {
                        $arFile["WIDTH"] = $imgArray[1];
                        $arFile["HEIGHT"] = $imgArray[0];
                    }
                    $properlyOriented = CFile::ImageHandleOrientation($exifData['Orientation'], $io->GetPhysicalName($strDbFileNameX));
                    if ($properlyOriented)
                    {
                        $jpgQuality = intval(COption::GetOptionString('main', 'image_resize_quality', '95'));
                        if ($jpgQuality <= 0 || $jpgQuality > 100)
                            $jpgQuality = 95;
                        imagejpeg($properlyOriented, $strPhysicalFileNameX, $jpgQuality);
                        clearstatcache(true, $strPhysicalFileNameX);
                        $arFile['size'] = filesize($strPhysicalFileNameX);
                    }
                }
            }
        } else
        {
            $arFile["WIDTH"] = 0;
            $arFile["HEIGHT"] = 0;
        }
    }
    if ($arFile["WIDTH"] == 0 || $arFile["HEIGHT"] == 0)
    {
        //mock image because we got false from CFile::GetImageSize()
        if (strpos($arFile["type"], "image/") === 0 && $arFile["type"] <> 'image/svg+xml')
        {
            $arFile["type"] = "application/octet-stream";
        }
    }
    if ($arFile["type"] == '' || !is_string($arFile["type"]))
    {
        $arFile["type"] = "application/octet-stream";
    }
    /****************************** QUOTA ******************************/
    if (COption::GetOptionInt("main", "disk_space") > 0)
    {
        CDiskQuota::updateDiskQuota("file", $arFile["size"], "insert");
    }
    /****************************** QUOTA ******************************/
    $NEW_IMAGE_ID = CFile::DoInsert(array(
        "HEIGHT" => $arFile["HEIGHT"],
        "WIDTH" => $arFile["WIDTH"],
        "FILE_SIZE" => $arFile["size"],
        "CONTENT_TYPE" => $arFile["type"],
        "SUBDIR" => $arFile["SUBDIR"],
        "FILE_NAME" => $arFile["FILE_NAME"],
        "MODULE_ID" => $arFile["MODULE_ID"],
        "ORIGINAL_NAME" => $arFile["ORIGINAL_NAME"],
        "DESCRIPTION" => isset($arFile["description"]) ? $arFile["description"] : '',
        "HANDLER_ID" => isset($arFile["HANDLER_ID"]) ? $arFile["HANDLER_ID"] : '',
        "EXTERNAL_ID" => isset($arFile["external_id"]) ? $arFile["external_id"] : md5(mt_rand()),
    ));
//    CFile::CleanCache($NEW_IMAGE_ID);
    return $NEW_IMAGE_ID;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function removeDirectory($dir) 
{
    if ($objs = glob($dir."/*")) 
	{
       	foreach($objs as $obj) 
		{
			is_dir($obj) ? removeDirectory($obj) : unlink($obj);
       	}
    }
    rmdir($dir);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////set_time_limit//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
set_time_limit(0);
//print_r("bitrix gavno");
//echo nl2br("\r\n");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////end of set_time_limit///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

AddMessage2Log("TEST", "FirstUpload");

if(filesize($ABS_LOG_FILENAME) > 50000000) 
{
	unlink($ABS_LOG_FILENAME);
	AddMessage2Log("TOO_BIG_LOG", "FirstUpload");
}


if (is_dir($WORK_DIR_UPLOAD_CATALOG))
{
	AddMessage2Log("WORK_DIR_UPLOAD_CATALOG is not empty", "FirstUpload");
	removeDirectory($WORK_DIR_UPLOAD_CATALOG);
	AddMessage2Log("WORK_DIR_UPLOAD_CATALOG is cleared now", "FirstUpload");
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////timeLastSync_prototypes///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * ОпределЯем времЯ последней сихронизации длЯ запроса прототипов
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
chdir($WORK_DIR_NAME);
if (FALSE)//(file_exists($ABS_FILE_NAME_PROTOTYPES))
{
    $xml_prototypes = simplexml_load_file($ABS_FILE_NAME_PROTOTYPES);
    // echo "The file $ABS_FILE_NAME_PROTOTYPES exists";
    if ($xml_prototypes->xpath('//timeLastSync'))
    {
        $timeLastSync_node_prototypes = $xml_prototypes->xpath('//timeLastSync');
        $TimeLastSync_prototypes = $timeLastSync_node_prototypes[0];
        AddMessage2Log("времЯ последней сихронизации длЯ прототипов: " . $TimeLastSync_prototypes, "FirstUpload");
    }
} else
{
    $TimeLastSync_prototypes = 0;
    AddMessage2Log("времЯ последней сихронизации длЯ прототипов: " . $TimeLastSync_prototypes, "FirstUpload");
    //echo "The file $ABS_FILE_NAME_PROTOTYPES does not exist";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////end of timeLastSync_prototypes///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////query of prototypes//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * ОтправлЯем запрос прототипов
 */
$url_prototypes = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allDevices/" . $TimeLastSync_prototypes;
$result_prototypes = GetCurlData($url_prototypes, $LOGIN, $PWS);
//print_r($result_prototypes);
//echo nl2br("\r\n");
AddMessage2Log("запрос прототипов: ", "FirstUpload");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////end of query of prototypes///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////prototypes_work.xml///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Создаём файл prototypes_work.xml  в текущей директории компонента в кодировке UTF-8
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
chdir($WORK_DIR_NAME);
/**
 * Если обновилсЯ существующий прототип то находим его в prototypes_work.xml и изменЯем.
 * Если прототип не найден, считаем что это новый прототип и добавлЯем его в список.
 */
//Проверка необходима длЯ использованиЯ xpath
if (file_exists($ABS_FILE_NAME_PROTOTYPES))
{
    /**
     * ОпределЯем источник данных длЯ $xml_prototypes_temp
     */
    $xml_prototypes = simplexml_load_file($ABS_FILE_NAME_PROTOTYPES);
    AddMessage2Log("файл prototypes_work.xml уже существует: ", "FirstUpload");

    $file_prototypes_work_temp_xml = fopen('prototypes_work_temp.xml', 'w');
    fwrite($file_prototypes_work_temp_xml, $result_prototypes);
    fclose($file_prototypes_work_temp_xml);
    $file_prototypes_work_temp_xml = mb_convert_encoding($file_prototypes_work_temp_xml, 'UTF-8', 'OLD-ENCODING');
    $xml_prototypes_temp = simplexml_load_file($ABS_FILE_NAME_PROTOTYPES_TEMP);

    /**
     * Включил проверку на доступность посредника, если не доступен, то сразу выходим, а $xml_prototypes_temp
     * перезапишетсЯ при следующем обращении
     */
    $xml_prototypes_temp_node_title = $xml_prototypes_temp->xpath('//title');
    $xml_prototypes_temp_node_title_arr = (array)$xml_prototypes_temp_node_title[0];
    if ($xml_prototypes_temp_node_title_arr[0] == 'Error')
    {
        $CRAFTMIDDLE_IS_DEAD = TRUE;
        return;
    }
    $xml_prototypes_temp->asXML($ABS_FILE_NAME_PROTOTYPES_TEMP);
    $xml_prototypes_temp = simplexml_load_file($ABS_FILE_NAME_PROTOTYPES_TEMP);
    //print_r($xml_prototypes_temp);
    //echo nl2br("\r\n");
    AddMessage2Log("загрузили файл prototypes_work_temp.xml c помощью Curl c текущей временной меткой", "FirstUpload");
    /////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Считываем времЯ последней сихнронизации с файла $xml_prototypes_temp
     */
    $proto_temp_upper_node = $xml_prototypes_temp->xpath('//deviceInfoListDataWs');
    $proto_temp_upper_node = (array)$proto_temp_upper_node[0];
    $proto_temp_last_time_sync = $proto_temp_upper_node[timeLastSync];
    /**
     * Записываем времЯ последней сихнронизации в файл $xml_prototypes и сохранЯем его
     */
    $proto_work_upper_node = $xml_prototypes->xpath('//deviceInfoListDataWs');
    $proto_work_upper_node[0]->timeLastSync = $proto_temp_last_time_sync;
    $xml_prototypes->asXML($ABS_FILE_NAME_PROTOTYPES);

    /**
     * Ищем что поменЯлось и изменЯем. Если поменЯлсЯ производитель ставим флаг $PRODUCERS_IS_CHANGED
     */
    if ($xml_prototypes_temp->xpath('//dataWs'))
    {
        $index_dataWs = 0;
        AddMessage2Log("в файле prototypes_work_temp.xml существует хотЯ бы один прототип", "FirstUpload");
        foreach ($xml_prototypes_temp->xpath('//dataWs') as $item_search_prototypes_temp)
        {
            $item_search_prototypes_temp_article = $item_search_prototypes_temp->article;
            $item_search_prototypes_temp_article = (array)$item_search_prototypes_temp_article;
            $THERE_IS_NO_MATCH = TRUE;
            if ($xml_prototypes->xpath('//dataWs'))
            {
                foreach ($xml_prototypes->xpath('//dataWs') as $item_search_prototypes)
                {
                    $item_search_prototypes_article = $item_search_prototypes->article;
                    $item_search_prototypes_article = (array)$item_search_prototypes_article;
                    if ($item_search_prototypes_article[0] == $item_search_prototypes_temp_article[0])
                    {
                        $THERE_IS_NO_MATCH = FALSE;
                        $item_search_prototypes->devType = $item_search_prototypes_temp->devType;
                        $item_search_prototypes->id = $item_search_prototypes_temp->id;
                        $item_search_prototypes->model = $item_search_prototypes_temp->model;
                        $item_search_prototypes->prdDate = $item_search_prototypes_temp->prdDate;
                        $item_search_prototypes_temp_producer = $item_search_prototypes_temp->producer;
                        $item_search_prototypes_temp_producer = (array)$item_search_prototypes_temp_producer;
                        $item_search_prototypes_producer = $item_search_prototypes_temp->producer;
                        $item_search_prototypes_producer = (array)$item_search_prototypes_producer;
                        AddMessage2Log("заменили четере первых полЯ(кроме Артикула) xml_prototypes на полЯ xml_prototypes_temp элемента с артикулом:" . $item_search_prototypes_article[0], "FirstUpload");
                        if ($item_search_prototypes_temp_producer[0] !== $item_search_prototypes_producer[0])
                        {
                            $item_search_prototypes->producer = $item_search_prototypes_temp->producer;
                            $PRODUCERS_IS_CHANGED = TRUE;
                            AddMessage2Log("заменили производителЯ и установили флаг PRODUCERS_IS_CHANGED у элемента с артикулом" . $item_search_prototypes_article[0], "FirstUpload");
                        }
                    }
                }
                if ($THERE_IS_NO_MATCH)
                {
                    AddMessage2Log("Поскольку не найдены совпадениЯ в xml_prototypes и xml_prototypes_temp, то считаем что добавлен новый элемент с артикулом: " . $item_search_prototypes_temp_article[0], "FirstUpload");
                    $item_search_prototypes = $xml_prototypes->xpath('//deviceInfoListDataWs');
                    $item_search_prototypes[0]->addChild('dataWs', '');
                    $item_search_prototypes[0]->dataWs[$index_dataWs]->addChild('article', $item_search_prototypes_temp_article[0]);
                    ////////////////////////////////////////////////////////////////////////////////////////////////////
                    $item_search_prototypes_temp_devType = $item_search_prototypes_temp->devType;
                    $item_search_prototypes_temp_devType = (array)$item_search_prototypes_temp_devType;
                    $item_search_prototypes[0]->dataWs[$index_dataWs]->addChild('devType', $item_search_prototypes_temp_devType[0]);
                    ////////////////////////////////////////////////////////////////////////////////////////////////////
                    $item_search_prototypes_temp_id = $item_search_prototypes_temp->id;
                    $item_search_prototypes_temp_id = (array)$item_search_prototypes_temp_id;
                    $item_search_prototypes[0]->dataWs[$index_dataWs]->addChild('id', $item_search_prototypes_temp_id[0]);
                    ////////////////////////////////////////////////////////////////////////////////////////////////////
                    $item_search_prototypes_temp_model = $item_search_prototypes_temp->model;
                    $item_search_prototypes_temp_model = (array)$item_search_prototypes_temp_model;
                    $item_search_prototypes[0]->dataWs[$index_dataWs]->addChild('model', $item_search_prototypes_temp_model[0]);
                    ////////////////////////////////////////////////////////////////////////////////////////////////////
                    $item_search_prototypes_temp_prdDate = $item_search_prototypes_temp->prdDate;
                    $item_search_prototypes_temp_prdDate = (array)$item_search_prototypes_temp_prdDate;
                    $item_search_prototypes[0]->dataWs[$index_dataWs]->addChild('prdDate', $item_search_prototypes_temp_prdDate[0]);
                    ////////////////////////////////////////////////////////////////////////////////////////////////////
                    $item_search_prototypes_temp_producer = $item_search_prototypes_temp->producer;
                    $item_search_prototypes_temp_producer = (array)$item_search_prototypes_temp_producer;
                    $item_search_prototypes[0]->dataWs[$index_dataWs++]->addChild('producer', $item_search_prototypes_temp_producer[0]);
                }
            }
        }
        $xml_prototypes->asXML($ABS_FILE_NAME_PROTOTYPES);
    }
} else
{
    $xml_prototypes = SaveFileXML('prototypes_work.xml', $ABS_FILE_NAME_PROTOTYPES, $result_prototypes);
    AddMessage2Log("Поскольку файл prototypes_work.xml ранее не сущестовал, то загрузили его из результата запроса с текущей временной меткой : ", "FirstUpload");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////end of prototypes_work.xml///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////timeLastSync_offers//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
chdir($WORK_DIR_NAME);
/**
 * ОпределЯем времЯ последней сихронизации длЯ запроса аккумулЯторов
 */
if (FALSE)//(file_exists($ABS_FILE_NAME_OFFERS))
{
    $xml_offers = simplexml_load_file($ABS_FILE_NAME_OFFERS);
    //echo "The file $ABS_FILE_NAME_OFFERS exists";
    if ($xml_offers->xpath('//timeLastSync'))
    {
        $timeLastSync_node_offers = $xml_offers->xpath('//timeLastSync');
        //echo $timeLastSync_node[0];
        $TimeLastSync_offers = $timeLastSync_node_offers[0];
        AddMessage2Log("времЯ последней сихронизации длЯ аккумулЯторов: " . $TimeLastSync_offers, "FirstUpload");
    }
} else
{
    $TimeLastSync_offers = 0;
    AddMessage2Log("времЯ последней сихронизации длЯ аккумулЯторов: " . $TimeLastSync_offers, "FirstUpload");
    //echo "The file $ABS_FILE_NAME_OFFERS does not exist";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////end of timeLastSync_offers///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////query of offers//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * ОтправлЯем запрос аккумулЯторов
 */
$url_offers = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allBatteries/" . $TimeLastSync_offers;
$result_offers = GetCurlData($url_offers, $LOGIN, $PWS);
AddMessage2Log("запрос аккумулЯторов: ", "FirstUpload");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////end of query of offers//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////OFFERS///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Создаём файл offers_work.xml  в текущей директории компонента в кодировке UTF-8
 */
chdir($WORK_DIR_NAME);
if (file_exists($ABS_FILE_NAME_OFFERS))
{
    $THERE_IS_FIRST_UPLOAD = FALSE;
    AddMessage2Log("файл offers_work.xml уже существовал, установили флаг THERE_IS_FIRST_UPLOAD в FALSE ", "FirstUpload");
    /**
     * ОпределЯем источник данных длЯ offers_work_temp
     */

    $xml_offers_temp = SaveFileXML('offers_work_temp.xml', $ABS_FILE_NAME_OFFERS_TEMP, $result_offers);
    $xml_offers_temp = simplexml_load_file($ABS_FILE_NAME_OFFERS_TEMP);
    AddMessage2Log("файл xml_offers_temp загрузили из результата запроса по аккумулЯторам", "FirstUpload");

    /**
     * Ничего не сравниваем - просто заменЯем старые данные новыми
     */
    $xml_offers_temp->asXML($ABS_FILE_NAME_OFFERS);
    $xml_offers = simplexml_load_file($ABS_FILE_NAME_OFFERS);
    AddMessage2Log("заменили файл xml_offers_work полностью на xml_offers_temp без каких либо сравнений или условий", "FirstUpload");
} else
{

    $xml_offers = SaveFileXML('offers_work.xml', $ABS_FILE_NAME_OFFERS, $result_offers);
    AddMessage2Log("загрузили файл xml_offers из результатов запроса по аккумуляторам ", "FirstUpload");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////END OF OFFERS////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////timeLastSync_prices//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * ОпределЯем времЯ последней сихронизации длЯ запроса цен
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
chdir($WORK_DIR_NAME);
if (FALSE)//(file_exists($ABS_FILE_NAME_PRICES))
{
    $xml_prices = simplexml_load_file($ABS_FILE_NAME_PRICES);
    // echo "The file $ABS_FILE_NAME_PRICES exists";
    if ($xml_prices->xpath('//timeLastSync'))
    {
        $timeLastSync_node_prices = $xml_prices->xpath('//timeLastSync');
        $TimeLastSync_prices = $timeLastSync_node_prices[0];
        AddMessage2Log("времЯ последней сихронизации длЯ цен: " . $TimeLastSync_prices, "FirstUpload");
    }
} else
{
    $TimeLastSync_prices = 0;
    AddMessage2Log("времЯ последней сихронизации длЯ цен: " . $TimeLastSync_prices, "FirstUpload");
    //echo "The file $ABS_FILE_NAME_PROTOTYPES does not exist";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////end of timeLastSync_prices///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////PRICES///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * ОтправлЯем запрос цен
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// HTTP авторизациЯ
$url_prices = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allPrice/" . $TimeLastSync_prices;
$result_prices = GetCurlData($url_prices, $LOGIN, $PWS);
AddMessage2Log("запрос цен: ", "FirstUpload");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Создаём файл prices_work.xml  в текущей директории компонента в кодировке UTF-8
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
chdir($WORK_DIR_NAME);
if (file_exists($ABS_FILE_NAME_PRICES))
{
    $THERE_IS_FIRST_UPLOAD = FALSE;
    AddMessage2Log("файл prices_work.xml уже существовал, установили флаг THERE_IS_FIRST_UPLOAD в FALSE ", "FirstUpload");
    /**
     * ОпределЯем источник данных длЯ prices_work_temp
     */
    $xml_prices_temp = SaveFileXML('prices_work_temp.xml', $ABS_FILE_NAME_PRICES_TEMP, $result_prices);
    $xml_prices_temp = simplexml_load_file($ABS_FILE_NAME_PRICES_TEMP);
    AddMessage2Log("файл xml_prices_temp загрузили из результата запроса по ценам", "FirstUpload");
    /**
     * Ничего не сравниваем - просто заменЯем старые данные новыми
     */
    $xml_prices_temp->asXML($ABS_FILE_NAME_PRICES);
    $xml_prices = simplexml_load_file($ABS_FILE_NAME_PRICES);
    AddMessage2Log("заменили файл xml_prices_work полностью на xml_prices_temp без каких либо сравнений или условий", "FirstUpload");
} else
{
    $xml_prices = SaveFileXML('prices_work.xml', $ABS_FILE_NAME_PRICES, $result_prices);
    AddMessage2Log("загрузили файл xml_prices из результатов запроса по ценам ", "FirstUpload");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////END_OF_PRICES////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////timeLastSync_instock/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * ОпределЯем времЯ последней сихронизации длЯ запроса наличиЯ
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
chdir($WORK_DIR_NAME);
if (FALSE)//(file_exists($ABS_FILE_NAME_INSTOCK))
{
    $xml_instock = simplexml_load_file($ABS_FILE_NAME_INSTOCK);
    // echo "The file $ABS_FILE_NAME_INSTOCK exists";
    if ($xml_instock->xpath('//timeLastSync'))
    {
        $timeLastSync_node_instock = $xml_instock->xpath('//timeLastSync');
        $TimeLastSync_instock = $timeLastSync_node_instock[0];
        AddMessage2Log("времЯ последней сихронизации длЯ наличиЯ: " . $TimeLastSync_instock, "FirstUpload");
    }
} else
{
    $TimeLastSync_instock = 0;
    AddMessage2Log("времЯ последней сихронизации длЯ наличиЯ: " . $TimeLastSync_instock, "FirstUpload");
    //echo "The file $ABS_FILE_NAME_INSTOCK does not exist";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////enf of timeLastSync_instock//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////INSTOCK///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * ОтправлЯем запрос наличиЯ
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// HTTP авторизациЯ
$url_instock = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allInStockInfo/" . $TimeLastSync_instock;
$result_instock = GetCurlData($url_instock, $LOGIN, $PWS);
AddMessage2Log("запрос наличиЯ: ", "FirstUpload");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Создаём файл instock_work.xml  в текущей директории компонента в кодировке UTF-8
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
chdir($WORK_DIR_NAME);
if (file_exists($ABS_FILE_NAME_INSTOCK))
{
    $THERE_IS_FIRST_UPLOAD = FALSE;
    AddMessage2Log("файл instock_work.xml уже существовал, установили флаг THERE_IS_FIRST_UPLOAD в FALSE ", "FirstUpload");
    /**
     * ОпределЯем источник данных длЯ instock_work_temp
     */
    $xml_instock_temp = SaveFileXML('instock_work_temp.xml', $ABS_FILE_NAME_INSTOCK_TEMP, $result_instock);
    $xml_instock_temp = simplexml_load_file($ABS_FILE_NAME_INSTOCK_TEMP);
    AddMessage2Log("файл xml_instock_temp загрузили из результата запроса по наличию", "FirstUpload");
    /**
     * Ничего не сравниваем - просто заменЯем старые данные новыми
     */
    $xml_instock_temp->asXML($ABS_FILE_NAME_INSTOCK);
    $xml_instock = simplexml_load_file($ABS_FILE_NAME_INSTOCK);
    AddMessage2Log("заменили файл xml_instock_work полностью на xml_instock_temp без каких либо сравнений или условий", "FirstUpload");
} else
{
    $xml_instock = SaveFileXML('instock_work.xml', $ABS_FILE_NAME_INSTOCK, $result_instock);
    AddMessage2Log("загрузили файл xml_prices из результатов запроса по ценам ", "FirstUpload");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////END_OF_INSTOCK///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////PROTOTYPE_0_AND_OFFERS_0/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Запрос и сохранение всех прототипов и всех аккумулЯторов в отдельные файл, если есть хотЯ бы одно предложение с текущей временной меткой
 */
if ($xml_offers->xpath('//dataWs'))
{
    AddMessage2Log("поскольку xml_offers содержит хотЯ бы один элемент, то далее загружаем прототипы и аккумулЯторы в нулевой временной меткой для сравнениЯ  ", "FirstUpload");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////prototypes///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $url_prototypes_0 = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allDevices/0";
    $result_prototypes_0 = GetCurlData($url_prototypes_0, $LOGIN, $PWS);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $xml_prototypes_0 = SaveFileXML('prototypes_0.xml', $ABS_FILE_NAME_PROTOTYPES_ALL, $result_prototypes_0);
    //AddMessage2Log("создаём xml_prototypes_0.xml из результатов запроса result_prototypes_0:  ". $result_prototypes_0, "FirstUpload");
    AddMessage2Log("создаём xml_prototypes_0.xml из результатов запроса result_prototypes_0 ", "FirstUpload");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////offers//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $url_offers_0 = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allBatteries/0";
    $result_offers_0 = GetCurlData($url_offers_0, $LOGIN, $PWS);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $xml_offers_0 = SaveFileXML('offers_0.xml', $ABS_FILE_NAME_OFFERS_ALL, $result_offers_0);
    //AddMessage2Log("создаём xml_offers_0 вне зависимости от флага TEST_CASE из результатов запроса result_offers_0:  ". $result_offers_0, "FirstUpload");
    AddMessage2Log("создаём xml_offers_0 вне зависимости от флага TEST_CASE из результатов запроса result_offers_0 ", "FirstUpload");
} else
{
    AddMessage2Log("нет ни одного элемента в xml_offers", "FirstUpload");
    if (file_exists($ABS_FILE_NAME_PROTOTYPES_ALL))
    {
        $xml_prototypes_0 = simplexml_load_file($ABS_FILE_NAME_PROTOTYPES_ALL);
        AddMessage2Log("поскольку нет ни одного элемента в xml_offers создаём xml_prototypes_0", "FirstUpload");
    }
    if (file_exists($ABS_FILE_NAME_OFFERS_ALL))
    {
        $xml_offers_0 = simplexml_load_file($ABS_FILE_NAME_OFFERS_ALL);
        AddMessage2Log("поскольку нет ни одного элемента в xml_offers создаём xml_offers_0", "FirstUpload");
    }

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////END_OF_PROTOTYPE_0_AND_OFFERS_0//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////UPLOAD_WORK/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Создаём файл upload_work.xml на основе pattern_work.xml в текущей директории компонента в кодировке UTF-8
 */
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
chdir($WORK_DIR_NAME);
$file_upload_work_xml = fopen('upload_work.xml', 'w');
$xml_pattern->asXML($ABS_FILE_NAME_UPLOAD);
fclose($file_upload_work_xml);
$file_upload_work_xml = mb_convert_encoding($file_upload_work_xml, 'UTF-8', 'OLD-ENCODING');
$xml_upload = simplexml_load_file($ABS_FILE_NAME_UPLOAD);
AddMessage2Log("создали файл xml_upload на основе pattern_work.xml  ", "FirstUpload");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Создаём первую Группы только в случае если добавилсЯ новый прототип.
 * В качестве дополнительного условиЯ производим проверку $xml_offers на то ЯвлЯется ли хотЯ бы один из аккумулЯторов в предложениЯх новым.
 */
if ($xml_prototypes->xpath('//dataWs'))
{
    $xml_prototypes = simplexml_load_file($ABS_FILE_NAME_PROTOTYPES_ALL);
    AddMessage2Log("пересоздаём файл xml_prototypes из xml_prototypes_0 поскольку в xml_prototypes создержится хотЯ бы один элемент  ", "FirstUpload");
    //print_r($xml_prototypes);
    //echo nl2br("\r\n");
}

$THERE_IS_NO_MATCH_OFFERS = TRUE;
if ($THERE_IS_FIRST_UPLOAD)
{
    AddMessage2Log("поскольку THERE_IS_FIRST_UPLOAD равно TRUE не прерЯем есть ли новые предложениЯ в xml_offers по сравнению с xml_offers_0", "FirstUpload");
    //Do nothing here!!!!
} else
{
	//$THERE_IS_NO_MATCH_OFFERS = IsParamMatchTrue($xml_offers, $xml_offers_0, 'article');
    AddMessage2Log("проверЯем есть ли новые предложениЯ в xml_offers по сравнению с xml_offers_0 и выставлЯем флаг THERE_IS_NO_MATCH_OFFERS равно значение: " . $THERE_IS_NO_MATCH_OFFERS, "FirstUpload");
}


if ($THERE_IS_NO_MATCH_OFFERS)
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////query of compatibility///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * ОтправлЯем запрос совместимых аккумулЯторов по артикулу прототипа
     */
    $url_compatibility = "http://middle.craftmann.ru:8080/craftmiddle/ws/bitrixinfo/allCompatibilityByDevice/0";
    $result_compatibility_0 = GetCurlData($url_compatibility, $LOGIN, $PWS);
    AddMessage2Log("запрос совместимых аккумулЯторов: ", "FirstUpload");
    $xml_compatibility_0 = SaveFileXML('compatibility_0.xml', $ABS_FILE_NAME_COMPATIBILITY_ALL, $result_compatibility_0);
    $xml_compatibility_0 = simplexml_load_file($ABS_FILE_NAME_COMPATIBILITY_ALL);
    AddMessage2Log("файл xml_compatibility_0 загрузили из результата запроса совместимых аккумулЯторов", "FirstUpload");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////end of query of compatibility///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * Переинициализируем использованные глобальные переменные
 */
$producers = array();
$number_producers = 0;
$first_input_flag = TRUE;
$flag_exist_member = FALSE;
$flag_increment_member = FALSE;
$ID = 3002;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////end of reinit global variables/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * Создаём список производителей. Если в файле $xml_prototypes существует хотЯ бы один прототип, то перезаписываем этот файл. ОбновлЯть там особо нечего, поэтому без доп. проверок
 * считаем что это новый ПРОТОТИП. В качестве дополнительного условиЯ производим проверку $xml_offers на то ЯвлЯется ли хотЯ бы один из аккумулЯторов в предложениЯх новым.
 */

if ($THERE_IS_NO_MATCH_OFFERS)
{
    if ($xml_prototypes->xpath('//dataWs'))
    {
        foreach ($xml_prototypes->xpath('//dataWs') as $itemObj)
        {
            $count = count($itemObj);
            if ($itemObj->producer)
            {
                $tempvar = $itemObj->producer;
                $tempvar = (array)$tempvar;
                $tempvar[0] = trim($tempvar[0]);
                $tempvar[0] = str_replace('+', 'plus', $tempvar[0]);
                if ($first_input_flag == TRUE)
                {
                    $first_input_flag = FALSE;
                    $producers[0] = $tempvar[0];
                    $number_producers = 1;
                    $flag_increment_member = TRUE;
                } else
                {
                    for ($y = 0; $y < $number_producers; $y++)
                    {
                        if ($producers[$y] == $tempvar[0])
                        {
                            $flag_exist_member = TRUE;
                        }
                    }
                    if ($flag_exist_member == FALSE)
                    {
                        $number_producers += 1;
                        $flag_increment_member = TRUE;
                        $producers[$number_producers - 1] = $tempvar[0];
                    } else
                    {
                        $flag_exist_member = FALSE;
                    }
                }
                $producer_var = $itemObj->producer;
                $producer_var = (array)$producer_var;
                $producer_var[0] = trim($producer_var[0]);
                $producer_var[0] = str_replace('+', 'plus', $producer_var[0]);
                $article_var = $itemObj->article;
                $article_var = (array)$article_var;
                $devType_var = $itemObj->devType;
                $devType_var = (array)$devType_var;
                $id_var = $itemObj->id;
                $id_var = (array)$id_var;
                $model_var = $itemObj->model;
                $model_var = (array)$model_var;
                $prdDate_var = $itemObj->prdDate;
                $prdDate_var = (array)$prdDate_var;
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////$xml_upload/////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if ($xml_upload->xpath('//Классификатор/Группы'))
            {
                foreach ($xml_upload->xpath('//Классификатор/Группы') as $itemObj2)
                {
                    if ($flag_increment_member == TRUE)
                    {
                        $flag_increment_member = FALSE;
                        $itemObj2[0]->addChild('Группа');

                        $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);

                        $itemObj2->Группа[$number_producers - 1]->addChild('Ид', $ID++);
                        if ($number_producers == 1)
                        {
                            $itemObj2->Группа[$number_producers - 1]->addChild('Наименование', $producers[0]);
                            $temp_producer = $producers[0];
                            $temp_producer = mb_strtolower($temp_producer);
                            $temp_producer = str_replace(' ', '_', $temp_producer);
                            $temp_producer = str_replace('.', '_', $temp_producer);
                        } else
                        {
                            $itemObj2->Группа[$number_producers - 1]->addChild('Наименование', $producers[$number_producers - 1]);
                            $temp_producer = $producers[$number_producers - 1];
                            $temp_producer = mb_strtolower($temp_producer);
                            $temp_producer = str_replace(' ', '_', $temp_producer);
                            $temp_producer = str_replace('.', '_', $temp_producer);
                        }
                        $itemObj2->Группа[$number_producers - 1]->addChild('Описание', '');
                        $itemObj2->Группа[$number_producers - 1]->addChild('БитриксАктивность', 'true');
                        $itemObj2->Группа[$number_producers - 1]->addChild('БитриксСортировка', '500');
                        $itemObj2->Группа[$number_producers - 1]->addChild('БитриксКод', $temp_producer);
                        $itemObj2->Группа[$number_producers - 1]->addChild('БитриксКартинка', '');
                        $itemObj2->Группа[$number_producers - 1]->addChild('БитриксКартинкаДетальная', '');
                        $itemObj2->Группа[$number_producers - 1]->addChild('ЗначенияСвойств', '');
                        $itemObj2->Группа[$number_producers - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                        $itemObj2->Группа[$number_producers - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                        $itemObj2->Группа[$number_producers - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                        $itemObj2->Группа[$number_producers - 1]->ЗначенияСвойств->ЗначенияСвойства[0]->addChild('Ид', 'UF_ARTICLE');
                        $itemObj2->Группа[$number_producers - 1]->ЗначенияСвойств->ЗначенияСвойства[0]->addChild('Значение', '');
                        $itemObj2->Группа[$number_producers - 1]->ЗначенияСвойств->ЗначенияСвойства[1]->addChild('Ид', 'UF_DEVTYPE');
                        $itemObj2->Группа[$number_producers - 1]->ЗначенияСвойств->ЗначенияСвойства[1]->addChild('Значение', '');
                        $itemObj2->Группа[$number_producers - 1]->ЗначенияСвойств->ЗначенияСвойства[2]->addChild('Ид', 'UF_PRDDATE');
                        $itemObj2->Группа[$number_producers - 1]->ЗначенияСвойств->ЗначенияСвойства[2]->addChild('Значение', '');
                        $itemObj2->Группа[$number_producers - 1]->addChild('Группы', '');
                    }
                }
            }
        }
        $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);
        AddMessage2Log("в файл xml_upload добавились Группы по производителЯм ", "FirstUpload");
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////enf of producers/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * Создаём список прототипов по производителЯм. Если в файле $xml_prototypes существует хотЯ бы один прототип, то перезаписываем этот файл.
 * В качестве дополнительного условиЯ производим проверку $xml_offers на то ЯвлЯется ли хотЯ бы один из аккумулЯторов в предложениЯх новым.
 */
if ($xml_prototypes->xpath('//dataWs'))
{
    $xml_prototypes = simplexml_load_file($ABS_FILE_NAME_PROTOTYPES_ALL);
    //print_r($xml_prototypes);
    //echo nl2br("\r\n");
}

if ($THERE_IS_NO_MATCH_OFFERS)
{
    if ($xml_prototypes->xpath('//dataWs'))
    {
        foreach ($xml_prototypes->xpath('//dataWs') as $itemObj)
        {
            $count = count($itemObj);
            if ($itemObj->producer)
            {
                $tempvar = $itemObj->producer;
                $tempvar = (array)$tempvar;
                $tempvar[0] = trim($tempvar[0]);
                $tempvar[0] = str_replace('+', 'plus', $tempvar[0]);
                if ($first_input_flag == TRUE)
                {
                    $first_input_flag = FALSE;
                    $producers[0] = $tempvar[0];
                    $number_producers = 1;
                    $flag_increment_member = TRUE;
                } else
                {
                    for ($y = 0; $y < $number_producers; $y++)
                    {
                        if ($producers[$y] == $tempvar[0])
                        {
                            $flag_exist_member = TRUE;
                        }
                    }
                    if ($flag_exist_member == FALSE)
                    {
                        $number_producers += 1;
                        $flag_increment_member = TRUE;
                        $producers[$number_producers - 1] = $tempvar[0];
                    } else
                    {
                        $flag_exist_member = FALSE;
                    }
                }
                $producer_var = $itemObj->producer;
                $producer_var = (array)$producer_var;
                $producer_var[0] = trim($producer_var[0]);
                $producer_var[0] = str_replace('+', 'plus', $producer_var[0]);
                ////////////////////////////////
                $article_var = $itemObj->article;
                $article_var = (array)$article_var;
                /////////////////////////////////
                $devType_var = $itemObj->devType;
                $devType_var = (array)$devType_var;
                //////////////////////
                $id_var = $itemObj->id;
                $id_var = (array)$id_var;
                ////////////////////////////
                $model_var = $itemObj->model;
                $model_var = (array)$model_var;
                $model_var[0] = trim($model_var[0]);
                $model_var[0] = str_replace('+', 'plus', $model_var[0]);
                ///////////////////////////////////
                $temp_name_items = $model_var[0];
                $temp_name_items = mb_strtolower($temp_name_items);
                $temp_name_items = str_replace(' ', '_', $temp_name_items);
                $temp_name_items = str_replace('.', '_', $temp_name_items);
                $temp_name_items = str_replace('/', '_', $temp_name_items);
                ///////////////////////////////////
                $prdDate_var = $itemObj->prdDate;
                $prdDate_var = (array)$prdDate_var;
                ///////////////////////////////////
                foreach ($xml_compatibility_0->xpath('//dataWs') as $item_comp_dataWs)
                {
                    $item_comp_dataWs_article = $item_comp_dataWs->article;
                    $item_comp_dataWs_article = (array)$item_comp_dataWs_article;

                    if ($article_var[0] == $item_comp_dataWs_article[0])
                    {
                        $item_comp_dataWs_compatibilityList = $item_comp_dataWs->compatibilityList;
                        $item_comp_dataWs_compatibilityList = (array)$item_comp_dataWs_compatibilityList;

                        //$compatibilityList_elems = $item_comp_dataWs->xpath('.//compatibilityList');
                        //$count_compatibilityList_elems = count($compatibilityList_elems);
                        $uf_compatibilityList = '';
                        foreach ($item_comp_dataWs->xpath('.//compatibilityList') as $compatibilityList_elems)
                        {
                            $compatibilityList_elems = (array)$compatibilityList_elems;

                            $uf_compatibilityList = $uf_compatibilityList . $compatibilityList_elems[0] . ' ';

                            // print_r($item_comp_dataWs_article[0]);
                            // echo nl2br("\r\n");
                            // print_r($compatibilityList_elems[0]);
                            // echo nl2br("\r\n");

                        }
                    }
                }
                /////////////////////////////////////////
                $batteryType_var = $itemObj->batteryType;
                $batteryType_var = (array)$batteryType_var;
                $uf_batteryType = $batteryType_var[0];
                ////////////////////////////////////////////////
                $uf_devType = $devType_var[0];
                ////////////////////////////////////////////////
                $uf_model = $model_var[0];
                ////////////////////////////////////////////////
                $uf_prdDate = $prdDate_var[0];
                ////////////////////////////////////////////////
                $uf_producer = $producer_var[0];
                ////////////////////////////////////////////////
                $uf_description = "test description";
                ////////////////////////////////////////////////
                //print_r("uf_alt_var result");
                //echo nl2br("\r\n");
                //print_r($uf_alt_var);
                //echo nl2br("\r\n");

                //if($article_var[0]=='A1.22.069')
                //{
                //return;
                //}
                /**
                 * ДлЯ сайта нужно было обрезать имена прототипов, убрав из названиЯ производителЯ.
                 * После этого отвалилсЯ поиск совместимостей длЯ предложений.
                 */
                /////////////////////////////////////////////
                $str_len_producer = strlen($producer_var[0]);
                $str_len_model = strlen($model_var[0]);
                $modified_model_var = substr($model_var[0], $str_len_producer, $str_len_model);
                $modified_model_var = trim($modified_model_var);
                /**
                 * 17.01.2017 Дописал еще один костыль чтобы название обрезанного прототипа соответствовало
                 * тому как называются прототипы с + в 1С-ке
                 */
                $modified_model_var = str_replace('plus', '+', $modified_model_var);
                //$modified_model_var = trim($model_var[0]);
                //print_r($modified_model_var);
                //echo nl2br("\r\n");
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////$xml_upload/////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if ($xml_upload->xpath('//Классификатор/Группы/Группа'))
            {
                foreach ($xml_upload->xpath('//Классификатор/Группы/Группа') as $producers_items)
                {
                    $count_producers_items = count($producers_items);
                    //print_r($count_producers_items);
                    //echo nl2br("\r\n");
                    $producers_items_name = $producers_items->Наименование;
                    $producers_items_name = (array)$producers_items_name;
                    $producers_items_name[0] = trim($producers_items_name[0]);
                    $producers_items_name[0] = str_replace('+', 'plus', $producers_items_name[0]);
                    if ($producers_items_name[0] == $producer_var[0])
                    {
                        //print_r($producers_items_name[0]);
                        // echo nl2br("\r\n");
                        //print_r($producer_var[0]);
                        //echo nl2br("\r\n");
                        $group_node = $producers_items->xpath('.//Группы');
                        //print_r($group_node);
                        //echo nl2br("\r\n");
                        if ($group_node[0] !== NULL)
                        {
                            $group_node[0]->addChild('Группа', '');
                        }
                        $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);
                        $group_node_elems = $producers_items->xpath('.//Группы/Группа');
                        $count_group_node_elems = count($group_node_elems);
                        //print_r($group_node);
                        //echo nl2br("\r\n");
                        if ($group_node_elems[$count_group_node_elems - 1] !== NULL)
                        {
                            if ($article_var[0] != NULL)
                            {
                                $temp_article_name = $article_var[0];
                                $temp_first_symbol = ord($temp_article_name);
                                $temp_article_name = preg_replace('~[^0-9]+~', '', $article_var[0]);
                                $temp_article_name = $temp_first_symbol . $temp_article_name;
                            } else
                            {
                                /**
                                 * Инкремент $global_article_temp производитсЯ ниже один раз за итерацию
                                 */
                                $temp_article_name = $global_article_temp_groups;
                            }
                            //print_r($temp_article_name);
                            //echo nl2br("\r\n");
                            /**
                             * Заменил внешний ИД на артикул
                             */
                            $group_node_elems[$count_group_node_elems - 1]->addChild('Ид', $temp_article_name);

                            $group_node_elems[$count_group_node_elems - 1]->addChild('Наименование', $modified_model_var);
			if (empty($uf_compatibilityList)) {
                            	$group_node_elems[$count_group_node_elems - 1]->addChild('БитриксАктивность', 'false');
				$group_node_elems[$count_group_node_elems - 1]->addChild('БитриксСортировка', '550');
			} else {
				$group_node_elems[$count_group_node_elems - 1]->addChild('БитриксАктивность', 'true');
				$group_node_elems[$count_group_node_elems - 1]->addChild('БитриксСортировка', '500');
			}
                            $group_node_elems[$count_group_node_elems - 1]->addChild('БитриксКод', $temp_name_items);
                            if ($THERE_IS_FIRST_UPLOAD)
                            {
                                $group_node_elems[$count_group_node_elems - 1]->addChild('БитриксКартинка', '');
                                $group_node_elems[$count_group_node_elems - 1]->addChild('БитриксКартинкаДетальная', '');
                            }
                            $group_node_elems[$count_group_node_elems - 1]->addChild('ЗначенияСвойств', '');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[0]->addChild('Ид', 'UF_ARTICLE');
                            if ($article_var[0] != NULL)
                            {
                                $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[0]->addChild('Значение', $article_var[0]);
                            } else
                            {
                                $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[0]->addChild('Значение', $global_article_temp_groups++);
                            }
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[1]->addChild('Ид', 'UF_DEVTYPE');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[1]->addChild('Значение', $uf_devType);
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[2]->addChild('Ид', 'UF_PRDDATE');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[2]->addChild('Значение', $uf_prdDate);

                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[3]->addChild('Ид', 'UF_DESCRIPTION');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[3]->addChild('Значение', $uf_description);

                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[4]->addChild('Ид', 'UF_BATTERYTYPE');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[4]->addChild('Значение', $uf_batteryType);

                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[5]->addChild('Ид', 'UF_MODEL');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[5]->addChild('Значение', 'Аккумулятор для '.$uf_model.'');

                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[6]->addChild('Ид', 'UF_PRODUCER');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[6]->addChild('Значение', $uf_producer);

                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[7]->addChild('Ид', 'UF_COMPATIBILITYLIST');
                            $group_node_elems[$count_group_node_elems - 1]->ЗначенияСвойств->ЗначенияСвойства[7]->addChild('Значение', $uf_compatibilityList);

                        }
                    }   //break;
                }
            }
        }
        $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);
        AddMessage2Log("в файл xml_upload добавились прототипы по группам производителей ", "FirstUpload");
    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////enf of prototypes/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Создаём список предложений
 */
$sort_count_temp=0;
if ($xml_offers->xpath('//dataWs'))
{
    foreach ($xml_offers->xpath('//dataWs') as $item_offers)
    {
        //$count_item_offers = count($item_offers);
        $article_var = $item_offers->article;
        $article_var = (array)$article_var;
        $barcode_var = $item_offers->barcode;
        $barcode_var = (array)$barcode_var;
        $capacity_var = $item_offers->capacity;
        $capacity_var = (array)$capacity_var;
        $complect_var = $item_offers->complect;
        $complect_var = (array)$complect_var;
        if ($item_offers->devices)
        {
            $count_item_offers_devices = count($item_offers->devices);
            //print_r($count_item_offers_devices);
            //echo nl2br("\r\n");
            $devices_var = (array)$devices_var;
            // print_r($count_item_offers_devices);
            // echo nl2br("\r\n");
            for ($count_dev = 0; $count_dev < $count_item_offers_devices; $count_dev++)
            {
                $temp_item_offers_devices = $item_offers->devices[$count_dev];
                $temp_item_offers_devices = (array)$temp_item_offers_devices;
                $temp_item_offers_devices = $temp_item_offers_devices[0];

                $temp_first_symbol = ord($temp_item_offers_devices);
                $temp_item_offers_devices = preg_replace('~[^0-9]+~', '', $temp_item_offers_devices);
                $temp_item_offers_devices = $temp_first_symbol . $temp_item_offers_devices;

                //print_r($temp_item_offers_devices);
                //echo nl2br("\r\n");

                $devices_var[$count_dev] = $temp_item_offers_devices;
                //print_r($devices_var[$count_dev]);
                //echo nl2br("\r\n");
            }
        } else
        {
            $count_item_offers_devices = 0;
        }
        $group_var = $item_offers->group;
        $group_var = (array)$group_var;
        $imagePath_var = $item_offers->imagePath;
        $imagePath_var = (array)$imagePath_var;


        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $flag_instock_exist = FALSE;
        if ($xml_instock->xpath('//dataWs'))
        {
            foreach ($xml_instock->xpath('//dataWs') as $item_instock)
            {
                $item_instock_article = $item_instock->article;
                $item_instock_article = (array)$item_instock_article;
                //print_r($item_instock_article[0]);
                //echo nl2br("\r\n");
                //print_r($article_var[0]);
                //echo nl2br("\r\n");
                if ($article_var[0] == $item_instock_article[0])
                {
                    $instock_var = $item_instock->status;
                    $instock_var = (array)$instock_var;
                    AddMessage2Log("Товар с артикулом " . $article_var[0] . " поменЯл наличие на " . $instock_var[0], "FirstUpload");
                    $flag_instock_exist = TRUE;
                    break;
                }
            }
        }
        //$instock_var = $item_offers->instock;
        //$instock_var = (array)$instock_var;
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $name_var = $item_offers->name;
        $name_var = (array)$name_var;
	if (isset($item_offers->batteryDescription))
	   $batteryDescription_var = $item_offers->batteryDescription;
	else 
	   $batteryDescription_var = "";
	$batteryDescription_var = (array)$batteryDescription_var;
        $originalCode_var = $item_offers->originalCode;
        $originalCode_var = (array)$originalCode_var;
        $index_temp = 1;
        AddMessage2Log("Значение переменной " . "item_offers->originalCode" . (string)$index_temp . "=" . $item_offers->{"originalCode" . (string)$index_temp}, "FirstUpload");
        while ( !empty($item_offers->{"originalCode" . (string)$index_temp}) ) {
           $originalCode_var[$index_temp] = $item_offers->{"originalCode" . (string)$index_temp};
           $index_temp++;
        }
        $packType_var = $item_offers->packType;
        $packType_var = (array)$packType_var;
        $power_var = $item_offers->power;
        $power_var = (array)$power_var;
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $flag_price_exist = FALSE;
        if ($xml_prices->xpath('//dataWs'))
        {
            foreach ($xml_prices->xpath('//dataWs') as $item_prices)
            {
                $item_prices_article = $item_prices->article;
                $item_prices_article = (array)$item_prices_article;
                //print_r($item_instock_article[0]);
                //echo nl2br("\r\n");
                //print_r($article_var[0]);
                //echo nl2br("\r\n");
                if ($article_var[0] == $item_prices_article[0])
                {
                    $price_var = $item_prices->price;
                    $price_var = (array)$price_var;
                    AddMessage2Log("Товар с артикулом " . $article_var[0] . " поменЯл цену на " . $price_var[0], "FirstUpload");
                    $flag_price_exist = TRUE;
                    break;
                }
            }
        }
        //$price_var = $item_offers->price;
        //$price_var = (array)$price_var;
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $type_var = $item_offers->type;
        $type_var = (array)$type_var;
        $voltage_var = $item_offers->voltage;
        $voltage_var = (array)$voltage_var;
        //print_r($id_var);
        //echo nl2br("\r\n");
        //print_r('да');
        //echo nl2br("\r\n");
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////$xml_upload/////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if ($xml_upload->xpath('//ПакетПредложений/Предложения'))
        {
            $offers_node_offers = $xml_upload->xpath('//ПакетПредложений/Предложения');
            $offers_node_offers[0]->addChild('Предложение', '');
            $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);
            // if ($offers_node_offers!== NULL)
            // {
            $offer_node = $xml_upload->xpath('.//Предложения/Предложение');
            $count_offers_node = count($offer_node);
            //print_r($count_offers_node);
            //echo nl2br("\r\n");
            if ($offer_node[$count_offers_node - 1] !== NULL)
            {
                $count_offers_node = $count_offers_node - 1;
                ///////////////////////////////////////////////////////////////////
                if ($article_var[0] != NULL)
                {
                    $temp_article_name = $article_var[0];
                    $temp_first_symbol = ord($temp_article_name);
                    $temp_article_name = preg_replace('~[^0-9]+~', '', $article_var[0]);
                    $temp_article_name = $temp_first_symbol . $temp_article_name;
                } else
                {
                    /**
                     * Инкремент $global_article_temp_offers производитсЯ ниже один раз за итерацию
                     */
                    $temp_article_name = $global_article_temp_offers;
                }
                ///////////////////////////////////////////////////////////////////

                //$temp_article_name = $article_var[0];
                //$temp_first_symbol = ord($temp_article_name);
                //$temp_article_name = preg_replace('~[^0-9]+~', '', $article_var[0]);
                //$temp_article_name = $temp_first_symbol . $temp_article_name;
                //print_r($temp_article_name);
                //echo nl2br("\r\n");
                $offer_node[$count_offers_node]->addChild('Ид', $temp_article_name++);


                $offer_node[$count_offers_node]->addChild('Наименование', $article_var[0]);
                ////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->addChild('БитриксТеги', '');
                $offer_node[$count_offers_node]->addChild('Группы', '');
                /**
                 * Поскольку количество вложенностей сократилось, то тут только привЯзка к СНЯТЫЕ С ПРОИЗВОДСТВА
                 * 23.11_2016 удалил СНЯТЫЕ С ПРОИЗВОДСТВА
                 */
                if (FALSE)//($xml_upload->xpath('//Классификатор/Группы/Группа'))
                {
                    foreach ($xml_upload->xpath('//Классификатор/Группы/Группа') as $xml_global_group_offers)
                    {
                        $temp_global_group_offers_name = $xml_global_group_offers->Наименование;
                        $temp_global_group_offers_name = (array)$temp_global_group_offers_name;
                        //print_r($temp_global_group_offers_name[0]);
                        //echo nl2br("\r\n");
                        //print_r($group_var[0]);
                        //echo nl2br("\r\n");
                        if ($temp_global_group_offers_name[0] == $group_var[0])
                        {
                            //print_r($xml_global_group_offers->Ид);
                            //echo nl2br("\r\n");
                            $temp_global_group_offers_id = $xml_global_group_offers->Ид;
                            $temp_global_group_offers_id = (array)$temp_global_group_offers_id;
                            $offer_node[$count_offers_node]->Группы->addChild('Ид', $temp_global_group_offers_id[0]);
                        }
                    }
                }

                //if ($xml_upload->xpath('//Классификатор/Группы/Группа/Группы/Группа'))
                //{
                //foreach ($xml_upload->xpath('//Классификатор/Группы/Группа/Группы/Группа') as $proto_items)
                //{
                //$temp_proto_items_id = $proto_items->Ид;
                //$temp_proto_items_id = (array)$temp_proto_items_id;

                for ($count_dev = 0; $count_dev < $count_item_offers_devices; $count_dev++)
                {
                    // print_r($devices_var[$count_dev]);
                    // echo nl2br("\r\n");
                    //if ($devices_var[$count_dev] == $temp_proto_items_id[0])
                    //{
                    //print_r($devices_var[$count_dev]);
                    //echo nl2br("\r\n");
                    //print_r($temp_proto_items_name[0]);
                    //echo nl2br("\r\n");
                    //$temp_proto_items_id = $proto_items->Ид;
                    //$temp_proto_items_id = (array)$temp_proto_items_id;
                    $offer_node[$count_offers_node]->Группы->addChild('Ид', $devices_var[$count_dev]);
                    //}
                }
                //}
                //}
                //Детальную картинку добавлЯем только в случае FIRST UPLOAD
                //$offer_node[$count_offers_node]->addChild('Картинка', '');
                $offer_node[$count_offers_node]->addChild('ЗначенияСвойств', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->addChild('ЗначенияСвойства', '');

                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[0]->addChild('Ид', 'CML2_ACTIVE');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[0]->addChild('Значение', 'true');

                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[1]->addChild('Ид', 'CML2_CODE');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[1]->addChild('Значение', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[2]->addChild('Ид', 'CML2_SORT');
                $sort_temp=(string)500+$sort_count_temp;
                if ($instock_var[0] != "в наличии")
                    $sort_temp=(string)$sort_count_temp+10500;
                $sort_count_temp++;
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[2]->addChild('Значение', $sort_temp);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[3]->addChild('Ид', 'CML2_ACTIVE_FROM');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[3]->addChild('Значение', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[4]->addChild('Ид', 'CML2_ACTIVE_TO');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[4]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[5]->addChild('Ид', 'CML2_PREVIEW_TEXT');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[5]->addChild('Значение', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[5]->addChild('Тип', 'text');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[6]->addChild('Ид', 'CML2_DETAIL_TEXT');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[6]->addChild('Значение', $batteryDescription_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[6]->addChild('Тип', 'text');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[7]->addChild('Ид', 'CML2_PREVIEW_PICTURE');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[7]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////

                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[8]->addChild('Ид', '38');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                if ($article_var[0] != NULL)
                {
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[8]->addChild('Значение', $article_var[0]);
                } else
                {
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[8]->addChild('Значение', $global_article_temp_offers++);
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[8]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[8]->ЗначенияСвойства[0]->addChild('Значение', $article_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[8]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[9]->addChild('Ид', '39');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[9]->addChild('Значение', implode("; ",$originalCode_var));
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[9]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[9]->ЗначенияСвойства[0]->addChild('Значение', implode("; ",$originalCode_var));
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[9]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[10]->addChild('Ид', '50');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[10]->addChild('Значение', $name_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[10]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[10]->ЗначенияСвойства[0]->addChild('Значение', $name_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[10]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[11]->addChild('Ид', '46');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[11]->addChild('Значение', $complect_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[11]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[11]->ЗначенияСвойства[0]->addChild('Значение', $complect_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[11]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[12]->addChild('Ид', '71');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[12]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[13]->addChild('Ид', '37');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[13]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[14]->addChild('Ид', '74');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[14]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[15]->addChild('Ид', '48');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[15]->addChild('Значение', 'На территории РФ: AE63, МЕ06');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[15]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[15]->ЗначенияСвойства[0]->addChild('Значение', 'На территории РФ: AE63, МЕ06');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[15]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[16]->addChild('Ид', '6');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[16]->addChild('Значение', '12');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[16]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[16]->ЗначенияСвойства[0]->addChild('Значение', '12');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[16]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[17]->addChild('Ид', '32');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[17]->addChild('Значение', $type_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[17]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[17]->ЗначенияСвойства[0]->addChild('Значение', $type_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[17]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[18]->addChild('Ид', '34');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[18]->addChild('Значение', $voltage_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[18]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[18]->ЗначенияСвойства[0]->addChild('Значение', $voltage_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[18]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[19]->addChild('Ид', '35');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[19]->addChild('Значение', $power_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[19]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[19]->ЗначенияСвойства[0]->addChild('Значение', $power_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[19]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[20]->addChild('Ид', '36');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[20]->addChild('Значение', $capacity_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[20]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[20]->ЗначенияСвойства[0]->addChild('Значение', $capacity_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[20]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[21]->addChild('Ид', '47');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[21]->addChild('Значение', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[21]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[21]->ЗначенияСвойства[0]->addChild('Значение', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[21]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[22]->addChild('Ид', '53');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[22]->addChild('Значение', $barcode_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[22]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[22]->ЗначенияСвойства[0]->addChild('Значение', $barcode_var[0]);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[22]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[23]->addChild('Ид', '40');
                if (trim($group_var[0]) == "СНЯТЫЕ С ПРОИЗВОДСТВА")
                {
                    $group_var_production_status = "не производится";
                } else
                {
                    $group_var_production_status = "производится";
                }
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[23]->addChild('Значение', $group_var_production_status);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[23]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[23]->ЗначенияСвойства[0]->addChild('Значение', $group_var_production_status);
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[23]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                if ($flag_price_exist)
                {
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[24]->addChild('Ид', '7');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[24]->addChild('Значение', $price_var[0]);
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[24]->addChild('ЗначенияСвойства', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[24]->ЗначенияСвойства[0]->addChild('Значение', $price_var[0]);
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[24]->ЗначенияСвойства[0]->addChild('Описание', '');
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[25]->addChild('Ид', '55');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[25]->addChild('Значение', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[25]->addChild('ЗначенияСвойства', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[25]->ЗначенияСвойства[0]->addChild('Значение', '');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[25]->ЗначенияСвойства[0]->addChild('Описание', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                if ($flag_instock_exist)
                {
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[26]->addChild('Ид', '56');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[26]->addChild('Значение', $instock_var[0]);
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[26]->addChild('ЗначенияСвойства', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[26]->ЗначенияСвойства[0]->addChild('Значение', $instock_var[0]);
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[26]->ЗначенияСвойства[0]->addChild('Описание', '');
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[27]->addChild('Ид', '70');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[27]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[28]->addChild('Ид', '73');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[28]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[29]->addChild('Ид', '76');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[29]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[30]->addChild('Ид', '77');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[30]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[31]->addChild('Ид', '90');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[31]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[32]->addChild('Ид', '91');
                $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[32]->addChild('Значение', '');
                ////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////////
                //////////41, 42, 43/////////////////ЗначениеСвойства///////////////////41, 42, 43//////////////
                ////////////////////////////////////////////////////////////////////////////////////////////////
                if ($THERE_IS_FIRST_UPLOAD)
                {
                    //Детальную картинку добавлЯем только в случае FIRST UPLOAD
                    $offer_node[$count_offers_node]->addChild('Картинка', '');

                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[33]->addChild('Ид', '41');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[33]->addChild('Значение', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[33]->addChild('ЗначениеСвойства', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[0]->addChild('Значение', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[0]->addChild('Описание', '');

                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[34]->addChild('Ид', '42');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[34]->addChild('Значение', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[34]->addChild('ЗначениеСвойства', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[0]->addChild('Значение', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[0]->addChild('Описание', '');

                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[35]->addChild('Ид', '43');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[35]->addChild('Значение', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[35]->addChild('ЗначениеСвойства', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[0]->addChild('Значение', '');
                    $offer_node[$count_offers_node]->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[0]->addChild('Описание', '');

                }
                ////////////////////////////////////////////////////////////////////////////////////////////////
                //////////41, 42, 43/////////////////ЗначениеСвойства///////////////////41, 42, 43//////////////
                ////////////////////////////////////////////////////////////////////////////////////////////////

                if ($flag_price_exist)
                {
                    $offer_node[$count_offers_node]->addChild('Цены', '');
                    $offer_node[$count_offers_node]->Цены->addChild('Цена', '');
                    $offer_node[$count_offers_node]->Цены->Цена[0]->addChild('ИдТипаЦены', 'retail');
                    $offer_node[$count_offers_node]->Цены->Цена[0]->addChild('ЦенаЗаЕдиницу', $price_var[0]);
                    $offer_node[$count_offers_node]->Цены->Цена[0]->addChild('Валюта', 'RUB');
                    $offer_node[$count_offers_node]->Цены->Цена[0]->addChild('Единица', '796');
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////////
                if ($flag_instock_exist)
                {
                    if ($instock_var[0] == "в наличии")
                    {
                        //print_r('в наличии');
                        //echo nl2br("\r\n");
                        $quantity_of_batteries = 1000;
                    } else
                    {
                        //print_r('нет');
                        //echo nl2br("\r\n");
                        $quantity_of_batteries = 0;
                    }
                    $offer_node[$count_offers_node]->addChild('Количество', $quantity_of_batteries);
                }
            }
        }
        //break;
    }
    $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);
    AddMessage2Log("в файл xml_upload добавились предложениЯ", "FirstUpload");
} else
{

    /**
     * Тут обновлЯем наличие на складе в свойствах элемента (они отображаютсЯ на сайте)
     */
    if ($xml_instock->xpath('//dataWs'))
    {
        foreach ($xml_instock->xpath('//dataWs') as $item_instock)
        {
            $item_instock_article = $item_instock->article;
            $item_instock_article = (array)$item_instock_article;

            $instock_var = $item_instock->status;
            $instock_var = (array)$instock_var;
            AddMessage2Log("Товар с артикулом " . $item_instock_article[0] . " поменЯл наличие на " . $instock_var[0], "FirstUpload");

            $res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $GLOBAL_IBLOCK_ID, "NAME" => $item_instock_article));

            while ($arElement = $res->Fetch())
            {
                if (trim($arElement['SEARCHABLE_CONTENT']) == trim($item_instock_article[0]))
                {
                    $PROPS = array();
                    $instock_var_win1251 = utf8win1251($instock_var[0]);
                    $PROPS["STORE"] = $instock_var_win1251;
                    CIBlockElement::SetPropertyValueCode($arElement["ID"], "STORE", $PROPS["STORE"]);
                }
            }
        }
    }

    /**
     * Тут обновлЯем цену в свойствах элемента (они отображаютсЯ на сайте)
     */
    if ($xml_prices->xpath('//dataWs'))
    {
        foreach ($xml_prices->xpath('//dataWs') as $item_prices)
        {
            $item_prices_article = $item_prices->article;
            $item_prices_article = (array)$item_prices_article;

            $price_var = $item_prices->price;
            $price_var = (array)$price_var;
            AddMessage2Log("Товар с артикулом " . $item_prices_article[0] . " поменЯл цену на " . $price_var[0], "FirstUpload");

            $res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $GLOBAL_IBLOCK_ID, "NAME" => $item_prices_article));

            while ($arElement = $res->Fetch())
            {
                if (trim($arElement['SEARCHABLE_CONTENT']) == trim($item_prices_article[0]))
                {
                    $PROPS = array();
                    $PROPS["PRICE"] = $price_var[0];
                    CIBlockElement::SetPropertyValueCode($arElement["ID"], "PRICE", $PROPS["PRICE"]);
                }
            }
        }
    }

    /**
     * Тут обновлЯем цену и наличие на складе в ТОРГОВОМ КАТАЛОГЕ (Нужно длЯ корзины и заказа)
     */
    if ($xml_prices->xpath('//dataWs'))
    {
        foreach ($xml_prices->xpath('//dataWs') as $item_prices)
        {
            $flag_instock_exist = FALSE;
            $item_prices_article = $item_prices->article;
            $item_prices_article = (array)$item_prices_article;

            $price_var = $item_prices->price;
            $price_var = (array)$price_var;
            AddMessage2Log("Товар с артикулом " . $item_prices_article[0] . " поменЯл цену на " . $price_var[0], "FirstUpload");

            /////////xml_upload/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if ($xml_upload->xpath('//ПакетПредложений/Предложения'))
            {
                $offers_node_offers = $xml_upload->xpath('//ПакетПредложений/Предложения');
                $offers_node_offers[0]->addChild('Предложение', '');
                $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);

                $offer_node = $xml_upload->xpath('.//Предложения/Предложение');
                $count_offers_node = count($offer_node);
                //print_r($count_offers_node);
                //echo nl2br("\r\n");
                if ($offer_node[$count_offers_node - 1] !== NULL)
                {
                    $count_offers_node = $count_offers_node - 1;
                    ///////////////////////////////////////////////////////////////////
                    if ($item_prices_article[0] != NULL)
                    {
                        $temp_article_name = $item_prices_article[0];
                        $temp_first_symbol = ord($temp_article_name);
                        $temp_article_name = preg_replace('~[^0-9]+~', '', $item_prices_article[0]);
                        $temp_article_name = $temp_first_symbol . $temp_article_name;
                    } else
                    {
                        /**
                         * Инкремент $global_article_temp_offers производитсЯ в данном случае здесь
                         */
                        $temp_article_name = $global_article_temp_offers++;
                    }

                    $offer_node[$count_offers_node]->addChild('Ид', $temp_article_name++);

                    $offer_node[$count_offers_node]->addChild('Цены', '');
                    $offer_node[$count_offers_node]->Цены->addChild('Цена', '');
                    $offer_node[$count_offers_node]->Цены->Цена[0]->addChild('ИдТипаЦены', 'retail');
                    $offer_node[$count_offers_node]->Цены->Цена[0]->addChild('ЦенаЗаЕдиницу', $price_var[0]);
                    $offer_node[$count_offers_node]->Цены->Цена[0]->addChild('Валюта', 'RUB');
                    $offer_node[$count_offers_node]->Цены->Цена[0]->addChild('Единица', '796');


                }
            }
        }
        $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);
        AddMessage2Log("в файл xml_upload добавились предложениЯ только по ценам", "FirstUpload");
    }

    if ($xml_instock->xpath('//dataWs'))
    {
        foreach ($xml_instock->xpath('//dataWs') as $item_instock)
        {
            $flag_price_exist = FALSE;

            $item_instock_article = $item_instock->article;
            $item_instock_article = (array)$item_instock_article;

            $instock_var = $item_instock->status;
            $instock_var = (array)$instock_var;
            AddMessage2Log("Товар с артикулом " . $item_instock_article[0] . " поменЯл наличие на " . $instock_var[0], "FirstUpload");
            /////////xml_upload/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if ($xml_upload->xpath('//ПакетПредложений/Предложения'))
            {
                $offers_node_offers = $xml_upload->xpath('//ПакетПредложений/Предложения');
                $offers_node_offers[0]->addChild('Предложение', '');
                $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);

                $offer_node = $xml_upload->xpath('.//Предложения/Предложение');
                $count_offers_node = count($offer_node);
                //print_r($count_offers_node);
                //echo nl2br("\r\n");
                if ($offer_node[$count_offers_node - 1] !== NULL)
                {
                    $count_offers_node = $count_offers_node - 1;
                    ///////////////////////////////////////////////////////////////////
                    if ($item_instock_article[0] != NULL)
                    {
                        $temp_article_name = $item_instock_article[0];
                        $temp_first_symbol = ord($temp_article_name);
                        $temp_article_name = preg_replace('~[^0-9]+~', '', $item_instock_article[0]);
                        $temp_article_name = $temp_first_symbol . $temp_article_name;
                    } else
                    {
                        /**
                         * Инкремент $global_article_temp_offers производитсЯ в данном случае здесь
                         */
                        $temp_article_name = $global_article_temp_offers++;
                    }

                    $offer_node[$count_offers_node]->addChild('Ид', $temp_article_name++);

                    if ($instock_var[0] == "в наличии")
                    {
                        //print_r('в наличии');
                        //echo nl2br("\r\n");
                        $quantity_of_batteries = 1000;
                    } else
                    {
                        //print_r('нет');
                        //echo nl2br("\r\n");
                        $quantity_of_batteries = 0;
                    }
                    $offer_node[$count_offers_node]->addChild('Количество', $quantity_of_batteries);

                }
            }
        }
        $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);
        AddMessage2Log("в файл xml_upload добавились предложениЯ только по наличию", "FirstUpload");
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////enf of offers///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////PICTURE_UPLOAD//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * ОпределЯем существует ли диреториЯ и в зависимости от этого выставлЯем флаг THERE_IS_FIRST_UPLOAD
 */
if (!is_dir($WORK_DIR_NAME . 'telpic'))
{
    AddMessage2Log("Первая загрузка, создаём директории  telpic и acupic, ставим флаг THERE_IS_FIRST_UPLOAD в TRUE ", "PictureUpload");
    //print_r('директория НЕ существует');
    //echo nl2br("\r\n");
    chdir($WORK_DIR_NAME);
    mkdir('telpic');
    mkdir('acupic');
    //$THERE_IS_FIRST_UPLOAD = TRUE;
} else
{
    //print_r('директория существует');
    //echo nl2br("\r\n");
    //$THERE_IS_FIRST_UPLOAD = FALSE;
}
//Zapusk2:
if ($Zapusk != 1)
{
	AddMessage2Log("Работаем с картанками прототипов при втором проходе", "FirstUpload");
}
//отключаем тест
shell_exec("echo yes>/home/bitrix/www/bitrix/components/esfull/FirstUploadFull/sleep");
/**
 * Прописываем пути к картинкам прототипов в теге <БитриксКартинка>.
 * В случае если THERE_IS_FIRST_UPLOAD равно TRUE скачиваем картинки в каталог и после прописываем пути.
 */
if ($xml_upload->xpath('//Классификатор/Группы/Группа/Группы/Группа'))
{
    AddMessage2Log("Начало загрузки telpic", "PictureUpload");
    foreach ($xml_upload->xpath('//Классификатор/Группы/Группа/Группы/Группа') as $proto_items)
    {
        /**
         * ОпределЯем артикул и наименование раздела для поиска.
         */
        $temp_proto_items_article = $proto_items->ЗначенияСвойств->ЗначенияСвойства[0]->Значение;
        $temp_proto_items_article = (array)$temp_proto_items_article;
        if ($temp_proto_items_article[0] == NULL) continue;
        $path_telpic = GetCurlTelPIC($temp_proto_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/deviceImageFile/' . $temp_proto_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'telpic');
        $name_telpic = basename($path_telpic);
        chdir($WORK_DIR_UPLOAD);
        if (!is_dir($WORK_DIR_UPLOAD . 'telpic'))
            mkdir('telpic');
        chdir('telpic');
        if (!file_exists($WORK_DIR_NAME . $path_telpic)) continue;
        if (filesize($WORK_DIR_NAME . $path_telpic) < 1000) continue;
        $temp_path_tp = $WORK_DIR_UPLOAD . 'telpic' . '/' . $name_telpic;
        $temp_jpg_path_dp = $WORK_DIR_UPLOAD . 'telpic' . '/' . $temp_proto_items_article[0] . 'jpg';
        $temp_cwd = getcwd();
        //AddMessage2Log("Сейчас будет создан "  . $WORK_DIR_NAME . $path_telpic . 'create' . " текущий каталог " . $temp_cwd, "PictureUpload");
        if (file_exists($temp_path_tp))
        {
//            if ($temp_jpg_path_dp != $temp_path_tp)
//            {
//                if ( file_exists($temp_jpg_path_dp) )  unlink ($temp_jpg_path_dp);
//                if ( file_exists($WORK_DIR_NAME . 'telpic' . '/' . $temp_proto_items_article[0] . 'jpg') ) unlink ($WORK_DIR_NAME . 'telpic' . '/' . $temp_proto_items_article[0] . 'jpg');
//            }
            if ( !file_exists($WORK_DIR_NAME . $path_telpic . 'create') ) file_put_contents($WORK_DIR_NAME . $path_telpic . 'create','');
            $temp_diff_time = abs (filemtime($temp_path_tp) - filemtime($WORK_DIR_NAME . $path_telpic . 'create'));
        }
        else
        {
            file_put_contents($WORK_DIR_NAME . $path_telpic . 'create','');
            $temp_diff_time = 0;
            AddMessage2Log("Создан " . $path_telpic . 'create', "PictureUpload");
        }
        if ((md5_file($WORK_DIR_NAME . $path_telpic) == md5_file($temp_path_tp)) and ($temp_diff_time > 720000000)) continue;
        $temp_proto_items_name = $proto_items->Наименование;
        $temp_proto_items_name = (array)$temp_proto_items_name;
        /**
         * УдалЯем картинку прототипа.
         */
        if ($THERE_IS_FIRST_UPLOAD == FALSE)
        {
            $arFilter = array('IBLOCK_ID' => $GLOBAL_IBLOCK_ID, 'UF_ARTICLE' => $temp_proto_items_article);
            $rsSections = CIBlockSection::GetList(array(), $arFilter);
            while ($arSection = $rsSections->Fetch())
            {
                $str_one = mb_strtoupper($arSection['SEARCHABLE_CONTENT']);
                $str_two = mb_strtoupper($temp_proto_items_name[0]);
                if (trim($str_one) == trim($str_two))
                {
                    $arr_del_telpic_picture = Array("PICTURE" => array("del" => "Y"));
                    $bs = new CIBlockSection;
                    $res_bs = $bs->Update($arSection["ID"], $arr_del_telpic_picture);
                    AddMessage2Log("В разделе с ID = " . $arSection['ID'] . " удаление картиники с ID = " . $arSection['PICTURE'], "PictureUpload");
                }
            }
        }
        /**
         * Качаем картинку прототипа.
         */
        $path_telpic = GetCurlTelPIC($temp_proto_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/deviceImageFile/' . $temp_proto_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'telpic');
        //$path_telpic = "C:/Bitrix/www/bitrix/components/es/PictureUpload/telpic/A1.01.001.jpg";
        $name_telpic = basename($path_telpic);
        chdir($WORK_DIR_UPLOAD);
        if (!is_dir($WORK_DIR_UPLOAD . 'telpic'))
        {
            mkdir('telpic');
        }
        chdir('telpic');
        $path_image = $WORK_DIR_UPLOAD . 'telpic' . '/' . $temp_proto_items_article[0];
        $suffix_image = substr($name_telpic,-3,3);

//        copy($WORK_DIR_NAME . $path_telpic, $WORK_DIR_UPLOAD . 'telpic' . '/' . $name_telpic);

        copy($WORK_DIR_NAME . $path_telpic, $path_image . '-400.' . $suffix_image);
        $exec_string = '/usr/bin/convert ' . $path_image . '-400.' . $suffix_image . ' -resize 50% ' . $path_image . '-200.' . $suffix_image;
        AddMessage2Log("exec_string = " . $exec_string, "PictureUpload");
        shell_exec($exec_string);
        //unlink($WORK_DIR_UPLOAD . 'telpic' . '/' . $name_telpic);
        symlink($path_image . '-200.' . $suffix_image, $WORK_DIR_UPLOAD . 'telpic' . '/' . $name_telpic);
        $dir_path_telpic = 'telpic' . '/';


        /**
         * ДобавлЯем картинку прототипа.
         */
        if ($THERE_IS_FIRST_UPLOAD == FALSE)
        {
            $arFilter = array('IBLOCK_ID' => $GLOBAL_IBLOCK_ID, 'UF_ARTICLE' => $temp_proto_items_article);
            $rsSections = CIBlockSection::GetList(array(), $arFilter);
            while ($arSection = $rsSections->Fetch())
            {
                $str_one = mb_strtoupper($arSection['SEARCHABLE_CONTENT']);
                $str_two = mb_strtoupper($temp_proto_items_name[0]);
                if (trim($str_one) == trim($str_two))
                {
                    $file = CFile::MakeFileArray($WORK_DIR_UPLOAD . $dir_path_telpic . $name_telpic);
                    //print_r("file = ".$file);
                    //echo nl2br("\r\n");
                    $tmpFile = Array(
                        "del" => "n",
                        "MODULE_ID" => "iblock");
                    $result_file = array_merge($file, $tmpFile);
                    $fid = SaveCustomFile($result_file, "/upload/catalog/", $dir_path_telpic);
                    /**
                     * SQL Query SET DETAIL_PICTURE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                     */
                    $DB->Query("UPDATE b_iblock_section SET PICTURE = " . $fid . " WHERE ID =" . $arSection["ID"], false, $err_mess . __LINE__);
                    AddMessage2Log("В разделе с ID = " . $arSection['ID'] . " добавление  картиники с ID = " . $fid . "!" . $temp_proto_items_article[0] . "!" . $name_telpic, "PictureUpload");
                }
            }
        }
        /**
         * ДобавлЯем данные о картинках в upload_xml только при первоначальной выгрузке, поскольку
         * ещё не к чему привЯзывать картинки. В случае сбоЯ данных лучше выставлЯть время
         * последней сихронизации равным нулю в соответствующих файлах xml, не удалЯЯ при этом
         * папки acupic и telpic. Также при формировании upload_xml создавать ЗначениЯСвойства,
         * в котором прописываются картинки только в случае FirstUpload.
         */
        if ($THERE_IS_FIRST_UPLOAD)
        {
            AddMessage2Log("Прописали в upload_xml пути к telpic ", "PictureUpload");
            $proto_items->БитриксКартинка = $path_telpic;
        }
    }
    $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);
    AddMessage2Log("Окончание загрузки telpic", "PictureUpload");
//$staticHtmlCache = \Bitrix\Main\Data\StaticHtmlCache::getInstance();
//$staticHtmlCache->deleteAll();
}
/**
 * Прописываем пути к картинкам аккумулЯторов в теге <Картинка> для главного изображениЯ и в теге <Значение> родительского тега <ЗначениЯСвойствa> с Ид=55.
 * В случае если THERE_IS_FIRST_UPLOAD равно TRUE скачиваем картинки в каталог и после прописываем пути.
 */
Zapusk2:
if ($Zapusk == 1)
{
	AddMessage2Log("Пропускаем работу с картинками аккумуляторов при первом проходе", "FirstUpload");
	goto Zapusk1;
}
else
{
	AddMessage2Log("Работаем с картанками аккумуляторов при втором проходе", "PictureUpload");
}
if ($xml_upload->xpath('//ПакетПредложений/Предложения/Предложение'))
{
    AddMessage2Log("Начало загрузки acupic", "PictureUpload");
    foreach ($xml_upload->xpath('//ПакетПредложений/Предложения/Предложение') as $offer_items)
    {
        /**
         * ОпределЯем артикул предложениЯ для поиска.
         */
        $temp_offer_items_article = $offer_items->ЗначенияСвойств->ЗначенияСвойства[8]->Значение;
        $temp_offer_items_article = (array)$temp_offer_items_article;
        if ($temp_offer_items_article[0] == NULL)
        {
            AddMessage2Log("ЗАПРОС с ПУСТЫМ АРТИКУЛОМ", "PictureUpload");
            continue;
        }
        else
        {
            AddMessage2Log($temp_offer_items_article[0], "PictureUpload");
        }
        $path_acupic_1 = GetCurlAcuPIC($temp_offer_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/batteryImageFile/' . $temp_offer_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'acupic/', '1');
        $path_acupic_2 = GetCurlAcuPIC($temp_offer_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/batteryImageFile/' . $temp_offer_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'acupic/', '2');
        $path_acupic_3 = GetCurlAcuPIC($temp_offer_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/batteryImageFile/' . $temp_offer_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'acupic/', '3');
        $path_acupic_4 = GetCurlAcuPIC($temp_offer_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/batteryImageFile/' . $temp_offer_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'acupic/', '4');
        $name_acupic_1 = basename($path_acupic_1);
        $name_acupic_2 = basename($path_acupic_2);
        $name_acupic_3 = basename($path_acupic_3);
        $name_acupic_4 = basename($path_acupic_4);
        chdir($WORK_DIR_UPLOAD);
        if (!is_dir($WORK_DIR_UPLOAD . 'acupic'))
        {
            mkdir('acupic');
        }
        chdir('acupic');
        if (!is_dir($WORK_DIR_UPLOAD . 'acupic' . $temp_offer_items_article[0]))
        {
            mkdir($temp_offer_items_article[0]);
        }
        chdir($temp_offer_items_article[0]);
        if (!file_exists($WORK_DIR_NAME . $path_acupic_1)) continue;
        if (!file_exists($WORK_DIR_NAME . $path_acupic_2)) continue;
        if (!file_exists($WORK_DIR_NAME . $path_acupic_3)) continue;
        if (!file_exists($WORK_DIR_NAME . $path_acupic_4)) continue;
        if (filesize($WORK_DIR_NAME . $path_acupic_1) < 1000) continue;
        if (filesize($WORK_DIR_NAME . $path_acupic_2) < 1000) continue;
        if (filesize($WORK_DIR_NAME . $path_acupic_3) < 1000) continue;
        if (filesize($WORK_DIR_NAME . $path_acupic_4) < 1000) continue;
        $temp_path_ap1 = $WORK_DIR_UPLOAD . 'acupic' . '/' . $temp_offer_items_article[0] . '/' . $name_acupic_1;
        $temp_path_ap2 = $WORK_DIR_UPLOAD . 'acupic' . '/' . $temp_offer_items_article[0] . '/' . $name_acupic_2;
        $temp_path_ap3 = $WORK_DIR_UPLOAD . 'acupic' . '/' . $temp_offer_items_article[0] . '/' . $name_acupic_3;
        $temp_path_ap4 = $WORK_DIR_UPLOAD . 'acupic' . '/' . $temp_offer_items_article[0] . '/' . $name_acupic_4;
        if (file_exists($temp_path_ap1))
        {
            if ( !file_exists($WORK_DIR_NAME . $path_acupic_1 . 'create') ) file_put_contents($WORK_DIR_NAME . $path_acupic_1 . 'create','');
            $temp_diff_time1 = abs (filemtime($temp_path_ap1) - filemtime($WORK_DIR_NAME . $path_acupic_1 . 'create'));
        }
        else
        {
            file_put_contents($WORK_DIR_NAME . $path_acupic_1 . 'create','');
            $temp_diff_time1 = 0;
        }
        if (file_exists($temp_path_ap2))
        {
            if ( !file_exists($WORK_DIR_NAME . $path_acupic_2 . 'create') ) file_put_contents($WORK_DIR_NAME . $path_acupic_2 . 'create','');
            $temp_diff_time2 = abs (filemtime($temp_path_ap2) - filemtime($WORK_DIR_NAME . $path_acupic_2 . 'create'));
        }
        else
        {
            file_put_contents($WORK_DIR_NAME . $path_acupic_2 . 'create','');
            $temp_diff_time2 = 0;
        }
        if (file_exists($temp_path_ap3))
        {
            if ( !file_exists($WORK_DIR_NAME . $path_acupic_3 . 'create') ) file_put_contents($WORK_DIR_NAME . $path_acupic_3 . 'create','');
            $temp_diff_time3 = abs (filemtime($temp_path_ap3) - filemtime($WORK_DIR_NAME . $path_acupic_3 . 'create'));
        }
        else
        {
            file_put_contents($WORK_DIR_NAME . $path_acupic_3 . 'create','');
            $temp_diff_time3 = 0;
        }
        if (file_exists($temp_path_ap4))
        {
            if ( !file_exists($WORK_DIR_NAME . $path_acupic_4 . 'create') ) file_put_contents($WORK_DIR_NAME . $path_acupic_4 . 'create','');
            $temp_diff_time4 = abs (filemtime($temp_path_ap4) - filemtime($WORK_DIR_NAME . $path_acupic_4 . 'create'));
        }
        else
        {
            file_put_contents($WORK_DIR_NAME . $path_acupic_4 . 'create','');
            $temp_diff_time4 = 0;
        }
        if ((md5_file($WORK_DIR_NAME . $path_acupic_1) == md5_file($temp_path_ap1)) and ($temp_diff_time1 > 7200))
            if ((md5_file($WORK_DIR_NAME . $path_acupic_2) == md5_file($temp_path_ap2)) and ($temp_diff_time2 > 7200))
                if ((md5_file($WORK_DIR_NAME . $path_acupic_3) == md5_file($temp_path_ap3)) and ($temp_diff_time3 > 7200))
                    if ((md5_file($WORK_DIR_NAME . $path_acupic_4) == md5_file($temp_path_ap4)) and ($temp_diff_time4 > 7200)) continue;
        /**
         * Сначала удалЯем все картинки из админки и таблицы b_file. В директории при этом ничего не должно
         * было удалЯтьсЯ по плану, но у разработчиков Битрикса на этот счёт своё мнение,
         * поэтому процесс удалениЯ пришлось перенести раньше загрузки, так как пути и названиЯ
         * файлов полностью совпадают.
         */
        if ($THERE_IS_FIRST_UPLOAD == FALSE)
        {
            $res_del_Elements = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $GLOBAL_IBLOCK_ID, "NAME" => $temp_offer_items_article), false);
            while ($arDelElement = $res_del_Elements->Fetch())
            {
                if (trim($arDelElement['SEARCHABLE_CONTENT']) == trim($temp_offer_items_article[0]))
                {
                    /**
                     * УдалЯем детальную картинку!
                     */
                    $arr_del_detail_picture = Array("DETAIL_PICTURE" => array("del" => "Y"));
                    $el = new CIBlockElement;
                    $res = $el->Update($arDelElement["ID"], $arr_del_detail_picture);
                    AddMessage2Log("В элементе с ID = " . $arDelElement["ID"] . " удаление детальной картиники", "PictureUpload");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $db_del_props = CIBlockElement::GetProperty($GLOBAL_IBLOCK_ID, $arDelElement["ID"], "sort", "asc", array());
                    $PROPS_del = array();
                    /**
                     * ЗаполнЯем в цикле массив PROPS длЯ данного элемента(количество итераций = количесво свойств элемента)
                     */
                    while ($ar_del_props = $db_del_props->Fetch())
                    {
                        /**
                         * THIS ALL MAGIC
                         */
                        $PROPS_del[$ar_del_props['CODE']] = $ar_del_props['VALUE'];
                        //print_r($ar_del_props['VALUE']);
                        //echo nl2br("\r\n");
                        if ($ar_del_props['CODE'] == 'PICTURES')
                        {
                            /**
                             * Если так удалЯть запись о картинке в таблице b_file и сам файл картинки с диска,
                             * в админке при этом остаются картинки с названием Unknown и выводЯтся
                             * их старые удалённые ID. Сброс кэша не помогает.
                             */
                            //CFile::Delete($ar_del_props["VALUE"]);
                            /**
                             * УдалЯем запись о картинке из таблицы b_file и админки, а на диске он остаётся!!!!!
                             * Сам файл на диске будем менять с помощью GetCurlAcuPIC() с тем же путём и именем.
                             */
                        }
                    }
                    //print_r($PROPS_del["PICTURES"]);
                    //echo nl2br("\r\n");
                    while (intval($PROPS_del["PICTURES"]) > 0)
                    {
                        $db_del_props = CIBlockElement::GetProperty($GLOBAL_IBLOCK_ID, $arDelElement["ID"], "sort", "asc", array());
                        $PROPS_del = array();
                        while ($ar_del_props = $db_del_props->Fetch())
                        {
                            /**
                             * THIS ALL MAGIC
                             */
                            $PROPS_del[$ar_del_props['CODE']] = $ar_del_props['VALUE'];
                            //print_r($ar_del_props['VALUE']);
                            //echo nl2br("\r\n");
                            if ($ar_del_props['CODE'] == 'PICTURES')
                            {
                                if (intval($ar_del_props["VALUE"]) > 0)
                                {
                                    //print_r($ar_del_props["VALUE"] );
                                    //echo nl2br("\r\n");
                                    $arr_del[$ar_del_props['PROPERTY_VALUE_ID']] = Array("VALUE" => Array("del" => "Y"));
                                    //print_r($arr);
                                    //echo nl2br("\r\n");
                                    CIBlockElement::SetPropertyValueCode($arDelElement["ID"], "PICTURES", $arr_del);
                                    AddMessage2Log("В элементе с ID = " . $arDelElement["ID"] . " удаление картиники с ID = " . $ar_del_props["VALUE"], "PictureUpload");
                                }
                            }
                        }
                    }


                    while (intval($PROPS_del["PREVIEW_PICTURES_1"]) > 0)
                    {
                        $db_del_props = CIBlockElement::GetProperty($GLOBAL_IBLOCK_ID, $arDelElement["ID"], "sort", "asc", array());
                        $PROPS_del = array();
                        while ($ar_del_props = $db_del_props->Fetch())
                        {
                            /**
                             * THIS ALL MAGIC
                             */
                            $PROPS_del[$ar_del_props['CODE']] = $ar_del_props['VALUE'];
                            //print_r($ar_del_props['VALUE']);
                            //echo nl2br("\r\n");
                            if ($ar_del_props['CODE'] == 'PREVIEW_PICTURES_1')
                            {
                                if (intval($ar_del_props["VALUE"]) > 0)
                                {
                                    //print_r($ar_del_props["VALUE"] );
                                    //echo nl2br("\r\n");
                                    $arr_del[$ar_del_props['PROPERTY_VALUE_ID']] = Array("VALUE" => Array("del" => "Y"));
                                    //print_r($arr);
                                    //echo nl2br("\r\n");
                                    CIBlockElement::SetPropertyValueCode($arDelElement["ID"], "PREVIEW_PICTURES_1", $arr_del);
                                    AddMessage2Log("В элементе с ID = " . $arDelElement["ID"] . " удаление картиники с ID = " . $ar_del_props["VALUE"], "PictureUpload");
                                }
                            }
                        }
                    }


                    while (intval($PROPS_del["PREVIEW_PICTURES_2"]) > 0)
                    {
                        $db_del_props = CIBlockElement::GetProperty($GLOBAL_IBLOCK_ID, $arDelElement["ID"], "sort", "asc", array());
                        $PROPS_del = array();
                        while ($ar_del_props = $db_del_props->Fetch())
                        {
                            /**
                             * THIS ALL MAGIC
                             */
                            $PROPS_del[$ar_del_props['CODE']] = $ar_del_props['VALUE'];
                            //print_r($ar_del_props['VALUE']);
                            //echo nl2br("\r\n");
                            if ($ar_del_props['CODE'] == 'PREVIEW_PICTURES_2')
                            {
                                if (intval($ar_del_props["VALUE"]) > 0)
                                {
                                    //print_r($ar_del_props["VALUE"] );
                                    //echo nl2br("\r\n");
                                    $arr_del[$ar_del_props['PROPERTY_VALUE_ID']] = Array("VALUE" => Array("del" => "Y"));
                                    //print_r($arr);
                                    //echo nl2br("\r\n");
                                    CIBlockElement::SetPropertyValueCode($arDelElement["ID"], "PREVIEW_PICTURES_2", $arr_del);
                                    AddMessage2Log("В элементе с ID = " . $arDelElement["ID"] . " удаление картиники с ID = " . $ar_del_props["VALUE"], "PictureUpload");
                                }
                            }
                        }
                    }


                }
            }
        }
        /**
         * ОпределЯем артикул предложениЯ для поиска.
         */
        $temp_offer_items_article = $offer_items->ЗначенияСвойств->ЗначенияСвойства[8]->Значение;
        $temp_offer_items_article = (array)$temp_offer_items_article;
        //print_r($temp_offer_items_article[0]);
        //echo nl2br("\r\n");
        /**
         * Качаем и сохранЯем ВРЕМЕННО в корне копонента. Старые файлы при обновлении заменЯются, а ВРЕМЕННЫЙ путь остаётся тем же самым.
         */
        $path_acupic_1 = GetCurlAcuPIC($temp_offer_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/batteryImageFile/' . $temp_offer_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'acupic/', '1');
        $path_acupic_2 = GetCurlAcuPIC($temp_offer_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/batteryImageFile/' . $temp_offer_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'acupic/', '2');
        $path_acupic_3 = GetCurlAcuPIC($temp_offer_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/batteryImageFile/' . $temp_offer_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'acupic/', '3');
        $path_acupic_4 = GetCurlAcuPIC($temp_offer_items_article[0], 'http://middle.craftmann.ru:8080/craftmiddle/ws/clientsinfo/batteryImageFile/' . $temp_offer_items_article[0], $LOGIN, $PWS, $WORK_DIR_NAME . 'acupic/', '4');
        //$path_acupic_1 = "C:/Bitrix/www/bitrix/components/es/PictureUpload/telpic/C1.01.001_1/C1.01.001_1.jpg";
        //$path_acupic_2 = "C:/Bitrix/www/bitrix/components/es/PictureUpload/telpic/C1.01.001_1/C1.01.001_1.jpg";
        //$path_acupic_3 = "C:/Bitrix/www/bitrix/components/es/PictureUpload/telpic/C1.01.001_1/C1.01.001_1.jpg";
        //$path_acupic_4 = "C:/Bitrix/www/bitrix/components/es/PictureUpload/telpic/C1.01.001_1/C1.01.001_1.jpg";
        $name_acupic_1 = basename($path_acupic_1);
        $name_acupic_2 = basename($path_acupic_2);
        $name_acupic_3 = basename($path_acupic_3);
        $name_acupic_4 = basename($path_acupic_4);
        chdir($WORK_DIR_UPLOAD);
        if (!is_dir($WORK_DIR_UPLOAD . 'acupic'))
        {
            mkdir('acupic');
        }
        chdir('acupic');
        if (!is_dir($WORK_DIR_UPLOAD . 'acupic' . $temp_offer_items_article[0]))
        {
            mkdir($temp_offer_items_article[0]);
        }
        chdir($temp_offer_items_article[0]);
        copy($WORK_DIR_NAME . $path_acupic_1, $WORK_DIR_UPLOAD . 'acupic' . '/' . $temp_offer_items_article[0] . '/' . $name_acupic_1);
        //print_r($WORK_DIR_NAME . $path_acupic_1);
        //echo nl2br("\r\n");
        //print_r($WORK_DIR_UPLOAD . 'acupic' . '/' . $temp_offer_items_article[0] . '/' . $name_acupic_1);
        //echo nl2br("\r\n");
        copy($WORK_DIR_NAME . $path_acupic_2, $WORK_DIR_UPLOAD . 'acupic' . '/' . $temp_offer_items_article[0] . '/' . $name_acupic_2);
        copy($WORK_DIR_NAME . $path_acupic_3, $WORK_DIR_UPLOAD . 'acupic' . '/' . $temp_offer_items_article[0] . '/' . $name_acupic_3);
        copy($WORK_DIR_NAME . $path_acupic_4, $WORK_DIR_UPLOAD . 'acupic' . '/' . $temp_offer_items_article[0] . '/' . $name_acupic_4);
        $dir_path_acupic_1 = 'acupic' . '/' . $temp_offer_items_article[0] . '/';
        $dir_path_acupic_2 = 'acupic' . '/' . $temp_offer_items_article[0] . '/';
        $dir_path_acupic_3 = 'acupic' . '/' . $temp_offer_items_article[0] . '/';
        $dir_path_acupic_4 = 'acupic' . '/' . $temp_offer_items_article[0] . '/';
        /**
         * Регистрируем картинки в таблице b_file с новым ID, добавлЯем свойство PICTURES и 4 картинки в него.
         */
        if ($THERE_IS_FIRST_UPLOAD == FALSE)
        {
            $res_Elements = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $GLOBAL_IBLOCK_ID, "NAME" => $temp_offer_items_article), false);
            while ($arElement = $res_Elements->Fetch())
            {
                if (trim($arElement['SEARCHABLE_CONTENT']) == trim($temp_offer_items_article[0]))
                {
                    /**
                     * ДобавлЯем детальную картинку.
                     */
                    $file = CFile::MakeFileArray($WORK_DIR_UPLOAD . $dir_path_acupic_1 . $name_acupic_1);
                    $tmpFile = Array(
                        "del" => "n",
                        "MODULE_ID" => "iblock");
                    $result_file = array_merge($file, $tmpFile);
                    $fid = SaveCustomFile($result_file, "/upload/catalog/", $dir_path_acupic_1);
                    /**
                     * SQL Query SET DETAIL_PICTURE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                     */
                    $DB->Query("UPDATE b_iblock_element SET DETAIL_PICTURE = " . $fid . " WHERE ID =" . $arElement["ID"], false, $err_mess . __LINE__);
                    AddMessage2Log("В элементе с ID = " . $arDelElement["ID"] . " добавление детальной картиники с ID = " . $fid, "PictureUpload");
                    //////////////////////////////////////////////////////////////////////////////////////////////////////
                    $db_props = CIBlockElement::GetProperty($GLOBAL_IBLOCK_ID, $arElement["ID"], "sort", "asc", array());
                    $PROPS = array();
                    /**
                     * ЗаполнЯем в цикле массив PROPS длЯ данного элемента(количество итераций = количесво свойств элемента)
                     */
                    while ($ar_props = $db_props->Fetch())
                    {
                        /**
                         * THIS ALL MAGIC
                         */
                        $PROPS[$ar_props['CODE']] = $ar_props['VALUE'];
                        //print_r($PROPS);
                        //echo nl2br("\r\n");
                        if ($ar_props['CODE'] == 'PICTURES')
                        {
                            //print_r("PICTURES");
                            //echo nl2br("\r\n");
                            /**
                             * Регистрируем картинку в таблице b_file с новым ID. Если разработчики CMS 1C-БИТРИКС не полностью глумные,
                             * то по достижении числа максимальной разрядности ID ничего плохого не
                             * должно произойти. Проверить это при тестировании.
                             */
                            //$file = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . '/upload/catalog/temp_folder/f6e73c653969169780559f0db3660c8e.jpg');
                            $file = CFile::MakeFileArray($WORK_DIR_UPLOAD . $dir_path_acupic_1 . $name_acupic_1);
                            //print_r($file);
                            //echo nl2br("\r\n");
                            $tmpFile = Array(
                                "del" => "n",
                                "MODULE_ID" => "iblock");
                            $result_file = array_merge($file, $tmpFile);
                            //print_r($result_file);
                            //echo nl2br("\r\n");
                            //second CustomPath is real Path, but first is need too
                            $fid = SaveCustomFile($result_file, "/upload/catalog/", $dir_path_acupic_1);
                            //print_r($dir_path_acupic_1);
                            //echo nl2br("\r\n");
                            $arrFile[] = $fid;
                            //second_picture
                            $file = CFile::MakeFileArray($WORK_DIR_UPLOAD . $dir_path_acupic_2 . $name_acupic_2);
                            $result_file = array_merge($file, $tmpFile);
                            $fid = SaveCustomFile($result_file, "/upload/catalog/", $dir_path_acupic_2);
                            $arrFile[] = $fid;
                            //third_picture
                            $file = CFile::MakeFileArray($WORK_DIR_UPLOAD . $dir_path_acupic_3 . $name_acupic_3);
                            $result_file = array_merge($file, $tmpFile);
                            $fid = SaveCustomFile($result_file, "/upload/catalog/", $dir_path_acupic_3);
                            $arrFile[] = $fid;
                            //fourth_picture
                            $file = CFile::MakeFileArray($WORK_DIR_UPLOAD . $dir_path_acupic_4 . $name_acupic_4);
                            $result_file = array_merge($file, $tmpFile);
                            $fid = SaveCustomFile($result_file, "/upload/catalog/", $dir_path_acupic_4);
                            $arrFile[] = $fid;
                        }
                    }
                    $PROPS["PICTURES"] = $arrFile;
                    CIBlockElement::SetPropertyValueCode($arElement["ID"], "PICTURES", $PROPS["PICTURES"]);
                    $PROPS["PREVIEW_PICTURES_1"] = $arrFile;
                    CIBlockElement::SetPropertyValueCode($arElement["ID"], "PREVIEW_PICTURES_1", $PROPS["PREVIEW_PICTURES_1"]);
                    $PROPS["PREVIEW_PICTURES_2"] = $arrFile;
                    CIBlockElement::SetPropertyValueCode($arElement["ID"], "PREVIEW_PICTURES_2", $PROPS["PREVIEW_PICTURES_2"]);
                    AddMessage2Log("В элементе с ID = " . $arElement["ID"] . " добавились картиники с ID = " . $arrFile[0] . " " . $arrFile[1] . " " . $arrFile[2] . " " . $arrFile[3], "PictureUpload");
                    $arrFile = array();

                    //print_r($PROPS["PICTURES"]);
                    //echo nl2br("\r\n");
                }
            }
        }
        /**
         * ДобавлЯем данные о картинках в upload_xml только при первоначальной выгрузке, поскольку
         * ещё не к чему привЯзывать картинки. В случае сбоЯ данных лучше выставлЯть время
         * последней сихронизации равным нулю в соответствующих файлах xml, не удалЯЯ при этом
         * папки acupic и telpic. Также при формировании upload_xml создавать ЗначениЯСвойства,
         * в котором прописываются картинки только в случае FirstUpload.
         */
        if ($THERE_IS_FIRST_UPLOAD)
        {
            //print_r("WAS_HERE");
            //echo nl2br("\r\n");
            $offer_items->Картинка = $path_acupic_1;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->Значение = $path_acupic_1;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства->Значение = $path_acupic_1;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->addChild('ЗначениеСвойства', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[1]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[1]->addChild('Описание', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->Значение[1] = $path_acupic_2;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[1]->Значение = $path_acupic_2;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->addChild('ЗначениеСвойства', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[2]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[2]->addChild('Описание', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->Значение[2] = $path_acupic_3;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[2]->Значение = $path_acupic_3;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->addChild('ЗначениеСвойства', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[3]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[3]->addChild('Описание', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->Значение[3] = $path_acupic_4;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[33]->ЗначениеСвойства[3]->Значение = $path_acupic_4;

            //$offer_items->Картинка = $path_acupic_1;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->Значение = $path_acupic_1;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства->Значение = $path_acupic_1;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->addChild('ЗначениеСвойства', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[1]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[1]->addChild('Описание', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->Значение[1] = $path_acupic_2;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[1]->Значение = $path_acupic_2;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->addChild('ЗначениеСвойства', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[2]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[2]->addChild('Описание', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->Значение[2] = $path_acupic_3;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[2]->Значение = $path_acupic_3;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->addChild('ЗначениеСвойства', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[3]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[3]->addChild('Описание', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->Значение[3] = $path_acupic_4;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[34]->ЗначениеСвойства[3]->Значение = $path_acupic_4;

            //$offer_items->Картинка = $path_acupic_1;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->Значение = $path_acupic_1;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства->Значение = $path_acupic_1;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->addChild('ЗначениеСвойства', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[1]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[1]->addChild('Описание', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->Значение[1] = $path_acupic_2;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[1]->Значение = $path_acupic_2;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->addChild('ЗначениеСвойства', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[2]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[2]->addChild('Описание', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->Значение[2] = $path_acupic_3;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[2]->Значение = $path_acupic_3;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->addChild('ЗначениеСвойства', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[3]->addChild('Значение', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[3]->addChild('Описание', '');
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->Значение[3] = $path_acupic_4;
            $offer_items->ЗначенияСвойств->ЗначенияСвойства[35]->ЗначениеСвойства[3]->Значение = $path_acupic_4;
            AddMessage2Log("Прописали пути к картинкам в xml, поскольку THERE_IS_FIRST_UPLOAD", "PictureUpload");
        }

    }
    $xml_upload->asXML($ABS_FILE_NAME_UPLOAD);
    AddMessage2Log("Окончание загрузки acupic", "PictureUpload");
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////END_OF_PICTURE_UPLOAD///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (is_dir($WORK_DIR_UPLOAD_CATALOG))
{
	AddMessage2Log("WORK_DIR_UPLOAD_CATALOG is not empty", "FirstUpload");
	removeDirectory($WORK_DIR_UPLOAD_CATALOG);
	AddMessage2Log("WORK_DIR_UPLOAD_CATALOG is cleared now", "FirstUpload");
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////upload///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Zapusk1:
if (($THERE_IS_NO_MATCH_OFFERS) || ($xml_offers->xpath('//dataWs')) || ($xml_prices->xpath('//dataWs')) || ($xml_instock->xpath('//dataWs')))
{
    AddMessage2Log("Начало загрузки на сайт", "FirstUpload");
    shell_exec("echo yes>/home/bitrix/www/bitrix/components/esfull/FirstUploadFull/sleep;sleep 60");
//This object will load file into database
    $obXMLFile = new CIBlockXMLFile;

    //тут мы задаем начальные параметры
    $NS = array(
        "STEP" => 0, //номер шага
        "IBLOCK_TYPE" => "catalog", //тип инфоблока
        "LID" => "s1", //сайт
        "URL_DATA_FILE" => $ABS_FILE_NAME_UPLOAD, //файл импорта
        "ACTION" => "A", //действие по умолчанию для элементов или секций которые отсутствуют в xml
        "PREVIEW" => "N", //не создавать превьюшки из картинок
    );

    //print_r($NS);
    //echo nl2br("\r\n");


    while ($NS["STEP"] < 8)
    {
        if (check_bitrix_sessid())
        {
            //print_r('check_bitrix_sessid');
            //echo nl2br("\r\n");
            //print_r('');
            //echo nl2br("\r\n");
            $arErrors[] = GetMessage("IBLOCK_CML2_ACCESS_DENIED");
        } elseif ($ABS_FILE_NAME_UPLOAD)
        {
            if ($NS["STEP"] < 1)
            {
                //print_r('STEP 1');
                //echo nl2br("\r\n");
                //This will save mapping for ID to XML_ID translation
                $_SESSION["BX_CML2_IMPORT"] = array(
                    "SECTION_MAP" => false,
                    "PRICES_MAP" => false,
                );
                CIBlockXMLFile::DropTemporaryTables();
                if (CIBlockCMLImport::CheckIfFileIsCML($ABS_FILE_NAME_UPLOAD))
                {
                    //print_r('STEP_1 if');
                    //echo nl2br("\r\n");
                    // print_r($NS["STEP"]);
                    // echo nl2br("\r\n");
                    $NS["STEP"]++;
                    //print_r($NS["STEP"]);
                    //echo nl2br("\r\n");
                } else
                {
                    //print_r('STEP 1_else');
                    //echo nl2br("\r\n");
                    $arErrors[] = GetMessage("IBLOCK_CML2_WRONG_FILE_ERROR");
                }
            } elseif ($NS["STEP"] < 2)
            {
                //print_r('STEP 2');
                //echo nl2br("\r\n");
                if (CIBlockXMLFile::CreateTemporaryTables())
                    $NS["STEP"]++;
                else
                    $arErrors[] = GetMessage("IBLOCK_CML2_TABLE_CREATE_ERROR");
            } elseif ($NS["STEP"] < 3)
            {
                //print_r('STEP 3');
                //echo nl2br("\r\n");
                //if (file_exists($ABS_FILE_NAME_UPLOAD) && is_file($ABS_FILE_NAME_UPLOAD) && ($fp = fopen($ABS_FILE_NAME_UPLOAD, "rb")))
                if (file_exists($ABS_FILE_NAME_UPLOAD) && ($fp = fopen($ABS_FILE_NAME_UPLOAD, "rb")))
                {
                    if ($obXMLFile->ReadXMLToDatabase($fp, $NS, 10))
                        $NS["STEP"]++;
                    fclose($fp);
                } else
                {
                    $arErrors[] = GetMessage("IBLOCK_CML2_FILE_ERROR");
                }
            } elseif ($NS["STEP"] < 4)
            {
                //print_r('STEP 4');
                //echo nl2br("\r\n");
                if (CIBlockXMLFile::IndexTemporaryTables())
                    $NS["STEP"]++;
                else
                    $arErrors[] = GetMessage("IBLOCK_CML2_INDEX_ERROR");
            } elseif ($NS["STEP"] < 5)
            {
                //print_r('STEP 5');
                //echo nl2br("\r\n");
                $obCatalog = new CIBlockCMLImport;
                $obCatalog->Init($NS, $WORK_DIR_NAME, true, $NS["PREVIEW"], false, true);
                $result = $obCatalog->ImportMetaData(array(1, 2), $NS["IBLOCK_TYPE"], $NS["LID"]);
                if ($result === true)
                {
                    //print_r('STEP 5 result of ImportMetaData is true');
                    //echo nl2br("\r\n");

                    $result = $obCatalog->ImportSections();
                    if ($result === true)
                    {
                        //print_r('STEP 5 result of ImportSections is true');
                        //echo nl2br("\r\n");
                        //$obCatalog->DeactivateSections("A");
                    }
				}
                if ($result === true)
                    $NS["STEP"]++;
                else
                    $arErrors[] = $result;
            } elseif ($NS["STEP"] < 6)
            {
                //print_r('STEP 6');
                //echo nl2br("\r\n");
                if (($NS["DONE"]["ALL"] <= 0) && $NS["XML_ELEMENTS_PARENT"])
                {
                    $rs = $DB->Query("select count(*) C from b_xml_tree where PARENT_ID = " . intval($NS["XML_ELEMENTS_PARENT"]));
                    $ar = $rs->Fetch();
                    $NS["DONE"]["ALL"] = $ar["C"];
                }
                $obCatalog = new CIBlockCMLImport;
                $obCatalog->Init($NS, $WORK_DIR_NAME, true, $NS["PREVIEW"], false, true);
                $obCatalog->ReadCatalogData($_SESSION["BX_CML2_IMPORT"]["SECTION_MAP"], $_SESSION["BX_CML2_IMPORT"]["PRICES_MAP"]);
                $result = $obCatalog->ImportElements($start_time, $INTERVAL);
                $counter = 0;
                foreach ($result as $key => $value)
                {
                    $NS["DONE"][$key] += $value;
                    $counter += $value;
                }
                if (!$counter)
                    $NS["STEP"]++;
            } elseif ($NS["STEP"] < 7)
            {
                //print_r('STEP 7');
                //echo nl2br("\r\n");
                //$obCatalog = new CIBlockCMLImport;
                //$obCatalog->Init($NS, $WORK_DIR_NAME, true, $NS["PREVIEW"], false, true);
                //$result = $obCatalog->DeactivateElement($NS["ACTION"], $start_time, $INTERVAL);
                //$counter = 0;
                //foreach ($result as $key => $value)
                //{
                //$NS["DONE"][$key] += $value;
                //$counter += $value;
                //}
                //if (!$counter)
                $NS["STEP"]++;
            } elseif ($NS["STEP"] < 8)
            {
                //print_r('STEP 8');
                //echo nl2br("\r\n");
                $obCatalog = new CIBlockCMLImport;
                $obCatalog->Init($NS, $WORK_DIR_NAME, true, $NS["PREVIEW"], false, true);
                $result = $obCatalog->ImportProductSets();
                $NS["STEP"]++;
            }
        } else
        {
            print_r('ERROR');
            echo nl2br("\r\n");
            $arErrors[] = GetMessage("IBLOCK_CML2_FILE_ERROR");
        }
    }

    shell_exec("echo no>/home/bitrix/www/bitrix/components/esfull/FirstUploadFull/sleep");
    // очищаем кэш
    $obCache = new CPHPCache();
    $obCache->CleanDir();
    AddMessage2Log("Окончание загрузки на сайт", "FirstUpload");
if ($Zapusk == 1)
{
	gc_collect_cycles();
	$Zapusk = 2;
	//$Zapusk = ++$Zapusk;
	AddMessage2Log("Засчитали первый проход", "FirstUpload");
	goto Zapusk2;
}
} else
{
    AddMessage2Log("загрузка на сайт НЕ П� ОИЗВОДИЛАСЬ", "FirstUpload");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////end of upload////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
die();
?>
