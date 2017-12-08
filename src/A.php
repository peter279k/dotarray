<?php
    /**
     * @Author  Anton Zinovyev
     * @link    https://github.com/xobotyi/dotarray
     * @license https://github.com/xobotyi/dotarray/blob/master/LICENSE.txt
     */

    namespace xobotyi;

    class A
    {
        /**
         * Apply $callback to each $array's element and returns true if ALL returns TRUE.
         * $callback has item value as 1'st parameter and item key as 2'nd.
         * Works on lazy algorithm, so it will return FALSE on first non-TRUE $callback's return.
         *
         * @param array    $array
         * @param callable $callback
         *
         * @return bool
         */
        public static function every(array $array, callable $callback) :bool
        {
            foreach ($array as $key => &$item) {
                if (!$callback($item, $key)) {
                    return false;
                }
            }

            return true;
        }

        /**
         * Apply $callback to each $array's element and returns true if ANY returns TRUE.
         * $callback has item value as 1'st parameter and item key as 2'nd.
         * Works on lazy algorithm, so it will return TRUE on first TRUE $callback's return.
         *
         * @param array    $array
         * @param callable $callback
         *
         * @return bool
         */
        public static function any(array $array, callable $callback) :bool
        {
            foreach ($array as $key => &$item) {
                if ($callback($item, $key)) {
                    return true;
                }
            }

            return false;
        }

        /**
         * Check if $array contains ALL of $value
         *
         * IMPORTANT!
         * This function uses strict comparison
         *
         * @param array   $array
         * @param mixed[] ...$values
         *
         * @return bool
         * @throws \ArgumentCountError
         */
        public static function has(array $array, ...$values) :bool
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
         * Check if $array contains ANY of $value.
         *
         * IMPORTANT!
         * This function uses strict comparison.
         *
         * @param array   $array
         * @param mixed[] ...$values
         *
         * @return bool
         * @throws \ArgumentCountError
         */
        public static function hasAny(array $array, ...$values) :bool
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
         * @param array  &$array
         * @param string $key
         *
         * @return bool
         */
        public static function arrayKeyExists(array &$array, string $key) :bool
        {
            return isset($array[$key]) || \array_key_exists($key, $array);
        }

        /**
         * Check if $array has ALL of $paths.
         * Works on lazy algorithm, so it will return FALSE on first non-existing $path.
         * Empty paths will be processed as non-existent.
         *
         * @param array    $array
         * @param string[] $paths
         *
         * @return bool
         * @throws \ArgumentCountError
         */
        public static function hasKey(array $array, string ...$paths) :bool
        {
            if (empty($paths)) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\A::hasKey(), 1 passed, at least 2 expected');
            }

            if (empty($array)) {
                return false;
            }

            foreach ($paths as &$path) {
                if (!self::getKeyRef($array, $path)['exists']) {
                    return false;
                }
            }

            return true;
        }

        /**
         * Array crawler, returns the array with reference to existent item, or creates it if it needed.
         * Empty paths will be processed as non-existent.
         *
         * @param array  $array
         * @param string $path
         * @param bool   $create
         * @param mixed  $createValue
         *
         * @return array
         */
        private static function getKeyRef(array &$array, string $path, bool $create = false, $createValue = null) :array
        {
            $path = self::splitPath($path);
            if (empty($path)) {
                return [
                    'exists' => false,
                ];
            }

            $scope = &$array;

            for ($i = 0; $i < count($path) - 1; $i++) {
                if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                    if (!$create) {
                        return [
                            'exists' => false,
                        ];
                    }

                    $scope[$path[$i]] = [];
                }

                $scope = &$scope[$path[$i]];
            }

            if ($create) {
                $scope[$path[$i]] = $createValue;

                return [
                    'exists'    => true,
                    'ref'       => &$scope[$path[$i]],
                    'parentRef' => &$scope,
                    'key'       => &$path[$i],
                ];
            }

            if (isset($scope[$path[$i]]) || \array_key_exists($path[$i], $scope)) {
                return [
                    'exists'    => true,
                    'ref'       => &$scope[$path[$i]],
                    'parentRef' => &$scope,
                    'key'       => &$path[$i],
                ];
            }

            return [
                'exists' => false,
            ];
        }

        /**
         * Split given string to it's segments according to dot notation.
         * Empty segments will be ignored.
         * Supports escaping.
         *
         * @param string $path
         *
         * @return array
         */
        private static function splitPath(string $path) :array
        {
            if ($path === '') {
                return [];
            }

            $segments = preg_split('~\\\\.(*SKIP)(*F)|\.~s', $path, -1, PREG_SPLIT_NO_EMPTY);

            if ($segments === false) {
                // actually this code can't be covered with tests, because i don't know how to make preg_split() return a FALSE value
                // but handling it in case some one will %)
                trigger_error('Path splitting failed, received path: ' . $path);

                $segments = [];
            }

            foreach ($segments as &$segment) {
                $segment = stripslashes($segment);
            }

            return $segments;
        }

        /**
         * Check if $array has ANY of $paths.
         * Works on lazy algorithm, so it will return TRUE on first existing $path.
         * Empty paths will be processed as non-existent.
         *
         * @param array    $array
         * @param string[] $paths
         *
         * @return bool
         * @throws \ArgumentCountError
         */
        public static function hasAnyKey(array $array, string ...$paths) :bool
        {
            if (empty($paths)) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\A::hasAnyKey(), 1 passed, at least 2 expected');
            }

            if (empty($array)) {
                return false;
            }

            foreach ($paths as &$path) {
                if (self::getKeyRef($array, $path)['exists']) {
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
         * @param array       $array
         * @param string|null $path
         * @param mixed       $default
         *
         * @return mixed
         */
        public static function get(array $array, ?string $path = null, $default = null)
        {
            if (empty($array)) {
                return $default;
            }
            if ($path === null) {
                return $array;
            }

            $ref = self::getKeyRef($array, $path);

            return $ref['exists'] ? $ref['ref'] : $default;
        }

        /**
         * Delete elements on all given $paths.
         * Empty paths will be processed as non-existent.
         *
         * @param array    $array
         * @param string[] ...$paths
         *
         * @return array
         * @throws \ArgumentCountError
         */
        public static function delete(array $array, string ...$paths) :array
        {
            if (empty($paths)) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\A::delete(), 1 passed, at least 2 expected');
            }

            foreach ($paths as &$path) {
                $ref = self::getKeyRef($array, $path);


                if ($ref['exists']) {
                    unset($ref['parentRef'][$ref['key']]);
                }
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
        public static function set(array $array, ...$args) :array
        {
            if (empty($args)) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\A::set(), 1 passed, at least 2 expected');
            }

            if (is_string($args[0]) || is_numeric($args[0])) {
                if (!isset($args[1]) && !\array_key_exists(1, $args)) {
                    throw new \ArgumentCountError('Too few arguments to function xobotyi\A::set(), 2 passed, at least 3 expected when second is string');
                }

                $args = [$args[0] => $args[1]];
            }
            else if (\is_array($args[0])) {
                $args = $args[0];
            }
            else {
                throw new \TypeError("Argument 2 passed to xobotyi\A::set() must be of the type array or string, " . gettype($args[0]) . " given");
            }

            foreach ($args as $path => &$value) {
                self::getKeyRef($array, $path, true, $value);
            }

            return $array;
        }

        /**
         * Check whether $array is an associative array.
         *
         * @param array $array
         *
         * @return bool
         */
        public static function isAssoc(array $array) :bool
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
        public static function isSequential(array $array) :bool
        {
            return ($keys = array_keys($array)) === array_keys($keys);
        }

        /**
         * Append given $values to the end of an $array.
         *
         * @param array   $array
         * @param mixed[] ...$values
         *
         * @return array
         * @throws \ArgumentCountError
         */
        public static function append(array $array, ...$values) :array
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
         * @param array   $array
         * @param mixed[] ...$values
         *
         * @return array
         * @throws \ArgumentCountError
         */
        public static function prepend(array $array, ...$values) :array
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
         * @param array    $array
         * @param callable $callback
         * @param bool     $recursive
         *
         * @return bool
         */
        public static function walk(array $array, callable $callback, bool $recursive = false) :bool
        {
            return $recursive ? \array_walk_recursive($array, $callback) : \array_walk($array, $callback);
        }

        /**
         * Return all values from an $array as a sequential array (without it's keys)
         *
         * @param array $array
         * @param bool  $flatten
         *
         * @return array
         */
        public static function values(array $array, bool $flatten = false) :array
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
    }