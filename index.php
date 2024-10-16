<?php

define('ROOT', __DIR__);
require_once(ROOT . '/utils/DB.php');
require_once(ROOT . '/utils/NewsManager.php');
require_once(ROOT . '/utils/CommentManager.php');
require_once(ROOT . '/utils/Logger.php');
require_once(ROOT . '/class/News.php');
require_once(ROOT . '/class/Comment.php');

try {
	// Create instance to reduce redundancy
	$db = DB::getInstance();
	$commentManager = new CommentManager($db);
	$newsManager = new NewsManager($db, $commentManager);

	foreach ($newsManager->listNews() as $news) {
		echo("############ NEWS " . $news->getTitle() . " ############<br />");
		echo($news->getBody() . "<br />");

		try {
			// Get comments specific to the news id for faster and less memory usage of the loop
			$comments = $commentManager->listCommentsByNewsId($news->getId());
			foreach ($comments as $comment) {
				echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "<br />");
			}
		} catch (Exception $e) {
			Logger::logError("Failed to list comments for news ID " . $news->getId() . ": " . $e->getMessage());
		}
	}
} catch (Exception $e) {
    Logger::logError("Failed to list news: " . $e->getMessage());
	echo "Failed to list news: " . $e->getMessage();
}
