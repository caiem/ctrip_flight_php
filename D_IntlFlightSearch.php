<?php
/**
 * 请求D_FlightSearch的服务（列表查询）
 */
class get_D_IntlFlightSearch{
    /**
     * @var 航程类型：string类型；必填；OW（单程）RT（往返程）
     */
    var $SearchType="";
    var $DCode="";
    var $ACode="";
    var $DDate="";
    var $DDate1="";
    var $PassengerType1="ADT",$PassengerType2="CHD",$PassengerCount1="",$PassengerCount2="",$Eligibility1="ALL",$Eligibility2="CHD",$Shopinfo='',$Step='',$count='',$seg='',$seg2='';
    /**
     *
     *@var Y 经济舱  C公务舱    F头等舱
     */
    var $ClassGrade="";
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
    var $Direction="Asc";
    var $Airline="";
    /**
     *@var返回体
     */
    var $DepartTime="";

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
        $RequestType="OTA_IntlFlightSearch";
        //构造权限头部
        $headerRight=getRightString($AllianceID,$SID,$KEYS,$RequestType);
//        echo $headerRight;
        $SearchType="";
        //航程类型
        if($this->SearchType!=""){
            $SearchType=<<<BEGIN
<TripType>$this->SearchType</TripType>
BEGIN;
        }
        //成人
       $PassengerType1="";
       if($this->PassengerType1!=""){
            $PassengerType1=<<<BEGIN
<PassengerType>$this->PassengerType1</PassengerType>
BEGIN;
       }
       $PassengerCount1="";
       if($this->PassengerCount1!=""){
            $PassengerCount1=<<<BEGIN
<PassengerCount>$this->PassengerCount1</PassengerCount>
BEGIN;
       }
       $Eligibility1="";
       if($this->Eligibility1!=""){
            $Eligibility1=<<<BEGIN
<Eligibility>$this->Eligibility1</Eligibility>
BEGIN;
       }
        //等级
        $ClassGrade="";
        if($this->ClassGrade!=""){
            $ClassGrade=<<<BEGIN
<ClassGrade>$this->ClassGrade</ClassGrade>
BEGIN;
        }
        $Airline="";
        if($this->Airline!=""){
            $Airline=<<<BEGIN
<Airline>$this->Airline</Airline>
BEGIN;
        }
        $OrderBy="";
        if($this->OrderBy!=""){
            $OrderBy=<<<BEGIN
<OrderBy>$this->OrderBy</OrderBy>
BEGIN;
        }
        $Direction="";
        if($this->Direction!=""){
            $Direction=<<<BEGIN
<Direction>$this->Direction</Direction>
BEGIN;
        }
        $DCode="";
        if($this->DCode!=""){
            $DCode=<<<BEGIN
<DCode>$this->DCode</DCode>
BEGIN;
        }
        $ACode="";
        if($this->ACode!=""){
            $ACode=<<<BEGIN
<ACode>$this->ACode</ACode>
BEGIN;
        }
        $DDate="";
        $this->DDate.='T00:00:00';
        if($this->DDate!=""){
            $DDate=<<<BEGIN
<DDate>$this->DDate</DDate>
BEGIN;
        }
        $DepartTime="";
        if($this->DepartTime!=""){
            $DepartTime=<<<BEGIN
<DepartTime>$this->DepartTime</DepartTime>
BEGIN;
        }
        if($this->Step==2&&$this->SearchType=='RT'){
        $Shopinfo="";
        if($this->Shopinfo!=""){
            $Shopinfo=<<<BEGIN
<ShoppingInfoID>$this->Shopinfo</ShoppingInfoID>
BEGIN;
        }
//        對routing分段做判斷
        if($this->count<4){
            $segar=explode('|',$this->seg);
            $segar2=explode('|',$this->seg2);
            $Routing1=<<<BEGIN
<Routing><DCode>$segar2[5]</DCode><ACode>$segar2[6]</ACode><DAirport>$segar2[0]</DAirport><AAirport>$segar2[1]</AAirport><Airline>$segar2[2]</Airline><SeatClass>$segar2[3]</SeatClass><FlightNo>$segar2[4]</FlightNo><OperatorNo></OperatorNo><SegmentInfoNo>1</SegmentInfoNo><No>2</No></Routing></Routings>
BEGIN;
            $Routing2=<<<BEGIN
<Routings><Routing><DCode>$segar[5]</DCode><ACode>$segar[6]</ACode><DAirport>$segar[0]</DAirport><AAirport>$segar[1]</AAirport><Airline>$segar[2]</Airline><SeatClass>$segar[3]</SeatClass><FlightNo>$segar[4]</FlightNo><OperatorNo></OperatorNo><SegmentInfoNo>1</SegmentInfoNo><No>1</No></Routing>
BEGIN;
            $Routings=<<<BEGIN
$Routing2$Routing1
BEGIN;
        }else {
            $segar=explode('|',$this->seg);
            $Routings=<<<BEGIN
<Routings><Routing><DCode>$segar[5]</DCode><ACode>$segar[6]</ACode><DAirport>$segar[0]</DAirport><AAirport>$segar[1]</AAirport><Airline>$segar[2]</Airline><SeatClass>$segar[3]</SeatClass><FlightNo>$segar[4]</FlightNo><OperatorNo></OperatorNo><SegmentInfoNo>1</SegmentInfoNo><No>1</No></Routing></Routings>
BEGIN;
        }
        }else{
            $Shopinfo=<<<BEGIN
<ShoppingInfoID />
BEGIN;
            $Routings=<<<BEGIN
<Routings />
BEGIN;

        }

        //判断是否往返
        if($this->SearchType=="RT"){
            $this->DDate1.='T00:00:00';
            $SegmentInfo1=<<<BEGIN
<SegmentInfo><DCode>$this->ACode</DCode><ACode>$this->DCode</ACode><DAirport /><AAirport /><DDate>$this->DDate1</DDate><TimePeriod>All</TimePeriod></SegmentInfo>
BEGIN;
        }
        $SegmentInfo=<<<BEGIN
<SegmentInfo>$DCode$ACode<DAirport /><AAirport />$DDate<TimePeriod>All</TimePeriod></SegmentInfo>
BEGIN;
        $SegmentInfos=<<<BEGIN
<SegmentInfos>$SegmentInfo$SegmentInfo1</SegmentInfos>
BEGIN;

//        $PassengerType2$PassengerCount2$Eligibility2
        $paravalues=<<<BEGIN
<?xml version="1.0"?>
<Request>
<Header $headerRight/>
<IntlFlightSearchRequest>$SearchType$PassengerType1$PassengerCount1$Eligibility1<BusinessID /><BusinessType>OWN</BusinessType>$Airline$DepartTime$ClassGrade<SalesType>Online</SalesType><FareIds /><FareType>All</FareType><AgentID /><ResultMode>All</ResultMode>$OrderBy$Direction$Shopinfo$SegmentInfos$Routings</IntlFlightSearchRequest>
</Request>
BEGIN;

        return  $paravalues;
    }

    function main(){
        try{
            $requestXML=$this->getRequestXML();
//            print_r($requestXML);exit;
            $commonRequestDo=new commonRequest();//常用数据请求
            $commonRequestDo->requestURL=OTA_IntlFlightSearch_Url;
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
