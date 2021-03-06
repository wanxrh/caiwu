<?php

/**
 * 首页模型
 * @author lin
 * @version 2016-02
 */
class Home_model extends Common_model {

	/**
	 * 继承父级构造方法
	 * 实例化两个数据库方法
	 */
	public function __construct() {
		parent::__construct();
	}
	/**
	 * [update_access 增加访问量数据]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:38:08+0800
	 * @return    [type]                   [返回影响行数]
	 */
	public function update_access(){
		$this->db->set('number', 'number+1',FALSE);
		$this->db->where(array('id'=>1))->update('dianji');
		$data=$this->db->affected_rows();
        return $data;
	}
	/**
	 * [get_information 关联表获取用户信息]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-16T16:25:26+0800
	 * @return    [type]                   [description]
	 */
	public function get_information($where){
		$sql="SELECT a.cat_id as g,b.cat_id as y,a.bumen_id as p,cat_name,c.bumen_name FROM `ab22_user_record` a LEFT JOIN `ab22_user_cat` b ON a.cat_id=b.cat_id LEFT JOIN `ab22_bumen` c  ON a.bumen_id=c.bumen_id WHERE `user_name` =  '$where'";
        $result=$this->db->query($sql)->row_array();
        return $result;
	}
	/**
	 * [user_list 用户列表]
	 * @AuthorHTL
	 * @DateTime  2016-02-23T09:10:47+0800
	 * @return    [type]                   [description]
	 */
	public function user_list($bumen_name,$keyword,$zhiyuanleixingmingcheng,$leibiemingcheng,$zhiyuanzhuangtai){

		if ($bumen_name !== '') {
            $this->db->where('user_record.bumen_name', $bumen_name);
        }
		//关键字搜索
        if ($keyword !== '') {
            $sql = "(`name` like '%{$keyword}%')";
            $this->db->where($sql);
        }
        if(!empty($zhiyuanleixingmingcheng)){
            $this->db->where('user_record.zhiyuanleixingmingcheng', $zhiyuanleixingmingcheng);
        }
        if(!empty($leibiemingcheng)){
            $this->db->where('user_record.leibiemingcheng', $leibiemingcheng);
        }
        if(!empty($zhiyuanzhuangtai)){
            $this->db->where('user_record.zhiyuanzhuangtai', $zhiyuanzhuangtai);
        }
        $temp = clone $this->db;
		$data['count'] = $this->db->select('user_cat.*,bumen_name,user_id,user_name,password,name,zhiyuandaima,zhiyuanleixingmingcheng,leibiemingcheng,zhiyuanzhuangtai')->join('user_cat', 'user_record.cat_id=user_cat.cat_id', 'left')->from('user_record')->count_all_results();
        //echo $this->db->last_query();exit;
		$this->db = $temp;
        $data['user'] = $this->db->select('user_cat.*,bumen_name,user_id,user_name,password,name,zhiyuandaima,zhiyuanleixingmingcheng,leibiemingcheng,zhiyuanzhuangtai')->join('user_cat', 'user_cat.cat_id=user_record.cat_id', 'left')->get('user_record', $this->per_page, $this->offset)->result_array();

        return $data;
	}
	public function user_field(){
		$sql="SHOW  full COLUMNS FROM ab22_user_record where Comment!=''";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	public function user_type(){
		return $this->db->select('*')->get('user_cat')->result_array();

	}
	public function sqlQuery($sql){
		$result=$this->db->query($sql);
		//echo $this->db->last_query();exit;
		return $result;
	}
	public function sqlQueryRow($sql){
		return $this->db->query($sql)->row_array();
		//echo $this->db->last_query();exit;

	}
	public function sqlQueryArray($sql){
		return $this->db->query($sql)->result_array();
	}
	public function wagesList($columns,$dyn,$start,$end,$add_time,$gongzileixing,$name,$select,$input,$zhiyuandaima,$bumen_name){
        $start = date("Y-m",strtotime($start));
        $end = date("Y-m",strtotime($end));
		if($start && !$end && empty($add_time)){
			$this->db->where('gongzibiao.nianyue >=',$start);
		}elseif (!$start && $end && empty($add_time)){
			$this->db->where('gongzibiao.nianyue <=',$end);
		}elseif ($start && $end && empty($add_time)){
			if($start > $end) $this->db->where('gongzibiao.nianyue >=',$start);
			if($start <= $end){/*echo $start.','.$end;*/
				$this->db->where('gongzibiao.nianyue >=',$start);
				$this->db->where('gongzibiao.nianyue <=',$end);
			}
		}
        if(!empty($add_time)){
            $add_time = strtotime($add_time);
            $add_time_end = $add_time+86400;
            $this->db->where('gongzibiao.add_time >=',$add_time);
            $this->db->where('gongzibiao.add_time <=',$add_time_end);
        }
		if($gongzileixing&&$gongzileixing!='综合' && empty($add_time)){
			$this->db->where('gongzibiao.gongzileixing',$gongzileixing);
		}
		
		if($select && empty($add_time)){
			foreach ($select as $k=>$v){
				if( $v!=''){
					$this->db->where($k,$v);
				}
			}
		}
		if($input && empty($add_time)){
			foreach ($input as $k=>$v){
				if( $v ){
					$this->db->like($k,trim($v));
				}
			}
		}	
		if($zhiyuandaima && empty($add_time)){
			$this->db->where('user_record.zhiyuandaima',$zhiyuandaima);
		}
		if($name && empty($add_time)){
			$this->db->where('user_record.name',$name);
		}
        if(!empty($bumen_name) && empty($add_time)){
            $this->db->where('gongzibiao.bumen_name',$bumen_name);
        }
		$clone = clone( $this->db );
		$syn_clone = clone( $this->db );
		$this->db->select('user_record.user_name,gongzibiao.*')->join('user_record','user_record.user_id = gongzibiao.user_id','left');
		$data['list'] = $this->db->order_by('gongzibiao.id','desc')->get('gongzibiao', $this->per_page, $this->offset)->result_array();
		//echo $this->db->last_query();exit;
		$this->db = $clone;
		$data['count'] = $this->db->from('gongzibiao')->join('user_record','user_record.user_id = gongzibiao.user_id','left')
->count_all_results();
		//统计
		$unset = array('id','user_id','nianyue','add_time');
        $str = '';
		foreach ($columns as $k => $v){
			if(in_array($v['COLUMN_NAME'],$unset)){
				continue;
			}
			if(isset($dyn[$v['COLUMN_NAME']])){
				if(!$dyn[$v['COLUMN_NAME']]['options'] && $dyn[$v['COLUMN_NAME']]['view'] && ( $v['DATA_TYPE'] == 'int' || $v['DATA_TYPE'] == 'decimal' ) ){
					$data['dyn_page'][$v['COLUMN_NAME']] = array_sum(array_column($data['list'],$v['COLUMN_NAME']) );
					$this->db = $syn_clone;
					$syn_clone = clone ($this->db );
					//$alls = $this->db->select_sum($v['COLUMN_NAME'])->join('user_record','user_record.user_id = gongzibiao.user_id','left')->join('bumen','user_record.bumen_id = bumen.bumen_id','left')->get('gongzibiao')->row_array();
					//$data['dyn_all'][$v['COLUMN_NAME']] = $alls[$v['COLUMN_NAME']];
                    $str.= "sum(".$v['COLUMN_NAME'].") as {$v['COLUMN_NAME']},";
                    //echo $this->db->last_query();exit;
				}else{
					$data['dyn_page'][$v['COLUMN_NAME']] = '';
					//$data['dyn_all'][$v['COLUMN_NAME']] = '';
				}
			}
		}

        //print_r($data['dyn_all']);exit;
        $str = substr($str,0,-1);
        $alls = $this->db->select($str)->get('gongzibiao')->row_array();
        foreach($alls as $k=>$vc){
            foreach ($columns as $k => $v2) {
                if (in_array($v2['COLUMN_NAME'], $unset)) {
                    continue;
                }
                if (isset($dyn[$v2['COLUMN_NAME']])) {
                    if (!$dyn[$v2['COLUMN_NAME']]['options'] && $dyn[$v2['COLUMN_NAME']]['view'] && ($v2['DATA_TYPE'] == 'int' || $v2['DATA_TYPE'] == 'decimal')) {
                        $data['dyn_all'][$v2['COLUMN_NAME']] = $alls[$v2['COLUMN_NAME']];
                    } else {
                        $data['dyn_all'][$v2['COLUMN_NAME']] = '';
                    }
                }

            }
        }
        //print_r($data['dyn_all']);exit;
		return $data;
	}
    //导出csv专用
    public function wagesList_export($columns,$dyn,$start,$end,$add_time,$gongzileixing,$name,$select,$input,$zhiyuandaima,$bumen_name){
        $start = date("Y-m",strtotime($start));
        $end = date("Y-m",strtotime($end));
        if($start && !$end){
            $this->db->where('gongzibiao.nianyue >=',$start);
        }elseif (!$start && $end){
            $this->db->where('gongzibiao.nianyue <=',$end);
        }elseif ($start && $end){
            if($start > $end) $this->db->where('gongzibiao.nianyue >=',$start);
            if($start <= $end){/*echo $start.','.$end;*/
                $this->db->where('gongzibiao.nianyue >=',$start);
                $this->db->where('gongzibiao.nianyue <=',$end);
            }
        }
        if(!empty($add_time)){
            $add_time = strtotime($add_time);
            $this->db->where('gongzibiao.add_time >=',$add_time);
        }
        if($gongzileixing&&$gongzileixing!='综合'){
            $this->db->where('gongzibiao.gongzileixing',$gongzileixing);
        }

        if($select){
            foreach ($select as $k=>$v){
                if( $v!=''){
                    $this->db->where($k,$v);
                }
            }
        }
        if($input){
            foreach ($input as $k=>$v){
                if( $v ){
                    $this->db->like($k,trim($v));
                }
            }
        }
        if($zhiyuandaima){
            $this->db->where('user_record.zhiyuandaima',$zhiyuandaima);
        }
        if($name){
            $this->db->where('user_record.name',$name);
        }
        if(!empty($bumen_name)){
            $this->db->where('gongzibiao.bumen_name',$bumen_name);
        }
        $this->db->select('user_record.user_name,gongzibiao.*')->join('user_record','user_record.user_id = gongzibiao.user_id','left');
        $data['list'] = $this->db->order_by('gongzibiao.id','desc')->get('gongzibiao')->result_array();
        //echo $this->db->last_query();exit;
        return $data;
    }

    //用户列表
    public function uList($columns,$dyn,$name,$select,$zhiyuandaima){

        if($select){
            $this->db->where('bumen_name',$select);
        }
        if($zhiyuandaima){
            $this->db->where('user_record.zhiyuandaima',$zhiyuandaima);
        }
        if($name){
            $this->db->where('user_record.name',$name);
        }
        $clone = clone( $this->db );
        //$syn_clone = clone( $this->db );
        $this->db->select('user_record.*');
        $data['list'] = $this->db->order_by('user_record.user_id','asc')->where('user_id >',1)->get('user_record')->result_array();
        //echo $this->db->last_query();exit;
        $this->db = $clone;
        $data['count'] = $this->db->from('user_record')->where("user_id >",1)->count_all_results();
        //统计
        //$unset = array('cat_id','user_id','bumen_id');
        //foreach ($columns as $k => $v){
        //    if(in_array($v['COLUMN_NAME'],$unset)){
        //        continue;
        //    }
        //    if(isset($dyn[$v['COLUMN_NAME']])){
        //        if(!$dyn[$v['COLUMN_NAME']]['options'] && $dyn[$v['COLUMN_NAME']]['view'] && ( $v['DATA_TYPE'] == 'int' || $v['DATA_TYPE'] == 'float' ) ){
        //            $data['dyn_page'][$v['COLUMN_NAME']] = array_sum(array_column($data['list'],$v['COLUMN_NAME']) );
        //            $this->db = $syn_clone;
        //            $syn_clone = clone ($this->db );
        //            $alls = $this->db->select_sum($v['COLUMN_NAME'])->get('user_record')->row_array();
        //            $data['dyn_all'][$v['COLUMN_NAME']] = $alls[$v['COLUMN_NAME']];
        //
        //        }else{
        //            $data['dyn_page'][$v['COLUMN_NAME']] = '';
        //            $data['dyn_all'][$v['COLUMN_NAME']] = '';
        //        }
        //    }
        //}
        return $data;
    }
	public function wagesCount($columns,$dyn2,$start,$end,$gongzileixing,$name,$select,$input,$bumen_name){
		$sum_sql = '';
		$data_type = array_column($columns,'DATA_TYPE','COLUMN_NAME');
		foreach ($columns as $v){
			if(in_array($v['COLUMN_NAME'],$dyn2)){
				if($data_type[$v['COLUMN_NAME']] == 'decimal' || $data_type[$v['COLUMN_NAME']] == 'int'){
					$sum_sql .= sprintf(',SUM(`%s`) as %s',$v['COLUMN_NAME'],$v['COLUMN_NAME']);
				}else{
					$sum_sql .= ','."gongzibiao.".$v['COLUMN_NAME'];
				}
			}
		}
		if($start && !$end){
			$this->db->where('gongzibiao.nianyue >=',$start);
		}elseif (!$start && $end){
			$this->db->where('gongzibiao.nianyue <=',$end);
		}elseif ($start && $end){
			if($start > $end) $this->db->where('gongzibiao.nianyue >=',$start);
			if($start < $end){
				$this->db->where('gongzibiao.nianyue >=',$start);
				$this->db->where('gongzibiao.nianyue <=',$end);
			}
		}
		if($gongzileixing&&$gongzileixing!='综合'){
			$this->db->where('gongzibiao.gongzileixing',$gongzileixing);
		}
		if($select){
			foreach ($select as $k=>$v){
				if( $v!=''){
					$this->db->where($k,$v);
				}
			}
		}
		if($input){
			foreach ($input as $k=>$v){
				if( $v ){
					$this->db->like($k,trim($v));
				}
			}
		}
		//if($zhiyuandaima){
		//	$this->db->where('user_record.zhiyuandaima',$zhiyuandaima);
		//}
		if($name){
			$this->db->where('user_record.name',$name);
		}
        if(!empty($bumen_name)){
            $this->db->where('gongzibiao.bumen_name',$bumen_name);
        }
		$this->db->join('user_record','user_record.user_id = gongzibiao.user_id','left');
		$this->db->group_by('gongzibiao.user_id');
		$clone = clone ($this->db);
		$this->db->select('user_record.user_name,gongzibiao.id'.$sum_sql);
		$data['list'] = $this->db->get('gongzibiao')->result_array();
        //echo $this->db->last_query();exit;
		$this->db = $clone;
		$rows = $this->db->select('count(DISTINCT `ab22_gongzibiao`.`user_id`) as rows')->get('gongzibiao')->row_array();

		$data['count'] = !empty($rows['rows'])?$rows['rows']:'';
		return $data;
	}
	//查看用户工资
	public function wagesViewList($user_id){
		if($user_id){
			$this->db->where('gongzibiao.user_id',$user_id);
		}
		$clones = clone( $this->db );
		$this->db->select('user_record.user_name,user_record.name,gongzibiao.*')->join('user_record','user_record.user_id = gongzibiao.user_id','left');
		$data['list'] = $this->db->order_by('gongzibiao.id','desc')->get('gongzibiao', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();exit;
        $this->db = $clones;
		$data['count'] = $this->db->from('gongzibiao')->count_all_results();
		return $data;
	}
	public function wagesView($id){
        $this->db->select('user_record.user_id,user_record.name,gongzibiao.*');
		$this->db->where('id',$id);
        $this->db->join('user_record','user_record.user_id = gongzibiao.user_id','left');
		return $this->db->get('gongzibiao')->row_array();
	}
	public function userList($user_id){
		if($user_id!=''){
			$this->db->where('user_id', $user_id);
		}
		$data= $this->db->select('*')->get('user_record')->row_array();

        return $data;
	}
	public function bumen(){
		$data['count'] = $this->db->select('*')->from('bumen')->count_all_results();
        $data['department'] = $this->db->select('*')->get('bumen', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();
        return $data;
	}
	public function category(){
		$data['count'] = $this->db->select('*')->from('user_cat')->count_all_results();
        $data['user_category'] = $this->db->select('*')->get('user_cat', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();
        return $data;
	}
	public function gongzileixing(){
		$data['count'] = $this->db->select('*')->from('gongzileixing')->count_all_results();
        $data['gongzileixing'] = $this->db->select('*')->get('gongzileixing', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();
        return $data;
	}
	/**
	 * [user_list 公告列表]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-23T09:10:47+0800
	 * @return    [type]                   [description]
	 */
	public function notice(){
		$data['count'] = $this->db->select('*')->from('news')->count_all_results();
        $data['news'] = $this->db->select('*')->get('news', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();
        return $data;
	}
	/**
	 * 公告
	 */
	public function noticeList($news_id){
		if($news_id!=''){
			$this->db->where('news_id', $news_id);
		}
		$data= $this->db->select('*')->get('news')->row_array();

        return $data;
	}
	/**
	 * 留言列表
	 */
	public function getMessage($where=''){
		if($where!=''){
			$this->db->where('user_id',$where);
		}
		$this->db->order_by('liuyan_id','desc');
		$clone = clone( $this->db );
		$data['count'] = $this->db->select('*')->from('liuyan')->count_all_results();
		$this->db = $clone;
        $data['message'] = $this->db->select('*')->get('liuyan', $this->per_page, $this->offset)->result_array();
        return $data;
	}
	/**
	 * 留言详情
	 */
	public function messageList($liuyan_id){
		if($liuyan_id!=''){
			$this->db->where('user_id', $liuyan_id);
		}
		$data= $this->db->select('*')->get('liuyan')->row_array();

        return $data;
	}
	public function gongziType(){
		return $this->db->get('gongzileixing')->result_array();
	}
	public function getTable(){
		return $this->db->query('SHOW TABLE STATUS')->result_array();
	}
    public function deep_in_array($value, $array) {
        foreach($array as $item) {
            if(!is_array($item)) {
                if ($item == $value) {
                    return true;
                } else {
                    continue;
                }
            }

            if(in_array($value, $item)) {
                return $item;
            } else if($this->deep_in_array($value, $item)) {
                return $item;
            }
        }
        return false;
    }
    /**
     * 公用输出方法
     * @param $array
     * @param $filename
     */
    public function _out($array, $filename)
    {
        //使用csv插件导出。
        require_once(FR_ROOT.'/application/helpers/ECSVExport.php');
        $filename = $filename . '.csv';
        $csv = new ECSVExport($array);
        $csv->includeColumnHeaders = false;
        $output = $csv->toCSV(); // returns string by default
        $btype = self::my_get_browser();
        if ($btype == 'IE') {
            $filename = urlencode($filename);
        }
        header("Content-type:text/csv;");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        print_r($output);
        //Yii::app()->getRequest()->sendFile($filename, iconv('UTF-8', 'GBK//IGNORE', $output), "text/csv", false);
        //Yii::app()->getRequest()->sendFile($filename, mb_convert_encoding($output,"GBK","UTF-8"), "text/csv", false);
    }
    /**
     * 把数据保存到EXCEL
     */
    public function wirte_excel($arrDataList, $title)
    {
        $xlsfilename = $title . '.xlsx';
        $btype = self::my_get_browser();
        if ($btype == 'IE') {
            $xlsfilename = urlencode($xlsfilename);
        }

        require_once(FR_ROOT.'/application/helpers/PHPExcel.php');
        if (!empty($arrDataList)) {
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("注册局")
                ->setLastModifiedBy("注册局")
                ->setTitle($title);

            //$arrExcelInfo = eval('return ' . iconv('gbk', 'utf-8', var_export($arrDataList, true)) . ';'); //将数组转换成utf-8
            $objPHPExcel->getActiveSheet()->fromArray(
                $arrDataList, // 赋值的数组
                NULL, // 忽略的值,不会在excel中显示
                'A1' // 赋值的起始位置
            );
            header('Content-Type : application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . $xlsfilename);
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }
    }
    /**
     * 获取浏览器类型
     * @return string
     */
    public static function my_get_browser()
    {
        if(empty($_SERVER['HTTP_USER_AGENT'])){

            return 'Unknown';
        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Firefox')){

            return 'Firefox';

        }

        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Chrome')){

            return 'Chrome';

        }

        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Safari')){

            return 'Safari';

        }

        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'Opera')){

            return 'Opera';

        }
        if(false!==strpos($_SERVER['HTTP_USER_AGENT'],'360SE')){

            return '360SE';

        }else{
            return 'IE';
        }
    }
}
