<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:106:"C:\Users\Administrator\Desktop\wamp64\www\admin\public/../application/admin\view\project_manager\edit.html";i:1565267484;s:90:"C:\Users\Administrator\Desktop\wamp64\www\admin\application\admin\view\layout\default.html";i:1562338655;s:87:"C:\Users\Administrator\Desktop\wamp64\www\admin\application\admin\view\common\meta.html";i:1562338655;s:89:"C:\Users\Administrator\Desktop\wamp64\www\admin\application\admin\view\common\script.html";i:1562338655;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/admin/public/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/admin/public/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/admin/public/assets/js/html5shiv.js"></script>
  <script src="/admin/public/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" data-rule="required" class="form-control" name="row[name]" type="text" value="<?php echo htmlentities($row['name']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Key'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-key" data-rule="required" class="form-control" name="row[key]" type="text" value="<?php echo htmlentities($row['key']); ?>">
        </div>
        <input id="oneKey" type="button" value="一键生成" style="margin-top:3px">
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Post'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-post" class="form-control" name="row[post]" type="text" value="<?php echo htmlentities($row['post']); ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
<script>
    function RndNum(n) {
        var rnd = "";
        for (var i = 0; i < n; i++) {
            rnd += Math.floor(Math.random() * 10);
        }
        return rnd;
    }
     var keyForm = document.getElementById('c-key');
     var oneKeyBtn = document.getElementById('oneKey');
     var len = 10;
     oneKeyBtn.onclick = function() {
        keyForm.value = Math.random().toString(36).substr(2);//RndNum(len)//parseInt((Math.random() + 1) * Math.pow(10,len-1))
     }
     keyForm.value = Math.random().toString(36).substr(2);
//RndNum(len);
</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/admin/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/admin/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>