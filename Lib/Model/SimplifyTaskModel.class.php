<?php

/*
 * 	任务管理模块
 *  author:jason.guo	 
 * 	date:2012-08-25
 */

class SimplifyTaskModel extends Model {
    /*     * ************************************************************************************************************** */

    protected $TableName = 'simplify_task';
    protected $pk = 'task_id'; //定义主键
    protected $_validate = array(
        array('task_name','require','任务名称必须！'),
        array('man_day','require','工时必须！', 0, 'number'),
        array('project_id','require','所属项目必须！'),
        array('begin_time','require','任务开始时间必须！'),
        array('end_time','require','任务开始时间必须！'),
        array('task_type','require','任务类型必须！'),
        array('task_status','require','任务状态必须！'),
    );
    protected $_auto = array ( 
        array('created','getDate',1,'callback'),
        array('created_by','getUsername',1,'callback') ,
        array('modified','getDate',3,'callback'),
        array('modified_by','getUsername',3,'callback')
    );
    static function getUsername() {
        return $_COOKIE[C('COOKIE_PREFIX') . 'username'];
    }
    static function getDate() {
        return date("Y-m-d H:i:s");
    }
    static function getAdmin() {
        $userid = $_COOKIE[C('COOKIE_PREFIX') . 'userid'];
        $is_admin = D('user')->where('userid=' . $_COOKIE[C('COOKIE_PREFIX') . 'userid'])->getField("is_admin");
        return $is_admin;
    }
    static function getmenuname($k){
        $menuname=array(
           'task_type'=>'类型','task_status'=>'状态','server_type'=>'类型','server_site'=>'地址','server_status'=>'状态','project_status'=>'状态','project_type'=>'类型','project_business_type'=>'商业类型','document_type'=>'类型','document_secret'=>'机密等级','document_whole'=>'whole等级','document_use'=>'使用等级','log_type'=>'log类型','question_type'=>'问题类型','report_party'=>'汇报方','blame'=>'blame',
        );
        return isset($menuname[$k])?$menuname[$k]:$k;
    }


    /*
     * 	任务列表
     * 	$map为查询条件
     * 	返回值为查询数据的数组和分页类信息
     *  author:jason.guo	 
     * 	date:2012-08-25
     */

    public function getTaskList($map) {
        import("@.ORG.Page"); 
        $count = $this->where($map)->count();
        $page = new Page($count, 20);
        $show = $page->show();
        $fields = array('task_id', 'task_name', 'project_id', 'task_type', 'begin_time', 'end_time', 'man_day', 'task_status', 'remark', 'created', 'created_by', 'modified', 'modified_by', 'true_man_day');
        $list = $this->where($map)->field($fields)->limit($page->firstRow . ',' . $page->listRows)->order('begin_time desc')->select();
        //dump($this->getLastsql());
        //dump($list);
        $man_day = self::getMandaySum($map);
		$true_man_day = self::getTrueMandaySum($map);
        return array('list' => $list, 'show' => $show, 'man_day' => $man_day,'true_man_day'=>$true_man_day);
    }

    public function getMandaySum($map){
       return $this->where($map)->sum("man_day");
    }
    public function getTrueMandaySum($map){
       return $this->where($map)->sum("true_man_day");
    }
    /*
     * 	时间转换
     * 	$inventory_time为你要得到时间段的范围 值：day week month season year
     * 	$time传进来的时间点
     * 	根据时间点得到你要得到的时间范围
     *  author:jason.guo	 
     * 	date:2012-08-25
     */

    public function check_time($inventory_time, $time) {

        if ($inventory_time == 'day') {
            $firstday = date("Y-m-d 00:00:00", strtotime($time));
            $lastday = date("Y-m-d 23:59:59", strtotime($time));
        } else if ($inventory_time == 'week') {
            $lastday = date("Y-m-d 23:59:59", strtotime("$time Sunday"));
            $firstday = date("Y-m-d 00:00:00", strtotime("$lastday - 6 days"));
        } else if ($inventory_time == 'month') {
            $firstday = date("Y-m-01 00:00:00", strtotime($time));
            $lastday = date("Y-m-d 23:59:59", strtotime("$firstday +1 month -1 day"));
        } else if ($inventory_time == 'season') {
            $season = ceil((date('n', strtotime($time))) / 3); //当月是第几季度
            $firstday = date('Y-m-d H:i:s', mktime(0, 0, 0, $season * 3 - 3 + 1, 1, date('Y', strtotime($time))));
            $lastday = date('Y-m-d H:i:s', mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date('Y', strtotime($time)))), date('Y', strtotime($time))));
        } else if ($inventory_time == 'year') {
            $firstday = date('Y-01-01 00:00:00', strtotime($time));
            $lastday = date('Y-12-31 23:59:59', strtotime($time));
        }
        //$map = array('between', '"' . $firstday . '","' . $lastday . '"');
        $map = array(0 => $firstday, 1 => $lastday);
        return $map;
    }

}

?>