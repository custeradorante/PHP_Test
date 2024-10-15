<?php

class Comment
{
	protected $id, $body, $createdAt, $newsId;

	public function setId(int $id): self
	{
		$this->id = $id;

		return $this;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setBody(string $body): self
	{
		$this->body = $body;

		return $this;
	}

	public function getBody(): string
	{
		return $this->body;
	}

	public function setCreatedAt(string $createdAt): self
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	public function getNewsId(): int
	{
		return $this->newsId;
	}

	public function setNewsId(int $newsId): self
	{
		$this->newsId = $newsId;

		return $this;
	}
}
