<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>android app for ios device list @TMT</title>
	<meta name="viewport" content=" initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<style>
		body {
			background: #EAEAEA;
			color: #4D4D4D;
			
			font-size: 12px;
			line-height: 20px;
		}
		.mod-list__des {
			background: #FFFFFF;
			padding: 10px;
			border-radius: 5px;
			margin: 0;
		}
		.mod-list {
			padding: 10px;

		}
		.mod-list__item {
			border-bottom: 1px solid #EAEAEA;
			list-style-type: none;
			padding: 10px 10px;
		}
		.mod-list__item:last-child {
			margin-bottom: 0;
		}
		.mod-list_ul {
			border-radius: 5px;			
			background: #FFFFFF;
			padding-left: 0;
			box-shadow: 2px 2px 3px #DEDEDE;
		}
		.mod-list__item_to {
			float: right;
		}
		.mod-list__link {
			display: block;
			text-decoration: none;
			color: #4D4D4D;
		}
	</style>
</head>
<body>

	<div class="mod-list">
		<p class="mod-list__des">您扫描的是android的app，已为您在app store搜索了如下结果，点击即进入app store。</p>
		<ul class="mod-list_ul">
			
            <?php foreach($url_list as $key => $value) :?>
                <li class="mod-list__item">
                    <a class="mod-list__link" href="<?php echo $value['artistViewUrl']?>">
                      <?php echo $value['artistName']?>  <span class="mod-list__item_to">>></span>	
                    </a>
                    
                </li>

			<?php endforeach;?>
		</ul>
	</div>
</body>
</html>