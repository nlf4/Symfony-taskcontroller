<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDO;

class TaskController extends AbstractController
{
    private $pdo;


    public function __construct()
    {
        $this->pdo = New PDO(
            'mysql:host=localhost;dbname=steden2',
            "root",
            "dumpling6");
    }

    /**
     * @Route("/taken/", name="app_show_taken")
     */
    public function showTasks()
    {
        return $this->render('article/show_taken.html.twig');
    }

    /**
     * @Route("/api/taken/", name="api_getAllTasks", methods={"GET"})
     *  @return JsonResponse
     */
    public function getAllTasks()
    {
        //get all tasks
        $sql = 'SELECT * FROM taak';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return new JsonResponse($rows);
    }

    /**
     * @Route("/api/taak/{id}", name="api_getOneTask", methods={"GET"})
     * @return JsonResponse
     */
    public function getOneTask($id)
    {
        //get task by id
        $sql = "SELECT * FROM taak WHERE taa_id = $id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return new JsonResponse($rows);
    }

    /**
     * @Route("/api/taken", name="api_createTask", methods={"POST"})
     * @return JsonResponse
     */
    public function createTask()
    {
        //get input data
        $data = json_decode(file_get_contents("php://input"));

       //clean data
        $taa_omschr = htmlentities($data->taa_omschr);
        $taa_naam = htmlentities($data->taa_naam);
        $taa_locatie = htmlentities($data->taa_locatie);

        //insert
        $sql = "INSERT INTO taak SET 
                     taa_datum = '$data->taa_datum', 
                     taa_omschr = '$taa_omschr',
                     taa_naam = '$taa_naam',
                     taa_datum_van = '$data->taa_datum_van',
                     taa_datum_tot = '$data->taa_datum_tot',
                     taa_uur_van = '$data->taa_uur_van',
                     taa_uur_tot = '$data->taa_uur_tot',
                     taa_locatie = '$taa_locatie'";

        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute()) {
            return new JsonResponse("Your task was created");
        } else {
            return new JsonResponse("Something went wrong, task was not created");
        }
    }

    /**
     * @Route("/api/taak/{id}", name="api_updateTask", methods={"PUT"})
     * @return JsonResponse
     */
    public function updateTask($id)
    {
        //get input
        $data = json_decode(file_get_contents("php://input"));
        //clean data
        $taa_omschr = htmlentities( $data->taa_omschr );
        $taa_naam = htmlentities($data->taa_naam);
        $taa_locatie = htmlentities($data->taa_locatie);
        //update
        $sql = "Update taak SET 
                taa_datum = '$data->taa_datum', 
                 taa_omschr = '$taa_omschr',
                 taa_naam = '$taa_naam',
                 taa_datum_van = '$data->taa_datum_van',
                 taa_datum_tot = '$data->taa_datum_tot',
                 taa_uur_van = '$data->taa_uur_van',
                 taa_uur_tot = '$data->taa_uur_tot',
                 taa_locatie = '$taa_locatie' WHERE taa_id = '$id'";

        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute()) {
            return new JsonResponse("Your task was updated");
        } else {
            return new JsonResponse("Something went wrong");
        }
    }


    /**
     * @Route("/api/taak/{id}", name="api_deleteTask", methods={"DELETE"})
     * @return JsonResponse
     */
    public function deleteTask()
    {
        //get task id
        $data = json_decode(file_get_contents("php://input"));
        //delete
        $sql = "Delete from taak WHERE taa_id = '$data->taa_id'";

        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute()) {
            return new JsonResponse("Your task was deleted");
        } else {
            return new JsonResponse("Something went wrong");
        }
    }
}

