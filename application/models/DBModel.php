<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DBModel extends CI_Model
{
    public function execute($query){
		$this->db->query($query);
    }

	public function getdata($query){
		$result = $this->db->query($query);
        return $result->result();
    }

    public function getsinglevalue($query){
		$result = $this->db->query($query);
        $row = $result->result()[0];
        return $row->svalue;
	}

    public function checkifexists($query){
		$result = $this->db->query($query);
        if(count($result->result()) > 0)
            return true;
        else
            return false;
    }

    public function configurePagination($url, $total_rows, $per_page, $uri_segment)
    {
        $config = array();
        $config["base_url"] = $url;
        $config["total_rows"] = $total_rows;
        $config["per_page"] = $per_page;
        $config["uri_segment"] = $uri_segment;
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a style="color:white;" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-long-arrow-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
        return $config;
    }
}

