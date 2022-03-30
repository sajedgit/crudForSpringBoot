<?php

function get_i_service_data($i_service_name,$request_name,$response_name,$model_name,$package_name,$author_name)
{
	$today = date("d M, Y");
	$request_name_var = lcfirst($request_name);


	$page_data = <<<EOF
package $package_name.service.IService;

import $package_name.helper.Response;
import $package_name.payload.$request_name;
import $package_name.payload.$response_name;
import org.springframework.http.ResponseEntity;

/**
 * This interface for $model_name service
 * @author $author_name
 * @since $today
 * @version 1.0
 */
public interface $i_service_name {
    ResponseEntity<Response<$response_name>> create$model_name($request_name $request_name_var);

    ResponseEntity<Response<$response_name>> update$model_name($request_name $request_name_var);
}


	
EOF;



	return	$page_data;

}


?>
