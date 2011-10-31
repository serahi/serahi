{block name=title}
ورود به سیستم‌
{/block}

{block name=main_content}

<div id="login_form">
   
    <?php
    
    	$attributes = array('class' => 'forms');
        echo form_open('user/login/login_check',$attributes);
        ?>
        <div class='error_msg'>
            <?php
            if( isset($error_msg) ){
                echo "<div> $error_msg </div>";
            }
            ?> 
        </div>
        <?php
        if( !isset($entered_username)){
            echo form_input('username', 'نام کاربری','id="username" class="check"' );
        }else{
            echo form_input('username', $entered_username,'id="username" class="check"' );
        }
        echo form_input('password', 'رمز عبور', 'id="password" class="pass check"');
        echo form_submit('submit', 'ورود');
        echo "<br/>";
        echo '<div id="register_msg">'. "اگر تاکنون در سایت ثبت نام ننموده‌اید از اینجا ثبت نام کنید". '<br/>' . anchor('login/sign_up', 'ثبت نام در سایت','id="register_btm"') . "</div>";
        ?>
        
           
    <?php echo form_close(); ?>
</div>

{/block}