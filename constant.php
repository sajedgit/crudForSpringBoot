<?php

function get_constant_data($constant_name,$constant_var_name,$model_name,$package_name,$author_name)
{
	$today = date("d M, Y");
	$constant_underscore_to_hyphen = str_replace("_","-",$constant_var_name);
	$constant_var_name_lower = strtolower($constant_underscore_to_hyphen);

	$page_data = <<<EOF
package $package_name.constants;

/**
 * This interface is to provide $model_name constant
 *
 * @author $author_name
 * @since $today
 * @version 1.0
 */
public interface $constant_name {

    final String $constant_var_name = "/$constant_var_name_lower";
    final String CREATE_$constant_var_name = "/create-$constant_var_name_lower";
    final String UPDATE_$constant_var_name = "/update-$constant_var_name_lower";
    final String GET_ACTIVE_LIST="/get-active-list";
}

	
EOF;



	return	$page_data;

}


?>
