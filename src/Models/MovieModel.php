<?php

namespace App\Models;

class MovieModel extends GeneralModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLastFourMovies()
    {
        $sql = "SELECT * FROM movies WHERE released = 1 ORDER BY id_movie DESC LIMIT 4";
        $req = $this->pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function getFavoriteFourMovies()
    {
        $sql = "SELECT * FROM movies WHERE released = 1 AND favorite = 1 ORDER BY id_movie DESC LIMIT 4";
        $req = $this->pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function getNextMovies()
    {
        $sql = "SELECT * FROM movies WHERE released = 0 ORDER BY id_movie LIMIT 10";
        $req = $this->pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function getOneMovie($id_movie) 
    {
        $sql = "SELECT * FROM movies NATURAL JOIN type WHERE id_movie = :id_movie";
        $req = $this->pdo->prepare($sql);
        $req->execute([":id_movie" => $id_movie]);
        return $req->fetch();
    }

    public function getIdLastMovie() 
    {
        $sql = "SELECT * FROM movies WHERE redirect = 1";
        $req = $this->pdo->prepare($sql);
        $req->execute();
        return $req->fetch();
    }

    public function redirectTo0($id_movie)
    {
        $sql = "UPDATE movies SET redirect = 0 WHERE id_movie = :id_movie";
        $req = $this->pdo->prepare($sql);
        $req->execute(["id_movie" => $id_movie]);
    }

    public function getDirectorsMovie($id_movie)
    {
        $sql = "SELECT * FROM participate NATURAL JOIN movies NATURAL JOIN person NATURAL JOIN role WHERE id_movie = :id_movie AND id_role = 1";
        $req = $this->pdo->prepare($sql);
        $req->execute([":id_movie" => $id_movie]);
        return $req->fetchAll();
    }

    public function getActorsMovie($id_movie)
    {
        $sql = "SELECT * FROM participate NATURAL JOIN movies NATURAL JOIN person NATURAL JOIN role WHERE id_movie = :id_movie AND id_role = 2";
        $req = $this->pdo->prepare($sql);
        $req->execute([":id_movie" => $id_movie]);
        return $req->fetchAll();
    }

    public function getMoviesSearch($research)
    {
        $research = "%$research%";
        $sql = "SELECT * FROM movies WHERE title LIKE ?";
        $req = $this->pdo->prepare($sql);
        $req->execute([$research]);
        return $req->fetchAll();
    }

    public function getAllMoviesReleased()
    {
        $sql = "SELECT * FROM movies WHERE released = 1 ORDER BY id_movie";
        $req = $this->pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function getMovieComments($id_movie)
    {
        $sql = "SELECT * FROM comments NATURAL JOIN users WHERE id_movie = :id_movie ORDER BY id_comment DESC";
        $req = $this->pdo->prepare($sql);
        $req->execute(["id_movie" => $id_movie]);
        return $req->fetchAll();
    }

    public function getSameTypeMovie($id_movie)
    {
        $actualMovie = $this->getOneMovie($id_movie);
        $id_type = $actualMovie['id_type'];

        $sql = "SELECT * FROM movies WHERE id_type = :id_type AND id_movie <> :id_movie LIMIT 10";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "id_type" => $id_type,
            "id_movie" => $id_movie
        ]);
        return $req->fetchAll();
    }

    public function favoriteMovies()
    {
        $sql = "SELECT * FROM movies WHERE favorite = 1 ORDER BY id_movie";
        $req = $this->pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function allNextMovies()
    {
        $sql = "SELECT * FROM movies WHERE released = 0 ORDER BY id_movie";
        $req = $this->pdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function change($title, $year, $synopsis, $id_movie, $released, $favorite)
    {
        $released = trueOrFalse($released);
        $favorite = trueOrFalse($favorite);

        $sql = "UPDATE movies SET title = :title, year = :year, synopsis = :synopsis, released = :released, favorite = :favorite WHERE id_movie = :id_movie";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "title" => $title,
            "year" => $year,
            "synopsis" => $synopsis,
            "id_movie" => $id_movie,
            "released" => $released,
            "favorite" => $favorite
        ]);
    }

    public function create($title, $year, $synopsis, $released, $favorite)
    {
        $released = trueOrFalse($released);
        $favorite = trueOrFalse($favorite);

        $sql = "INSERT INTO movies (title, year, synopsis, released, favorite, redirect) VALUES (:title, :year, :synopsis, :released, :favorite, 1)";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "title" => $title,
            "year" => $year,
            "synopsis" => $synopsis,
            "released" => $released,
            "favorite" => $favorite
        ]);
    }

    public function addComment($id_movie, $id_user, $comment, $spoiler)
    {
        $spoiler = trueOrFalse($spoiler);

        $sql = "INSERT INTO comments (id_movie, id_user, comment, post_date, spoiler) VALUES (:id_movie, :id_user, :comment, NOW(), :spoiler)";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "id_movie" => $id_movie,
            "id_user" => $id_user,
            "comment" => $comment,
            "spoiler" => $spoiler
        ]);
    }

    public function getMovieType($id_type)
    {
        $sql = "SELECT * FROM movies WHERE id_type = :id_type";
        $req = $this->pdo->prepare($sql);
        $req->execute(["id_type" => $id_type]);
        return $req->fetchAll();
    }
}