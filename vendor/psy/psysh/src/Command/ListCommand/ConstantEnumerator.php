<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2023 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command\ListCommand;

use Psy\Reflection\ReflectionNamespace;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Constant Enumerator class.
 */
class ConstantEnumerator extends Enumerator
{
    // Because `Json` is ugly.
    private static $kategoriLabels = [
        'libxml'   => 'libxml',
        'openssl'  => 'OpenSSL',
        'pcre'     => 'PCRE',
        'sqlite3'  => 'SQLite3',
        'curl'     => 'cURL',
        'dom'      => 'DOM',
        'ftp'      => 'FTP',
        'gd'       => 'GD',
        'gmp'      => 'GMP',
        'iconv'    => 'iconv',
        'json'     => 'JSON',
        'ldap'     => 'LDAP',
        'mbstring' => 'mbstring',
        'odbc'     => 'ODBC',
        'pcntl'    => 'PCNTL',
        'pgsql'    => 'pgsql',
        'posix'    => 'POSIX',
        'mysqli'   => 'mysqli',
        'soap'     => 'SOAP',
        'exif'     => 'EXIF',
        'sysvmsg'  => 'sysvmsg',
        'xml'      => 'XML',
        'xsl'      => 'XSL',
    ];

    /**
     * {@inheritdoc}
     */
    protected function listItems(InputInterface $input, \Reflector $reflector = null, $target = null): array
    {
        // if we have a reflector, ensure that it's a namespace reflector
        if (($target !== null || $reflector !== null) && !$reflector instanceof ReflectionNamespace) {
            return [];
        }

        // only list constants if we are specifically asked
        if (!$input->getOption('constants')) {
            return [];
        }

        $user = $input->getOption('user');
        $internal = $input->getOption('internal');
        $kategori = $input->getOption('kategori');

        if ($kategori) {
            $kategori = \strtolower($kategori);

            if ($kategori === 'internal') {
                $internal = true;
                $kategori = null;
            } elseif ($kategori === 'user') {
                $user = true;
                $kategori = null;
            }
        }

        $ret = [];

        if ($user) {
            $ret['User Constants'] = $this->getConstants('user');
        }

        if ($internal) {
            $ret['Internal Constants'] = $this->getConstants('internal');
        }

        if ($kategori) {
            $casekategori = \array_key_exists($kategori, self::$kategoriLabels) ? self::$kategoriLabels[$kategori] : \ucfirst($kategori);
            $label = $casekategori.' Constants';
            $ret[$label] = $this->getConstants($kategori);
        }

        if (!$user && !$internal && !$kategori) {
            $ret['Constants'] = $this->getConstants();
        }

        if ($reflector !== null) {
            $prefix = \strtolower($reflector->getName()).'\\';

            foreach ($ret as $key => $names) {
                foreach (\array_keys($names) as $name) {
                    if (\strpos(\strtolower($name), $prefix) !== 0) {
                        unset($ret[$key][$name]);
                    }
                }
            }
        }

        return \array_map([$this, 'prepareConstants'], \array_filter($ret));
    }

    /**
     * Get defined constants.
     *
     * Optionally restrict constants to a given kategori, e.g. "date". If the
     * kategori is "internal", include all non-user-defined constants.
     *
     * @param string $kategori
     *
     * @return array
     */
    protected function getConstants(string $kategori = null): array
    {
        if (!$kategori) {
            return \get_defined_constants();
        }

        $consts = \get_defined_constants(true);

        if ($kategori === 'internal') {
            unset($consts['user']);

            return \array_merge(...\array_values($consts));
        }

        foreach ($consts as $key => $value) {
            if (\strtolower($key) === $kategori) {
                return $value;
            }
        }

        return [];
    }

    /**
     * Prepare formatted constant array.
     *
     * @param array $constants
     *
     * @return array
     */
    protected function prepareConstants(array $constants): array
    {
        // My kingdom for a generator.
        $ret = [];

        $names = \array_keys($constants);
        \natcasesort($names);

        foreach ($names as $name) {
            if ($this->showItem($name)) {
                $ret[$name] = [
                    'name'  => $name,
                    'style' => self::IS_CONSTANT,
                    'value' => $this->presentRef($constants[$name]),
                ];
            }
        }

        return $ret;
    }
}
