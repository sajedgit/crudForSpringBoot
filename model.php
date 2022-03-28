<?php

function get_model_data($arr,$table_name,$model_name)
{
    $str="";
	for($i=1;$i<count($arr);$i++)
	{
		if($i==count($arr)-1)
		  $str.="'".$arr[$i][0]."'";
	    else
		  $str.="'".$arr[$i][0]."',";
			
	}
	 
	$page_data = <<<EOF
<?php 
/*
NAME : Sajed Ahmed
EMAIL ADDRESS: sajedaiub@gmail.com
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class $model_name extends Model
{
	
	   protected \$fillable = [
      $str
    ];
}

	
EOF;



	return	$page_data;

}


?>