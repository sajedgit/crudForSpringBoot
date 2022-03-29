<?php

function get_model_data($arr,$table_name,$model_name,$package_name)
{
	$today = date("d M, Y");
    $str="";
	for($i=1;$i<count($arr);$i++)
	{

	    if($arr[$i]['data_type'] == "varchar")
			$str.="private String ".$arr[$i]['column_name'].";\n\t";

	    elseif ($arr[$i]['data_type'] == "text")
			$str.="\n\t@Column(columnDefinition = \"TEXT\") \n\t private String ".$arr[$i]['column_name'].";\n\t";

		elseif($arr[$i]['data_type'] == "date" || $arr[$i]['data_type'] == "datetime" || $arr[$i]['data_type'] == "timestamp")

			$str.="\n\t@Column(columnDefinition = \"TIMESTAMP\") \n\t private String ".$arr[$i]['column_name'].";\n\t";
		else
			$str.="private String ".$arr[$i]['column_name'].";\n\t";
			
	}




	 
	$page_data = <<<EOF
package $package_name.model;
import lombok.Data;
import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;
import javax.persistence.*;


/**
 * @author Md. Sajed Ahmed
 * @since $today
 * @version 1.0
 *
 */
@Data
@Entity
@Table(name = "$table_name")
@EntityListeners(AuditingEntityListener.class)
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class $model_name extends AuditModel<Long>{

    $str

}

	
EOF;



	return	$page_data;

}


?>
