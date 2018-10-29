<?php
namespace WxPay;
/**
 *
 */
use WxPayLib\WxPayConfig;
use WxPayLib\WxPayUnifiedOrder;
use WxPayLib\WxPayOrderQuery;
use WxPayLib\WxPayCloseOrder;
use WxPayLib\WxPayRefund;
use WxPayLib\WxPayRefundQuery;

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
        $jsapipay = new JsApiPay();
        $result = $jsapipay->GetJsApiParameters($payresult);
        return $result;
    }
    /**
     * 订单查询
     *
     * @DateTime 2018-10-26
     * @param    WxPayConfig     $config   [description]
     * @param    WxPayOrderQuery $inputObj [description]
     * @return   [type]                    [description]
     */
    public function queryOrder(WxPayConfig $config, WxPayOrderQuery $inputObj)
    {
        $result = WxPayApi::orderQuery($config, $inputObj);
        return $result;
    }
    /**
     * 关闭订单
     *
     * @DateTime 2018-10-26
     *
     * @param    WxPayConfig     $config   [description]
     * @param    WxPayCloseOrder $inputObj [description]
     * @return   [type]                    [description]
     */
    public function closeOrder(WxPayConfig $config, WxPayCloseOrder $inputObj)
    {
        $result = WxPayApi::orderQuery($config, $inputObj);
        return $result;
    }
    /**
     * 退款
     *
     * @DateTime 2018-10-26
     * @param    WxPayConfig $config [description]
     * @param    WxPayRefund $input  [description]
     * @return   [type]              [description]
     */
    public function refund(WxPayConfig $config, WxPayRefund $input)
    {
        // $input = new WxPayRefund();
        // $input->SetOut_trade_no($out_trade_no);
        // $input->SetTotal_fee($total_fee);
        // $input->SetRefund_fee($refund_fee);

        // $config = new WxPayConfig();
        // $input->SetOut_refund_no("sdkphp".date("YmdHis"));
        if (!$input->IsOp_user_idSet()) {
            $input->SetOp_user_id($config->GetMerchantId());
        }
        $result = WxPayApi::refund($config, $input);
        return $result;
    }
    /**
     * 退款查询
     *
     * @DateTime 2018-10-26
     * @param    WxPayConfig      $config [description]
     * @param    WxPayRefundQuery $input  [description]
     * @return   [type]                   [description]
     */
    public function refundQuery(WxPayConfig $config, WxPayRefundQuery $input)
    {
        $result = WxPayApi::refundQuery($config, $input);
        return $result;
    }

}