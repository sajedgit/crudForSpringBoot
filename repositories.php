<?php

function get_repository_data($repository_name,$model_name,$package_name,$author_name)
{
	$today = date("d M, Y");

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

}

	
EOF;



	return	$page_data;

}


?>
