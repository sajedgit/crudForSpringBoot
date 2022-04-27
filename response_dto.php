<?php

function get_response_dto_data($arr,$table_name,$response_name,$model_name,$package_name,$author_name)
{
	$today = date("d M, Y");
	$str="";
	for($i=1;$i<count($arr);$i++)
	{

		if($arr[$i]['data_type'] == "int")
			$str.="private Long ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif($arr[$i]['data_type'] == "varchar" || $arr[$i]['data_type'] == "text")
			$str.="private String ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif($arr[$i]['data_type'] == "date" )
			$str.="private Date ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif( $arr[$i]['data_type'] == "datetime" )
			$str.="private LocalDate ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif( $arr[$i]['data_type'] == "timestamp")
			$str.="private Date ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif( $arr[$i]['data_type'] == "double")
			$str.="private Double ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif( $arr[$i]['data_type'] == "tinyint" )
			$str.="private boolean ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		else
			$str.="private String ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

	}


	$page_data = <<<EOF
package $package_name.payload;
import lombok.Data;

/**
 * This class is to provide $model_name response
 *
 * @author $author_name
 * @since $today
 * @version 1.0
 */
@Data
public class $response_name extends IdHolderRequestBodyDTO {

    $str
}

	
EOF;



	return	$page_data;

}


?>
