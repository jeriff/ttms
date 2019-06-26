<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionModel
 *
 * @author Michael.shi
 */
import("ORG.Net.Upload"); 
class QuestionModel extends Model {
    
    public function get_question($map){
         import("@.ORG.Page"); //导入分页类 
        $array = array('id', 'project_name', 'log_type', 'question_type', 'report_party','report_date', 'report_user', 'question_contetn', 'affect', 'blame','reason','countermeasure','process_time','remark','follow_user','process_user','time','attachment');
        $model = D('question');
		unset($map['p']);
        $count = $model->where($map)->count();
        $page = new Page($count, 20);
        $show = $page->show();
        $list = $model->field($array)->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('caeated_time DESC')->select();
        return array('list' => $list, 'show' => $show);
    }
    
    public function upload($_FILES){
        $type=  explode('.', $_FILES['name']);
        $type=$type[1];
        $new_name=date('YmdHis').'.'.$type;
        move_uploaded_file($_FILES["tmp_name"],"Public/Attachment/" .$new_name);
        return $new_name;
    }
    
    public function del_attachment(){
        
    }
    
    public function getHeaderArray($type) {
        $array[1] = array(
            'project_name' => '项目名称',
            'log_type' => '日志类型',
            'question_type' => '问题类型',
            'report_party' => '报告方',
            'report_date' => '报告时间',
            'report_user' => '报告人',
            'question_contetn' => '报告内容',
            'affect' => '影响',
            'blame'=>'责任归类',
            'reason'=>'原因',
            'countermeasure'=>'对策',
            'process_time'=>'产生工时',
            'remark'=>'备注',
            'follow_user'=>'跟进人',
            'process_user'=>'处理人',
            'time'=>'处理时间',
            'attachment'=>'附件名',
        );
        return $array[$type];
    }
   
    
}

?>
