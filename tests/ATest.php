<?php
    /**
     * @Author  Anton Zinovyev
     * @link    https://github.com/xobotyi/dotarray
     * @license https://github.com/xobotyi/dotarray/blob/master/LICENSE.txt
     */

    namespace xobotyi\tests;

    use PHPUnit\Framework\TestCase;
    use xobotyi\A;

    class ATest extends TestCase
    {
        public function testEvery() :void
        {
            $array = ['Hello', 'world', '!'];

            $this->assertFalse(A::every($array, function ($item) { }));
            $this->assertTrue(A::every($array, function ($item) { return is_string($item); }));
            $this->assertFalse(A::every($array, function ($item) { return is_int($item); }));
        }

        public function testAny() :void
        {
            $array = ['Hello', 'world', '!'];

            $this->assertFalse(A::any($array, function ($item) { }));
            $this->assertFalse(A::any($array, function ($item) { return is_int($item); }));
            $this->assertTrue(A::any($array, function ($item) { return is_string($item); }));
        }

        public function testHas() :void
        {
            $this->assertFalse(A::has([], 0));

            $array = [1 => false, 'foo' => null, 'bar' => ['baz']];

            $this->assertTrue(A::has($array, false));
            $this->assertFalse(A::has($array, true));
            $this->assertTrue(A::has($array, false, null));
            $this->assertFalse(A::has($array, false, null, ['bar']));
        }

        public function testHasException1() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::has([]);
        }

        public function testHasAny() :void
        {
            $this->assertFalse(A::hasAny([], 0));

            $array = [1 => false, 'foo' => null, 'bar' => ['baz']];

            $this->assertTrue(A::hasAny($array, false));
            $this->assertFalse(A::hasAny($array, true));
            $this->assertTrue(A::hasAny($array, false, true));
            $this->assertFalse(A::hasAny($array, true, 1, ['bar']));
        }

        public function testHasAnyException1() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::hasAny([]);
        }

        public function testArrayKeyExists()
        {
            $array = ['hello' => 'world'];

            $this->assertFalse(A::arrayKeyExists($array, 'hell'));
            $this->assertTrue(A::arrayKeyExists($array, 'hello'));
        }

        public function testSplitPath()
        {
            $this->assertEquals([], A::splitPath(''));
            $this->assertEquals([], A::splitPath('...'));
            $this->assertEquals(['a', 'b', 'c'], A::splitPath('a.b.c'));
            $this->assertEquals(['a', 'b', 'c'], A::splitPath('a.b..c'));
            $this->assertEquals(['a\\', 'b', 'c'], A::splitPath('a\\\\.b.c'));
            $this->assertEquals(['a.b', 'c'], A::splitPath('a\.b.c'));
        }

        public function testHasKey() :void
        {
            $this->assertFalse(A::hasKey([], 0));

            $array = [0 => 0, 'a' => 1, 2 => 1, 'b' => ['c' => ['d' => 1]], 'b.c\\.d' => 'qwe'];

            $this->assertFalse(A::hasKey($array, ''));
            $this->assertFalse(A::hasKey($array, '.....'));
            $this->assertTrue(A::hasKey($array, 0));
            $this->assertTrue(A::hasKey($array, 2));
            $this->assertFalse(A::hasKey($array, 3));

            $this->assertTrue(A::hasKey($array, 'a'));
            $this->assertTrue(A::hasKey($array, 'b.c.d'));
            $this->assertFalse(A::hasKey($array, 'b.d.e'));
            $this->assertFalse(A::hasKey($array, 'b.c.e'));
            $this->assertTrue(A::hasKey($array, 'b\.c\\\\\.d'));

            $this->assertTrue(A::hasKey($array, 0, 2, 'b.c.d'));
            $this->assertFalse(A::hasKey($array, 'b.c.d', 'b.c.e'));
        }

        public function testHasKeyException1() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::hasKey([]);
        }

        public function testHasAnyKey() :void
        {
            $this->assertFalse(A::hasAnyKey([], 0));

            $array = [0 => 0, 'a' => 1, 2 => 1, 'b' => ['c' => ['d' => 1]], 'b.c\\.d' => 'qwe'];

            $this->assertFalse(A::hasAnyKey($array, ''));
            $this->assertFalse(A::hasAnyKey($array, '....'));
            $this->assertTrue(A::hasAnyKey($array, 0));
            $this->assertTrue(A::hasAnyKey($array, 2));
            $this->assertFalse(A::hasAnyKey($array, 3));

            $this->assertTrue(A::hasAnyKey($array, 'a'));
            $this->assertTrue(A::hasAnyKey($array, 'b.c.d'));
            $this->assertFalse(A::hasAnyKey($array, 'b.d.e'));
            $this->assertFalse(A::hasAnyKey($array, 'b.c.e'));
            $this->assertTrue(A::hasAnyKey($array, 'b\.c\\\\\.d'));

            $this->assertTrue(A::hasAnyKey($array, 0, 2, 'b.c.d'));
            $this->assertTrue(A::hasAnyKey($array, 'b.c.d', 'b.c.e'));
            $this->assertFalse(A::hasAnyKey($array, 'b.c.f', 'b.c.e'));
        }

        public function testHasAnyKeyException1() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::hasAnyKey([]);
        }

        public function testGet() :void
        {
            $this->assertEquals('default', A::get([], '1.2.3', 'default'));

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

            $this->assertEquals($array, A::get($array, null));
            $this->assertEquals('default', A::get($array, '', 'default'));
            $this->assertEquals('default', A::get($array, '....', 'default'));
            $this->assertEquals('qwe',
                                A::get($array, 'bar.bat'));
            $this->assertEquals(4,
                                A::get($array, 'bar.1.2.3'));
            $this->assertEquals('yeeee!',
                                A::get($array, 'bar\.bat'));
            $this->assertEquals('yeeee[2]!',
                                A::get($array, 'bar\\\\.bat'));
            $this->assertEquals('yeeee[3]!',
                                A::get($array, 'bar\\\\\\\\\.bat'));
            $this->assertEquals('not yeeee =(',
                                A::get($array, 'bar\\\\\\\.bat', 'not yeeee =('));
            $this->assertEquals('not yeeee =(',
                                A::get($array, 'bar\\\\\\\.bat', 'not yeeee =('));
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

            $this->assertEquals($array, A::delete($array, ''));
            $this->assertEquals($array, A::delete($array, '....'));
            $this->assertEquals([
                                    'a' => [
                                        'b' => [
                                            0   => 0,
                                            'c' => 1,
                                        ],
                                    ],
                                ], A::delete($array, 0));
            $this->assertEquals([
                                    'a' => [
                                        'b' => [],
                                    ],
                                ], A::delete($array, 0, 'a.b.c', 'a.d.c', 'a.b.0'));


        }

        public function testDeleteException1() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::delete([]);
        }

        public function testSet() :void
        {
            $array = [];

            $this->assertEquals([], A::set($array, '', 'bar'));
            $this->assertEquals([], A::set($array, '.....', 'bar'));
            $this->assertEquals(['foo' => 'bar'], A::set($array, 'foo', 'bar'));
            $this->assertEquals(['foo' => ['bar' => 'baz']], A::set($array, 'foo.bar', 'baz'));
            $this->assertEquals(['foo' => ['bar' => 'baz']], A::set($array, ['foo' => 'bar', 'foo.bar' => 'baz']));
            $this->assertEquals(['foo' => 'bar', 'baz' => ['qwe' => 'bat']], A::set($array, ['foo' => 'bar', 'baz.qwe' => 'bat']));
        }

        public function testSetException1() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::set([]);
        }

        public function testSetException2() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::set([], '123');
        }

        public function testSetException3() :void
        {
            $this->expectException(\TypeError::class);
            A::set([], null);
        }

        public function testIsAssoc() :void
        {
            $this->assertFalse(A::isAssoc([]));

            $array = [1, 2, 3, 4, 5, 'some', 'stuff'];
            $this->assertFalse(A::isAssoc($array));

            $array[2] = 123;
            $this->assertFalse(A::isAssoc($array));

            $array['foo'] = 'bar';
            $this->assertTrue(A::isAssoc($array));
        }

        public function testIsSequential() :void
        {
            $array = [1, 2, 3, 4, 5];
            $this->assertTrue(A::isSequential($array));

            $array[] = 6;
            $this->assertTrue(A::isSequential($array));

            $array[8] = false;
            $this->assertFalse(A::isSequential($array));
        }

        public function testAppend() :void
        {
            $array = [];

            $array = A::append($array, 1, 2);
            $this->assertEquals([1, 2], $array);

            $array = A::append($array, 1, 2);
            $this->assertEquals([1, 2, 1, 2], $array);
        }

        public function testAppendException1() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::append([]);
        }

        public function testPrepend() :void
        {
            $array = [];

            $array = A::prepend($array, 1, 2);
            $this->assertEquals([2, 1], $array);

            $array = A::prepend($array, 1, 2);
            $this->assertEquals([2, 1, 2, 1], $array);
        }

        public function testPrependException1() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::prepend([]);
        }

        public function testWalk() :void
        {
            $array  = [1, 2, [1, 2, 3]];
            $result = [];

            A::walk($array, function ($item) use (&$result) { $result[] = $item; });
            $this->assertEquals($array, $result);
            $result = [];

            A::walk($array, function ($item) use (&$result) { $result[] = $item; }, true);
            $this->assertEquals([1, 2, 1, 2, 3], $result);
        }

        public function testValues() :void
        {
            $array = ['a' => 1, 'b' => 2, 'c' => [1, 2, 3]];

            $this->assertEquals([1, 2, [1, 2, 3]], A::values($array));
            $this->assertEquals([1, 2, 1, 2, 3], A::values($array, true));
        }

        public function testLast() :void
        {
            $this->assertEquals([], A::last([]));
            $this->assertEquals(false, A::last([false]));
            $this->assertEquals([2, 3], A::last([1, 2, 3], 2));
            $this->assertEquals([2, 3], A::last(['a' => 1, 'b' => 2, 'c' => 3], 2));
        }

        public function testLastException() :void
        {
            $this->expectException(\Error::class);
            A::last([], -1);
        }

        public function testLastKeys() :void
        {
            $this->assertEquals([], A::lastKeys([]));
            $this->assertEquals(0, A::lastKeys([false]));
            $this->assertEquals([1, 2], A::lastKeys([1, 2, 3], 2));
            $this->assertEquals(['b', 'c'], A::lastKeys(['a' => 1, 'b' => 2, 'c' => 3], 2));
        }

        public function testLastKeysException() :void
        {
            $this->expectException(\Error::class);
            A::lastKeys([], -1);
        }

        public function testFirst() :void
        {
            $this->assertEquals([], A::first([]));
            $this->assertEquals(false, A::first([false]));
            $this->assertEquals([1, 2], A::first([1, 2, 3], 2));
            $this->assertEquals([1, 2], A::first(['a' => 1, 'b' => 2, 'c' => 3], 2));
        }

        public function testFirstException() :void
        {
            $this->expectException(\Error::class);
            A::first([], -1);
        }

        public function testFirstKeys() :void
        {
            $this->assertEquals([], A::firstKeys([]));
            $this->assertEquals(false, A::firstKeys([false]));
            $this->assertEquals([0, 1], A::firstKeys([1, 2, 3], 2));
            $this->assertEquals(['a', 'b'], A::firstKeys(['a' => 1, 'b' => 2, 'c' => 3], 2));
        }

        public function testFirstKeysException() :void
        {
            $this->expectException(\Error::class);
            A::firstKeys([], -1);
        }

        public function testGlue() :void
        {
            $this->assertEquals('', A::glue([]));
            $this->assertEquals('1,2,3', A::glue([1, 2, 3], ','));
        }

        public function testChunk() :void
        {
            $this->assertEquals([], A::chunk([], 2));
            $this->assertEquals([[1, 2], [3]], A::chunk([1, 2, 3], 2));
            $this->assertEquals([[1, 2], [3]], A::chunk(['a' => 1, 'b' => 2, 'c' => 3], 2));
            $this->assertEquals([['a' => 1, 'b' => 2], ['c' => 3]], A::chunk(['a' => 1, 'b' => 2, 'c' => 3], 2, true));
        }

        public function testFlip() :void
        {
            $this->assertEquals([], A::flip([]));
            $this->assertEquals([1 => 0, 2 => 1, 3 => 2], A::flip([1, 2, 3]));
            $this->assertEquals([1 => 'a', 2 => 'b', 3 => 'c'], A::flip(['a' => 1, 'b' => 2, 'c' => 3]));
        }

        public function testFlipWarn() :void
        {
            $this->expectException(\PHPUnit\Framework\Error\Warning::class);
            A::flip(['a' => 1, 'b' => function () { }, 'c' => 3]);
        }

        public function testDiff() :void
        {
            $a1 = [1, 2, 3];
            $a2 = [2, 3, 4];
            $a3 = [4, 5, 6];

            $this->assertEquals([], A::diff([], $a2, $a3));
            $this->assertEquals([1], A::diff($a1, $a2));
            $this->assertEquals([2, 3], A::diff($a2, $a3));
            $this->assertEquals([5, 6], A::diff($a3, $a2));
            $this->assertEquals([1 => 5, 2 => 6], A::diff($a3, $a2, true));
        }

        public function testDiffException() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::diff([]);
        }

        public function testDiffAssoc() :void
        {
            $a1 = [1, 2, 3];
            $a2 = [2, 3, 4];
            $a3 = [5, 6, 4];

            $this->assertEquals([], A::diffAssoc([], $a2, $a3));
            $this->assertEquals([1, 2, 3], A::diffAssoc($a1, $a2));
            $this->assertEquals([2, 3], A::diffAssoc($a2, $a3));
            $this->assertEquals([5, 6], A::diffAssoc($a3, $a2));
        }

        public function testDiffAssocException() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::diffAssoc([]);
        }

        public function testSymdiff() :void
        {
            $a1 = [1, 2, 3, 4];
            $a2 = [3, 2, 4, 5];
            $a3 = [4, 5, 6];

            $this->assertEquals([3, 2, 4, 5, 6], A::symdiff([], $a2, $a3));
            $this->assertEquals([1, 5], A::symdiff($a1, $a2));
            $this->assertEquals([1, 2, 3, 5, 6], A::symdiff($a1, $a2, $a3));
            $this->assertEquals([1, 6], A::symdiff($a1, $a2, $a3, true));
            $this->assertEquals([2, 3, 6],
                                A::symdiff(
                                    [4],
                                    [2, 3],
                                    [4, 5, 6, 7],
                                    [5, 7],
                                    true));
        }

        public function testSymdiffException() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::symdiff([]);
        }

        public function testIntersect() :void
        {
            $a1 = [1, 2, 3, 4];
            $a2 = [2, 3, 4];
            $a3 = [4, 5, 6];

            $this->assertEquals([], A::intersect([], []));
            $this->assertEquals([2, 3, 4], A::intersect($a1, $a2));
            $this->assertEquals([4], A::intersect($a1, $a2, $a3));
            $this->assertEquals([3 => 4], A::intersect($a1, $a2, $a3, true));
        }

        public function testIntersectException() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::intersect([]);
        }

        public function testIntersectAssoc() :void
        {
            $a1 = [1, 2, 3, 4];
            $a2 = [2, 5, 3, 4];
            $a3 = [4, 5, 3, 6];

            $this->assertEquals([], A::intersectAssoc([], []));
            $this->assertEquals([2 => 3, 3 => 4], A::intersectAssoc($a1, $a2));
            $this->assertEquals([2 => 3], A::intersectAssoc($a1, $a2, $a3));
        }

        public function testIntersectAssocException() :void
        {
            $this->expectException(\ArgumentCountError::class);
            A::intersectAssoc([]);
        }
    }