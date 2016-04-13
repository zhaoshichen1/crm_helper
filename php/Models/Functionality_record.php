<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 4/6/2016
 * Time: 8:13 PM
 */

@ini_set('display_errors', 'on');

/**
 * Chinese Time - UTF+8
 */
date_default_timezone_set("Asia/Hong_Kong");

class Functionality_reocrd {

    /**
     * @var the id of this func
     */
    private $func_id;

    /**
     * @var the id of the page where the func is located
     */
    private $page_id;

    /**
     * @var the name of the func
     */
    private $func_name;

    /**
     * Page constructor.
     */
    public function __construct($fi,$pi,$fn){

        $this->func_id = $fi;
        $this->func_name = $fn;
        $this->page_id = $pi;
    }

    public function is_this_id_existing_in_DB($m){
        if (!($m->query("select * from functionality_record where func_id = ".$this->id)))
            return false;
        else
            return true;
    }

    public function am_I_really_existing_in_DB($m){
        if($this->is_this_id_existing_in_DB($m)){
            if (!($m->query("select * from functionality_record where func_id = ".$this->func_id.""." and func_name = '".$this->func_name."'"." and page_id = ".$this->page_id)))
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
        $response = $m->queryMultiple("select f.func_id,f.func_name,f.page_id,p.page_name from functionality_record f join pages p on f.page_id = p.page_id;");
        print json_encode($response);
    }

    public function change_my_name($m,$newName){
        $response = $m->query("update functionality_record set func_name = ''".$newName."' where func_id=".$this->func_id);
    }
}
