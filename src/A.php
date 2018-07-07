<?php
declare(strict_types=1);

/**
 * @Author  Anton Zinovyev
 * @link    https://github.com/xobotyi/dotarray
 * @license https://github.com/xobotyi/dotarray/blob/master/LICENSE.txt
 */

namespace xobotyi;

class A
{
    /**
     * Delimiter which will be used to separate one array key from another
     *
     * @var string $separator
     */
    private static $separator = '.';

    /**
     * If $safeSeparationMode is set to FALSE - keys will be hadled inspite of characters escaping
     *
     * @var bool $safeSeparationMode
     */
    private static $safeSeparationMode = true;

    /**
     * Set the default separator
     *
     * @param string $separator Delimiter which will be used to separate one array key from another
     *
     * @throws \Error
     */
    public static function setDefaultSeparator(string $separator): void
    {
        if ($separator === '') {
            throw new \InvalidArgumentException('Argument 1 passed to xobotyi\A::SetDefaultSeparator() must be a valuable string');
        }

        self::$separator = $separator;
    }

    /**
     * Get the default separator
     *
     * @return string
     */
    public static function getDefaultSeparator(): string
    {
        return self::$separator;
    }

    public static function setSafeSeparationMode(bool $enabled): void
    {
        self::$safeSeparationMode = $enabled;
    }

    public static function isSafeSeparationMode(): bool
    {
        return self::$safeSeparationMode;
    }

    /**
     * Apply $callback to each $array's element and return true if EVERY call returned TRUE.
     * $callback has item value as 1'st parameter and item key as 2'nd.
     * Works on lazy algorithm, so it will return FALSE on first non-TRUE $callback's return.
     *
     * @param array $array
     * @param callable $callback
     *
     * @return bool
     */
    public static function every(array $array, callable $callback): bool
    {
        foreach ($array as $key => &$item) {
            if (!$callback($item, $key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Apply $callback to each $array's element and return true if ANY call returned TRUE.
     * $callback has item value as 1'st parameter and item key as 2'nd.
     * Works on lazy algorithm, so it will return TRUE on first TRUE $callback's return.
     *
     * @param array $array
     * @param callable $callback
     *
     * @return bool
     */
    public static function any(array $array, callable $callback): bool
    {
        foreach ($array as $key => &$item) {
            if ($callback($item, $key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Test whether $array contains ALL of provided ...$values
     *
     * IMPORTANT!
     * This function uses strict comparison
     *
     * @param array $array
     * @param mixed[] ...$values
     *
     * @return bool
     * @throws \ArgumentCountError
     */
    public static function has(array $array, ...$values): bool
    {
        if (empty($values)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::has(), 1 passed, at least 2 expected');
        }

        if (empty($array)) {
            return false;
        }

        foreach ($values as &$val) {
            if (!\in_array($val, $array, true)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Test whether $array contains ANY of provided ...$values
     *
     * IMPORTANT!
     * This function uses strict comparison.
     *
     * @param array $array
     * @param mixed[] ...$values
     *
     * @return bool
     * @throws \ArgumentCountError
     */
    public static function hasAny(array $array, ...$values): bool
    {
        if (empty($values)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::hasAny(), 1 passed, at least 2 expected');
        }

        if (empty($array)) {
            return false;
        }

        foreach ($values as &$val) {
            if (\in_array($val, $array, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * The faster analog to \array_key_exists()
     *
     * @param array &$array
     * @param string $key
     *
     * @return bool
     */
    public static function arrayKeyExists(array &$array, string $key): bool
    {
        return isset($array[$key]) || \array_key_exists($key, $array);
    }

    /**
     * Split given string to it's segments according to dot notation.
     * Empty segments will be ignored.
     * Supports escaping.
     *
     * @param string $path
     * @param bool $safe
     *
     * @return array
     */
    public static function splitPath(string $path, bool $safe = null): array
    {
        if ($path === '') {
            return [];
        }

        $safe = ($safe === null ? self::$safeSeparationMode : $safe);

        if ($safe) {
            $segments = preg_split('~\\\\' . self::$separator . '(*SKIP)(*F)|\.~s', $path, -1, PREG_SPLIT_NO_EMPTY);

            if ($segments === false) {
                // actually this code can't be covered with tests, because i don't know how to make preg_split()
                // return a FALSE value but handling it in case some one will %)
                trigger_error('Path splitting failed, received path: ' . $path);

                $segments = [];
            }

            foreach ($segments as &$segment) {
                $segment = stripslashes($segment);
            }

            return $segments;
        }

        return explode(self::$separator, $path);
    }

    /**
     * Test whether $array has ALL of provided ...paths.
     * Works on lazy algorithm, so it will return FALSE on first non-existing $path.
     * Empty paths will be processed as non-existent.
     *
     * @param array $array
     * @param string[] $paths
     *
     * @return bool
     * @throws \ArgumentCountError
     */
    public static function hasKey(array $array, string ...$paths): bool
    {
        if (empty($paths)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::hasKey(), 1 passed, at least 2 expected');
        }

        if (empty($array)) {
            return false;
        }

        foreach ($paths as &$path) {
            if ($path === '') {
                return false;
            }

            $path = self::splitPath($path);

            if (empty($path)) {
                return false;
            }

            $scope = &$array;

            for ($i = 0; $i < count($path) - 1; $i++) {
                if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                    return false;
                }

                $scope = &$scope[$path[$i]];
            }

            if (!isset($scope[$path[$i]]) && !\array_key_exists($path[$i], $scope)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Test whether $array has ANY of provided ...paths.
     * Works on lazy algorithm, so it will return TRUE on first existing $path.
     * Empty paths will be processed as non-existent.
     *
     * @param array $array
     * @param string[] $paths
     *
     * @return bool
     * @throws \ArgumentCountError
     */
    public static function hasAnyKey(array $array, string ...$paths): bool
    {
        if (empty($paths)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::hasAnyKey(), 1 passed, at least 2 expected');
        }

        if (empty($array)) {
            return false;
        }

        foreach ($paths as &$path) {
            if ($path === '') {
                continue;
            }

            $path = self::splitPath($path);

            if (empty($path)) {
                continue;
            }

            $scope = &$array;

            for ($i = 0; $i < count($path) - 1; $i++) {
                if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                    continue 2;
                }

                $scope = &$scope[$path[$i]];
            }

            if (isset($scope[$path[$i]]) || \array_key_exists($path[$i], $scope)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return the $array's value placed on the $path if it exists, otherwise $default.
     * If $path is null, whole $array will be returned.
     * Empty paths will be processed as non-existent.
     *
     * @param array $array
     * @param null|string $path
     * @param mixed $default
     *
     * @param bool|null $safeSeparationMode
     * @return mixed
     */
    public static function get(array $array, ?string $path = null, $default = null, bool $safeSeparationMode = null)
    {
        if (empty($array)) {
            return $default;
        }
        if ($path === null) {
            return $array;
        }
        if ($path === '') {
            return $default;
        }

        $path = self::splitPath($path, $safeSeparationMode);

        if (empty($path)) {
            return $default;
        }

        $scope = &$array;

        for ($i = 0; $i < count($path) - 1; $i++) {
            if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                return $default;
            }

            $scope = &$scope[$path[$i]];
        }

        return (isset($scope[$path[$i]]) && \array_key_exists($path[$i], $scope)) ? $scope[$path[$i]] : $default;
    }

    /**
     * Delete elements on all given $paths.
     * Empty paths will be processed as non-existent.
     *
     * @param array $array
     * @param string[] ...$paths
     *
     * @return array
     * @throws \ArgumentCountError
     */
    public static function delete(array $array, string ...$paths): array
    {
        if (empty($paths)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::delete(), 1 passed, at least 2 expected');
        }

        foreach ($paths as &$path) {
            if ($path === '') {
                continue;
            }


            $path = self::splitPath($path);

            if (empty($path)) {
                continue;
            }

            $scope = &$array;

            for ($i = 0; $i < count($path) - 1; $i++) {
                if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                    continue 2;
                }

                $scope = &$scope[$path[$i]];
            }

            unset($scope[$path[$i]]);
        }

        return $array;
    }

    /**
     * Set the value passed with 3'rd argument on the path passed with 2'nd argument.
     * If 2'nd argument is array, it's keys will be used as paths and items as values.
     * Empty paths will be processed as non-existent.
     *
     * @param array $array
     * @param array ...$args
     *
     * @return array
     * @throws \ArgumentCountError
     * @throws \TypeError
     */
    public static function set(array $array, ...$args): array
    {
        if (empty($args)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::set(), 1 passed, at least 2 expected');
        }

        if (is_string($args[0]) || is_numeric($args[0])) {
            if (!isset($args[1]) && !\array_key_exists(1, $args)) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\A::set(), 2 passed, at least 3 expected when second is string');
            }

            $args = [$args[0] => $args[1]];
        } else if (\is_array($args[0])) {
            $args = $args[0];
        } else {
            throw new \TypeError("Argument 2 passed to xobotyi\A::set() must be of the type array or string, " . gettype($args[0]) . " given");
        }

        foreach ($args as $path => &$value) {
            if ($path === '') {
                continue;
            }

            $path = self::splitPath($path);

            if (empty($path)) {
                continue;
            }

            $scope = &$array;

            for ($i = 0; $i < count($path) - 1; $i++) {
                if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                    $scope[$path[$i]] = [];
                }

                $scope = &$scope[$path[$i]];
            }

            $scope[$path[$i]] = $value;
        }

        return $array;
    }

    /**
     * Test whether $array is an associative array.
     *
     * @param array $array
     *
     * @return bool
     */
    public static function isAssoc(array $array): bool
    {
        if (empty($array)) {
            return false;
        }

        foreach (array_keys($array) as $key) {
            if (\is_string($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check whether $array is a sequential ([1,2,3,4,...]) array.
     *
     * @param array $array
     *
     * @return bool
     */
    public static function isSequential(array $array): bool
    {
        return ($keys = array_keys($array)) === array_keys($keys);
    }

    /**
     * Append given $values to the end of an $array.
     *
     * @param array $array
     * @param mixed[] ...$values
     *
     * @return array
     * @throws \ArgumentCountError
     */
    public static function append(array $array, ...$values): array
    {
        if (empty($values)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::append(), 1 passed, at least 2 expected');
        }

        return \array_merge($array, $values);
    }

    /**
     * Prepend given $values to the beginning of an $array.
     * Note, that values will prepend individually, so every $value
     * element will be prepended to the very beginning of an $array.
     *
     * A::prepend([1], 2, 3); // returns [3, 2, 1]
     *
     * @param array $array
     * @param mixed[] ...$values
     *
     * @return array
     * @throws \ArgumentCountError
     */
    public static function prepend(array $array, ...$values): array
    {
        if (empty($values)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::prepend(), 1 passed, at least 2 expected');
        }

        \array_unshift($array, ...array_reverse($values));

        return $array;
    }

    /**
     * Apply $callback to each element of an $array.
     * Passes to $callback item value as 1'st and item key as 2'nd parameter
     *
     * @param array $array
     * @param callable $callback
     * @param bool $recursive
     *
     * @return bool
     */
    public static function walk(array $array, callable $callback, bool $recursive = false): bool
    {
        return $recursive ? \array_walk_recursive($array, $callback) : \array_walk($array, $callback);
    }

    /**
     * Return all values from an $array as a sequential array (without it's keys)
     *
     * @param array $array
     * @param bool $flatten
     *
     * @return array
     */
    public static function values(array $array, bool $flatten = false): array
    {
        if (!$flatten) {
            return \array_values($array);
        }

        $res = [];

        \array_walk_recursive($array, function ($val) use (&$res) {
            $res[] = $val;
        });

        return $res;
    }

    /**
     * Return last $count element(s) value(s) from an $array.
     * If $array is empty - empty array will be returned,
     * If $count == 1 - last item value will be returned,
     * If $count > 1 - array with $count last items value will be returned.
     *
     * Note, that returned values depends of how current arrays sorted.
     *
     * @param array $array
     * @param int $count
     *
     * @return mixed
     * @throws \Error
     */
    public static function last(array $array, int $count = 1)
    {
        if ($count <= 0) {
            throw new \Error("xobotyi\\A::last() 2'nd argument mut be greater than zero, got " . $count);
        } else if (empty($array)) {
            return [];
        } else if ($count === 1) {
            return \end($array);
        }

        return \array_values(\array_slice($array, -$count, $count, false));
    }

    /**
     * Return last $count element(s) key(s) from an $array.
     * If $array is empty - empty array will be returned,
     * If $count == 1 - last item key will be returned,
     * If $count > 1 - array with $count last items keys will be returned.
     *
     * Note, that returned values depends of how current arrays sorted.
     *
     * @param array $array
     * @param int $count
     *
     * @return array|int|string
     * @throws \Error
     */
    public static function lastKeys(array $array, int $count = 1)
    {
        if ($count <= 0) {
            throw new \Error("xobotyi\\A::lastKeys() 2'nd argument mut be greater than zero, got " . $count);
        } else if (empty($array)) {
            return [];
        } else if ($count === 1) {
            \end($array);

            return \key($array);
        }

        return \array_keys(\array_slice($array, -$count, $count, true));
    }

    /**
     * Return first $count element(s) value(s) from an $array.
     * If $array is empty - empty array will be returned,
     * If $count == 1 - first item value will be returned,
     * If $count > 1 - array with $count first items value will be returned.
     *
     * Note, that returned values depends of how current arrays sorted.
     *
     * @param array $array
     * @param int $count
     *
     * @return mixed
     * @throws \Error
     */
    public static function first(array $array, int $count = 1)
    {
        if ($count <= 0) {
            throw new \Error("xobotyi\\A::first() 2'nd argument mut be greater than zero, got " . $count);
        } else if (empty($array)) {
            return [];
        } else if ($count === 1) {
            return \reset($array);
        }

        return \array_values(\array_slice($array, 0, $count, false));
    }

    /**
     * Return first $count element(s) keys from an $array.
     * If $array is empty - empty array will be returned,
     * If $count == 1 - first item keys will be returned,
     * If $count > 1 - array with $count first items keys will be returned.
     *
     * Note, that returned values depends of how current arrays sorted.
     *
     * @param array $array
     * @param int $count
     *
     * @return array|int|string
     * @throws \Error
     */
    public static function firstKeys(array $array, int $count = 1)
    {
        if ($count <= 0) {
            throw new \Error("xobotyi\\A::firstKeys() 2'nd argument mut be greater than zero, got " . $count);
        } else if (empty($array)) {
            return [];
        } else if ($count === 1) {
            \reset($array);

            return key($array);
        }

        return \array_keys(\array_slice($array, 0, $count, true));
    }

    /**
     * Glue $array items into a string, with $glue as delimiter.
     *
     * @param array $array
     * @param string $glue
     *
     * @return string
     */
    public static function glue(array $array, string $glue = ''): string
    {
        return \implode($glue, $array);
    }

    /**
     * Split an $array into chunks of size $chunkSize.
     * If $preserveKeys is true, items keys will be saved in chunks.
     *
     * @param array $array
     * @param int $chunkSize
     * @param bool $preserveKeys
     *
     * @return array
     */
    public static function chunk(array $array, int $chunkSize, bool $preserveKeys = false): array
    {
        if (empty($array)) {
            return [];
        }

        return \array_chunk($array, $chunkSize, $preserveKeys);
    }

    /**
     * Swap $array keys and values.
     * Note that values have to be a valid keys, to be included in output,
     * otherwise they will be ignored and WARNING will be emitted.
     *
     * @param array $array
     *
     * @return array
     */
    public static function flip(array $array): array
    {
        return \array_flip($array);
    }

    /**
     * Return elements presented only in $array, comparing to other given arrays values despite of keys.
     * If the last given argument is boolean and TRUE, arrays keys will be preserved,
     * otherwise, all given arguments should be of type array.
     *
     * @param array $array
     * @param mixed[] $arrays
     *
     * @return array
     * @throws \ArgumentCountError
     */
    public static function diff(array $array, ...$arrays): array
    {
        if (empty($arrays)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::diff(), 1 passed, at least 2 expected');
        }

        $preserve = array_pop($arrays);

        if (!is_bool($preserve)) {
            $arrays[] = $preserve;
            $preserve = false;
        }

        return $preserve ? \array_diff($array, ...$arrays) : \array_values(\array_unique(\array_diff($array, ...$arrays)));
    }

    /**
     * Return elements presented only in $array, comparing to other given arrays values AND keys.
     *
     * @param array $array
     * @param array[] $arrays
     *
     * @return array
     * @throws \ArgumentCountError
     */
    public static function diffAssoc(array $array, array ...$arrays): array
    {
        if (empty($arrays)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::diffAssoc(), 1 passed, at least 2 expected');
        }

        return \array_diff_assoc($array, ...$arrays);
    }

    /**
     * Return symmetric difference between arrays (values not presented in all the arrays simultaneously).
     * If the last given argument is boolean and TRUE, result will include only values that has no intersection
     * with other arrays.
     *
     * @param array $array
     * @param mixed[] $arrays
     *
     * @return array
     * @throws \ArgumentCountError
     */
    public static function symdiff(array $array, ...$arrays): array
    {
        if (empty($arrays)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::diff(), 1 passed, at least 2 expected');
        }

        \array_unshift($arrays, $array);
        $softDiff = array_pop($arrays);

        if (is_bool($softDiff)) {
            if ($softDiff) {
                $maxIdx = count($arrays) - 1;
                $inter = [];

                for ($i = 0; $i < $maxIdx; $i++) {
                    for ($j = $i + 1; $j <= $maxIdx; $j++) {
                        $inter = \array_merge($inter, \array_values(\array_intersect($arrays[$i], $arrays[$j])));
                    }
                }

                return \array_values(\array_unique(\array_diff(\array_merge(...$arrays), $inter)));
            }
        } else {
            $arrays[] = $softDiff;
        }

        return \array_values(\array_unique(\array_diff(\array_merge(...$arrays), \array_intersect(...$arrays))));
    }

    /**
     * Return elements presented in $array and all given arrays despite of keys.
     * If the last given argument is boolean and TRUE, arrays keys will be preserved,
     * otherwise, all given arguments should be of type array.
     *
     * @param array $array
     * @param mixed[] $arrays
     *
     * @return array
     * @throws \ArgumentCountError
     */
    public static function intersect(array $array, ...$arrays): array
    {
        if (empty($arrays)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::intersect(), 1 passed, at least 2 expected');
        }

        $preserve = array_pop($arrays);

        if (!is_bool($preserve)) {
            $arrays[] = $preserve;
            $preserve = false;
        }

        return $preserve ? \array_intersect($array, ...$arrays) : \array_values(\array_unique(\array_intersect($array, ...$arrays)));
    }

    /**
     * Return elements presented in $array and all given arrays in spite of keys.
     *
     * @param array $array
     * @param array[] ...$arrays
     *
     * @return array
     * @throws \ArgumentCountError
     */
    public static function intersectAssoc(array $array, array ...$arrays): array
    {
        if (empty($arrays)) {
            throw new \ArgumentCountError('Too few arguments to function xobotyi\A::intersectAssoc(), 1 passed, at least 2 expected');
        }

        return \array_intersect_assoc($array, ...$arrays);
    }

    /**
     * Change $array's keys case
     *
     * @param array $array
     * @param int $case
     * @param bool $recursive
     *
     * @return array
     */
    public static function changeKeyCase(array $array, int $case = CASE_LOWER, bool $recursive = false): array
    {
        if (empty($array)) {
            return $array;
        }

        $array = \array_change_key_case($array, $case);

        if ($recursive) {
            foreach ($array as &$item) {
                if (!empty($item) && is_array($item)) {
                    $item = self::changeKeyCase($item, $case, true);
                }
            }
        }

        return $array;
    }
}
