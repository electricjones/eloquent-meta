<?php

class MoneyTest extends PHPUnit_Framework_TestCase
{
    public function testAddMeta()
    {
        // Arrange
        $a = new Money(1);

        // Act
        $b = $a->negate();

        // Assert
        $this->assertEquals(-1, $b->getAmount());
    }

    // ...
}