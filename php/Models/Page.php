<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 3/31/2016
 * Time: 8:13 PM
 */

@ini_set('display_errors', 'on');

/**
 * Chinese Time - UTF+8
 */
date_default_timezone_set("Asia/Hong_Kong");

class Page {

    /**
     * @var the id of this page
     */
    private $id;

    /**
     * @var the name of the page
     */
    private $name;

    /**
     * Page constructor.
     */
    public function __construct($i,$n){

        $this->id = $i;
        $this->name = $n;

    }

    public function is_this_id_existing_in_DB($m){
        if (!($m->query("select * from pages where page_id = ".$this->id)))
            return false;
        else
            return true;
    }

    /**
     * update the page's name in DB
     * @param $m
     * @param $new_name
     */
    public function change_my_name($m,$new_name){
        $response = $m->queryUpdate("update pages set page_name = '".$new_name."' where page_id = ".$this->id);
        $this->name = $new_name;
        echo "update successfully ".$response;
    }

    public function am_I_really_existing_in_DB($m){
        if($this->is_this_id_existing_in_DB($m)){
            if (!($m->query("select * from pages where page_id = ".$this->id.""." and page_name = '".$this->name."'")))
                return false;
            else
                return true;
        }
        else
            return false;
    }

    /**
     * @param $m the mysql manager
     * give all the page_id and page_name of the pages
     */
    public function list_all_inside_DB($m){
        $response = $m->queryMultiple("select page_id,page_name from pages;");
        print json_encode($response);
    }
}
