<?php
namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use JMS\Serializer\SerializerInterface;

use App\Entity\Directors;



/**
 * Class MoviesController
 *
 * @Route("/api")
 */
class DirectorsController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/v1/directors", name="directors_list")
     *
     * @OA\Response(
     *     response=200,
     *     description="Gets all directors."
     * )
     *
     * @OA\Response(
     *     response=500,
     *     description="An error has occurred trying to get all directors."
     * )
     * 
     * @OA\Parameter(
     *     name="name",
     *     in="query",
     *     @OA\Schema(
     *       type="string",
     *     ),
     *     schema={}
     * )
     *
     * @OA\Tag(name="Directors")
     */
    public function getMovies(Request $request, SerializerInterface $serializer) {
        $em = $this->getDoctrine()->getManager();
        $message = [];

        try {
            $code = 200;
            $error = false;
            
            $name = $request->request->get('name');
            if(!is_null($name) && $name != ''){
                $director = $em->getRepository("App:Directors")->findOneBy(["name" => $name]);
                if(is_null($director)){
                    $directors = new Directors();
                    $directors->setName($name);

                    $em->persist($directors);
                    $em->flush();
                }else{
                    $code=500;
                    $message["name"]="Name already exists in Directors";
                }
            }else{
                $code=500;
                $message["name"]="Name cannot be empty";
                $exist_email = false;
            }

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message[] = "An error has occurred trying to register the director - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $directors : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }
    
    

}
