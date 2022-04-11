<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Models\PersonneModel\UserModel;
use App\Models\PersonneModel\StaffModel;

class PageController extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $movieModel = new MovieModel();
        $userModel = new UserModel();
        $lastMovies = $movieModel->getLastFourMovies();
        $favMovies = $movieModel->getFavoriteFourMovies();
        $nextMovies = $movieModel->getNextMovies();
        $auth = $_SESSION['auth'];
        $flash = flash();

        $template = $this->twig->load('home.html.twig');
        echo $template->render([
            "lastMovies" => $lastMovies,
            "favMovies" => $favMovies,
            "nextMovies" => $nextMovies,
            "auth" => $auth,
            "flash" => $flash
        ]);
    }

    public function showMovie($id_movie) 
    {
        $movieModel = new MovieModel();
        $movie = $movieModel->getOneMovie($id_movie);
        $directors = $movieModel->getDirectorsMovie($id_movie);
        $actors = $movieModel->getActorsMovie($id_movie);
        $sameTypes = $movieModel->getSameTypeMovie($id_movie);
        $comments = $movieModel->getMovieComments($id_movie);
        $auth = $_SESSION['auth'];

        $template = $this->twig->load('movie/movie.html.twig');
        echo $template->render([
            "movie" => $movie,
            "directors" => $directors,
            "actors" => $actors,
            "comments" => $comments,
            "sameTypes" => $sameTypes,
            "auth" => $auth
        ]);
    }
  
    public function search()
    {
        $movieModel = new MovieModel();
        $allReleasedMovies = $movieModel->getMoviesSearch($_POST['research']);
        echo json_encode($allReleasedMovies);
    }

    public function searchMovies()
    {
        $movieModel = new MovieModel();
        $searchMovies = $movieModel->getMoviesSearch($_POST['research']);
        $nextMovies = $movieModel->getNextMovies();
        $auth = $_SESSION['auth'];
        
        $template = $this->twig->load('movie/search_movies.html.twig');

        echo $template->render([
            "searchMovies" => $searchMovies,
            "nextMovies" => $nextMovies,
            "auth" => $auth
        ]);
    }

    public function allMoviesReleased()
    {
        $movieModel = new MovieModel();
        $allMovies = $movieModel->getAllMoviesReleased();
        $nextMovies = $movieModel->getNextMovies();
        $auth = $_SESSION['auth'];

        $template = $this->twig->load('movie/all_movies.html.twig');
        echo $template->render([
            "allMovies" => $allMovies,
            "nextMovies" => $nextMovies,
            "auth" => $auth
        ]);
    }

    public function favoriteMovies()
    {
        $movieModel = new MovieModel();
        $favoriteMovies = $movieModel->favoriteMovies();
        $nextMovies = $movieModel->getNextMovies();
        $auth = $_SESSION['auth'];

        $template = $this->twig->load('movie/favorite_movies.html.twig');
        echo $template->render([
            "favoriteMovies" => $favoriteMovies,
            "nextMovies" => $nextMovies,
            "auth" => $auth
        ]);
    }

    public function allNextMovies()
    {
        $movieModel = new MovieModel();
        $allNextMovies = $movieModel->allNextMovies();
        $nextMovies = $movieModel->getNextMovies();
        $auth = $_SESSION['auth'];

        $template = $this->twig->load('movie/all_next_movies.html.twig');
        echo $template->render([
            "allNextMovies" => $allNextMovies,
            "nextMovies" => $nextMovies,
            "auth" => $auth
        ]);
    }

    public function loginPage()
    {
        $template = $this->twig->load('account/login.html.twig');
        $auth = $_SESSION['auth'];
        $flash = flash();
        echo $template->render([
            "auth" => $auth,
            "flash" => $flash
        ]);
    }

    public function login()
    {
        $userModel = new UserModel();
        $userModel->login($_POST['username'], $_POST['password']);
        header("Location: ".$this->baseUrl);
    }

    public function logout()
    {
        $_SESSION['auth'] = false;
        header("Location: ".$this->baseUrl);
    }

    public function forgetPage()
    {
        $template = $this->twig->load('account/forget.html.twig');
        $flash = flash();
        echo $template->render(["flash" => $flash]);
    }

    public function forget()
    {
        $userModel = new UserModel();
        $account = $userModel->selectAccount($_POST['reset']);
        if($account) {
            $reset_token = str_random(60);
            $id_reset = $account['id_user'];
            $userModel->forget($id_reset, $reset_token);
            sendMail($account['email'], $account['id_user'], $reset_token);
            $_SESSION['flash']['success'] = "L'email de changement de mot de passe vous a bien été envoyé";
            header("Location: ".$this->baseUrl."/loginPage");
        }
        else {
            $_SESSION['flash']['danger'] = "Email ou pseudo invalide !";
            header("Location: ".$this->baseUrl."/forgetPage");
        }
    }

    public function resetPage()
    {
        $userModel = new UserModel();
        $verif = $userModel->verifReset($_GET['id'], $_GET['token']);
        if($verif === 1) {
            $template = $this->twig->load('account/reset.html.twig');
            echo $template->render(["id" => $_GET['id']]);
        } else {
            $_SESSION['flash']['danger'] = "Lien invalide";
            header("Location: ".$this->baseUrl);
        }

    }

    public function reset($id_user) 
    {   
        $userModel = new UserModel();
        $user = $userModel->getUser($id_user);
        $token = $user['reset_token'];
        if($_POST['password'] === $_POST['confirm_password']) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            // $userModel->reset($id_user)
            $_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié";
            $userModel->reset($id_user, $password);
            header("Location: ".$this->baseUrl);
        } else {
            $_SESSION['flash']['danger'] = "Vos mot de passe ne se correspondent pas !";
            header("Location: ".$this->baseUrl."/resetPage/id=".$id_user."&token=".$token);
        }
    }

    public function create_accountPage()
    {
        $template = $this->twig->load('account/create_account.html.twig');
        $auth = $_SESSION['auth'];
        $flash = flash();
        echo $template->render([
            "auth" => $auth,
            "flash" => $flash
        ]);
    }

    public function create_account()
    {
        if($_POST['password'] === $_POST['confirm_password']) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $userModel = new UserModel();
            $userModel->create_account($_POST['username'], $_POST['email'], $password);
            $userModel->login($_POST['username'], $_POST['password']);
            $_SESSION['flash']['success'] = "Votre compte a bien été créer";
            header("Location: ".$this->baseUrl);
        } else {
            $_SESSION['flash']['danger'] = "Erreur lors de la création du compte";
            header("Location: ".$this->baseUrl."/create_accountPage");
        }
    }

    public function my_account()
    {
        $auth = $_SESSION['auth'];
        $flash = flash();

        $template = $this->twig->load("account/my_account.html.twig");
        echo $template->render([
            "auth" => $auth,
            "flash" => $flash
        ]);    
    }

    public function change_password()
    {
        if($_POST['password'] === $_POST['confirm_password']) {
            $userModel = new UserModel();
            $userModel->change_password($_POST['password']);
            $_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié";
            header("Location: ".$this->baseUrl);
        } else {
            $_SESSION['flash']['danger'] = "Vos mot de passes ne sont pas identiques";
            header("Location: ".$this->baseUrl."/my_account");
        }
    }

    public function getOnePerson($id_person)
    {
        $staffModel = new StaffModel();
        $person = $staffModel->nameStaff($id_person);
        $roles = $staffModel->allRoles($id_person);
        $movies = $staffModel->allMovies($id_person);

        $template = $this->twig->load('staff.html.twig');
        echo $template->render([
            "person" => $person,
            "roles" => $roles,
            "movies" => $movies
        ]);
    }

    public function changePage($id_movie)
    {
        $movieModel = new MovieModel();
        $movie = $movieModel->getOneMovie($id_movie);
        $auth = $_SESSION['auth'];

        $template = $this->twig->load('movie/change.html.twig');
        echo $template->render([
            "movie" => $movie,
            "auth" => $auth]);
    }

    public function change($id_movie) {
        $auth = $_SESSION['auth'];
        if($auth['admin'] === "3") {
            $movieModel = new MovieModel();
            $movieModel->change($_POST['title'], $_POST['year'], $_POST['synopsis'], $id_movie, $_POST['released'], $_POST['favorite']);
            header("Location: ".$this->baseUrl."/movie"."/".$id_movie);
        } else {
            $_SESSION['flash']['danger'] = "Vous n'avez pas les droits de modification";
            header("Location: ".$this->baseUrl);
        }
    }

    public function createPage()
    {
        $auth = $_SESSION['auth'];

        $template = $this->twig->load('movie/create_movie.html.twig');
        echo $template->render([
            "auth" => $auth]);
    }

    public function create()
    {
        $auth = $_SESSION['auth'];
        if($auth['admin'] === "3"){
            $movieModel = new MovieModel();
            $movieModel->create($_POST['title'], $_POST['year'], $_POST['synopsis'], $_POST['released'], $_POST['favorite']);
            header("Location: ".$this->baseUrl."/redirect");
        }else {
            $_SESSION['flash']['danger'] = "Vous n'avez pas les droits de modification";
            header("Location: ".$this->baseUrl);
        }
    }

    public function redirect()
    {
        $movieModel = new MovieModel();
        $id_movie = $movieModel->getIdLastMovie();
        $movieModel->redirectTo0($id_movie['id_movie']);
        header("Location: ".$this->baseUrl."/movie"."/".$id_movie['id_movie']);
    }

    public function addComment($id_movie)
    {
        $auth = $_SESSION['auth'];
        $movieModel = new MovieModel();
        $movieModel->addComment($id_movie, $auth['id_user'], $_POST['comment'], $_POST['spoiler']);
        header("Location: ".$this->baseUrl."/movie"."/".$id_movie);
    }

    public function showMovieType($id_type){
        $movieModel = new MovieModel();
        $movie_type = $movieModel->getMovieType($id_type);
        $next_movies = $movieModel->getNextMovies();

        $template = $this->twig->load('movie/movie_type.html.twig');
        echo $template->render([
            'movieTypes' => $movie_type,
            'nextMovies' => $next_movies
            ]);
    }
}