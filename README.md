# wxpay 公众号支付及小程序支付封装
***
1. 安装  
	`composer require miszhou/wxpay`
2. 注册provider  
	在app.php里加入：`$app->register(WxPay\WxPayServiceProvider::class);`
3. 静态资源文件生成  
	`php artisan vendor:publish --provider="WxPay/WxPayServiceProvider"`
   在config文件夹中将会生成wxpayConfig.php文件。
4. 使用：  
	统一下单  
	```
		use WxPay\WxApi;
		use WxPay\WxPayConfig;
		use WxPayLib\WxPayUnifiedOrder;

		$openid = 'ovIb50************nrU0s';  // 用户openid
    	$config = new WxPayConfig(config('wxpayConfig'));
    	$config->SetAppid('appid******');
    	$config->SetAppSecret('appsecret******');
    	$config->SetKey('key******');
    	$config->SetMerchantId('商户号');
    	$config->SetNotifyUrl('支付成功回调地址');
    	$order = new WxPayUnifiedOrder();
    	$order->SetBody(iconv_substr('商品名', 0, 20, 'utf-8'));
    	$order->SetAttach("******");
    	$order->SetOut_trade_no('订单号');
	    $order->SetTotal_fee(支付金额单位：分);
	    $order->SetTime_start('下单时间');
	    $order->SetTime_expire('下单时间+600');
	    $order->SetGoods_tag('优惠券标识');
	    $order->SetNotify_url("支付成功回调地址"); // 设置回调地址 不设置默认为WxPayConfig里的回调地址
	    $order->SetOpenid($openid);
	    $order->SetTrade_type("JSAPI");
	    $wxapi = new WxApi();
	    $res = $wxapi->unifiedOrder($config, $order);
    ```