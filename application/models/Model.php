<?php
class Model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	
	
	function getData($tableName, $where_data=array(), $where_in = array(), $like = array()){
        try{
			if (isset($tableName) && isset($where_data)) {
				
				$this->db->trans_start();
				if(!empty($where_data)){
					$this->db->where($where_data);
				}
				if(!empty($where_in)){
					$this->db->where_in($where_in['field'],$where_in['in_array']);
				}
				if(!empty($like)){
					$this->db->like($like['field'], $like['keyword']);
				}
				$query = $this->db->get($tableName);
                               
				$this->db->trans_complete();
				if ($query->num_rows() > 0){
					$rows = $query->result_array();
					return $rows;
				}else{
					return false;
				} 
			}else{
				return false;
			}
		} catch (Exception $e){
			return false;
		}
	}

	function getDataLimit($tableName, $where_data, $limit='', $start=''){
		//echo '<pre>'; print_r($where_data); 
		//echo $tableName.' - '.$limit .' - '. $start;
		try{
			if (isset($tableName) && isset($where_data)) {
				
				$this->db->trans_start();
				$query = $this->db->get_where($tableName, $where_data, $limit, $start);
				
				$this->db->trans_complete();
				if ($query->num_rows() > 0){
					$rows = $query->result_array();
					return $rows;
				}else{
					return false;
				} 
			}else{
				return false;
			}
		} catch (Exception $e){
			return false;
		}
	}

	function get_like_data($tbl,$clm,$keyword) /*$wh_data,*/
	{
		$this->db->select('*');
		$this->db->from($tbl);
		/*$this->db->where($wh_data);*/
		$this->db->like($clm, $keyword);
		return $this->db->get()->result_array();
	}



    function countrecord($tablename)
    {
    	$query = $this->db->get($tablename);
    	$count = $query->num_rows(); 
    	return $count;
    }

    function CountWhereRecord($tableName,$where_data)
    {
    	$query = $this->db->get_where($tableName, $where_data);
    	$count = $query->num_rows(); 
    	return $count;
    }
   	
   	function count_by_query($sql){
   		$query = $this->db->query($sql);
      	$count = $query->num_rows(); 
    	return $count;
   	}

	function insertData($tableName, $array_data){
		try{
			if (isset($tableName) && isset($array_data)) {
				
				$this->db->trans_start();

				$this->db->insert($tableName, $array_data);
				$globals_id = $this->db->insert_id();

				$this->db->trans_complete();

				return $globals_id;

			}else{
				return false;
			}
		} catch (Exception $e){
			return false;
		}
	}

	function getAllData($tableName){
		if (isset($tableName)) {
			
			$this->db->trans_start();	
			$query = $this->db->get($tableName);
			//$query = $this->db->get($tableName);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
		}else{
			return false;
		}
	}

	
	function selectData($tableName,$fields){
		if (isset($tableName)) {
			
			$this->db->trans_start();	
			$this->db->select($fields);
			$query = $this->db->get($tableName);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}

	function selectDataNotIn($tableName,$selectField,$notInClmName,$notInData)
	{		
		if (isset($tableName)) {
			
			$this->db->trans_start();	
			$this->db->select($selectField);
			$this->db->where_not_in($notInClmName, $notInData);
			$query = $this->db->get($tableName);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}


	function getReportData($tableName, $whereData ){
		//echo $tableName;print_r($whereData);
		if (isset($tableName) && isset($whereData)) {
			
			$del_clm = array('is_deleted' => '-1' ); //-1 : Record not deleted
			$whereData = array_merge($del_clm, $whereData);
			$this->db->trans_start();
			$query = $this->db->get_where($tableName, $whereData);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}
	
	
	function getDatanew($tableName, $where_data=array(), $where_in = array(), $like = array(), $order_by, $ASC_DESC='ASC'){
        try{
			if (isset($tableName) && isset($where_data)) {
				
				$this->db->trans_start();
				if(!empty($where_data)){
					$this->db->where($where_data);
				}
				if(!empty($where_in)){
					$this->db->where_in($where_in['field'],$where_in['in_array']);
				}
				if(!empty($like)){
					$this->db->like($like['field'], $like['keyword']);
				}

			$this->db->order_by($order_by, $ASC_DESC);
				$query = $this->db->get($tableName);
                   
				$this->db->trans_complete();
				if ($query->num_rows() > 0){
					$rows = $query->result_array();
					return $rows;
				}else{
					return false;
				} 
			}else{
				return false;
			}
		} catch (Exception $e){
			return false;
		}
	}
	
	function getDataOrderBy($tableName, $whereData="", $order_by, $ASC_DESC='ASC'){
		if (isset($tableName) && isset($whereData)) {
			
			$this->db->trans_start();	
			//$query = $this->db->get_where($tableName, $whereData)->order_by($order_by, $ASC_DESC);

			$this->db->from($tableName);
			$this->db->where($whereData);
			$this->db->order_by($order_by, $ASC_DESC);
			$query = $this->db->get(); 
			
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}
	function getDataOrderBytop_ten($tableName, $whereData, $order_by, $ASC_DESC='DESC'){
		if (isset($tableName) && isset($whereData)) {
			
			$this->db->trans_start();	
			//$query = $this->db->get_where($tableName, $whereData)->order_by($order_by, $ASC_DESC);

			$this->db->from($tableName);
			$this->db->where($whereData);
			$this->db->order_by($order_by, $ASC_DESC);
			$query = $this->db->get(); 
			
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}

	function getReportDataWhereNotIn($tableName, $whereData, $whereColumn, $WhereInValues){
		$del_clm = array('is_deleted' => '-1' ); //-1 : Record not deleted
		$whereData = array_merge($del_clm, $whereData);
		
		$this->db->trans_start();	
		
		$this->db->from($tableName);
		$this->db->where($whereData);
		$this->db->where_not_in($whereColumn, $WhereInValues);
		
		$query = $this->db->get(); 
		
		$this->db->trans_complete();
		
		if ($query->num_rows() > 0){
			$rows = $query->result_array();
			return $rows;
		}else{
			return false;
		} 	
	}

	function getDataWhereIn($tableName, $whereData, $whereColumn, $WhereInValues){
		$this->db->trans_start();	
		
		$this->db->from($tableName);
		$this->db->where($whereData);
		$this->db->where_in($whereColumn, $WhereInValues);
		
		$query = $this->db->get(); 
		
		$this->db->trans_complete();
		
		if ($query->num_rows() > 0){
			$rows = $query->result_array();
			return $rows;
		}else{
			return false;
		} 	
	}


	/*
	function updateReportData($tableName, $report_data, $where){}
		$tableName   => Tablename
		$report_data => array format data which has to set
		$where => array format data for the column on which basis it will be updated.
			$where can be like "id = 4" for single condition
			$where can be like array('id' => 1005, 'sr_no'=> '10') for multiple condition
	*/

	function updateData($tableName, $updateData, $where){
		//echo $tableName;print_r($updateData);print_r($where);exit;
		
		$this->db->trans_start();	
		$query = $this->db->update($tableName, $updateData, $where);
		$this->db->trans_complete();

		$result = $query ? 1 : 0;
		return $result;
	}

	function deleteData($tableName,$whereData){
		if(isset($tableName) && isset($whereData)){
			
			$this->db->trans_start();	
			$this->db->delete($tableName, $whereData); 
			//$this->db->where($whrColumn, $whrValue);
			//$this->db->delete($tableName); 
			$this->db->trans_complete();

			if($this->db->affected_rows() > 0){ // returns 1 ( == true) if successfuly deleted
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		
	}

	function getSqlData($sql){
		
       	$query = $this->db->query($sql);
      	$result=$query->result_array();
      	return $result;
	}
        
	
	function tableInsert($tablename,$val)
    {
    	
        $this->db->insert($tablename, $val);
        if($this->db->affected_rows() == 1){
         return True;
            }
        else
        {
         return False;
        }
    }

    function truncate_table($sql){
    	$this->db->from($sql); 
		$this->db->truncate(); 
    }

    function generate_next_id($tablename,$field,$series='req'){
    	$query = $this->db->select($field)
    	->from($tablename)
    	->order_by($field,'DESC')
    	->like($field,$series)
    	->limit(1)
    	->get();
    	$data = $query->first_row();

    	if(empty($data)){
    		return $series.'000001';
    	}
    	else{
    		$last_id = $data->$field;
    		$number = substr($last_id,strlen($series));
    		$number = (int)$number + 1;
    		$next_id = $series.sprintf('%06s',$number);
    		return $next_id;
    	}
    }

    function generate_next_id2($last_id,$series= ''){
		$number = substr($last_id,strlen($series));
		$number = (int)$number + 1;
		$next_id = $series.sprintf('%06s',$number);
		return $next_id;
    }

    function isExist($tablename,$fieldname,$value){
    	$query = $this->db->select('*')
    	->from($tablename)
    	->where($fieldname,$value)
    	->get();
    	$num_rows = $query->num_rows();
    	if($num_rows > 0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }

    function getValue($tablename,$fieldname,$where =array()){
    	$query = $this->db->select($fieldname)
    	->from($tablename)
    	->where($where)
    	->get();
    	$data = $query->first_row();
    	$data = (array)$data;
    	return isset($data[$fieldname])?$data[$fieldname]:'';
    }

    function selectWhereData($tableName,$whereData,$fields='*',$row = true,$order_by='',$group_by=''){
		if (isset($tableName)&&isset($whereData)) {
			$this->db->trans_start();	
			$this->db->select($fields);
			$this->db->where($whereData);
			if (!empty($order_by)) {
				$this->db->order_by(@$order_by[0],@$order_by[1]);
			}
			if (!empty($group_by)) {
				$this->db->group_by(@$group_by);
			}
			// $this->db->limit(2);
			$query = $this->db->get($tableName);
			$this->db->trans_complete();
			
			if ($query->num_rows() > 0){
				if($row)
				$rows = $query->row_array();
				else				
				$rows = $query->result_array();
				return $rows;
			}else{
				return false;
			} 
			
		}else{
			return false;
		}
	}
}//class ends here	