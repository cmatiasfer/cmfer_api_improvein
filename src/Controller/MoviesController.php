<?php
namespace App\Controller;

use App\Entity\Users;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use JMS\Serializer\SerializerInterface;


/**
 * Class MoviesController
 *
 * @Route("/api")
 */
class MoviesController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/v1/movies", name="movies_list")
     *
     * @OA\Response(
     *     response=200,
     *     description="Gets all movies."
     * )
     *
     * @OA\Response(
     *     response=500,
     *     description="An error has occurred trying to get all movies."
     * )
     *
     * @OA\Tag(name="Movies")
     */
    public function getMovies(Request $request, SerializerInterface $serializer) {
        $em = $this->getDoctrine()->getManager();
        $filterGenre = $request->query->get('genre',null);//drama
        $filterShortBy = $request->query->get('short_by',null);//alpha-desc && alpha-asc
        
        $message = "";

        try {
            $code = 200;
            $error = false;
            $movies = $em->getRepository("App:Movies")->findAll();
            
            $moviesCustom = [];
            if (!is_null($movies)){
                foreach($movies as $movie){
                    $moviesRow["id"] = $movie->getId();
                    $moviesRow["name"] = $movie->getName();
                    $moviesRow["genre"] = $movie->getGenre();
                    $moviesRow["description"] = $movie->getDescription();
                    $moviesRow["popularity"] = $movie->getPopularity();
                    $moviesRow["voteAverage"] = $movie->getVoteAverage();
                    array_push($moviesCustom,$moviesRow);
                }
            }
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Movies - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $moviesCustom : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Post("/v1/movies", name="add_movie")
     *
     * @OA\Response(
     *     response=200,
     *     description="Movie was added successfully."
     * )
     *
     * @OA\Response(
     *     response=500,
     *     description="An error has occurred trying to add movie."
     * )
     *
     * @OA\Tag(name="Movies")
     */
    public function addMovies(Request $request, SerializerInterface $serializer) {
        $em = $this->getDoctrine()->getManager();
        $message = "";

        try {
            $code = 200;
            $error = false;
            $movies = $em->getRepository("App:Movies")->findAll();


            $name = $request->request->get('name');
            $genre = $request->request->get('genre');
            $description = $request->request->get('description');
            $popularity = $request->request->get('popularity');
            $voteAverage = $request->request->get('voteAverage');
            $director = $request->request->get('director');
            
            $moviesCustom = [];
            if (!is_null($movies)){
                foreach($movies as $movie){
                    $moviesRow["id"] = $movie->getId();
                    $moviesRow["name"] = $movie->getName();
                    $moviesRow["genre"] = $movie->getGenre();
                    $moviesRow["description"] = $movie->getDescription();
                    $moviesRow["popularity"] = $movie->getPopularity();
                    $moviesRow["voteAverage"] = $movie->getVoteAverage();
                    $moviesRow["director"] = $movie->getVoteAverage();
                    array_push($moviesCustom,$moviesRow);
                }
            }
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all Movies - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $moviesCustom : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }
    
    

}
