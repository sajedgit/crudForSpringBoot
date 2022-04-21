<?php

function get_repository_data($arr,$repository_name,$model_name,$package_name,$author_name)
{
	$today = date("d M, Y");

	$has_unique = false;

	$str="Long countAllByIsDeletedFalseAnd";
	$columnName = array();
	$parameters = array();

	for($i=1;$i<count($arr);$i++)
	{
		if($arr[$i]['column_key'] == "UNI")
		{
			$has_unique = true;
			$formateColumn=create_table_to_class_name($arr[$i]['column_name']);
			array_push($columnName,$formateColumn);
			array_push($parameters,"String ".dashesToCamelCase($arr[$i]['column_name']));
		}

	}

	if($has_unique)
	{
		$column_concate = implode("And",$columnName);
		$param_concate = implode(",",$parameters);

		$str_insert = $str.$column_concate;
		$str_insert_param = "(".$param_concate.")";
		$insert_function = $str_insert.$str_insert_param.";\n\t";


		$str_update = $str.$column_concate."AndIdNot";
		$str_update_param = "(".$param_concate.",Long id)";
		$update_function = $str_update.$str_update_param.";\n\t";

		//	Long countAllByIsDeletedFalseAndMobileNo(String mobileNo);
		//  Long countAllByIsDeletedFalseAndMobileNoAndIdNot(String mobileNo,Long id);

		$final_str = $insert_function.$update_function;
	}
	else
	{
		$final_str = "";
	}




	$page_data = <<<EOF
package $package_name.repositories;

import $package_name.model.$model_name;
import org.springframework.stereotype.Repository;

/**
 * @author $author_name
 * @since $today
 * @version 1.0
 */

@Repository
public interface $repository_name extends ServiceRepository<$model_name> {

    $final_str

}

	
EOF;



	return	$page_data;

}


?>
