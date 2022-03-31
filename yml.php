<?php

function get_yml_change_log_data($table_name,$yml_name)
{


    $page_data = <<<EOF
        - include:
            file: $table_name.yml
            relativeToChangelogFile: true
	
EOF;



    return	$page_data;
}



function get_yml_data($arr,$table_name,$yml_name,$model_name,$author_name)
{
    $today = date("d M, Y");
    $str="";
    for($i=0;$i<count($arr);$i++)
    {
       // print_r($arr[$i]);
        $column_name = $arr[$i]['column_name'];

        $data_type_length = $arr[$i]['data_type_length'];


        //for is_nullable
        if($arr[$i]['IS_NULLABLE'] == "NO")
        {
            $is_nullable = "false";
        }
        else
        {
            $is_nullable = "true";
        }
        //end is_nullable


        //for auto_increment
        if($arr[$i]['extra'] == "auto_increment")
        {
            $auto_increment = "\n                  autoIncrement: true";
        }
        else
        {
            $auto_increment = "";
        }
        //end auto_increment


        //for primary key
        if($arr[$i]['column_key'] == "PRI")
        {
            $primary_key = "\n                    primaryKey: true";
        }
        else
        {
            $primary_key = "";
        }
        //end primary key


        //for data type
        if($arr[$i]['data_type'] == "int")
        {
            $data_type = "BIGINT";
        }
        elseif($arr[$i]['data_type'] == "varchar")
        {
            $data_type = "varchar(".$data_type_length.")";
        }
        elseif($arr[$i]['data_type'] == "text")
        {
            $data_type = "LONGTEXT";
        }
        elseif($arr[$i]['data_type'] == "date" )
        {
            $data_type = "date";
        }
        elseif( $arr[$i]['data_type'] == "datetime" || $arr[$i]['data_type'] == "timestamp")
        {
            $data_type = "timestamp";
        }
        else
        {
            $data_type = $arr[$i]['data_type'];
        }
        //end data type



        $str.= "- column:
                  name: $column_name
                  type: $data_type $auto_increment
                  constraints: $primary_key
                    nullable: $is_nullable";

        if($i<count($arr)-1)
        $str.="\n              ";

    }





    $page_data = <<<EOF
#######################################################
## @author   $author_name                         ##
## @version  1.0                                     ##
## @since    $today                            ##
#######################################################

databaseChangeLog:
  - changeSet:
      id: create $table_name table
      author: $author_name
      changes:
        - createTable:
            tableName: $table_name
            columns:
              $str
              - column:
                  name: created_at
                  type: timestamp
                  constraints:
                    nullable: false
              - column:
                  name: updated_at
                  type: timestamp
                  constraints:
                    nullable: false
              - column:
                  name: created_by
                  type: BIGINT
                  constraints:
                    nullable: false
              - column:
                  name: updated_by
                  type: BIGINT
                  constraints:
                    nullable: false

	
EOF;



    return	$page_data;

}


?>
