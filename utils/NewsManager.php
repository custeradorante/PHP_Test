<?php

class NewsManager
{
	private $db;

    private $commentManager;

	public function __construct(DB $db, CommentManager $commentManager)
    {
        $this->db = $db;
        $this->commentManager = $commentManager;
    }

	public static function getInstance(): self
	{
        static $instance = null;

        if ($instance === null) {
            $instance = new self(DB::getInstance(), CommentManager::getInstance());
        }

        return $instance;
	}

	/**
	* list all news
	*/
	public function listNews($limit = null, $offset = null): array
	{
		$sql = 'SELECT * FROM `news`';
        $params = [];

        if ($limit !== null && $offset !== null) {
            $sql .= ' LIMIT ? OFFSET ?';
            $params = [$limit, $offset];
        }

		$rows = $this->db->select($sql, $params);

        return $this->populateNews($rows);
	}

	/**
	* add a record in news table
	*/
	public function addNews($title, $body): int
	{
		$sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES (?, ?, ?)";
        $this->db->exec($sql, [$title, $body, date('Y-m-d')]);

        return $this->db->lastInsertId();
	}

	/**
	* deletes a news, and also linked comments
	*/
	public function deleteNews($id): bool
    {
        $comments = $this->commentManager->listCommentsByNewsId($id);
        foreach ($comments as $comment) {
            $this->commentManager->deleteComment($comment->getId());
        }

        $sql = "DELETE FROM `news` WHERE `id` = ?";

        return $this->db->exec($sql, [$id]);
    }

	private function populateNews(array $rows): array
    {
        $newsList = [];
        foreach ($rows as $row) {
            $news = new News();
            $news->setId($row['id'])
                 ->setTitle($row['title'])
                 ->setBody($row['body'])
                 ->setCreatedAt($row['created_at']);
            $newsList[] = $news;
        }

        return $newsList;
    }
}
