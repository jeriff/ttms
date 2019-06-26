<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionAction
 *
 * @author Michael.shi
 */
require_once './Common/enumeration.class.php';
header("Content-type: text/html; charset=utf-8");
import("@.ORG.User");

class QuestionAction extends Action {

    public function index() {
        
        $enum = new Enumeration();
        $fields = "project_name,log_type,question_type,report_party,blame";
        unset($_REQUEST['__hash__']);
        foreach ($_REQUEST as $key => $val) {
            //if (in_array($key,$fields)) {
            if (isset($_REQUEST[$key]) && !empty($_REQUEST[$key])) {
                if ($key == 'project_name') {
                    $map[$key] = array('like', '%' . trim($_REQUEST[$key]) . '%');
                } else {
                    $map[$key] = trim($_REQUEST[$key]);
                }
            }
            //}
        }
        $list = D('question')->get_question($map);
        $this->list = $list['list'];
        $this->page = $list['show'];
        $this->project_name = $_REQUEST['project_name'];
        $this->log_type = $enum->get_select(C('ec_question.log_type'), 'log_type', 'log_type', $_GET['log_type'], $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->question_type = $enum->get_select(C('ec_question.question_type'), 'question_type', 'question_type', $_GET['question_type'], $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->report_party = $enum->get_select(C('ec_question.report_party'), 'report_party', 'report_party', $_GET['report_party'], $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->blame = $enum->get_select(C('ec_question.blame'), 'blame', 'blame', $_GET['blame'], $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('menu_name', 'icon_11');
        $this->display();
    }

    public function add() {
        $enum = new Enumeration();
        $project_array = M('project')->field('project_id,project_name')->findAll();
        foreach ($project_array as $key => $value) {
            $project_arr[$value['project_name']] = $value['project_name'];
        }
        $this->project = $project = $enum->get_radio($project_arr, 'project_name', 'project_name', '', $size = 9, '', $class = '', $ext = '', $gettype = 2);
        $this->log_type = $enum->get_radio(C('ec_question.log_type'), 'log_type', 'log_type', '', $size = 5, '', $class = '', $ext = '', $gettype = 2);
        $this->question_type = $enum->get_radio(C('ec_question.question_type'), 'question_type', 'question_type', '', $size = 5, '', $class = '', $ext = '', $gettype = 2);
        $this->report_party = $enum->get_radio(C('ec_question.report_party'), 'report_party', 'report_party', '', $size = 5, '', $class = '', $ext = '', $gettype = 2);
        $this->blame = $enum->get_radio(C('ec_question.blame'), 'blame', 'blame', '', $size = 5, '', $class = '', $ext = '', $gettype = 2);
        $user_array = M('user')->field('userid,username')->findAll();
        foreach ($user_array as $k => $v) {
            $use_arr[$v['username']] = $v['username'];
        }
        $this->user_array = $enum->get_radio($use_arr, 'process_user', 'process_user', '', $size = 5, '', $class = '', $ext = '', $gettype = 2);
        $this->a = 'add';
        $this->assign('menu_name', 'icon_11');
        $this->display();
    }

    public function insert() {
        unset($_POST['submit']);
        $question = D('question');
        $data = $_POST;
        $data['follow_user'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
        $data['created_user'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
        $data['caeated_time'] = date('Y-m-d H:i:s');

        if (isset($_FILES['attachment']) && !empty($_FILES['attachment']['name'])) {
            $filename = $question->upload($_FILES['attachment']);
            $data['attachment'] = $filename;
        }

        $str = $question->add($data);
        if ($str) {
            die("<script>alert('项目日志添加成功');window.location='?m=question&a=index';</script>");
        }
    }

    public function edit() {
        $enum = new Enumeration();
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $map['id'] = $id;
            $list = D('question')->get_question($map);
            $project_array = M('project')->field('project_id,project_name')->findAll();
            foreach ($project_array as $key => $value) {
                $project_arr[$value['project_name']] = $value['project_name'];
            }
            $this->project = $project = $enum->get_radio($project_arr, 'project_name', 'project_name', $list['list']['0']['project_name'], $size = 9, '', $class = '', $ext = '', $gettype = 2);
            $this->log_type = $enum->get_radio(C('ec_question.log_type'), 'log_type', 'log_type', $list['list']['0']['log_type'], $size = 5, '', $class = '', $ext = '', $gettype = 2);
            $this->question_type = $enum->get_radio(C('ec_question.question_type'), 'question_type', 'question_type', $list['list']['0']['question_type'], $size = 5, '', $class = '', $ext = '', $gettype = 2);
            $this->report_party = $enum->get_radio(C('ec_question.report_party'), 'report_party', 'report_party', $list['list']['0']['report_party'], $size = 5, '', $class = '', $ext = '', $gettype = 2);
            $this->blame = $enum->get_radio(C('ec_question.blame'), 'blame', 'blame', $list['list']['0']['blame'], $size = 5, '', $class = '', $ext = '', $gettype = 2);
            $this->model = $list['list']['0'];

            $user_array = M('user')->field('userid,username')->findAll();
            foreach ($user_array as $k => $v) {
                $use_arr[$v['username']] = $v['username'];
            }
            $this->user_array = $enum->get_radio($use_arr, 'process_user', 'process_user', $list['list']['0']['process_user'], $size = 5, '', $class = '', $ext = '', $gettype = 2);
            $this->a = 'edit';
            $this->assign('menu_name', 'icon_11');
        }
        $this->display();
    }

    public function update() {
        unset($_POST['submit']);
        $question = D('question');
        $data = $_POST;
        $data['modified_user'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
        $data['modified_time'] = date('Y-m-d H:i:s');
        if (isset($_FILES['attachment']) && !empty($_FILES['attachment']['name'])) {
            $filename = $question->upload($_FILES['attachment']);
            $data['attachment'] = $filename;
        }
        $str = $question->save($data);
        if ($str) {
            die("<script>alert('项目日志编辑成功');window.location='?m=question&a=index';</script>");
        }
    }

    public function delete() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $where['id'] = $id;
            $str = M('question')->where($where)->delete();
            if ($str) {
                die("<script>alert('项目日志删除成功');window.location='?m=question&a=index';</script>");
            }
        }
    }


    public function export() {
        $question = D('question');
        if(empty($_POST['begin_time']) || empty($_POST['begin_time'])) {
            die("<script>alert('请选择导出时间');window.location='?m=question&a=index';</script>");
        }
        $map['report_date'] = array('between', '"' . $_POST['begin_time'] . '","' . $_POST['end_time'] . '"');
        $field='project_name,log_type,question_type,report_party,report_date,report_user,question_contetn,affect,blame,reason,countermeasure,process_time,remark,follow_user,process_user,time,attachment';
        $data[0]=$question->getHeaderArray('1');
        $question_list = $question->where($map)->order('report_date desc')->field($field)->select();
        if(!$question_list){
            die("<script>alert('没有要导出的数据');window.location='?m=question&a=index';</script>");
        }
        $log_type=C('ec_question.log_type');
        $question_type=C('ec_question.question_type');
        $report_party=C('ec_question.report_party');
        $blame=C('ec_question.blame');
        if(is_array($question_list)){
            foreach($question_list as $key=>$value){
                $data[$key+1]=$value;
                $data[$key+1]['log_type']=$log_type[$value['log_type']];
                $data[$key+1]['question_type']=$question_type[$value['question_type']];
                $data[$key+1]['report_party']=$report_party[$value['report_party']];
                $data[$key+1]['blame']=$blame[$value['blame']];
            }
        }
        $res=D('report')->export($data,'Public/Attachment/export/');
        //dump($res);
        if($res['status']==1){

            $url=$res['url'];
            die("<script>window.location='$url';</script>");
        }
        
    }

}

?>
