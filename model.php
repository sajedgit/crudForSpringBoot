<?php

function get_model_data($arr,$table_name,$model_name,$package_name,$author_name)
{
	$today = date("d M, Y");
    $str="";
	for($i=1;$i<count($arr);$i++)
	{

	    if($arr[$i]['data_type'] == "int")
			$str.="private Long ".dashesToCamelCase($arr[$i]['column_name']).";\n\t";

		elseif($arr[$i]['data_type'] == "varchar")
			$str.="private String ".dashesToCamelCase($arr[$i]['column_name']).";\n\t";

	    elseif ($arr[$i]['data_type'] == "text")
			$str.="\n\t@Column(columnDefinition = \"TEXT\") \n\tprivate String ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif($arr[$i]['data_type'] == "date" )

			$str.=" \n\tprivate Date ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif($arr[$i]['data_type'] == "datetime" )

			$str.=" \n\tprivate LocalDate ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif( $arr[$i]['data_type'] == "timestamp")

			$str.="\n\t@Column(columnDefinition = \"TIMESTAMP\") \n\tprivate Date ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif( $arr[$i]['data_type'] == "double")

			$str.="\n\tprivate Double ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";

		elseif( $arr[$i]['data_type'] == "tinyint"  &&  $arr[$i]['data_type_length']==1)

			$str.="\n\tprivate boolean ".dashesToCamelCase($arr[$i]['column_name']).";\n\n\t";
		else
			$str.="private String ".dashesToCamelCase($arr[$i]['column_name']).";\n\t";
			
	}




	 
	$page_data = <<<EOF
package $package_name.model;
import lombok.Data;
import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;
import javax.persistence.*;


/**
 * @author $author_name
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
