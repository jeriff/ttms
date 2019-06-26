<?php

class ProjectModel extends Model {

    protected $pk = 'project_id';
    
    public function getProjectlist($map) {
        
        //import("@.ORG.Page"); //导入分页类 
		import("ORG.Util.Page");
        $project_list = M('Project');
        $count = $project_list->table(C('DB_PREFIX') . "project AS P ")
                        ->join("LEFT JOIN " . C('DB_PREFIX') . "server AS S ON P.project_server_id = S.server_id")->where($map)->count();
        $page = new Page($count,20);
        $show = $page->show();
        $map['P.project_name']=array('exp','is not NULL');
        $array = array('P.project_id,P.project_name,P.project_site,P.project_status,P.project_ontime,P.project_offlinetime,S.server_ip,P.created_by,P.modified_by');
        $projectlist = $project_list->table(C('DB_PREFIX') . "project AS P")
                        ->join("LEFT JOIN " . C('DB_PREFIX') . "server AS S ON P.project_server_id = S.server_id")->field($array)->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('project_id DESC')->select();
        //echo D('Project')->getLastSql();
        return array('list' => $projectlist, 'show' => $show);
    }
    
    public function getProjectbyid($project_id){
        $condition['project_id'] = $project_id;
        $project=M('Project')->where($condition)->select();
        $sql="select server_ip from ttms_server,ttms_project where server_id=project_server_id and project_id=".$project_id;
        $server= $this->query($sql);
        $project['0']['server_ip']=$server['0']['server_ip'];
        return $project;
    }

}

?>
