<?php
/**
 * 请求D_FlightSearch的服务（列表查询）
 */
class get_D_FlightSearch{
	/**
	 * @var 航程类型：string类型；必填；S（单程）D（往返程）M（联程）
	 */
	var $SearchType="";
	/**
	 * @var 航程列表
	 */
	var $Routes="";
	/**
	 * @var 出发城市：目前仅支持城市三字码 如北京：BJS,上海：SHA
	 */
	var $DepartCity="";
	/**
	 * @var 到达城市：目前仅支持城市三字码 如北京：BJS,上海：SHA
	 */
	var $ArriveCity="";
	/**
	 *@var 出发日期：yyyy-MM-dd （或yyyy-MM-ddThh:mm:ss）格式日期
	 */
	var $DepartDate="";
	var $ArriveDate="";
	/**
	 * @var 航空公司二字码
	 */
	var $AirlineDibitCode="";
	/**
	 * @var 出发机场三字码 上海：SHA 或 PVG
	 */
	var $DepartPort="";
	/**
	 *@var 到达机场三字码 北京：PEK 或 NAY 
	 */
	var $ArrivePort="";
	/**
	 * @var 最早起飞时间 2013-05-20T08:00:00
	 */
	var $EarliestDepartTime="";
	/**
	 * @var 最晚起飞时间 2013-05-20T12:00:00
	 */
	var $LatestDepartTime="";
	/**
	 *@var 送票城市：string类型；可空；缺省默认出发城市
	 */
	var $SendTicketCity="";
	/**
	 *	以下请求选项会减少响应数据，并且增加开销，响应时间会有所增加
	 */
	/**
	 * @var 返回简单响应（历史版本使用过，非常规请求项）
	 */
	var $IsSimpleResponse="";
	/**
	 *@var 是否只返回每个航班最低价记录
	 */
	var $IsLowestPrice="";
	/**
	 *@var 产品价格类型筛选选项 NormalPrice：普通政策，SingleTripPrice: 提前预售特价
	 */
	var $LatestDepartTimeOptions="";
	/**
	 *@var 产品类型筛选选项 Normal：普通，YoungMan:青年特价，OldMan:老年特价
	 */
	var $ProductTypeOptions="Normal";
	/**
	 *
	 *@var Y 经济舱C公务舱 F头等舱
	 */
	var $Classgrade="";
	/**
	 *
	 * @var 响应排序方式 DepartTime/TakeOffTime：起飞时间排序（舱位按价格次之），Price:按价格排序（时间次之），Rate:折扣优先（时间次之）,Direction: 低价单一排序
	 */
	var $OrderBy="Price";
	/**
	 *
	 * @var 响应排序方向 ASC:升序，Desc:降序
	 * @var string
	 */
	var $Direction="ASC";
	/**
	 *@var返回体
	 */
	var $ResponseXML="";

	/**
	 *@var 构造请求体
	 */
	private  function getRequestXML()
	{
		/*
		 * 从config.php中获取系统的联盟信息(只读)
		 */
		$AllianceID=Allianceid;
		$SID=Sid;
		$KEYS=SiteKey;
		$RequestType="OTA_FlightSearch_Url";
		//构造权限头部
		$headerRight=getRightString($AllianceID,$SID,$KEYS,$RequestType);
//		echo $headerRight;
		$SearchType="";
		if($this->SearchType!=""){
			$SearchType=<<<BEGIN
<SearchType>$this->SearchType</SearchType>
BEGIN;
		}
		//构造航程列表
		$DepartCity="";
		if($this->DepartCity!=""){
			$DepartCity=<<<BEGIN
<DepartCity>$this->DepartCity</DepartCity>
BEGIN;
		}
		$ArriveCity="";
		if($this->ArriveCity!=""){
			$ArriveCity=<<<BEGIN
<ArriveCity>$this->ArriveCity</ArriveCity>
BEGIN;
		}
		$DepartDate="";
		if($this->DepartDate!=""){
			$DepartDate=<<<BEGIN
<DepartDate>$this->DepartDate</DepartDate>
BEGIN;
		}

		$AirlineDibitCode="";
		if($this->AirlineDibitCode!="")
		{
			$AirlineDibitCode=<<<BEGIN
<AirlineDibitCode>$this->AirlineDibitCode</AirlineDibitCode>
BEGIN;
		}
		$DepartPort="";
		if($this->DepartPort!=""){
			$DepartPort=<<<BEGIN
<DepartPort>$this->DepartPort</DepartPort>
BEGIN;
		}
		$ArrivePort="";
		if($this->ArrivePort!=""){
			$ArrivePort=<<<BEGIN
<ArrivePort>$this->ArrivePort</ArrivePort>
BEGIN;
		}
		$EaliestDepartTime="";
		if($this->EaliestDepartTime!=""){
			$EaliestDepartTime=<<<BEGIN
<EaliestDepartTime>$this->EaliestDepartTime</EaliestDepartTime>
BEGIN;
		}
		$LatestDepartTime="";
		if($this->LatestDepartTime!=""){
			$LatestDepartTime=<<<BEGIN
<LatestDepartTime>$this->LatestDepartTime</LatestDepartTime>
BEGIN;
		}

        if($this->SearchType=='D'){
        $ArriveCity1="";
        if($this->DepartCity!=""){
            $ArriveCity1=<<<BEGIN
<ArriveCity>$this->DepartCity</ArriveCity>
BEGIN;
        }
        $DepartCity1="";
        if($this->ArriveCity!=""){
            $DepartCity1=<<<BEGIN
<DepartCity>$this->ArriveCity</DepartCity>
BEGIN;
        }
        $DepartDate1="";
        if($this->ArriveDate!=""){
            $DepartDate1=<<<BEGIN
<DepartDate>$this->ArriveDate</DepartDate>
BEGIN;
        }
      /*  $EaliestDepartTime1='';
        if($this->ArriveDate!=""){
            $EaliestDepartTime1=<<<BEGIN
<EaliestDepartTime>$this->ArriveCity</EaliestDepartTime>
BEGIN;
        }*/


        //        回程
        $Routes1=<<<BEGIN
<FlightRoute>$DepartCity1$ArriveCity1$DepartDate1$AirlineDibitCode$DepartPort1$ArrivePort1$EaliestDepartTime1$LatestDepartTime1</FlightRoute>
BEGIN;
        }

		$Routes=<<<BEGIN
<Routes><FlightRoute>$DepartCity$ArriveCity$DepartDate$AirlineDibitCode$DepartPort$ArrivePort$EaliestDepartTime$LatestDepartTime</FlightRoute>$Routes1</Routes>
BEGIN;


		// 航程列表到此结束

		$SendTicketCity="";
		if($this->SendTicketCity!=""){
			$SendTicketCity=<<<BEGIN
<SendTicketCity>$this->SendTicketCity</SendTicketCity>
BEGIN;
		}
		$IsSimpleResponses="";
		if($this->IsSimpleResponse!=""){
            $IsSimpleResponses=<<<BEGIN
<IsSimpleResponse>$this->IsSimpleResponse</IsSimpleResponse>
BEGIN;
		}
		$IsLowestPrices="";
		if($this->IsLowestPrice!=""){
			$IsLowestPrices=<<<BEGIN
<IsLowestPrice>$this->IsLowestPrice</IsLowestPrice>
BEGIN;
		}
		$LatestDepartTimeOptionss="";
		if($this->LatestDepartTimeOptions!=""){
			$LatestDepartTimeOptionss=<<<BEGIN
<LatestDepartTimeOptions>$this->LatestDepartTimeOptions</LatestDepartTimeOptions>
BEGIN;
		}
		$ProductTypeOptionss="";
		if($this->ProductTypeOptions!=""){
			$ProductTypeOptionss=<<<BEGIN
<ProductTypeOptions>$this->ProductTypeOptions</ProductTypeOptions>
BEGIN;
		}
		$Classgrade="";
		if($this->Classgrade!=""){
			$Classgrade=<<<BEGIN
<ClassGrade>$this->Classgrade</ClassGrade>
BEGIN;
		}
		$OrderBys="";
		if($this->OrderBy!=""){
            $OrderBys=<<<BEGIN
<OrderBy>$this->OrderBy</OrderBy>
BEGIN;
		}
		$Directions="";
		if($this->Direction!=""){
			$Directions=<<<BEGIN
<Direction>$this->Direction</Direction>
BEGIN;
		}
		$paravalues=<<<BEGIN
<?xml version="1.0"?>
<Request>
<Header $headerRight/>
<FlightSearchRequest>$SearchType$Routes$SendTicketCity$IsSimpleResponses$IsLowestPrices$LatestDepartTimeOptionss$ProductTypeOptionss$Classgrade$OrderBys$Directions</FlightSearchRequest>
</Request>
BEGIN;

		return  $paravalues;
	}

	function main(){
		try{
			$requestXML=$this->getRequestXML();
//            print_r($requestXML);exit;
			$commonRequestDo=new commonRequest();//常用数据请求
			$commonRequestDo->requestURL=OTA_FlightSearch_Url;
			$commonRequestDo->requestXML=$requestXML;
			$commonRequestDo->requestType=System_RequestType;//取config中的配置
			$commonRequestDo->doRequest();
			$returnXML=$commonRequestDo->responseXML;
			
			//print_r($commonRequestDo);die;
            // echo json_encode($returnXML);die;//校验请求数据-临时用
			//调用Common/RequestDomXml.php中函数解析返回的XML
			$this->ResponseXML=getXMLFromReturnString($returnXML);
		}
		catch(Exception $e)
		{
			$this->ResponseXML=null;
		}
	}
		
}
?>
