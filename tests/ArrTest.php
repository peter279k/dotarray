<?php
    /**
     * @Author  Anton Zinovyev
     * @link    https://github.com/xobotyi/dotarray
     * @license https://github.com/xobotyi/dotarray/blob/master/LICENSE.txt
     */

    namespace xobotyi\tests;

    use PHPUnit\Framework\TestCase;
    use xobotyi\Arr;

    class ArrTest extends TestCase
    {
        public function testEvery() :void
        {
            $array = ['Hello', 'world', '!'];

            $this->assertFalse(Arr::every($array, function ($item) { }));
            $this->assertTrue(Arr::every($array, function ($item) { return is_string($item); }));
            $this->assertFalse(Arr::every($array, function ($item) { return is_int($item); }));
        }

        public function testAny() :void
        {
            $array = ['Hello', 'world', '!'];

            $this->assertFalse(Arr::any($array, function ($item) { }));
            $this->assertFalse(Arr::any($array, function ($item) { return is_int($item); }));
            $this->assertTrue(Arr::any($array, function ($item) { return is_string($item); }));
        }

        public function testHas() :void
        {
            $array = [1 => false, 'foo' => null, 'bar' => ['baz']];

            $this->assertTrue(Arr::has($array, false));
            $this->assertFalse(Arr::has($array, true));
            $this->assertTrue(Arr::has($array, false, null));
            $this->assertFalse(Arr::has($array, false, null, ['bar']));
        }

        public function testHasAny() :void
        {
            $array = [1 => false, 'foo' => null, 'bar' => ['baz']];

            $this->assertTrue(Arr::hasAny($array, false));
            $this->assertFalse(Arr::hasAny($array, true));
            $this->assertTrue(Arr::hasAny($array, false, true));
            $this->assertFalse(Arr::hasAny($array, true, 1, ['bar']));
        }

        public function testHasKey() :void
        {
            $array = [0 => 0, 'a' => 1, 2 => 1, 'b' => ['c' => ['d' => 1]], 'b.c\\.d' => 'qwe'];

            $this->assertTrue(Arr::hasKey($array, 0));
            $this->assertTrue(Arr::hasKey($array, 2));
            $this->assertFalse(Arr::hasKey($array, 3));

            $this->assertTrue(Arr::hasKey($array, 'a'));
            $this->assertTrue(Arr::hasKey($array, 'b.c.d'));
            $this->assertFalse(Arr::hasKey($array, 'b.c.e'));
            $this->assertTrue(Arr::hasKey($array, 'b\.c\\\\\.d'));

            $this->assertTrue(Arr::hasKey($array, 0, 2, 'b.c.d'));
            $this->assertFalse(Arr::hasKey($array, 'b.c.d', 'b.c.e'));
        }


        public function testHasAnyKey() :void
        {
            $array = [0 => 0, 'a' => 1, 2 => 1, 'b' => ['c' => ['d' => 1]], 'b.c\\.d' => 'qwe'];

            $this->assertTrue(Arr::hasAnyKey($array, 0));
            $this->assertTrue(Arr::hasAnyKey($array, 2));
            $this->assertFalse(Arr::hasAnyKey($array, 3));

            $this->assertTrue(Arr::hasAnyKey($array, 'a'));
            $this->assertTrue(Arr::hasAnyKey($array, 'b.c.d'));
            $this->assertFalse(Arr::hasAnyKey($array, 'b.c.e'));
            $this->assertTrue(Arr::hasAnyKey($array, 'b\.c\\\\\.d'));

            $this->assertTrue(Arr::hasAnyKey($array, 0, 2, 'b.c.d'));
            $this->assertTrue(Arr::hasAnyKey($array, 'b.c.d', 'b.c.e'));
            $this->assertFalse(Arr::hasAnyKey($array, 'b.c.f', 'b.c.e'));
        }

        public function testGet() :void
        {
            $array = [
                0             => 'foo',
                'qux'         => 'baz',
                'bar.bat'     => 'yeeee!',
                'bar\\'       => [
                    'bat' => 'yeeee[2]!',
                ],
                'bar\\\\.bat' => 'yeeee[3]!',
                'bar'         => [
                    'bat' => 'qwe',
                    'asd' => [
                        'Hello',
                        'world',
                        '!',
                    ],
                    1     => [
                        2 => [
                            3 => 4,
                        ],
                    ],
                ],
            ];

            $this->assertEquals($array, Arr::get($array, ''));
            $this->assertEquals('qwe',
                                Arr::get($array, 'bar.bat'));
            $this->assertEquals(4,
                                Arr::get($array, 'bar.1.2.3'));
            $this->assertEquals('yeeee!',
                                Arr::get($array, 'bar\.bat'));
            $this->assertEquals('yeeee[2]!',
                                Arr::get($array, 'bar\\\\.bat'));
            $this->assertEquals('yeeee[3]!',
                                Arr::get($array, 'bar\\\\\\\\\.bat'));
            $this->assertEquals('not yeeee =(',
                                Arr::get($array, 'bar\\\\\\\.bat', 'not yeeee =('));
            $this->assertEquals('not yeeee =(',
                                Arr::get($array, 'bar\\\\\\\.bat', 'not yeeee =('));
        }

        public function testDelete() :void
        {
            $array = [
                0   => 'foo',
                'a' => [
                    'b' => [
                        0   => 0,
                        'c' => 1,
                    ],
                ],
            ];

            $this->assertEquals($array, Arr::delete($array, ''));
            $this->assertEquals($array = [
                'a' => [
                    'b' => [
                        0   => 0,
                        'c' => 1,
                    ],
                ],
            ], Arr::delete($array, 0));
            $this->assertEquals($array = [
                'a' => [
                    'b' => [],
                ],
            ], Arr::delete($array, 0, 'a.b.c', 'a.b.0'));
        }

        public function testSet() :void
        {
            $array = [];

            $this->assertEquals(['foo' => 'bar'],
                                Arr::set($array, 'foo', 'bar'));
            $this->assertEquals(['foo' => ['bar' => 'baz']],
                                Arr::set($array, 'foo.bar', 'baz'));
            $this->assertEquals(['foo' => ['bar' => 'baz']],
                                Arr::set($array, ['foo' => 'bar', 'foo.bar' => 'baz']));
            $this->assertEquals(['foo' => 'bar', 'baz' => ['qwe' => 'bat']],
                                Arr::set($array, ['foo' => 'bar', 'baz.qwe' => 'bat']));
        }

        public function testIsAssoc() :void
        {
            $array = [1, 2, 3, 4, 5, 'some', 'stuff'];
            $this->assertFalse(Arr::isAssoc($array));

            $array[2] = 123;
            $this->assertFalse(Arr::isAssoc($array));

            $array['foo'] = 'bar';
            $this->assertTrue(Arr::isAssoc($array));
        }

        public function testIsSequential() :void
        {
            $array = [1, 2, 3, 4, 5];
            $this->assertTrue(Arr::isSequential($array));

            $array[] = 6;
            $this->assertTrue(Arr::isSequential($array));

            $array[8] = false;
            $this->assertFalse(Arr::isSequential($array));
        }
    }