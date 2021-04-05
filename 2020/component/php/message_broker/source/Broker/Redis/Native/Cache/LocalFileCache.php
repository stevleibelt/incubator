<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-16
 */

namespace Net\Bazzline\Component\MessageQueue\Broker\Redis\Native\Cache;

class LocalFileCache implements CacheInterface
{
    /** @var string */
    private $filePath;

    public function __construct(
        string $filePath
    ) {
        $this->filePath = $filePath;
    }



    public function delete()
    {
        if ($this->has()) {
            unlink($this->filePath);
        }
    }



    public function get(): string
    {
        return file_get_contents(
            $this->filePath
        );
    }



    public function has(): bool
    {
        return file_exists(
            $this->filePath
        );
    }



    public function set($data)
    {
        file_put_contents(
            $this->filePath,
            $data
        );
    }
}
