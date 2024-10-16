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
        try {
            $sql = 'SELECT * FROM `comment`';
            $params = [];

            if ($limit !== null && $offset !== null) {
                $sql .= ' LIMIT ? OFFSET ?';
                $params = [$limit, $offset];
            }

            $rows = $this->db->select($sql, $params);

            return $this->populateComments($rows);
        } catch (Exception $e) {
            Logger::logError("Failed to list comments: " . $e->getMessage());
            return [];
        }
    }

	public function listCommentsByNewsId($newsId): array
    {
        try {
            $sql = 'SELECT * FROM `comment` WHERE `news_id` = ?';
            $rows = $this->db->select($sql, [$newsId]);

            return $this->populateComments($rows);
        } catch (Exception $e) {
            Logger::logError("Failed to list comments for news ID " . $newsId . ": " . $e->getMessage());
            return [];
        }
    }

	public function addCommentForNews($body, $newsId): int
    {
        try {
            $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES (?, ?, ?)";
            $this->db->exec($sql, [$body, date('Y-m-d'), $newsId]);

            return $this->db->lastInsertId();
        } catch (Exception $e) {
            Logger::logError("Failed to add comment for news ID " . $newsId . ": " . $e->getMessage());
            return 0;
        }
    }

	public function deleteComment($id): bool
    {
        try {
            $sql = "DELETE FROM `comment` WHERE `id` = ?";

            return $this->db->exec($sql, [$id]);
        } catch (Exception $e) {
            Logger::logError("Failed to delete comment with ID " . $id . ": " . $e->getMessage());
            return false;
        }
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
