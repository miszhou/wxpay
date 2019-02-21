<?php
namespace WxPay;
/**
 *
 */
use WxPay\WxPayConfig;
use WxPayLib\WxPayApi;
use WxPayLib\WxPayUnifiedOrder;
use Exception;
class WxApi
{
    /**
     * 统一下单，WxPayUnifiedOrder中out_trade_no、body、total_fee、trade_type必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     *
     * @param WxPayConfigInterface $config   配置对象
     * @param WxPayUnifiedOrder    $inputObj 下单对象
     *
     * @return 成功时返回，其他抛异常
     */
    public function unifiedOrder(WxPayConfig $config, WxPayUnifiedOrder $inputObj)
    {
        $payresult = WxPayApi::unifiedOrder($config, $inputObj);
        if ($payresult['return_code'] == 'SUCCESS' && $payresult['result_code'] == 'SUCCESS') {
            $jsapipay = new JsApiPay();
            $result = $jsapipay->GetJsApiParameters($config, $payresult);
        } else {
            throw new Exception($payresult['return_msg'], 1);
        }
        return $result;
    }
}