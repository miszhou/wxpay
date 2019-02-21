<?php
namespace WxPay;

use WxPay\WxApi;
use WxPay\WxPayConfig;
use WxPay\PayNotifyCallBack;
use WxPayLib\WxPayApi;
use WxPayLib\WxPayUnifiedOrder;
use WxPayLib\WxPayOrderQuery;
use WxPayLib\WxPayCloseOrder;
use WxPayLib\WxPayRefund;
use WxPayLib\WxPayRefundQuery;
use WxPayLib\QueryCouponStock;
use WxPayLib\QueryCouponInfo;
use WxPayLib\QueryCouponSend;

class Demo
{
    /**
     * 统一下单，WxPayUnifiedOrder中out_trade_no、body、total_fee、trade_type必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     *
     * @param WxPayConfig       $config   配置对象
     * @param WxPayUnifiedOrder $inputObj 下单对象
     *
     * @return 成功时返回，其他抛异常
     */
    public function unifiedOrder()
    {
        $openid = 'ovIb50************nrU0s';  // 用户openid
        $config = $this->getConfig();
        // 下单对象封装
        $inputObj = new WxPayUnifiedOrder();
        $inputObj->SetBody(iconv_substr('商品名', 0, 20, 'utf-8'));
        $inputObj->SetAttach("附加值，用于支付成功通知的标题栏显示");
        $inputObj->SetOut_trade_no('订单号');
        $inputObj->SetTotal_fee('支付金额单位：分');
        $inputObj->SetTime_start('下单时间');
        $inputObj->SetTime_expire('下单时间+600');
        $inputObj->SetGoods_tag('优惠券标识');
        $inputObj->SetNotify_url("支付成功回调地址"); // 设置回调地址 不设置默认为WxPayConfig对象$config设置的回调地址
        $inputObj->SetOpenid($openid);
        $inputObj->SetTrade_type("JSAPI");
        // 一键下单
        $wxapi = new WxApi();
        $result = $wxapi->unifiedOrder($config, $inputObj);
        return $result;
    }
    /**
    * 支付成功回调
     *
     * @param WxPayConfig       $config   配置对象
     * @param PayNotifyCallBack $notify   回调实现类
     *
     * @return 成功时返回，其他抛异常
     */
    public function paycallback()
    {
        $notify = new PayNotifyCallBack();
        $notify->Handle(config('wxpayConfig'), false);
    }
    /**
     * 订单查询
     *
     * @DateTime 2018-10-26
     * @param    WxPayConfig     $config   [description]
     * @param    WxPayOrderQuery $inputObj [description]
     * @return   [type]                    [description]
     */
    public function queryOrder()
    {
        $config = $this->getConfig();
        $inputObj = new WxPayOrderQuery();
        $inputObj->SetOut_trade_no($out_trade_no); // 下单商户订单号唯一  或者用微信订单号transaction_id
        // $inputObj->SetTransaction_id($transaction_id);  // 与out_trade_no二选一
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
    public function closeOrder()
    {
        $config = $this->getConfig();
        $inputObj = new WxPayCloseOrder();
        $inputObj->SetOut_trade_no($out_trade_no); // 下单商户订单号唯一
        $result = WxPayApi::closeOrder($config, $inputObj);
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
    public function refund()
    {
        $config = $this->getConfig();
        // 确保config的证书路径已设置
        $inputObj = new WxPayRefund();
        $inputObj->SetOut_trade_no($out_trade_no); // 下单商户订单号唯一  或者用微信订单号transaction_id
        // $inputObj->SetTransaction_id($transaction_id);  // 与out_trade_no二选一
        $inputObj->SetTotal_fee($total_fee);   // 下单支付总金额 单位：分
        $inputObj->SetRefund_fee($refund_fee); // 退款金额 单位：分
        $inputObj->SetOut_refund_no("sdkphp".date("YmdHis"));  // 商户自定义退款id 唯一
        $inputObj->SetOp_user_id($config->GetMerchantId());
        $result = WxPayApi::refund($config, $inputObj);
        return $result;
    }
    /**
     * 退款查询
     * 退款查询接口中，out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个！
     *
     * @DateTime 2018-10-26
     * @param    WxPayConfig      $config [description]
     * @param    WxPayRefundQuery $inputObj  [description]
     * @return   [type]                   [description]
     */
    public function refundQuery()
    {
        $config = $this->getConfig();
        $inputObj = new WxPayRefund();
        $inputObj->SetOut_refund_no($out_refund_no); // 商户退款单号  或者
        // $inputObj->SetRefund_id($out_trade_no); // 微信退款单号  或者
        // $inputObj->SetOut_trade_no($refund_id); // 商户订单号  或者
        // $inputObj->SetTransaction_id($transaction_id);  // 微信订单号 四选一
        $result = WxPayApi::refundQuery($config, $inputObj);
        return $result;
    }
    /**
     * 查询代金券批次
     * 查询代金券批次接口中，coupon_stock_id必填！
     *
     * @DateTime 2019-02-21
     * @param    WxPayConfig      $config [description]
     * @param    QueryCouponStock $inputObj  [description]
     * @return   [type]                   [description]
     */
    public function couponStock()
    {
        $config = $this->getConfig();
        $inputObj = new QueryCouponStock();
        $inputObj->SetCoupon_stock_id($coupon_stock_id); // 代金券批次id
        $result = WxPayApi::couponStock($config, $inputObj);
        return $result;
    }
    /**
     * 查询代金券信息
     * 查询代金券批次接口中，coupon_id、openid、stock_id必填！
     *
     * @DateTime 2019-02-21
     * @param    WxPayConfig      $config [description]
     * @param    QueryCouponInfo $inputObj  [description]
     * @return   [type]                   [description]
     */
    public function couponInfo()
    {
        $config = $this->getConfig();
        $inputObj = new QueryCouponInfo();
        $inputObj->SetCoupon_id($coupon_id); // 代金券id
        $inputObj->SetOpenid($openid);      // 用户openid
        $inputObj->SetStock_id($stock_id);  // 批次号
        $result = WxPayApi::couponInfo($config, $inputObj);
        return $result;
    }
    /**
     * 发放代金券
     * 发放代金券接口中，coupon_stock_id、openid_count=1发送记录数只能填1、partner_trade_no、openid必填！
     *
     * @DateTime 2019-02-21
     * @param    WxPayConfig      $config [description]
     * @param    QueryCouponSend $inputObj  [description]
     * @return   [type]                   [description]
     */
    public function couponSend()
    {
        $config = $this->getConfig();
        $inputObj = new QueryCouponSend();
        $inputObj->SetCoupon_stock_id($coupon_stock_id); // 代金券批次id
        $inputObj->SetOpenid_count(1); // openid记录数 唯一值:1
        $inputObj->SetPartner_trade_no($partner_trade_no); // 商户单据号 商户此次发放凭据号（格式：商户id+日期+流水号），商户侧需保持唯一性
        $inputObj->SetOpenid($openid);  // 用户openid
        $result = WxPayApi::couponSend($config, $inputObj);
        return $result;
    }
    private function getConfig($key = 'default')
    {
        $config = new WxPayConfig(config('wxpayConfig'), $key);
        // $config->SetAppid('appid');                 // 设置appid 不设置默认为wxpayConfig数组文件里的appid
        // $config->SetAppSecret('appsecret');         // 设置appsecret 不设置默认为wxpayConfig数组文件里的appsecret
        // $config->SetKey('key');                     // 设置key 不设置默认为wxpayConfig数组文件里的key
        // $config->SetMerchantId('商户号');           // 设置商户号 不设置默认为wxpayConfig数组文件里的商户号
        // $config->SetNotifyUrl('支付成功回调地址');  // 设置回调地址 不设置默认为wxpayConfig数组文件里的回调地址
        return $config;
    }
}