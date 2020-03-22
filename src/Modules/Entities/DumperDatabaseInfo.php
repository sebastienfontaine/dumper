<?php

namespace SebastienFontaine\Dumper\Modules\Entities;

class DumperDatabaseInfo
{
    /** @var array */
    public $environments;

    /** @var string */
    public $connection;

    /** @var string */
    public $host;

    /** @var string */
    public $port;

    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var string */
    public $database;

    /** @var DumperDatabaseOptions */
    public $options;

    /**
     * DumperDatabase constructor.
     *
     * @param array $configurations
     */
    public function __construct(array $configurations)
    {
        $this->environments = $configurations['environments'];
        $this->connection   = $configurations['connection'];
        $this->host         = $configurations['host'];
        $this->port         = $configurations['port'];
        $this->username     = $configurations['username'];
        $this->password     = $configurations['password'];
        $this->database     = $configurations['database'];

        $this->options = new DumperDatabaseOptions($configurations['options']);
    }
}
