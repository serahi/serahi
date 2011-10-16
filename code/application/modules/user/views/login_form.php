{block name=main_content}

<div id="login_form">
    <h2>  ورود </h2>
    <?php
    
    
        echo form_open('user/login/login_check');
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
            echo form_input('username', 'نام کاربری','id="username"' );
        }else{
            echo form_input('username', $entered_username,'id="username"' );
        }
        echo form_password('password', 'password', 'id="password"');
        echo form_submit('submit', 'ورود');
        echo "<br/>";
        echo '<div id="register_msg">'. "اگر تاکنون در سایت ثبت نام ننموده‌اید از اینجا ثبت نام کنید". anchor('login/sign_up', 'ثبت نام در سایت','id="register_btm"') . "</div>";
        ?>
        
           
    <?php echo form_close(); ?>
</div>

{/block}