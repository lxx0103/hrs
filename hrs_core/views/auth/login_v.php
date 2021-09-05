<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Matrix Admin</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/assets/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="/assets/css/matrix-login.css" />
        <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    </head>
    <body>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical" action="/auth/login" method="POST">
                 <div class="control-group normal_text"> <h3><img src="/assets/img/logo.png" alt="考勤管理系统" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" name="username" placeholder="用户名" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="密码" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-right"><button type="submit" class="btn btn-success" /> 登录</button></span>
                </div>
            </form>
        </div>
        
        <script src="/assets/js/jquery.min.js"></script>  
        <script src="/assets/js/matrix.login.js"></script> 
    </body>

</html>
