<?php

namespace MyProject\Controllers;
use MyProject\Models\Articles\Article;

class MainController extends AbstractController
{
    public function main(): void
    {
        $articles = Article::findLastEntriesWithLimit(15);
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }
}