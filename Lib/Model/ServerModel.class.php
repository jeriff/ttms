<?php

class ServerModel extends Model {

    function getServerip() {
        $sql = "select distinct server_ip from ttms_server ";
        $server = $this->query($sql);
        foreach ($server as $key => $value) {
            $server_ip[$server[$key]['server_ip']] = $server[$key]['server_ip'];
        }
        return $server_ip;
    }

    function getServerid($map) {
        $sql = "select server_id from ttms_server where server_ip='" . $map . "'";
        $server = $this->query($sql);
        $server_ip = $server['0']['server_id'];
        return $server_ip;
    }
    
     public function getServer2($map) {
        $array = array('server_ip');
        $model = M('Server');
        $server = $model->field($array)->where($map)->order('server_id DESC')->select();
        return array('list' => $server);
    }

    public function getServer($map) {

        import("@.ORG.Page"); //导入分页类 
        $array = array('server_id', 'server_ip', 'server_name', 'server_type', 'server_site','server_status', 'server_info', 'server_remark', 'created_by', 'modified_by');
        $model = M('Server');
        $count = $model->where($map)->count();
        $page = new Page($count, 20);
        $show = $page->show();
        $server = $model->field($array)->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('server_id DESC')->select();
        return array('list' => $server, 'show' => $show);
    }

    public function getServerbyid($server_id) {
        $model = M('Server');
        $array = array('server_id', 'server_ip', 'server_name', 'server_type', 'server_site','server_status', 'server_info', 'server_remark', 'created_by', 'modified_by');
        $condition['server_id'] = $server_id;
        $server = $model->field($array)->where($condition)->select();
        return $server['0'];
    }

}

?>