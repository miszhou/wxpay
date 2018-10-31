<?php
namespace WxPay;

use WxPay\WxPayConfig;
use WxPayLib\WxPayNotify;

class PayNotifyCallBack extends WxPayNotify
{

    //重写回调处理函数
    /**
     * @param WxPayNotifyResults $data 回调解释出的参数
     * @param WxPayConfig        $config
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($data, $config, &$msg)
    {
        /*
        TODO 3、处理业务逻辑 业务逻辑应该有去重处理
        注意!!!!
        1、微信回调超时时间为2s，建议用户使用异步处理流程，确认成功之后立刻回复微信服务器
        2、微信服务器在调用失败或者接到回包为非确认包的时候，会发起重试，需确保你的回调是可以重入
        成功返回true 失败返回false
        */
        return true;
    }
}