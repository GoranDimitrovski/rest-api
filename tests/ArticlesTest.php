<?php

use App\Models\Article;

class ArticlesTest extends TestCase
{
    /**
     * /api/articles [POST]
     */
    public function testShouldCreateArticle()
    {
        $this->authUser();
        $parameters = [
            'title' => 'Test Title',
            'description' => 'Test Description'
        ];
        $this->post("api/articles", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                "title",
                "description",
                "author_id",
                "updated_at",
                "created_at",
                "id",
            ]
        );
        $responseData = json_decode($this->response->getContent(), true);

        return $responseData['id'];
    }


    /**
     * /api/articles/id [GET]
     * @depends testShouldCreateArticle
     */
    public function testShouldReturnArticle($id)
    {
        $this->authUser();
        $this->get("api/articles/" . $id, []);
        $this->seeStatusCode(200);

        $this->seeJsonStructure(
            [
                "title",
                "description",
                "author_id",
                "updated_at",
                "created_at",
                "id",
            ]
        );
    }

    /**
     * /articles [GET]
     */
    public function testShouldReturnAllArticles()
    {
        $this->authUser();
        $this->get("api/articles", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                "page",
                "result" => [
                    '*' => [
                        "title",
                        "description",
                        "author_id",
                        "updated_at",
                        "created_at",
                        "id",
                    ]
                ]
            ]
        );
    }


    /**
     * /articles/id [PUT]
     * @depends testShouldCreateArticle
     */
    public function testShouldUpdateArticle($id)
    {
        $this->authUser();
        $parameters = [
            'title' => 'Test Title 1',
            'description' => 'Test Description 1'
        ];
        $this->put("api/articles/".$id, $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                "title",
                "description",
                "author_id",
                "updated_at",
                "created_at",
                "id",
            ]
        );

        $this->seeJson([
            'title' => 'Test Title 1',
            'description' => 'Test Description 1'
        ]);

    }

    /**
     * /articles/id [DELETE]
     * @depends testShouldCreateArticle
     */
    public function testShouldDeleteArticle($id)
    {
        $this->authUser();
        $this->delete("api/articles/".$id, [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
            'status'
        ]);
        $article = Article::withTrashed()->find($id);
        $this->assertNotNull($article->deleted_at);
        $article->forceDelete();
    }

}