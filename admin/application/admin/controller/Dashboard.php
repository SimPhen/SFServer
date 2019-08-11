<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Config;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {
        $list = model("detail")->select();

        $offday = 6;
        $seventtime = \fast\Date::unixtime('day',-$offday);
        $paylist = $createlist = [];
        for ($i = 0; $i <= $offday; $i++)
        {
            $day = date("Y-m-d", $seventtime + ($i * 86400));
            $tmp = 0;
            foreach($list as $key=>$user){
                if($user["date"]==$day){
                    $tmp = $tmp + $user["time"];
                };
            };
            $createlist[$day] = 20000;//mt_rand(5000, 10000);
            $paylist[$day] = $tmp;//mt_rand(5000, 10000);//mt_rand(1, mt_rand(1, $createlist[$day]));
        }
        $hooks = config('addons.hooks');
        $uploadmode = isset($hooks['upload_config_init']) && $hooks['upload_config_init'] ? implode(',', $hooks['upload_config_init']) : 'local';
        $addonComposerCfg = ROOT_PATH . '/vendor/karsonzhang/fastadmin-addons/composer.json';
        Config::parse($addonComposerCfg, "json", "composer");
        $config = Config::get("composer");
        $addonVersion = isset($config['version']) ? $config['version'] : __('Unknown');

        //访问总次数
        $time = 0;
        foreach($list as $key=>$user){
          $time = $user["time"] + $time;
        }

        $this->view->assign([
            'totaluser'        => 35200,
            'totalviews'       => $time,
            'totalorder'       => 32143,
            'totalorderamount' => 174800,
            'todayuserlogin'   => 321,
            'todayusersignup'  => 430,
            'todayorder'       => 2324,
            'unsettleorder'    => 132,
            'sevendnu'         => '80%',
            'sevendau'         => '32%',
            'paylist'          => $paylist,
            'createlist'       => $createlist,
            'addonversion'       => $addonVersion,
            'uploadmode'       => $uploadmode
        ]);
        return $this->view->fetch();
    }

    public function test(){
        $from = $this->request->post("from");
        $to   = $this->request->post("to");
        $fromD   = $this->request->post("fromD");
        $off   = $this->request->post("off");

        $paylist = [];
        $list = model("detail")->select();
        $time = 0;
        for ($i = 0; $i <= $off; $i++)
        {   
            $day = date("Y-m-d",$fromD + ($i * 86400));
            $tmp = 0;
            foreach($list as $key=>$user){
                if($user["date"]==$day){
                    $tmp = $tmp + $user["time"];
                };
            };
            $paylist[$day] = $tmp;
            $time = $tmp + $time;
        };
        return array('time'=>$time,'keys'=>array_keys($paylist),'values'=>array_values($paylist));
    }

}
