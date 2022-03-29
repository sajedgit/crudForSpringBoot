<?php
function create_column_to_readable($column)
{
$new_column_name="";
$column_name_captalize=ucwords($column);
$column_arr=preg_split("/[-,_,#,\s]+/", $column_name_captalize);
foreach($column_arr as $data):
$new_column_name.=ucwords($data)." ";
endforeach;

return	$new_column_name;	

}


function get_controller_data($arr,$table_name,$controller_name,$model_name,$constant_name,$request_name,$response_name,$i_service_name,$i_service_var,$package_name,$constant_var_name,$author_name)
{

    $today = date("d M, Y");
	$model_var = lcfirst($model_name);
	$request_var = lcfirst($request_name);
	$page_data = <<<EOF
package $package_name.controller;

import $package_name.constants.$constant_name;
import $package_name.helper.Response;
import $package_name.model.$model_name;
import $package_name.payload.$request_name;
import $package_name.service.BaseService;
import $package_name.service.IService.$i_service_name;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.media.ArraySchema;
import io.swagger.v3.oas.annotations.media.Content;
import io.swagger.v3.oas.annotations.media.Schema;
import io.swagger.v3.oas.annotations.responses.ApiResponses;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

/**
 * This controller is to provide all the $model_name relevant api's
 *
 * @author $author_name
 * @since $today
 * @version 1.0
 */
@RestController
@RequestMapping($constant_name.$constant_var_name)
public class $controller_name extends BaseController<$model_name, $request_name, $response_name>{

    Logger logger = LoggerFactory.getLogger($controller_name.class);

    private final $i_service_name $i_service_var;

    public $controller_name(BaseService<$model_name, $request_name, $response_name> service, $i_service_name $i_service_var) {
        super(service);
        this.$i_service_var = $i_service_var;
    }

    /**
     * This API will create $model_name.
     * @author $author_name
     * @param $request_var - $request_var dto
     * @return Response
     * @since $today
     * @version 1.0
     */
    @SuppressWarnings({ "rawtypes", "unchecked" })
    @Operation(summary = "Create $model_name", description = "Create New $model_name into DB")
    @ApiResponses(value = {
            @io.swagger.v3.oas.annotations.responses.ApiResponse(responseCode = "200", description = "$model_name data store into database", content = @Content(array = @ArraySchema(schema = @Schema(implementation = $model_name.class)))),
            @io.swagger.v3.oas.annotations.responses.ApiResponse(responseCode = "400, 401", description = "Bad Request, could not save $model_name ", content = @Content(array = @ArraySchema(schema = @Schema(implementation = Response.class)))) })
    @PostMapping(path = $constant_name.CREATE_$constant_var_name, produces = "application/json")
    public ResponseEntity<Response<$response_name>> create$model_name(@RequestBody $request_name $request_var) {
            return $i_service_var.create$model_name($request_var);
    }

    /**
     * This API will update $model_name.
     * @author $author_name
     * @param $request_var - $request_var dto
     * @return Response
     * @since $today
     * @version 1.0
     */
    @SuppressWarnings({ "rawtypes", "unchecked" })
    @Operation(summary = "Update $model_name", description = "Update $model_name into DB")
    @ApiResponses(value = {
            @io.swagger.v3.oas.annotations.responses.ApiResponse(responseCode = "200", description = "$model_name data update into database", content = @Content(array = @ArraySchema(schema = @Schema(implementation = $model_name.class)))),
            @io.swagger.v3.oas.annotations.responses.ApiResponse(responseCode = "400, 401", description = "Bad Request, could not update $model_name ", content = @Content(array = @ArraySchema(schema = @Schema(implementation = Response.class)))) })
    @PutMapping(path = $constant_name.UPDATE_$constant_var_name, produces = "application/json")
    public ResponseEntity<Response<$response_name>> update$model_name(@RequestBody $request_name $request_var) {
            return $i_service_var.update$model_name($request_var);
    }

}

	
	
EOF;



	return	$page_data;

}


?>
