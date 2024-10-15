<?php

class News
{
	protected $id, $title, $body, $createdAt;

	public function setId(int $id): self
	{
		$this->id = $id;

		return $this;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getTitle(): string
	{
		return $this->title;
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
}
