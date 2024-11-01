<?php
require dirname(__FILE__).'/../assets/php/config.php';
add_action('admin_menu', 'wp_spatialtree_settings_add_menu');
function wp_spatialtree_settings_add_menu() {
	$page = add_menu_page('Spatial Tree', 'Spatial Tree', 'manage_options', 'wp-spatialtree-settings', 'wp_spatialtree_settings_settings_page', plugin_dir_url( __FILE__ ).'/icon.png');
}

add_action('admin_init', 'wp_spatialtree_settings_admin_init');
function wp_spatialtree_settings_admin_init() {	
	?>
	
			<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/spatialtree/assets/js/settings.js"></script>
            <script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/spatialtree/assets/js/config.js"></script>
			<link type="text/css" rel="stylesheet" href="<?php echo WP_PLUGIN_URL; ?>/spatialtree/assets/css/settings.css" />
	<?php
    register_setting('wp_spatialtree_options', 'wp_spatialtree_options');
	add_settings_section('wp_spatialtree_settings_main', '', 'wp_spatialtree_settings_section_text', 'wp-spatialtree-settings');
		$data = wp_spatialtree_check_user();
		add_meta_box('wp_spatialtree_credentials', 'Login Details', 'wp_spatialtree_credentials_content', 'wp_spatialtree_settings_main', 'normal', 'high', $data);
	
    add_meta_box('wp_spatialtree_create_account', 'Create Your Account', 'wp_spatialtree_create_account', 'wp_spatialtree_settings_main', 'normal', 'high');
    
    
	if($data == null || $data['result'] == 'Error')
	{
		return;
	}else
	{
        
        if(isset($_GET['pageNum']))
        {
            $data = wp_spatialtree_get_article_list($_GET['pageNum'],5);
        }else
        {
            $data = wp_spatialtree_get_article_list(1,5);
        }
        
		if($data != false) {
			add_meta_box('wp_spatialtree_articles', 'Articles', 'wp_spatialtree_articles_content', 'wp_spatialtree_settings_main', 'normal', 'high', $data);
		}
        
	}
}

function wp_spatialtree_create_account()
{
    ?>
    <div id="wp_spatialtree_create_account_area">
        <span class="wp_spatialtree_create_span">Username: </span><input type="text" id="wp_spatialtree_create_usrname" name="wp_spatialtree_create_usrname" onblur="check_usrname()"><span class="wp_spatialtree_info" id="wp_spatialtree_usrname_info" style="display:none;color:red;"></span><br/>
        <span class="wp_spatialtree_create_span">Email: </span><input type="text" id="wp_spatialtree_create_email" name="wp_spatialtree_create_email" onblur="check_email()"><span class="wp_spatialtree_info" id="wp_spatialtree_create_email_info" style="display:none;color:red;"></span><br/>
        <span class="wp_spatialtree_create_span">Password: </span><input type="password" id="wp_spatialtree_create_pwd" name="wp_spatialtree_create_pwd" onblur="check_pwd()"><span class="wp_spatialtree_info" id="wp_spatialtree_create_pwd_info" style="display:none;color:red;"></span><br/>
        <span class="wp_spatialtree_create_span">Confirm Password: </span><input type="password" id="wp_spatialtree_create_cpwd" name="wp_spatialtree_create_cpwd" onblur="check_confirmPwd()"><span class="wp_spatialtree_info" id="wp_spatialtree_create_cpwd_info" style="display:none;color:red;"></span><br/>
        <input type="checkbox" id="wp_spatialtree_create_cb" name="wp_spatialtree_create_cb">I have read and agree with the Terms of Use.<span class="wp_spatialtree_info" id="wp_spatialtree_create_cb_info" style="display:none;color:red;"></span><br/>
        <input type="button" class="button-primary" value="Register" onclick="wp_spatialtree_new_account()">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button-primary" value="Cancel" onclick="wp_spatialtree_new_account_cancel()">
    </div>
    <?php
    
}

function wp_spatialtree_settings_settings_page() { ?>
    <div class="wrap wp_spatialtree">
		<form method="post" action="options.php" name="wp_auto_commenter_form" id="spatialtree_save_credentials_form">
			<?php settings_fields('wp_spatialtree_options'); ?>
			<div id="poststuff" class="metabox-holder no-right-sidebar mobile-site-plugin">
				<div id="post-body" class="no-sidebar">				
					<div id="post-body-content" class="no-sidebar-content">
						<?php do_settings_sections('wp-spatialtree-settings'); ?>
					</div>
				</div>
				<br class="clear"/>			
			</div>
			<?php
			wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
			wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
			?>
			<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/spatialtree/assets/js/jquery.fittext.js"></script>
			<script type="text/javascript">
			var xmlhttp;
			jQuery(document).ready( function($) {
				$('#wp_spatialtree_options_username').keypress(function(e)
				{
					var key = e.which;
					if(key == 13)
					{
						spatialtree_checkCredentials();
					}
				}
					);
					$('#wp_spatialtree_options_password').keypress(function(e)
				{
					var key = e.which;
					if(key == 13)
					{
						spatialtree_checkCredentials();
					}
				}
					);
                $('#wp_spatialtree_create_account').hide();
				$('.article-panel').each(function()
				{
                    var title = $(this).find('.article-title').html();
					if(title.length < 35)
					{
						$(this).fitText(1.8);
					}else
					{
						$(this).fitText(1.8 + (title.length - 35)/100.0);
					}
                    
				});
				jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				try{
					postboxes.add_postbox_toggles('wp-spatialtree-settings');	
				}catch(err){
				}
			});		
					
			
			function spatialtree_checkCredentials()
			{
				var email = document.getElementById("wp_spatialtree_options_username").value;
				var pwd = document.getElementById("wp_spatialtree_options_password").value;
				if(window.XMLHttpRequest) {
        	xmlhttp = new XMLHttpRequest();
        	if(xmlhttp.overrideMimeType) {
        	    xmlhttp.overrideMimeType("text/html");
        	}
    	  }else if(window.ActiveXObject){
        	var activeName = ["MSXML2.XMLHTTP","Microsoft.XMLHTTP"];
        	for(var i=0;i>activeName.length();i++) {
        	      try{
        	          xmlhttp = new ActiveXObject(activeName[i]);
        	          break;
        	      }catch(e){
        	      }
        	}
    	  }
    	  xmlhttp.onreadystatechange=spatialtree_callback;
    	  var url = config.apiServerAddr+"/api/checkUser";
                console.log(url);
    	  xmlhttp.open("POST",url,true);
    	  xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    	  xmlhttp.send("username="+email+"&password="+pwd);
			}
			
			function openNewWindow(url)
			{
				var host = "http://www.spatialtree.com:3001";
				window.open(host+url,"_blank");
			}
			
			
			function spatialtree_callback(data)
			{
				if(xmlhttp.readyState == 4) {
					if(xmlhttp.status == 200) {
						var json = eval('(' + xmlhttp.responseText + ')'); 
                        var email = document.getElementById("wp_spatialtree_options_username").value;
                        var pwd = document.getElementById("wp_spatialtree_options_password").value;
                        
						if(json.result == "OK")
						{
                            document.getElementById("wp_spatialtree_options_password").value = json.pwd;
							document.getElementById("spatialtree_save_credentials_form").submit();
//							do_action("admin_init");
						}
                        else if(!email && ! pwd){
							document.getElementById("spatialtree_save_credentials_form").submit();
                        }
                        else
						{
							var visualizationList = document.getElementById("wp_spatialtree_data_visualizations");
							var parentNode = document.getElementById("normal-sortables");
							var articlesNode = document.getElementById("wp_spatialtree_articles");
							if(visualizationList)
							{
								parentNode.removeChild(visualizationList);
							}
							if(articlesNode)
							{
								parentNode.removeChild(articlesNode);
							}
							document.getElementById("verification_information").style.display="inline";
							document.getElementById("verification_information").innerHTML=json.message+'   Please verify your login credentials from <a href="http://www.spatialtree.com:3001/login" target="_blank">www.spatialtree.com</a>';
							document.getElementById("spatialtree_save_credentials_form").submit();
						}
					}
				}
			}
			function create_post(id)
			{
				var url="<?php echo $_SERVER[PHP_SELF];?>?page=wp-spatialtree-settings&wp_spatialtree_action=create&wp_spatialtree_article_id="+id;
				window.open(url, "_self");
			}
			
			//page break
			function pageClick(pageNum)
			{
				var url="<?php echo $_SERVER[PHP_SELF];?>?page=wp-spatialtree-settings&pageNum="+pageNum;
				window.open(url, "_self");
			}
            
            // check username
            function check_usrname()
            {
                var usrname = jQuery('#wp_spatialtree_create_usrname').val();
                if(usrname.replace(/^ +| +$/g,'')=='')
                {
                    jQuery('#wp_spatialtree_usrname_info').text('Please fill out this field');
                    jQuery('#wp_spatialtree_usrname_info').show();
                }else
                {
                    jQuery('#wp_spatialtree_usrname_info').hide();
                }
            }
            
            //check email
            function check_email()
            {
                var email = jQuery('#wp_spatialtree_create_email').val();
                if(email.replace(/^ +| +$/g,'')=='')
                {
                    jQuery('#wp_spatialtree_create_email_info').text('Please fill out this field');
                    jQuery('#wp_spatialtree_create_email_info').show();
                }else
                {
                    var pattern =   new RegExp(/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]+$/);
                    if(!pattern.test(email))
                    {
                        jQuery('#wp_spatialtree_create_email_info').text('invalid email address');
                        jQuery('#wp_spatialtree_create_email_info').show();
                    }else
                    {
                        jQuery('#wp_spatialtree_create_email_info').hide();
                    }
                }
            }
            
            function check_pwd()
            {
                var pwd = jQuery('#wp_spatialtree_create_pwd').val();
                if(pwd.replace(/^ +| +$/g,'')=='')
                {
                    jQuery('#wp_spatialtree_create_pwd_info').text('Please fill out this field');
                    jQuery('#wp_spatialtree_create_pwd_info').show();
                }else
                {
                    jQuery('#wp_spatialtree_create_pwd_info').hide();
                }
            }
            
            function check_confirmPwd()
            {
                var pwd = jQuery('#wp_spatialtree_create_pwd').val();
                var confirmPwd = jQuery('#wp_spatialtree_create_cpwd').val();
                if(confirmPwd != pwd)
                {
                    jQuery('#wp_spatialtree_create_cpwd_info').text('Must match password entered above');
                    jQuery('#wp_spatialtree_create_cpwd_info').show();
                }else
                {
                    jQuery('#wp_spatialtree_create_cpwd_info').hide();
                }
            }
                
            //register
            function wp_spatialtree_new_account()
            {
                check_usrname();
                check_email();
                check_pwd();
                check_confirmPwd();
                if(jQuery('#wp_spatialtree_usrname_info').css('display') == 'none' && jQuery('#wp_spatialtree_create_email_info').css('display') == 'none' && jQuery('#wp_spatialtree_create_pwd_info').css('display') == 'none' && jQuery('#wp_spatialtree_create_cpwd_info').css('display') == 'none' && jQuery('#wp_spatialtree_create_cb').is(':checked'))
                {
                    jQuery('#wp_spatialtree_create_cb_info').hide();
                    jQuery.post(config.webServerAddr+'/registerFromWordpress',
                                {
                                    email:jQuery('#wp_spatialtree_create_email').val(),
                                    username:jQuery('#wp_spatialtree_create_usrname').val(),
                                    'reg-password':jQuery('#wp_spatialtree_create_pwd').val()
                                }, function(data,status){
                                    console.log(data);
                                    console.log(data.result);
                                    console.log(data.area);
                                    if(data.result == 'error')
                                    {
                                        if(data.area == 'email')
                                        {
                                            jQuery('#wp_spatialtree_create_email_info').text(data.message);
                                            jQuery('#wp_spatialtree_create_email_info').show();
                                        }else if(data.area == 'username')
                                        {
                                            jQuery('#wp_spatialtree_usrname_info').text(data.message);
                                            jQuery('#wp_spatialtree_usrname_info').show();
                                        }else if(data.area == 'general')
                                        {
                                            alert(data.message);
                                        }
                                    }else if(data.result == 'successful')
                                    {
                                        jQuery('#wp_spatialtree_options_username').val(jQuery('#wp_spatialtree_create_email').val());
                                        jQuery('#wp_spatialtree_options_password').val(data.pwd);
                                        document.getElementById("spatialtree_save_credentials_form").submit();
                                    }
                                },'json');
                }else if(!jQuery('#wp_spatialtree_create_cb').is(':checked'))
                {
                    jQuery('#wp_spatialtree_create_cb_info').text('Please check the checkbox above');
                    jQuery('#wp_spatialtree_create_cb_info').show();
                }
            }
                function createAccount()
                {
                    jQuery('#wp_spatialtree_create_account').show();
                    if(jQuery('#wp_spatialtree_articles'))
                    {
                         jQuery('#wp_spatialtree_articles').hide();
                    }
                    jQuery('#wp_spatialtree_credentials').hide();
                }
                function wp_spatialtree_new_account_cancel()
                {
                    var url="<?php echo $_SERVER[PHP_SELF];?>?page=wp-spatialtree-settings";
				    window.open(url, "_self");
                }
			</script>
		</form>
    </div>
<?php
}

function wp_spatialtree_settings_section_text() {
	do_meta_boxes('wp_spatialtree_settings_main', 'normal', null);
}

function wp_spatialtree_credentials_content($post, $data) {
	$options = get_option('wp_spatialtree_options');
	echo  wp_spatialtree_get_control('text', 'Username', 'wp_spatialtree_options_username', 'wp_spatialtree_options[username]', $options['username']);
	echo  wp_spatialtree_get_control('password', 'Password', 'wp_spatialtree_options_password', 'wp_spatialtree_options[password]', '00000000');
	if($options['username'] == '' || $options['password'] == '') {
		echo '<small id="verification_information">Please enter your login credentials from <a href="http://www.spatialtree.com:3001" target="_blank">www.spatialtree.com</a></small>';
	} else if($data['args']['result'] == 'Error') {
		echo '<small id="verification_information">'.$data['args']['message'].' Please verify your login credentials from <a href="http://www.spatialtree.com:3001" target="_blank">www.spatialtree.com</a></small>';
	} else
	{
		echo '<small id="verification_information"></small>';
	}
	echo '<p class="submit"><input type="button" name="Submit" class="button-primary" value="Create Account" onclick="createAccount()" /></p><p class="submit"><input type="button" name="Submit" class="button-primary" value="Login" onclick="spatialtree_checkCredentials()" /></p><div style="clear: both;"></div>';
}

function wp_spatialtree_articles_content($post, $data) {
	if($data['args'] != false && is_array($data['args']['articles'])) {
		echo '<div>';
		foreach($data['args']['articles'] as $article) {
			echo '<div class="article-panel-container">';
				echo '<div class="dummy"></div>';
				echo '<div class="article-panel" id="article'.$article['_id'].'">';
					echo '<div class="article-title-div">';
						echo '<div class="article-centerer">';
						$url= $article['url'];
							echo '<h2 style="margin-top:2px;line-height:1em" class="article-title" onclick="openNewWindow(\''.$url.'\')">'.$article['title'].'</h2>';
						echo '</div>';
					echo '</div>';
					echo '<div class="cropper">';
					$src = "";
					if($article['image'] != null)
					{
						$src = $article['image'];
					}
					if($src != "")
					{
						echo '<img class="article-image" src="'.$src.'">';
					}else
					{
						echo '<img class="article-image">';
					}
					echo '</div>';
					echo '<div class="article-footer">';
						echo '<a class="button-secondary" onclick="create_post(\''.$article['_id'].'\')">Create Post</a>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
            }
		echo '<div id="pageBreak" class="page">';
		echo '</div>';
		echo '</div>';
	} else {
		echo '<p>No Articles Found!</p>';
	}
	echo "<script LANGUAGE='javascript'>setPage(document.getElementById('pageBreak'),".$data['args']['count'].",".$data['args']['page'].");</script>";
}

function wp_spatialtree_data_visualizations_content($post, $data) {
	if($data['args'] != false && is_array($data['args'])) {
		echo '<table class="widefat" cellpadding="10" cellspacing="10">';
			echo '<thead>';
				echo '<tr>';
					echo '<th>Data</th>';
					echo '<th style="text-align: center;">Action</th>';
				echo '</tr>';
			echo '</thead>';
			$index = 0;
			foreach($data['args'] as $visualization) {
				echo '<tr '.(($index % 2 != 0)?'class="alternate"':'').'>';
					echo '<td style="width: 80%;">'.$visualization['title'].'</td>';
					echo '<td style="text-align: center;"><a class="button-secondary" onclick="javascript:tb_show(\'Spatial Tree : View Visualization\', \''.WP_PLUGIN_URL.'/spatialtree/settings/show-visualization-popup.php?wp_spatialtree_visualization_id='.$visualization['id'].'&TB_iframe=true&width=\'+parseInt(jQuery(window).width() * 0.8)+\'&height=\'+parseInt(jQuery(window).height() * 0.8));">View Visualization</a></td>';
				echo '</tr>';
				$index++;
			}
			echo '<tfoot>';
				echo '<tr>';
					echo '<th>Data</th>';
					echo '<th style="text-align: center;">Action</th>';
				echo '</tr>';
			echo '</tfoot>';
		echo '</table>';
	} else {
		echo '<p>No Articles Found!</p>';
	}
}

add_action('init', 'wp_spatialtree_actions_init');
function wp_spatialtree_actions_init() {
	if(isset($_GET['wp_spatialtree_action']) && $_GET['wp_spatialtree_action'] == 'create' && isset($_GET['wp_spatialtree_article_id'])) {
		$data = wp_spatialtree_get_article_content($_GET['wp_spatialtree_article_id']);
		if($data != false) {
			if($data[0]['title'] == null && $data[0]['content'] == null)
			{
				wp_redirect(admin_url('post-new.php'));
			die();
			}else
			{
				$title = "";
				$content = "";
				if($data[0]['title'] != null)
				{
					$title = strtoupper(wp_strip_all_tags($data[0]['title']));
				}
				if($data[0]['content'] != null)
				{
					$content = $data[0]['content'];
				}
			$articleID = wp_insert_post(
				array(
					'post_type' => 'post',
					'post_title' => $title,
					'post_content' => $content,
					'post_status' => 'draft'
				)
			);
			wp_redirect(admin_url('post.php?post='.$articleID.'&action=edit'));
			die();
		}
		}
	}
}

?>