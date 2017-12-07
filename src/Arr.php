<?php
    /**
     * @Author  Anton Zinovyev
     * @link    https://github.com/xobotyi/dotarray
     * @license https://github.com/xobotyi/dotarray/blob/master/LICENSE.txt
     */

    namespace xobotyi;

    class Arr
    {
        /**
         * Applies $callback to each $array's element and returns true if ALL returns TRUE
         * $callback has item value as 1'st parameter and item key as 2'nd
         * Works on lazy algorithm, so it will return FALSE on first non-TRUE $callback's return
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
         * Applies $callback to each $array's element and returns true if ANY returns TRUE
         * $callback has item value as 1'st parameter and item key as 2'nd
         * Works on lazy algorithm, so it will return TRUE on first TRUE $callback's return
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
         * Checks if $array contains ALL of $value
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
            if (!$values) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\Arr::has(), 1 passed, at least 2 expected');
            }

            if (!$array) {
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
         * Checks if $array contains ANY of $value
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
        public static function hasAny(array $array, ...$values) :bool
        {
            if (!$values) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\Arr::hasAny(), 1 passed, at least 2 expected');
            }

            if (!$array) {
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
         * Checks if $array has ALL of $paths
         * Works on lazy algorithm, so it will return FALSE on first non-existing $path
         * Empty paths will be ignored
         *
         * @param array    $array
         * @param string[] $paths
         *
         * @return bool
         * @throws \ArgumentCountError
         */
        public static function hasKey(array $array, string ...$paths) :bool
        {
            if (!$paths) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\Arr::hasKey(), 1 passed, at least 2 expected');
            }

            if (!$array) {
                return false;
            }

            foreach ($paths as &$path) {
                if ($path === '') {
                    continue;
                }

                $path  = preg_split('~\\\\.(*SKIP)(*F)|\.~s', $path);
                $scope = &$array;
                $i     = 0;

                for (; $i < count($path) - 1; $i++) {
                    $path[$i] = stripslashes($path[$i]);
                    if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                        return false;
                    }

                    $scope = &$scope[$path[$i]];
                }

                $path[$i] = stripslashes($path[$i]);

                if (!isset($scope[$path[$i]]) && !\array_key_exists($path[$i], $scope)) {
                    return false;
                }
            }

            return true;
        }

        /**
         * Checks if $array has ANY of $paths
         * Works on lazy algorithm, so it will return TRUE on first existing $path
         * Empty paths will be ignored
         *
         * @param array    $array
         * @param string[] $paths
         *
         * @return bool
         * @throws \ArgumentCountError
         */
        public static function hasAnyKey(array $array, string ...$paths) :bool
        {
            if (!$paths) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\Arr::hasAnyKey(), 1 passed, at least 2 expected');
            }

            if (!$array) {
                return false;
            }

            foreach ($paths as &$path) {
                if ($path === '') {
                    continue;
                }

                $path  = preg_split('~\\\\.(*SKIP)(*F)|\.~s', $path);
                $scope = &$array;
                $i     = 0;

                for (; $i < count($path) - 1; $i++) {
                    $path[$i] = stripslashes($path[$i]);
                    if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                        continue 2;
                    }

                    $scope = &$scope[$path[$i]];
                }

                $path[$i] = stripslashes($path[$i]);

                if (isset($scope[$path[$i]]) || \array_key_exists($path[$i], $scope)) {
                    return true;
                }
            }

            return false;
        }

        /**
         * Returns the $array's value placed on the $path if it exists, otherwise $default
         * If $path is null or empty string, whole $array will be returned
         *
         * @param array       $array
         * @param string|null $path
         * @param mixed       $default
         *
         * @return mixed
         */
        public static function get(array $array, ?string $path = null, $default = null)
        {
            if (!$array) {
                return $default;
            }
            if ($path === '') {
                return $array;
            }

            $path = preg_split('~\\\\.(*SKIP)(*F)|\.~s', $path);
            $i    = 0;

            for (; $i < count($path) - 1; $i++) {
                $path[$i] = stripslashes($path[$i]);
                if (!isset($array[$path[$i]]) || !\is_array($array[$path[$i]])) {
                    return $default;
                }

                $array = &$array[$path[$i]];
            }

            $path[$i] = stripslashes($path[$i]);

            return (isset($array[$path[$i]]) && \array_key_exists($path[$i], $array)) ? $array[$path[$i]] : $default;
        }

        /**
         * Deletes elements on all given $paths
         * Empty paths will be ignored
         *
         * @param array    $array
         * @param string[] ...$paths
         *
         * @return array
         * @throws \ArgumentCountError
         */
        public static function delete(array $array, string ...$paths) :array
        {
            if (!$paths) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\Arr::delete(), 1 passed, at least 2 expected');
            }

            if ($array) {
                foreach ($paths as &$path) {
                    if ($path === '') {
                        continue;
                    }

                    $path  = preg_split('~\\\\.(*SKIP)(*F)|\.~s', $path);
                    $scope = &$array;
                    $i     = 0;

                    for (; $i < count($path) - 1; $i++) {
                        $path[$i] = stripslashes($path[$i]);
                        if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                            continue 2;
                        }

                        $scope = &$scope[$path[$i]];
                    }

                    $path[$i] = stripslashes($path[$i]);

                    unset($scope[$path[$i]]);
                }
            }

            return $array;
        }

        /**
         * Sets the value passed with 3'rd argument on the path passed with 2'nd argument.
         * If 2'nd argument is array, it's keys will be used as paths and items as values
         * Empty paths will be ignored
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
            if (!$args) {
                throw new \ArgumentCountError('Too few arguments to function xobotyi\Arr::set(), 1 passed, at least 2 expected');
            }

            if (is_string($args[0]) || is_numeric($args[0])) {
                if (!isset($args[1]) && !\array_key_exists(1, $args)) {
                    throw new \ArgumentCountError('Too few arguments to function xobotyi\Arr::set(), 2 passed, at least 3 expected when second is string');
                }

                $args = [$args[0] => $args[1]];
            }
            else if (\is_array($args[0])) {
                $args = $args[0];
            }
            else {
                throw new \TypeError("Argument 2 passed to xobotyi\Arr::set() must be of the type array or string, " . gettype($args[0]) . " given");
            }

            foreach ($args as $path => &$value) {
                if ($path === '') {
                    continue;
                }

                $path  = preg_split('~\\\\.(*SKIP)(*F)|\.~s', $path);
                $scope = &$array;
                $i     = 0;

                for (; $i < count($path) - 1; $i++) {
                    $path[$i] = stripslashes($path[$i]);
                    if (!isset($scope[$path[$i]]) || !\is_array($scope[$path[$i]])) {
                        $scope[$path[$i]] = [];
                    }

                    $scope = &$scope[$path[$i]];
                }

                $path[$i] = stripslashes($path[$i]);

                $scope[$path[$i]] = $value;
            }

            return $array;
        }

        /**
         * Checks whether $array is an associative array
         *
         * @param array $array
         *
         * @return bool
         */
        public static function isAssoc(array $array) :bool
        {
            if (!$array) {
                return false;
            }

            foreach (array_keys($array) as &$key) {
                if (\is_string($key)) {
                    return true;
                }
            }

            return false;
        }

        /**
         * Checks whether $array is a sequential ([1,2,3,4,...]) array
         *
         * @param array $array
         *
         * @return bool
         */
        public static function isSequential(array $array) :bool
        {
            return ($keys = array_keys($array)) === array_keys($keys);
        }
    }