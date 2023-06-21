<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class Article
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function showPublishedArticle(string $id, $notAddedComment, $addedComment): void
    {
        $articleRepository = new ArticleRepository();
        $commentRepository = new CommentRepository();
        $articleRepository->connection = new DatabaseConnection();
        $commentRepository->connection = new DatabaseConnection();

        $article = $articleRepository->getSingleArticle($id);
        $comments = $commentRepository->getPublishedComments($id);

        $this->twig->display('article.html.twig', [
            'article' => $article, 'comments' => $comments,
            'waitingValidationComment' => $addedComment,
            'notWaitingValidationComment' => $notAddedComment ?? null
        ]);
    }

    public function showAddArticlePage(): void
    {
        $this->twig->display('addArticle.html.twig');
    }
    public function addArticle(): void
    {
        if (count($_POST) > 0) {
            $idUser = $_SESSION['user']->id;
            $title = $_POST['title'];
            $short = $_POST['short'];
            $content = $_POST['article'];


            $article = new ArticleRepository();
            $article->connection = new DatabaseConnection();
            $addArticle = $article->addArticle($idUser, $title, $short, $content);

            if (!$addArticle) {
                $notAddedArticle = 'Votre article n\'a pas pu être ajouté';
            }
        }

        $addedArticle = 'Votre article est en attente de validation !';
        $this->twig->display('addArticle.html.twig', [
            'waitingValidationArticle' => $addedArticle,
            'notWaitingValidationArticle' => $notAddedArticle ?? null
        ]);
    }

    public function showNotPublishedArticles(
        $deletedArticle, $errorDeleteArticle, $publishedArticle, $errorPublishArticle): void
    {
        $notPublishedArticle = new ArticleRepository();
        $notPublishedArticle->connection = new DatabaseConnection();
        $notPublishedArticles = $notPublishedArticle->getWaitingPublicationArticles();

        $this->twig->display('waitingArticlesList.html.twig', [
            'notPublishedArticles' => $notPublishedArticles,
            'deletedArticle' => $deletedArticle,
            'errorDeleteArticle' => $errorDeleteArticle,
            'publishedArticle' => $publishedArticle,
            'errorPublishArticle' => $errorPublishArticle
        ]);
    }

    public function deleteArticle($deletedArticle, $errorDeleteArticle, $publishedArticle, $errorPublishArticle): void
    {
        $id = $_GET['id'];

        $deleteArticle = new ArticleRepository();
        $deleteArticle->connection = new DatabaseConnection();
        $deleteArticles = $deleteArticle->deleteArticle($id);

        if ($deleteArticles) {
            $deletedArticle = 'Article supprimé !';
        } else {
            $errorDeleteArticle = 'Article non supprimé';
        }

        $this->showNotPublishedArticles($deletedArticle ?? null,
            $errorDeleteArticle ?? null,
            $publishedArticle ?? null,
            $errorPublishArticle ?? null
        );
    }

    public function publishArticle($deletedArticle, $errorDeleteArticle, $publishedArticle, $errorPublishArticle): void
    {
        $id = $_GET['id'];

        $publishArticle = new ArticleRepository();
        $publishArticle->connection = new DatabaseConnection();
        $publishArticles = $publishArticle->publishArticle($id);

        if ($publishArticles) {
            $publishedArticle = 'Article publié !';
        } else {
            $errorPublishArticle = 'Erreur dans la publication de l\'article';
        }

        $this->showNotPublishedArticles(
            $deletedArticle ?? null,
            $errorDeleteArticle ?? null,
            $publishedArticle ?? null,
            $errorPublishArticle ?? null
        );
    }

    public function editArticle(): void
    {
        if (count($_POST) > 0) {
            $id = $_GET['id'];
            $title = $_POST['title'];
            $short = $_POST['short'];
            $content = $_POST['article'];

            $article = new ArticleRepository();
            $article->connection = new DatabaseConnection();
            $editArticle = $article->editArticle($id, $title, $short, $content);

            if (!$editArticle) {
                $notEditedArticle = 'Votre article n\'a pas pu être modifié !';
            }
        }

        $editedArticle = 'Votre article a bien été modifié !';
        $this->showEditArticlePage($id ?? null, $editedArticle, $notEditedArticle ?? null);
    }

    public function showEditArticlePage($id, $editedArticle, $notEditedArticle): void
    {
        $articleRepository = new ArticleRepository();
        $articleRepository->connection = new DatabaseConnection();
        $articleToEdit = $articleRepository->getSingleArticle($id);

        $this->twig->display('editArticle.html.twig', [
            'articleToEdit' => $articleToEdit,
            'editedArticle' => $editedArticle,
            'notEditedArticle' => $notEditedArticle ?? null
        ]);
    }
}