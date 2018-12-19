<?php
    /**
     * TODO: 修改这里配置为您自己申请的商户信息
     * 微信公众号信息配置
     *
     * appid：绑定支付的APPID（必须配置，开户邮件中可查看）
     *
     * merchantid：商户号（必须配置，开户邮件中可查看）
     *
     * key：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
     * 设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
     *
     * appsecert：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），
     * 获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
     *
     * notifyurl: 支付成功回调地址 （必须配置）
     *
     * sslcertpath：例：../cert/apiclient_cert.pem （必须配置）
     * sslkeypath：例：../cert/apiclient_key.pem （必须配置）
     * TODO：设置商户证书路径 绝对路径
     * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，
     * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
     * 注意:
     * 1.证书文件不能放在web服务器虚拟目录，应放在有访问权限控制的目录中，防止被他人下载；
     * 2.建议将证书文件名改为复杂且不容易猜测的文件名；
     * 3.商户服务器要做好病毒和木马防护工作，不被非法侵入者窃取证书文件。
     *
     * signtype：加密类型 MD5或者HMAC-SHA256 默认HMAC-SHA256
     *
     * proxyhost：默认0.0.0.0
     * proxyport：默认0
     * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
     * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
     * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
     *
     * reportlevenl：:默认-1
     * TODO：接口调用上报等级，默认紧错误上报（注意：上报超时间为【1s】，上报无论成败【永不抛出异常】，
     * 不会影响接口调用流程），开启上报之后，方便微信监控请求调用的质量，建议至少开启错误上报。
     * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
     */
    return
    [
        'default' => [
            'appid' => '',
            'merchantid' => '',
            'key' => '',
            'appsecert' => '',
            'notifyurl' => '',
            'sslcertpath' => '',
            'sslkeypath' => '',
            'signtype' => 'HMAC-SHA256',    //默认值
            'proxyhost' => '0.0.0.0',       //默认值
            'proxyport' => '0',             //默认值
            'reportlevenl' => '-1'          //默认值
        ]
    ];
