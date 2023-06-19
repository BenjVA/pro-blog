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

    public function showPublishedArticle(string $id): void
    {
        $articleRepository = new ArticleRepository();
        $commentRepository = new CommentRepository();
        $articleRepository->connection = new DatabaseConnection();
        $commentRepository->connection = new DatabaseConnection();

        $article = $articleRepository->getSingleArticle($id);
        $comments = $commentRepository->getPublishedComments($id);

        $this->twig->display('article.html.twig', ['article' => $article, 'comments' => $comments]);
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

            if ($addArticle) {
                $this->twig->display('addArticle.html.twig', [
                    'waitingValidationArticle' => 'Votre article est en attente de validation !'
                ]);
            }
        }
        $this->twig->display('notFound.html.twig');
    }

    public function showNotPublishedArticles(): void
    {
        $notPublishedArticle = new ArticleRepository();
        $notPublishedArticle->connection = new DatabaseConnection();
        $notPublishedArticles = $notPublishedArticle->getWaitingPublicationArticles();

        $this->twig->display('waitingArticlesList.html.twig', ['notPublishedArticles' => $notPublishedArticles]);
    }

    public function deleteArticle(): void
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

        $this->twig->display('waitingArticlesList.html.twig', [
            'deletedArticle' => $deletedArticle ?? null,
            'errorPublishArticle' => $errorDeleteArticle ?? null
        ]);
    }

    public function publishArticle(): void
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

        $this->twig->display('waitingArticlesList.html.twig', [
            'publishedArticle' => $publishedArticle ?? null,
            'errorPublishArticle' => $errorPublishArticle ?? null
        ]);
    }
}