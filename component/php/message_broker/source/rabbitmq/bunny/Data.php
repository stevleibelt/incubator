<?php
/**
 * @author: stev leibelt <stev.leibelt@jobleads.de>
 * @since: 2018-04-12
 */

class Data
{
    /** @var string */
    private $createdAt;

    /** @var string */
    private $id;

    /** @var string */
    private $payload;



    /**
     * Data constructor.
     *
     * @param string $createdAt
     * @param string $id
     * @param string $payload
     */
    public function __construct($createdAt, $id, $payload)
    {
        $this->createdAt = $createdAt;
        $this->id = $id;
        $this->payload = $payload;
    }



    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }



    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }



    /**
     * @param string $json
     * @return Data
     * @throws InvalidArgumentException
     */
    public static function fromJSON($json)
    {
        $data = (array) json_decode($json);

        foreach (['created_at', 'payload', 'served_by'] as $key) {
            if (!isset($data[$key])) {
                throw new InvalidArgumentException(
                    'json in unexpected format. ' . $key . ' is missing.'
                );
            }
        }

        return new self(
            $data['created_at'],
            $data['id'],
            $data['payload']
        );
    }



    /**
     * @return string
     */
    public function toJSON()
    {
        return json_encode(
            [
                'created_at'    => $this->createdAt,
                'id'            => $this->id,
                'payload'       => $this->payload
            ]
        );
    }
}
