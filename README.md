***
# wxpay 公众号支付及小程序支付封装  
1. 安装  
	`composer require miszhou/wxpay`
2. 注册provider  
在app.php里加入： `$app->register(WxPay\WxPayServiceProvider::class);`  
3. 静态资源文件生成  
	`php artisan vendor:publish --provider="WxPay/WxPayServiceProvider"`  
   在config文件夹中将会生成wxpayConfig.php文件  
   在demo文件夹中将会生成demo.php文件以及成功回调实现类  
   在app.php里加入：`$app->configure('wxpayConfig');`确保文件能被调用到  
4. 使用：  
	统一下单  
	```
	use WxPay\WxApi;
	use WxPay\WxPayConfig;
	use WxPayLib\WxPayUnifiedOrder;

	$openid = 'ovIb50************nrU0s';  // 用户openid
	$config = new WxPayConfig(config('wxpayConfig'));
	$config->SetAppid('appid');					// 设置appid 不设置默认为wxpayConfig数组文件里的appid
	$config->SetAppSecret('appsecret'); 		// 设置appsecret 不设置默认为wxpayConfig数组文件里的appsecret
	$config->SetKey('key'); 					// 设置key 不设置默认为wxpayConfig数组文件里的key
	$config->SetMerchantId('商户号'); 			// 设置商户号 不设置默认为wxpayConfig数组文件里的商户号
	$config->SetNotifyUrl('支付成功回调地址'); 	// 设置回调地址 不设置默认为wxpayConfig数组文件里的回调地址
	$order = new WxPayUnifiedOrder();
	$order->SetBody(iconv_substr('商品名', 0, 20, 'utf-8'));
	$order->SetAttach("附加值支付成功通知的标题栏");
	$order->SetOut_trade_no('订单号');
	$order->SetTotal_fee(支付金额单位：分);
	$order->SetTime_start('下单时间');
	$order->SetTime_expire('下单时间+600');
	$order->SetGoods_tag('优惠券标识');
	$order->SetNotify_url("支付成功回调地址"); // 设置回调地址 不设置默认为WxPayConfig对象$config设置的回调地址
	$order->SetOpenid($openid);
	$order->SetTrade_type("JSAPI");
	$wxapi = new WxApi();
	$res = $wxapi->unifiedOrder($config, $order);
    ```
具体使用见Demo：https://github.com/miszhou/wxpay/blob/master/demo/Demo.php  
## 可能错误提示
1. curl出错，错误码:60  
  本地取消https证书校验，正式环境记得回退改动，正式环境应为严格模式。  
  miszhou/wxpay/lib/WxPay.Api.php 562行  
	```
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 2);//严格校验
	```  
  变更为：  
	```
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 0);//取消校验
	```  
2. time_expire时间过短，刷卡至少1分钟，其他5分钟  
  由于本地时区错误导致，不改变时区的情况下，可以将失效时间适当延长，一般延长8小时即可解决问题。  
  `$order->SetTime_expire('下单时间+600+8*3600');`