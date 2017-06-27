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
    protected $dataDirPath;

    /**
     * CLIWrapper constructor.
     * @param string      $bin
     * @param string|null $dataDirPath
     */
    public function __construct(string $dataDirPath = null, string $bin = '/usr/bin/bitcoin-cli')
    {
        $this->bin = $bin;
        $this->dataDirPath = $dataDirPath;
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

        if ($this->dataDirPath) {
            $command .= ' -datadir=' . $this->dataDirPath;
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