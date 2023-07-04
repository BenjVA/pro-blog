<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Model\DatabaseConnection;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Article
{
    public function __construct(public Environment $twig)
    {
        $this->twig->addGlobal('session', $_SESSION);
    }

    /**Show all articles published and notifications after adding comment if logged in
     *
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function showPublishedArticle(string $id, ?string $notAddedComment, ?string $addedComment): void
    {
        $articleRepository = new ArticleRepository();
        $commentRepository = new CommentRepository();
        $articleRepository->connection = new DatabaseConnection();
        $commentRepository->connection = new DatabaseConnection();

        $article = $articleRepository->getSingleArticle($id);
        $comments = $commentRepository->getPublishedComments($id);

        $this->twig->display('article.html.twig', [
            'article' => $article,
            'comments' => $comments ?? null,
            'waitingValidationComment' => $addedComment ?? null,
            'notWaitingValidationComment' => $notAddedComment ?? null
        ]);
    }

    /**Only show add article template
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function showAddArticlePage(): void
    {
        $this->twig->display('addArticle.html.twig');
    }

    /**Show add article template and nofitications after submit form
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function addArticle(): void
    {
        if (count($_POST) > 0) {
            if (isset($_SESSION['user']->id) && is_numeric($_SESSION['user']->id)
                && isset($_POST['title']) && !empty($_POST['title'])
                && isset($_POST['short']) && !empty($_POST['short'])
                && isset($_POST['article']) && !empty($_POST['article'])) {
                $idUser = $_SESSION['user']->id;
                $title = filter_input(INPUT_POST, 'title',FILTER_SANITIZE_SPECIAL_CHARS);
                $short = filter_input(INPUT_POST, 'short',FILTER_SANITIZE_SPECIAL_CHARS);
                $content = filter_input(INPUT_POST, 'article',FILTER_SANITIZE_SPECIAL_CHARS);

                $article = new ArticleRepository();
                $article->connection = new DatabaseConnection();
                $addArticle = $article->addArticle($idUser, $title, $short, $content);

                if ($addArticle) {
                    $addedArticle = 'Votre article est en attente de validation !';
                } else {
                    $notAddedArticle = 'Votre article n\'a pas pu être ajouté';
                }
            }

            $this->twig->display('addArticle.html.twig', [
                'waitingValidationArticle' => $addedArticle ?? null,
                'notAddedArticle' => $notAddedArticle ?? null
            ]);
        }
    }

    /**Show articles awaiting publications in admin template
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function showNotPublishedArticles(
        ?string $deletedArticle,
        ?string $errorDeleteArticle,
        ?string $publishedArticle,
        ?string $errorPublishArticle): void
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

    /**Option to delete articles by admin
     *
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function deleteArticle(?string $deletedArticle,
                                  ?string $errorDeleteArticle,
                                  ?string $publishedArticle,
                                  ?string $errorPublishArticle): void
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

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
    }

    /**Option to publish articles by admin
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function publishArticle(?string $deletedArticle,
                                   ?string $errorDeleteArticle,
                                   ?string $publishedArticle,
                                   ?string $errorPublishArticle): void
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

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
    }

    /**Submit article edits and showing notifications
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function editArticle(): void
    {
        if (count($_POST) > 0) {
            if (isset($_GET['id']) && !empty($_GET['id'])
                && isset($_POST['title']) && !empty($_POST['title'])
                && isset($_POST['short']) && !empty($_POST['short'])
                && isset($_POST['article']) && !empty($_POST['article'])) {
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
                $title = filter_input(INPUT_POST, 'title',FILTER_SANITIZE_SPECIAL_CHARS);
                $short = filter_input(INPUT_POST, 'short',FILTER_SANITIZE_SPECIAL_CHARS);
                $content = filter_input(INPUT_POST, 'article',FILTER_SANITIZE_SPECIAL_CHARS);

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
    }

    /**Show edit article template and notifications
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function showEditArticlePage(string $id, ?string $editedArticle, ?string $notEditedArticle): void
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
