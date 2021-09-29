<?php
/* Example test */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class CreateAuthorTest extends TestCase
{
    public $author;

    protected function setUp(): void
    {
        $this->author = new Author();
    }

    public function testIfObjectIsAnInstanceOfAuthorClass()
    {
        $this->assertInstanceOf(Author::class, $this->author);
    }
}
