<?php

function get_service_data($service_name,$request_name,$response_name,$model_name,$package_name,$author_name,$i_service_name,$repository_name)
{
	$today = date("d M, Y");
	$request_name_var = lcfirst($request_name);
	$repository_name_var = lcfirst($repository_name);
	$response_name_var = lcfirst($response_name);
	$model_name_var = lcfirst($model_name);
	$model_name_save = $model_name_var."Save";


	$page_data = <<<EOF
package $package_name.service;

import $package_name.helper.Response;
import $package_name.model.$model_name;
import $package_name.payload.$request_name;
import $package_name.payload.$response_name;
import $package_name.repositories.*;
import $package_name.service.IService.$i_service_name;
import org.modelmapper.ModelMapper;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.util.ObjectUtils;

import javax.transaction.Transactional;

/**
 * This class is to provide $model_name api services
 *
 * @author $author_name
 * @since $today
 * @version 1.0
 */
@Service
@Transactional
public class $service_name extends BaseService<$model_name, $request_name, $response_name> implements $i_service_name {

    private final $repository_name $repository_name_var;
    Logger logger = LoggerFactory.getLogger($service_name.class);

    protected $service_name(ServiceRepository<$model_name> repository, $repository_name $repository_name_var) {
        super(repository);
        this.$repository_name_var = $repository_name_var;
    }

    /**
     * This Service will create $model_name.
     * @author $author_name
     * @param $request_name_var - $request_name_var dto
     * @return Response
     * @since $today
     * @version 1.0
     */
    @Override
    public ResponseEntity<Response<$response_name>> create$model_name($request_name $request_name_var) {
        Response<$response_name> response = new Response();
        try{
            Long isExists = $repository_name.countAllByIsDeletedFalseAndColumn($request_name_var.getColumn());  //  Column like: name,email,username etc and This Column must have to be in your database

            if (isExists == 0) {
                ModelMapper modelMapper = new ModelMapper();
                $model_name $model_name_var = new $model_name();
                modelMapper.map($request_name_var, $model_name_var);
              
                $model_name_var.setIsDeleted(false);
                $model_name $model_name_save = $repository_name_var.save($model_name_var);
                $response_name $response_name_var = new $response_name();

                modelMapper.map($model_name_save, $response_name_var);
                response.setObj($response_name_var);
                return new ResponseEntity<>(getSuccessResponse("Created Successfully", response), HttpStatus.OK);
            }

            return new ResponseEntity<>(getErrorResponse("Already Exist!."), HttpStatus.OK);
        } catch(Exception ex){
            logger.error("Could not create $model_name data", ex);
            ex.printStackTrace();
            System.out.println(ex);
            response.setMessage("$model_name not saved for internal error!");
            response.setSuccess(false);
            response.setErrorMessage(ex.getMessage());
            return new ResponseEntity<>(response, HttpStatus.INTERNAL_SERVER_ERROR);
        }

    }


    /**
     * This Service  will update $model_name.
     * @author $author_name
     * @param $request_name_var - $request_name_var dto
     * @return Response
     * @since $today
     * @version 1.0
     */
    @Override
    public ResponseEntity<Response<$response_name>> update$model_name($request_name $request_name_var) {
        Response<$response_name> response = new Response();
        try{
            Long isExists = $repository_name_var.countAllByIsDeletedFalseAndColumnAndIdNot($request_name_var.getColumn(), $request_name_var.getId());  //  Column like: name,email,username etc and This Column must have to be in your database
            if (isExists == 0) {
                ModelMapper modelMapper = new ModelMapper();
                $model_name $model_name_var = $repository_name_var.findById($request_name_var.getId()).orElse(null);
                modelMapper.map($request_name_var, $model_name_var);
                
                $model_name_var.setIsDeleted(false);
                $model_name $model_name_save = $repository_name_var.save($model_name_var);
                $response_name $response_name_var = new $response_name();

                modelMapper.map($model_name_save, $response_name_var);
                response.setObj($response_name_var);
                return new ResponseEntity<>(getSuccessResponse("Updated Successfully", response), HttpStatus.OK);
            }
            return new ResponseEntity<>(getErrorResponse("Already Exist!."), HttpStatus.OK);
        } catch(Exception ex){
            logger.error("Could not update $model_name data", ex);
            ex.printStackTrace();
            System.out.println(ex);
            response.setMessage("$model_name not updated for internal error!");
            response.setSuccess(false);
            response.setErrorMessage(ex.getMessage());
            return new ResponseEntity<>(response, HttpStatus.INTERNAL_SERVER_ERROR);
        }

    }
}


	
EOF;



	return	$page_data;

}


?>
