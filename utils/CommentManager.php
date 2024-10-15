<?php

class CommentManager
{
	private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

	public static function getInstance(): self
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self(DB::getInstance());
        }

        return $instance;
    }

	public function listComments($limit = null, $offset = null): array
	{
        $sql = 'SELECT * FROM `comment`';
        $params = [];

        if ($limit !== null && $offset !== null) {
            $sql .= ' LIMIT ? OFFSET ?';
            $params = [$limit, $offset];
        }

        $rows = $this->db->select($sql, $params);

        return $this->populateComments($rows);
    }

	public function listCommentsByNewsId($newsId): array
    {
        $sql = 'SELECT * FROM `comment` WHERE `news_id` = ?';
        $rows = $this->db->select($sql, [$newsId]);

        return $this->populateComments($rows);
    }

	public function addCommentForNews($body, $newsId): int
    {
        $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES (?, ?, ?)";
        $this->db->exec($sql, [$body, date('Y-m-d'), $newsId]);

        return $this->db->lastInsertId();
    }

	public function deleteComment($id): bool
    {
        $sql = "DELETE FROM `comment` WHERE `id` = ?";

        return $this->db->exec($sql, [$id]);
    }

	private function populateComments(array $rows): array
    {
        $comments = [];
        foreach ($rows as $row) {
            $comment = new Comment();
            $comment->setId($row['id'])
                    ->setBody($row['body'])
                    ->setCreatedAt($row['created_at'])
                    ->setNewsId($row['news_id']);
            $comments[] = $comment;
        }

        return $comments;
    }
}
