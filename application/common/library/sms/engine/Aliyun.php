<?php
namespace app\common\library\sms\engine;
use app\common\library\sms\package\aliyun\SignatureHelper;
/**
 * 阿里云短信模块引擎
 * Class Aliyun
 * @package app\common\library\sms\engine
 */
class Aliyun extends Server
{
    private $config;
    static $acsClient = null;

    /**
     * 构造方法
     * Qiniu constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 发送短信通知
     * @param $msgType
     * @param $templateParams
     * @return bool|\stdClass
     */
    public function sendSms($msgType, $templateParams)
    {
        $params = [];
        // *** 需用户填写部分 ***

        // 必填: 短信接收号码
        $params["PhoneNumbers"] = $this->config[$msgType]['accept_phone'];

        // 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = $this->config['sign'];

        // 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $this->config[$msgType]['template_code'];

        // 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = $templateParams;

        // 可选: 设置发送短信流水号
        // $params['OutId'] = "12345";

        // 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        // $params['SmsUpExtendCode'] = "1234567";

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper;

        // 此处可能会抛出异常，注意catch
        $response = $helper->request(
            $this->config['AccessKeyId']
            , $this->config['AccessKeySecret']
            , "dysmsapi.aliyuncs.com"
            , array_merge($params, [
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ])
            // 选填: 启用https
            , true
        );
        // 记录日志
        log_write([
            'config' => $this->config,
            'params' => $params
        ]);
        log_write($response);
        $this->error = $response->Message;
        return $response->Code === 'OK';
    }
    
    /**
     * 发短信验证码
     * @param unknown $phone
     * @param unknown $templateParams
     * @return unknown
     */
    public function sendPhoneCode($phone, $templateParams, $code){
    	// 初始化SendSmsRequest实例用于设置发送短信的参数
    	$request = new SendSmsRequest();
    	// 必填，设置短信接收号码
    	$request->setPhoneNumbers($phone);
    	// 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    	$request->setSignName($this->config['sign']);
    	// 必填，设置模板CODE，应严格按"模板CODE"填写,（如果发送国际/港澳台消息时，请使用国际/港澳台短信模版） 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    	$request->setTemplateCode($templateParams);
    	// 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
    	$request->setTemplateParam(json_encode(Array(  // 短信模板中字段的值
    			"code"=>$code
    			)));
    	// 可选，设置流水号
    	$request->setOutId("000001");
    	// 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
    	// $request->setSmsUpExtendCode("1234567");
    	// 发起访问请求
    	$acsResponse = static::getAcsClient()->getAcsResponse($request);
    	return $acsResponse;
    }
    
    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public function getAcsClient() {
    	//产品名称:云通信短信服务API产品,开发者无需替换
    	$product = "Dysmsapi";
    
    	//产品域名,开发者无需替换
    	$domain = "dysmsapi.aliyuncs.com";
    
    	// TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
    	$accessKeyId = $this->config['AccessKeyId']; // AccessKeyId
    
    	$accessKeySecret = $this->config['AccessKeySecret']; // AccessKeySecret
    
    	// 暂时不支持多Region
    	$region = "cn-hangzhou";
    
    	// 服务结点
    	$endPointName = "cn-hangzhou";
    
    
    	if(static::$acsClient == null) {
    
    		//初始化acsClient,暂不支持region化
    		$profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
    		
    		// 手动加载endpoint
    		EndpointConfig::load();
    		
    		// 增加服务结点
    		DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
    		
    		// 初始化AcsClient用于发起请求
    		static::$acsClient = new DefaultAcsClient($profile);
    	}
    	return static::$acsClient;
    }
}
