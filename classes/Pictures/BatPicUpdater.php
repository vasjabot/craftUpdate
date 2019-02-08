<?
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
?>