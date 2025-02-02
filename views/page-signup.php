<!DOCTYPE html>
<html lang="zh">
<head>
	<?php include( ROOT_PATH . '/views/part-head.php' );?>
	<style>
		.main h2{margin-bottom:25px;}
		.main p.label{margin:0;}
		.red{color:#D00;}
		select,input[type=text]{box-sizing:border-box;border:1px solid #EEE;padding:5px;height:36px;outline:0;max-width:400px;width:100%;line-height:24px;}
		input[name=super_title]{max-width:9999px;}
		input[name=file]{display:none;}
		input[type=submit]{width:200px;height:36px;}
		select{width:80px;}
		select.small{width:50px;}
		textarea{box-sizing:border-box;border:1px solid #EEE;padding:5px;outline:0;width:100%;height:180px;line-height:24px;}
		#upload{display:block;position:relative;width:185px;height:185px;cursor:pointer;}
		#upload-close{
			position:absolute;top:0;right:0;width:24px;height:24px;line-height:24px;text-align:center;
			background:#D00;border:1px solid #FFF;color:#FFF;font-size:20px;z-index:99;cursor:pointer;display:none;
		}
		@media only screen and (max-width: 680px){
			textarea{height:250px;}
			input[type=submit]{width:100%;}
		}
		.panel-error{
			margin-bottom:25px;
		}
		#err-msg{
			display:none;
		}
		#err-msg p{
			margin:0;
		}
		#eyes{
			color:#747474;
			cursor:pointer;
		}
		#eyes.active{
			color:#D72171;
		}
		input[name=password]{box-sizing:border-box;border:1px solid #EEE;padding:5px;height:36px;outline:0;max-width:250px;width:75%;line-height:24px;}
	</style>
</head>
<body>
	<?php include( ROOT_PATH . '/views/part-header.php' );?>
	<div class="main">
		<div class="container">
			<h2>免费注册会员</h2>
			<div class="content">
			
				<div id="err-msg" class="panel-error"></div>
				
				<form id="form-signup" action="" method="post">
					<p class="label">名字: <span class="red">*</span></p>
					<p><input type="text" name="name" /></p>
					<p>
						性别: <span class="red">*</span>
						<input type="radio" name="gender" value="m"> 男生
						<input type="radio" name="gender" value="f"> 女生
					</p>
					<p class="label">生日日期: <span class="red">*</span></p>
					<p>
						<select name="birth_year">
							<?php for($i = 1970; $i <= date('Y') - 18; $i++): ?>
								<option value="<?php echo $i;?>" <?php if($i==1990) echo 'selected';?>><?php echo $i;?></option>
							<?php endfor; ?>
						</select>
						<select class="small" name="birth_month">
							<?php for($i = 1; $i <= 12; $i++): ?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php endfor; ?>
						</select>
						<select class="small" name="birth_day">
							<?php for($i = 1; $i <= 31; $i++): ?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php endfor; ?>
						</select>
					</p>
					<p>
						上传头像:<br>
						<span id="upload">
							<span id="upload-close">&times;</span>
							<img src="<?php echo DEFAULT_SILHOUETTE;?>" />
						</span>
						<input type="file" id="file" name="file" />
						<input type="hidden" name="profile_image" value="" />
					</p>
					<div id="uploadMsg"></div>
					<p class="label">至少要填一个或一个以上的联系方式: <span class="red">*</span></p>
					<p class="label">微信号码:</p>
					<p><input type="text" name="wechat" /></p>
					<p class="label">电话号码:</p>
					<p><input type="text" name="phone" /></p>
					<p class="label">电子邮箱:</p>
					<p><input type="text" name="email" /></p>
					<!-- <p class="label">帐号密码:(用于以后更改资料)</p> -->
					<!-- <p><input type="password" name="password" /> <span id="eyes"> &#128064 </span> </p> -->
	<!-- 				<p class="label">标题: </p>
					<p><input type="text" name="super_title" /></p> -->
					<p class="label">基本资料: <span class="red">*</span><br />
						<i style="color:#777;font-size:14px;">请尽量填详细的信息：现居地(精确到区，例如纽约法拉盛), 来自哪个城市，职业，兴趣爱好，来美多久，学历，婚姻状况，信仰，身高，体重，三观等等...</i>
					</p>
					<p><textarea name="about_me"></textarea></p>
					<p class="label">喜欢什么样的男生/女生: </p>
					<p><textarea name="preference"></textarea></p>
					<p><input name="submit" type="submit" class="btn" value="提交" /></p>
				</form>
			</div>
		</div>
	</div>
	<?php include( ROOT_PATH . '/views/part-footer.php' );?>
	
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script>
	//Adjust date picker days in month.
	$('select[name=birth_year],select[name=birth_month]').change(function(){
		
		var year = $('select[name=birth_year]').val();
		var month = $('select[name=birth_month]').val();

		var days_in_month = 31;

		if( month == 2 && year % 4 == 0 ){
			days_in_month = 29;
		}
		else if( month == 2 && year % 4 != 0 ){
			days_in_month = 28;
		}
		else if( $.inArray(parseInt(month,10), [4,6,9,11]) !== -1 ){
			days_in_month = 30;
		}

		var $days_selector = $('select[name=birth_day]');

		for( var i = $days_selector.children().length; i < days_in_month; i++ ){
			$days_selector.append('<option value="'+(i+1)+'">'+(i+1)+'</option>');
		}

		$days_selector.find('option:gt('+(days_in_month-1)+')').remove();
	});
	
	//Show-hide password event.
	// var showPassword = false;
	// $('#eyes').click(function(){
		
	// 	showPassword = !showPassword;
		
	// 	if( showPassword ){
	// 		$(this).addClass('active');
	// 		$('input[name=password]').attr('type','text');
	// 	}
	// 	else{
	// 		$(this).removeClass('active');
	// 		$('input[name=password]').attr('type','password');
	// 	}
		
	// });
	
	//Auto-correct phone number.
	$('input[name=phone]').keyup(function(){
		$(this).val( $(this).val().replace(/\D+/g, '').substring(0,11) );
	});
	
    //Validations.
    jQuery(document).ready(function($){

        $('#form-signup').submit(function(event){

			var errors = [];

            var name = $('input[name=name]').val().trim();
			var wechat = $('input[name=wechat]').val().trim();
			var phone = $('input[name=phone]').val().trim();
			var email = $('input[name=email]').val().trim();
			// var password = $('input[name=password]').val().trim();
			// var super_title = $('input[name=super_title]').val().trim();
			var about_me = $('textarea[name=about_me]').val().trim();

            if( name.length == 0 ){
				errors.push('必须填写你的名字!');
			}

			if( $('input[name=gender]:checked').length != 1 ){
				errors.push('必须选择你的性别!');
			}

			if( about_me.length < 40 ){
				errors.push('基本资料必须至少有40个字或以上!');
			}

			if( wechat.length == 0 && phone.length == 0 && email.length == 0 ){
				errors.push('必须填写微信号码或电话号码或电子邮箱其中之一个联系方式!');
			}

			if( wechat.length > 0 && wechat.length < 4 ){
				errors.push('微信号码格式不正确!');
			}

			if( phone.length > 1 && ! /\d{10,11}/.test(phone) ){
				errors.push('电话号码格式不正确!');
			}

			if( email.length > 0 && ! /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email) ){
				errors.push('电子邮箱格式不正确!');
			}

			// if( password.length < 8 ){
			// 	errors.push('帐号密码至少要有8位数!');
			// }

			if( errors.length > 0 ){

				$('#err-msg').html('');
				for(var i=0; i<errors.length; i++){
					$('#err-msg').append('<p>&bull; '+errors[i]+'</p>');
				}
				$('#err-msg').show();
				
				$("html, body").animate({ scrollTop: 0 }, "slow");

				event.preventDefault();
				return false;
			}
			else{

				return true;
			}
        });

    });
    </script>
	<script>
	jQuery(document).ready(function($){
		
		//Click upload image event.
		$('#upload').click(function(event){
			
			$('#file').trigger('click');
			
		});
		
		//File upload async event.
		$('#file').change(function(){

			var $message = $('#uploadMsg');

			var file_data = $('#file').prop('files')[0];
            var file_type = file_data.type.toLowerCase();
            var file_size = file_data.size;
            var file_extension = file_data.name.split('.').pop().toLowerCase();

			//Selected photo file validations.

			if( ! /^image\/\w+$/.test(file_type) ){
				$message.html('<p class="panel-error">上传错误: 只允许上传图片文件!</p>');
				return false;
			}

			if( ! /^(jpg|jpeg|png|gif)$/.test(file_extension) ){
				$message.html('<p class="panel-error">上传错误: 图片文件后缀只允许jpg,jpeg,png,gif!</p>');
				return false;
			}

			if( file_size > 4194303 ){
				$message.html('<p class="panel-error">上传错误: 图片文件太大了,超过了4MB的上传限制!</p>');
				return false;
			}

			var form_data = new FormData();
			form_data.append('file', file_data);

			$.ajax({
				url: '<?php echo SITE_URL;?>/profile/update',
				dataType: 'text', // what to expect back from the server
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (response){
					
					if( response ){
						$('#upload img').attr("src", response);
						$('input[name=profile_image]').val(response);
						$('#upload-close').show();
					}
					else{
						$message.html('<p class="panel-error">上传错误!</p>');
					}
				},
				error: function (response){
					$message.html('<p class="panel-error">上传错误!</p>');
				}
			});

		});

		//Remove uploaded image event.
		$('#upload-close').click(function(event){
			
			event.stopPropagation();
			
			$('#upload img').attr("src", '<?php echo DEFAULT_SILHOUETTE;?>');
			$('#upload-close').fadeOut("slow");
	
			$('input[name=profile_image]').val('');
		});

	});
	</script/>

</body>