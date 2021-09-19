<?php
class Response{
    public function returnData($data){
        $responseData=array();
        $responseData["responseCode"]= '100';
        $responseData["responseMessage"]= 'Success';
        $responseData["data"]= json_encode($data);
        return $responseData;
    }
}