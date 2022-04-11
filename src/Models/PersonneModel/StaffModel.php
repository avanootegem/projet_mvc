<?php

namespace App\Models\PersonneModel;

use App\Models\GeneralModel;

class StaffModel extends GeneralModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function nameStaff($id_person)
    {
        $sql = "SELECT * FROM person WHERE id_person = :id_person";
        $req = $this->pdo->prepare($sql);
        $req->execute(["id_person" => $id_person]);
        return $req->fetch();
    }

    public function allRoles($id_person)
    {
        $sql = "SELECT * FROM participate NATURAL JOIN role WHERE id_person = :id_person GROUP BY id_role";
        $req = $this->pdo->prepare($sql);
        $req->execute(["id_person" => $id_person]);
        return $req->fetchAll();
    }
    
    public function allMovies($id_person)
    {
        $sql = "SELECT * FROM participate NATURAL JOIN movies WHERE id_person = :id_person GROUP BY id_movie";
        $req = $this->pdo->prepare($sql);
        $req->execute(["id_person" => $id_person]);
        return $req->fetchAll();
    }
}