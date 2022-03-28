<?php

function get_main_layout_data($arr,$table_name)
{
$page_data = <<<EOF
<html>
<head>

<style>
.maindiv
{
width:950px;
margin:0 auto;
border:1px solid #000;
}
.header
{
float:left;
width:950px;
border:1px solid #000;
height:150px;
}
.section
{
float:left;
width:950px;
border:1px solid #000;
height:auto;
}
.content
{
float:left;
width:750px;
border:1px solid #000;
height:auto;
}
.sidebar
{
float:left;
width:190px;
border:1px solid #000;
height:auto;
}
.footer
{
float:left;
width:950px;
border:1px solid #000;
height:80px;
}

</style>

</head>

<body>


<div class="maindiv">

	<div class="header">	<h3 align="center">header</h3></div>
	<div class="section">
	
		<div class="content"><?php  \$this->load->view(\$content);?>	</div>
		<div class="sidebar">
		
		<ul><li>Menu 1</li><li>Menu 2</li><li>Menu 3</li><li>Menu 4</li><li>Menu 5</li><li>Menu 6</li></ul>
		
		</div>
	
	</div>
	<div class="footer"><h3 align="center">footer</h3></div>
	
	
</div>


</body>
</html>
	
EOF;
	return	$page_data;

}



function get_single_view_data($arr,$table_name,$table_name_to_class)
{
	
	$viewData="";
	for($i=1;$i<count($arr);$i++)
	{
	$column=$arr[$i][0];
	$columnLabel=$arr[$i][0].'_label';
		
	$viewData.="<tr>
					<td class='col-lg-3'><?php echo \$this->$columnLabel ?></td>
					<td class='col-lg-9'><?php echo \$query_result->$column;  ?></td>
				 </tr>";
	
	}
$page_data = <<<EOF
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php echo \$title;  ?>
			</div>
			
			
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
		   <table class="table">
			 
			  <thead>
				 <tr>
					<th>Column</th>
					<th>Value</th>
				 </tr>
			  </thead>
			  <tbody>
				 $viewData
				
		
			  </tbody>
		   </table>
		</div>  	
	</div>
</div>

	
EOF;
	return	$page_data;
}



function get_edit_view_data($arr,$table_name,$table_name_to_class)
{
	$primary_id=$arr[0][0];
	
	$viewData="";
	for($i=1;$i<count($arr);$i++)
	{
	$column=$arr[$i][0];	
	$columnLabel=$arr[$i][0].'_label';
	$viewData.="<div class='form-group'>
						<label><?php echo \$this->$columnLabel ?></label>
						<input type='text' class='form-control' value='<?php echo \$edit_query_result->$column; ?>'  name='$column' placeholder='$column' >
						<span class='text-danger'><?php  echo form_error('$column'); ?></span>
					</div>";
	
	}
	
$page_data = <<<EOF
	
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php  echo \$title; ?>
			</div>
			<div class="panel-body">
			
				<?php 
			
				\$attributes = array('method' => 'POST', 'id' => 'form_$table_name');
				echo form_open("$table_name_to_class/edit_$table_name/\$edit_query_result->$primary_id", \$attributes);
				?>
					<?php if (isset(\$message)) : ?>
						<h1 class="text-center text-success">Data Edited successfully</h1>	<br/>
					<?php endif; ?>

					$viewData
				
				
				
					<button type="submit" class="btn btn-primary btn-block">Submit</button>
				<?php echo form_close(); ?>
				
			</div>
		</div>
	</div>
</div>

EOF;
	return	$page_data;
}





function get_all_view_data($arr,$table_name,$table_name_to_class)
{
	
	 $th="";
	 $td="";
	for($i=1;$i<count($arr);$i++)
	{
	   $column=$arr[$i][0];
	   $th.="	<th>$column</th>\n";	
	   $td.="	<td>{{ \$row->$column }}</td>\n";	
	}
	 
$page_data = <<<EOF
	

@extends('parent')

@section('main')


<table class="table table-bordered table-striped">
 <tr>
  $th
 </tr>
 @foreach(\$data as \$row)
  <tr>
   $td
  </tr>
 @endforeach
</table>


{!! \$data->links() !!}
@endsection


EOF;
	return	$page_data;
}





function get_add_data($arr,$table_name,$table_name_to_class)
{

	$viewData="";
	for($i=1;$i<count($arr);$i++)
	{
	$column=$arr[$i][0];
	$columnLabel=$arr[$i][0].'_label';	
	$viewData.="<div class='form-group'>
						<label><?php echo \$this->$columnLabel ?></label>
						<input type='text' class='form-control'   name='$column' placeholder='<?php echo \$this->$columnLabel ?>' >
						<span class='text-danger'><?php  echo form_error('$column'); ?></span>
					</div>";
	
	}
	
$page_data = <<<EOF
	
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php  echo \$title; ?>
			</div>
			<div class="panel-body">
			
				<?php 
			
				\$attributes = array('method' => 'POST', 'id' => 'form_$table_name');
				echo form_open("$table_name_to_class/create_$table_name", \$attributes);
				?>
					<?php if (isset(\$message)) : ?>
						<h1 class="text-center text-success">Data Inserted successfully</h1>	<br/>
					<?php endif; ?>

					$viewData
				
				
				
					<button type="submit" class="btn btn-primary btn-block">Submit</button>
				<?php echo form_close(); ?>
				
			</div>
		</div>
	</div>
</div>

EOF;
	return	$page_data;
}





?>