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
require_once(__DIR__.'/../Prototypes/ProtoGetterSite.php');
use PrototypesNS\ProtoGetterSite as ProtoGetterSite;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once(__DIR__.'/BatGetterSite.php');
require_once(__DIR__.'/../SimpleXML/BatGetterXML.php');
use SimpleXMLNS\BatGetterXML as BatGetterXML;
//require_once(__DIR__.'/../SimpleXML/CompatibilityGetterXML.php');
//use SimpleXMLNS\CompatibilityGetterXML as CompatibilityGetterXML;
use Bitrix;
use Bitrix\Main\Loader;
Loader::includeModule("iblock");
Loader::includeModule("catalog");




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

		public function __construct($Config, $allBatteriesByArticlesDiff, $xml_offers, $xml_prices, $xml_instock)
		{
				 $this->config = $Config;
				 $this->diff_array_of_articles = $allBatteriesByArticlesDiff;
				 $this->xml_offers = $xml_offers;
				 $this->xml_prices = $xml_prices;
         $this->xml_instock = $xml_instock;
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
							
							// print_r("print from updateAllBatteriesByArticlesDiff: ");
							// echo nl2br("\r\n");
					  //   print_r("curBatArticle: " . $curBatArticle);
					  //   echo nl2br("\r\n");
							

							$OneBatArrayFromSite = $batGetterSite->getBatByArticle($curBatArticle);
							// print_r("OneBatArrayFromSite is: ");
							// echo nl2br("\r\n");
							// print_r($OneBatArrayFromSite);
							// echo nl2br("\r\n");


							// foreach($OneBatArrayFromSite[0] as $key => $value)
							// {
							// 		print_r("print from updateAllBatteriesByArticlesDiff: ");
							// 		echo nl2br("\r\n");
							//     print_r("$key: " . $value);
							//     echo nl2br("\r\n");
							// }
							
							if ($OneBatArrayFromSite!==NULL)
							{
									//res is TRUE or FALSE
									$res = $this->updateOldBattery($OneBatArrayFromSite, $curBatArticle);
									//break;
							}
							else
							{  
									//print_r("setNewBattery");
									//echo nl2br("\r\n");         
									$res = $this->setNewBattery($curBatArticle);   
							}
						}
				}
		}

		public function updateOldBattery($OneBatArrayFromSite, $curBatArticle)
		{
				
				$batGetterXML = new BatGetterXML($this->config, $this->xml_offers, $this->xml_prices, $this->xml_instock);
				$OneBatArrayFromXML= $batGetterXML->getBatByArticle($curBatArticle);

			
				 $ELEMENT_ID = $OneBatArrayFromSite[0]['ID'];
				 $IBLOCK_ID = $this->config->IBLOCK_ID;
				 //ARTICLE get from SITE
				 $prop = array();
				 $prop['ARTICLE'] = $OneBatArrayFromSite[0]['ARTICLE'];
				 $prop['EAN_13'] = $OneBatArrayFromXML['EAN_13'];
				 $prop['DETAIL_TEXT'] = $OneBatArrayFromXML['DETAIL_TEXT'];
				 $prop['CAPACITY'] = $OneBatArrayFromXML['CAPACITY'];
				 $prop['COMPLECT'] = $OneBatArrayFromXML['COMPLECT'];
				 $prop['GROUPS_ARTICLE'] = $OneBatArrayFromXML['GROUPS_ARTICLE'];
				 $prop['DISCONTINUED'] = $OneBatArrayFromXML['DISCONTINUED'];
				 $prop['COMPATIBLE_MODEL'] = $OneBatArrayFromXML['COMPATIBLE_MODEL'];
				 $prop['ORIGINAL_CODE'] = $OneBatArrayFromXML['ORIGINAL_CODE'];
				 $prop['POWER'] = $OneBatArrayFromXML['POWER'];
				 $prop['TYPE'] = $OneBatArrayFromXML['TYPE'];
				 $prop['VOLTAGE'] = $OneBatArrayFromXML['VOLTAGE'];
				 if ($OneBatArrayFromXML['PRICE'] !== NULL)
				 {
				 		$prop['PRICE'] = $OneBatArrayFromXML['PRICE'];
				 		//$prop['PRICE'] = 665;
				 		//$arFields_price = Array('PRICE' => IntVal($prop['PRICE']));
				 		$arFields_price = Array('PRICE' => $prop['PRICE']);

				 		// print("Price from Site is: " . $OneBatArrayFromSite[0]['PRICE']);
      			// echo nl2br("\r\n");

						$res_price = \CPrice::GetList( array(), array("PRODUCT_ID" => $ELEMENT_ID));

						if ($arr_price = $res_price->Fetch())
						{
								// print("arr_price_is: " . $arr_price);
      					// echo nl2br("\r\n");
      	
      					// foreach ($arr_price as $key => $value)
      					// {
      					// 	print("arr_price_item $key is: " . $value);
      					// 	echo nl2br("\r\n");

      					// }
						    \CPrice::Update($arr_price["ID"], $arFields_price);
						}	 		
				 }
				 if ($OneBatArrayFromXML['STORE'] !== NULL)
				 {
				 		$prop['STORE'] = $OneBatArrayFromXML['STORE'];

				 		$temp_string ="в наличии";
		       	$temp_string = iconv("utf-8", "windows-1251", $temp_string);
						if ($OneBatArrayFromXML['STORE'] == $temp_string)
		        {
		            $quantity_of_batteries = 1000;
		        } else
		        {
		            $quantity_of_batteries = 0;
		        }
	
		        $arFields = array('QUANTITY' => IntVal($quantity_of_batteries));
						\CCatalogProduct::Update($ELEMENT_ID, $arFields);
				 }

				 print_r("prop: ");
				 echo nl2br("\r\n");
				 print_r("ELEMENT_ID: " . $ELEMENT_ID);
				 echo nl2br("\r\n");
				 print_r("IBLOCK_ID: " . $IBLOCK_ID);
				 echo nl2br("\r\n");
				 foreach($prop as $key => $value)
				 {
					  print_r("$key: " . $value);
					  echo nl2br("\r\n");
				 }
				 \CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, $IBLOCK_ID, $prop);
	

				//CIBlockElement::SetPropertyValuesEx always returns NULL
				$res = TRUE;
				return $res;
				
		}




		public function setNewBattery($curBatArticle)
		{

			$batGetterXML = new BatGetterXML($this->config, $this->xml_offers, $this->xml_prices, $this->xml_instock);
			$OneBatArrayFromXML= $batGetterXML->getBatByArticle($curBatArticle);

			$IBLOCK_ID = $this->config->IBLOCK_ID;

			$el = new \CIBlockElement;

			$PROP = array();
			print("PROP is: " . $PROP);
			foreach($OneBatArrayFromXML as $key => $value)
			{
				  print_r("$key: " . $value);
				  echo nl2br("\r\n");
				 	if ($key == 'PRICE')
				 	{
				 		if($value !==NULL)
				 		{
				 			$PROP[$key] = $value;
				 		}
				 		else
				 		{
				 			continue;
				 		}	
				 	}
				 	if ($key == 'STORE')
				 	{
				 		if($value !==NULL)
				 		{
				 			$PROP[$key] = $value;
				 		}
				 		else
				 		{
				 			continue;
				 		}	
				 	}

				 	$PROP[$key] = $value;
			}

			$GROUPS_ARTICLE_ARRAY = array();
			$pieces = explode("; ", $PROP['GROUPS_ARTICLE']);
      foreach($pieces as $piece)
      {
          $GROUPS_ARTICLE_ARRAY[] = $piece;
      }

      $IBLOCK_SECTION_ID_ARRAY = array();
      $protoGetterSite = new ProtoGetterSite($this->config);
      foreach($GROUPS_ARTICLE_ARRAY as $ProtoArticle)
      {
      	$OneProtoArrayFromSite = $protoGetterSite->getProtoByArticle($ProtoArticle);
      	$IBLOCK_SECTION_ID_ARRAY[] = $OneProtoArrayFromSite[0]['ID'];
      }

      // print("IBLOCK_SECTION_ID_ARRAY is: " . $IBLOCK_SECTION_ID_ARRAY);
      // echo nl2br("\r\n");

      foreach($IBLOCK_SECTION_ID_ARRAY as $item)
      {
      	print("item is: " . $item);
      	echo nl2br("\r\n");
      }


			$arLoadProductArray = Array(
			  "IBLOCK_SECTION" => $IBLOCK_SECTION_ID_ARRAY,
			  "IBLOCK_ID"      => $IBLOCK_ID,
			  "PROPERTY_VALUES"=> $PROP,
			  "NAME"           => $PROP['ARTICLE'],
			  "ACTIVE"         => "Y",
			  "SORT"         	 => $OneBatArrayFromXML['SORT']
			  );

			if($PRODUCT_ID = $el->Add($arLoadProductArray))
			{
				$res = TRUE;
				echo "was added Battery element with New ID: ".$PRODUCT_ID;
				echo nl2br("\r\n");

				print("OneBatArrayFromXML['STORE'] is: " . $OneBatArrayFromXML['STORE']);
       	echo nl2br("\r\n");
       	$temp_string ="в наличии";
       	$temp_string = iconv("utf-8", "windows-1251", $temp_string);
				if ($OneBatArrayFromXML['STORE'] == $temp_string)
        {
            $quantity_of_batteries = 1000;
        } else
        {
            $quantity_of_batteries = 0;
        }
        print("quantity_of_batteries is: " . $quantity_of_batteries);
       	echo nl2br("\r\n");
        $arFields = array('QUANTITY' => IntVal($quantity_of_batteries));
				\CCatalogProduct::Update($PRODUCT_ID, $arFields);

			}			  
			else
			{
				$res = FALSE;
				echo "Error in adding new Battery element: ".$el->LAST_ERROR;
				echo nl2br("\r\n");
			}
			  				
							
			return $res;



			 
		}





}




?>