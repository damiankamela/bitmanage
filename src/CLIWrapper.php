<?php

namespace BitManage;

use JsonRPC\Exception\ServerErrorException;

/**
 * @method string getblockhash(int $number)
 * @method array getblock(string $hash)
 */
class CLIWrapper implements ConnectorInterface
{
    /** @var string */
    protected $bin;

    /** @var string */
    protected $bitDataDir;

    /**
     * @param string      $bin
     * @param string|null $bitDataDir
     */
    public function __construct(string $bitDataDir = null, string $bin = null)
    {
        $this->bitDataDir = $bitDataDir;
        $this->bin = $bin ?? Config::get('bitcoin_bin');
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return array
     * @throws ServerErrorException
     */
    public function __call(string $name, array $arguments)
    {
        $result = $this->runCommand($name, $arguments);

        if (isset($result['errorcode'])) {
            throw new ServerErrorException($result['errormessage']);
        }

        return $result;
    }

    /**
     * @param string $method
     * @param array  $arguments
     * @return array
     */
    protected function runCommand(string $method, array $arguments)
    {
        $command = $this->buildCommand($method, $arguments);

        exec("$command 2>&1", $results, $output);

        return $this->buildResponse($results);
    }

    /**
     * @param string $method
     * @param array  $arguments
     * @return string
     */
    protected function buildCommand(string $method, array $arguments)
    {
        $command = $this->bin;

        if ($this->bitDataDir) {
            $command .= ' -datadir=' . $this->bitDataDir;
        }

        $command .= ' ' . strtolower($method) . ' ' . implode(' ', $arguments);

        return $command;
    }

    /**
     * @param array $results
     * @return array
     */
    protected function buildResponse(array $results)
    {
        $mapped = [];

        if (count($results) === 1) {
            return $results[0];
        }

        foreach ($results as $result) {
            if (strpos($result, ':') === false) {
                continue;
            }

            $result = str_replace([' ', '"', ','], '', $result);
            $result = explode(':', $result);

            $mapped[$result[0]] = $result[1];
        }

        return $mapped;
    }
}