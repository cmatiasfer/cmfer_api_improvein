<?php
namespace App\Controller;

use App\Entity\Users;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use OpenApi\Annotations as OA;
use JMS\Serializer\SerializerInterface;


/**
 * Class ApiController
 *
 * @Route("/api")
 */
class ApiController extends AbstractFOSRestController
{
    // USER URI's

    /**
     * @Rest\Post("/login_check", name="user_login_check")
     *
     * @OA\Response(
     *     response=200,
     *     description="User was logged in successfully"
     * )
     *
     * @OA\Response(
     *     response=500,
     *     description="User was not logged in successfully"
     * )
     *
     * @OA\Parameter(
     *     name="_username",
     *     in="query",
     *     description="The user name for login",
     *     @OA\Schema(
     *       type="string",
     *     )
     * 
     * )
     *
     * @OA\Parameter(
     *     name="_password",
     *     in="query",
     *     @OA\Schema(
     *       type="string",
     *     )
     * )

     *
     * @OA\Tag(name="User")
     */
    public function getLoginCheckAction(Request $request) {
        return $request;
    }

    /**
     * @Rest\Get("/v1/username_check", name="user_check")
     *
     * @OA\Response(
     *     response=200,
     *     description="User was logged in successfully"
     * )
     *
     * @OA\Response(
     *     response=500,
     *     description="User was not logged in successfully"
     * )
     *
     * @OA\Tag(name="User")
     */
    public function getUsernameAction(Request $request) {
        $serializer = $this->get('jms_serializer');
        $response = [
            'data' => $this->getUser()->getUsername()
        ];
 
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Post("/register", name="user_register")
     *
     * @OA\Response(
     *     response=201,
     *     description="User was added successfully"
     * )
     *
     * @OA\Response(
     *     response=500,
     *     description="An error was occurred trying to add User"
     * )
     * 
     * @OA\Parameter(
     *     name="_name",
     *     in="query",
     *     @OA\Schema(
     *       type="string",
     *     ),
     *     schema={}
     * )
     *
     * @OA\Parameter(
     *     name="_email",
     *     in="query",
     *     @OA\Schema(
     *       type="string",
     *     ),
     *     schema={}
     * )
     *
     * @OA\Parameter(
     *     name="_username",
     *     in="query",
     *     @OA\Schema(
     *       type="string",
     *     ),
     *     schema={}
     * )
     *
     * @OA\Parameter(
     *     name="_password",
     *     in="query",
     *     @OA\Schema(
     *       type="string",
     *     ),
     * )
     *
     * @OA\Tag(name="User")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder,SerializerInterface $serializer) {
        $em = $this->getDoctrine()->getManager();
 
        $user = [];
        $message = [];
 
        try {
            $code = 200;
            $error = false;
 
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            if(!is_null($email)){
                $exist_email = $em->getRepository("App:Users")->findOneBy(["email" => $email]);
            }else{
                $code=500;
                $message["email"]="Email cannot be empty";
                $exist_email = false;
            }
            if(!is_null($username)){
                $exist_username = $em->getRepository("App:Users")->findOneBy(["username" => $username]);
            }else{
                $code=500;
                $message["username"]="Username cannot be empty";
                $exist_username = false;
            }
            if(is_null($password)){
                $code=500;
                $message["password"]="Password cannot be empty";
            }
            
            
            if(is_null($exist_email) && is_null($exist_username) && !is_null($password)){
                $user = new Users();
                $user->setName($name);
                $user->setEmail($email);
                $user->setUsername($username);
                $user->setPlainPassword($password);
                $user->setPassword($encoder->encodePassword($user, $password));
    
                $em->persist($user);
                $em->flush();
            }else{
                if(!is_null($exist_email)){
                    $code=500;
                    $message["email"]="Email already exists in another account";
                }
                if(!is_null($exist_username)){
                    $code=500;
                    $message["username"]="Username already exists in another account";
                }
            }
            
            
 
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message[] = "An error has occurred trying to register the user - Error: {$ex->getMessage()}";
        }
 
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $user : $message,
        ];
 
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Get("/v1/users.{_format}", name="user_list", defaults={"_format":"json"})
     *
     * @OA\Response(
     *     response=200,
     *     description="Gets all faq for current logged user."
     * )
     *
     * @OA\Response(
     *     response=500,
     *     description="An error has occurred trying to get all faq."
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="header",
     *     description="The text ID",
     *     @OA\Schema(
     *       type="string",
     *     ),
     * )
     *
     * @OA\Tag(name="User")
     */
    public function getAllUserAction(Request $request, SerializerInterface $serializer) {
        $em = $this->getDoctrine()->getManager();
        $contact = [];
        $message = "";

        try {
            $code = 200;
            $error = false;
            $users = $em->getRepository("App:Users")->findAll();
            
            if (is_null($users)) {
                $usersCustom = [];
            }else{
                $usersCustom=[];
                foreach($users as $user){
                    $userRow["id"] = $user->getId();
                    $userRow["name"] = $user->getName();
                    $userRow["email"] = $user->getEmail();
                    $userRow["username"] = $user->getUsername();
                    $userRow["create_at"] = $user->getCreatedAt()->format('m-d-Y');
                    array_push($usersCustom,$userRow);
                }
            }
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all users - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $usersCustom : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }
    
    

}
