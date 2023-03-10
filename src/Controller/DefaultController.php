<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\Globals;

  class DefaultController extends AbstractController{
    private Globals $globals;
    public function __construct(Globals $globals)
    {
      $this->globals=$globals;
    }
   
    /**
     * @return JsonResponse
     */
    #[Route('', name: 'home')]
    public function home():JsonResponse{
      return $this->globals->successs([
        'message'=>'bienvenues' 
      ]);
    }
  }
?>