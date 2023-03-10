<?php
  namespace App\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\JsonResponse;

  class Globals{
    private ManagerRegistry $managerRegistry;
    public function __construct(ManagerRegistry $managerRegistry)
    {
      $this->managerRegistry=$managerRegistry;
    }

    public function successs(array $data=null,$message='success',int $codeHttp=200):JsonResponse
    {
      return new JsonResponse([
        'status' =>1,
        'message' =>$message,
        'data' =>$data
      ],status:$codeHttp);
    }

    public function error($message='error',int $codeHttp=500):JsonResponse
    {
      return new JsonResponse([
        'status' =>0,
        'message' =>$message
      ],status:$codeHttp);
    }

    public function jsoncode(){
      try{
        return file_get_contents(filename:'php://input')?
          json_decode(file_get_contents(filename:'php//input'),associative:false):[];
      }
      catch(\Exception $e){
        return [];
      }
    }

    public function entityManager():ObjectManager{
      return $this->managerRegistry->getManager();
    }
  }
?>