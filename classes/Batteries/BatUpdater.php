<?php 
/**
*-------------------------------------------------------------------------------
* BatUpdater Class
*-------------------------------------------------------------------------------
* This is a class for curl requests execution.
* @package  BatteriesNS 
* @author   mixxxxx 
* @link     top-secret
*/

namespace BatteriesNS;

$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once(__DIR__.'/BatGetterSite.php');
require_once(__DIR__.'/../SimpleXML/BatGetterXML.php');
use SimpleXMLNS\BatGetterXML as BatGetterXML;
//require_once(__DIR__.'/../SimpleXML/CompatibilityGetterXML.php');
//use SimpleXMLNS\CompatibilityGetterXML as CompatibilityGetterXML;
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");




interface BatUpdaterInterface
{
		public function updateAllBatteriesByArticlesDiff();
		public function updateOldBattery($OneBatArrayFromSite, $curBatArticle);
		public function setNewBattery($curBatArticle);    
}

abstract class AbstractBatUpdater implements BatUpdaterInterface
{
		protected $config;
		protected $diff_array_of_articles;
		protected $xml_offers;

		public function __construct($Config, $allBatteriesByArticlesDiff, $xml_offers)
		{
				 $this->config = $Config;
				 $this->diff_array_of_articles = $allBatteriesByArticlesDiff;
				 $this->xml_offers = $xml_offers;
		}
}

class BatUpdater extends AbstractBatUpdater
{

		public function updateAllBatteriesByArticlesDiff()
		{   
				$batGetterSite = new BatGetterSite($this->config);        
				foreach($this->diff_array_of_articles as $curBatArticle)
				{  
						if (($curBatArticle !== NULL) || $curBatArticle !== '')
						{      
							$OneBatArrayFromSite = $batGetterSite->getBatByArticle($curBatArticle);
							// print_r("OneBatArrayFromSite is: ");
							// echo nl2br("\r\n");
							// print_r($OneBatArrayFromSite);
							// echo nl2br("\r\n");
							// foreach($OneBatArrayFromSite[0] as $key => $value)
							// {
							//     print_r("$key: " . $value);
							//     echo nl2br("\r\n");
							// }
							
							if ($OneBatArrayFromSite!==NULL)
							{
									//res is TRUE or FALSE
									$res = $this->updateOldBattery($OneBatArrayFromSite, $curBatArticle);
									break;
							}
							else
							{  
									//print_r("setNewBattery");
									//echo nl2br("\r\n");         
									//$res = $this->setNewBattery($curBatArticle);   
							}
						}
				}
		}

		public function updateOldBattery($OneBatArrayFromSite, $curProtoArticle)
		{
				print_r("BEFORE UPDATING");
				echo nl2br("\r\n");
				foreach($OneBatArrayFromSite[0] as $key => $value)
				{
				    print_r("$key: " . $value);
				    echo nl2br("\r\n");
				}

				$batGetterSite = new BatGetterSite($this->config); 
				/////////////////////////////////////////////////////////////////////////////////////////////
				$batGetterXML = new BatGetterXML($this->config, $this->xml_offers);
				$OneBatArrayFromXML= $batGetterXML->getBatByArticle($curProtoArticle);

			


				$be = \CIBlockElement::GetList(array(), array("=ARTICLE"=>$curProtoArticle), false, false, array("ID", "IBLOCK_ID", "ARTICLE", "EAN_13", "DETAIL_TEXT", "CAPACITY", "COMPLECT", "GROUPS_ARTICLE", "DISCONTINUED", "COMPATIBLE_MODEL", "ORIGINAL_CODE", "POWER", "TYPE", "VOLTAGE"));

				if ($be_arr = $be->Fetch())
				{
				 $ELEMENT_ID = $be_arr["ID"];
				 $IBLOCK_ID = $be_arr["IBLOCK_ID"];
				 //ARTICLE get from SITE
				 $prop['ARTICLE'] = $OneProtoArrayFromSite[0]['ARTICLE'];
				 $prop['EAN_13'] = $OneBatArrayFromXML[0]['EAN_13'];
				 $prop['DETAIL_TEXT'] = $OneBatArrayFromXML[0]['DETAIL_TEXT'];
				 $prop['CAPACITY'] = $OneBatArrayFromXML[0]['CAPACITY'];
				 $prop['COMPLECT'] = $OneBatArrayFromXML[0]['COMPLECT'];
				 $prop['GROUPS_ARTICLE'] = $OneBatArrayFromXML[0]['GROUPS_ARTICLE'];
				 $prop['DISCONTINUED'] = $OneBatArrayFromXML[0]['DISCONTINUED'];
				 $prop['COMPATIBLE_MODEL'] = $OneBatArrayFromXML[0]['COMPATIBLE_MODEL'];
				 $prop['ORIGINAL_CODE'] = $OneBatArrayFromXML[0]['ORIGINAL_CODE'];
				 $prop['POWER'] = $OneBatArrayFromXML[0]['POWER'];
				 $prop['TYPE'] = $OneBatArrayFromXML[0]['TYPE'];
				 $prop['VOLTAGE'] = $OneBatArrayFromXML[0]['VOLTAGE'];
				 \CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, $IBLOCK_ID, $prop);
				}

				//CIBlockElement::SetPropertyValuesEx always returns NULL
				$res = TRUE;
				//////////////////////////////////////////////////////////////////////////////////////////////
				$OneBatArrayFromSite = $batGetterSite->getBatByArticle($curBatArticle);
				print_r("AFTER UPDATING");
				echo nl2br("\r\n");
				foreach($OneBatArrayFromSite[0] as $key => $value)
				{
				    print_r("$key: " . $value);
				    echo nl2br("\r\n");
				}

				return $res;
				
		}




		public function setNewBattery($curProtoArticle)
		{
				$protoGetterXML = new ProtoGetterXML($this->config, $this->xml_prototypes);
				$OneProtoArrayFromXML= $protoGetterXML->getProtoByArticle($curProtoArticle);


				$bitrix_code =  $OneProtoArrayFromXML["UF_MODEL"];
				$bitrix_code = mb_strtolower($bitrix_code);
				$bitrix_code = str_replace(' ', '_', $bitrix_code);
				$bitrix_code = str_replace('.', '_', $bitrix_code); 

				$model = 'Аккумулятор для '.$OneProtoArrayFromXML["UF_MODEL"].'';
				$model_win1251 = iconv("utf-8", "windows-1251", $model);


				$compatibilityGetterXML = new CompatibilityGetterXML($this->config, $this->xml_compatibility);
				$CompatibilityStringFromXML = $compatibilityGetterXML->getCompatibilityByArticle($curProtoArticle);


				if (empty($CompatibilityStringFromXML) || ($CompatibilityStringFromXML==NULL)) 
				{
						$ACTIVE = "N";
						//print_r("CompatibilityStringFromXML is empty" . $CompatibilityStringFromXML);
						//echo nl2br("\r\n");
						
				}else
				{
						$ACTIVE = "Y";
						//print_r("CompatibilityStringFromXML is NOT empty" . $CompatibilityStringFromXML);
						//echo nl2br("\r\n");            
				}


				$IBLOCK_SECTION_ID = NULL;
				$protoGetterSite = new ProtoGetterSite($this->config);
				//In this case NAME in FirstDepthLevel == UF_PRODUCER from OneProtoArrayFromXML
				$OneProtoArrayFirstDepthLevel = $protoGetterSite->getProtoFirstDepthLevelByName($OneProtoArrayFromXML["UF_PRODUCER"]);

				if ($OneProtoArrayFirstDepthLevel[0]["ID"] > 0 )
				{
 
						$IBLOCK_SECTION_ID = $OneProtoArrayFirstDepthLevel[0]["ID"];
				}
				else
				{
						//There are not existed FirstDepthLevelProto, which equal with OneProtoArrayFromXML["UF_PRODUCER"]
						//In this case we just go away this func and return NULL
						//print_r("In this case we just go away from this func and return NULL" . $IBLOCK_SECTION_ID);
						//echo nl2br("\r\n");
						$IBLOCK_SECTION_ID = NULL;
						return NULL;
				}

		 
				$bs = new \CIBlockSection;

				$arFields = Array(
					//XML
					"UF_ARTICLE" => $OneProtoArrayFromXML["UF_ARTICLE"],
					//Define in this method 
					"ACTIVE" => $ACTIVE,
					//In this place we set OneProtoArrayFirstDepthLevel[0]["ID"]
					"IBLOCK_SECTION_ID" => $OneProtoArrayFirstDepthLevel[0]["ID"],////////!!!!!!!!!!!!!
					//Config
					"IBLOCK_ID" => $this->config->IBLOCK_ID,
					//XML
					"NAME" => $OneProtoArrayFromXML["NAME"],
					//Just temp phrase
					"UF_DESCRIPTION" => "test description",
					//Defaul 500
					"SORT" => 500,
					//Define in this method
					"CODE" => $bitrix_code,
					//EMPTY FIELD when new
					"PICTURE" => "",
					//XML
					"UF_DEVTYPE" => $OneProtoArrayFromXML["UF_DEVTYPE"],
					//XML
					"UF_PRDDATE" => $OneProtoArrayFromXML["UF_PRDDATE"],
					//XML
					"UF_BATTERYTYPE" => $OneProtoArrayFromXML["UF_BATTERYTYPE"],
					//Define in this method         
					"UF_MODEL" => $model_win1251,     
					//XML
					"UF_PRODUCER" => $OneProtoArrayFromXML["UF_PRODUCER"],
					//XML
					"UF_COMPATIBILITYLIST" => $CompatibilityStringFromXML
					);

			 
				$ID = $bs->Add($arFields);
				$res = ($ID>0);
				if($res)
				{
						//NEED add this string to Message
						print_r("new ProtoSection " .$OneProtoArrayFromXML["NAME"]. " was added with ID = " . $ID);  
						//return TRUE or FALSE  

				}
							
				return $res;



			 
		}





}




?>