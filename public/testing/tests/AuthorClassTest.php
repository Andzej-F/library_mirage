<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class AuthorClassTest extends TestCase
{
    // public $author;

    // protected function setUp(): void
    // {
    //     $this->author = new Author();
    // }

    public function testIfObjectIsAnInstanceOfAuthorClass()
    {
        $author = new Author();
        $this->assertInstanceOf(Author::class, $author);
    }

    // public function testCreateAuthorMethod()
    // {
    //     $author = new Author();
    //     $author->createAuthor('Helen', 'Fielding');

    //     $this->assertEquals('Helen', $author->getName());
    // }

    public function testMockOfTheAuthorClass()
    {
        $authorMockObject = $this->createMock(Author::class);

        $authorMockObject->createAuthor('Helen', 'Fielding');

        $authorMockObject->method('getName')
            ->willReturn($authorMockObject->name);

        $this->assertEquals('Helen', $authorMockObject->getName());
    }
}
